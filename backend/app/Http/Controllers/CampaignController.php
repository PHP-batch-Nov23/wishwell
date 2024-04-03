<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;


use App\Models\AllUser;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon; 

class CampaignController extends Controller
{

        public function index(Request $request)
        {
            $campaigns = Campaign::all();
            return response()->json($campaigns);
        }
    
        public function store(Request $request)
        {
            // Find the user by ID

       

            $user = AllUser::findOrFail($request->userInfo['id']);

          
        
            // Check if the user is a fundraiser
            if ($user->role != 'fundraiser') {
                return response()->json([
                    "message" => "You can't create a campaign because you are not a fundraiser",
                ], 401);
            }

        
        
            // Define the required fields
            $requiredFields = [
                'cause',
                'title',
                'description',
                'goal_amount',
                'start_date',
                'end_date',
                'beneficiary_name',
                'beneficiary_age',
                'beneficiary_city',
                'beneficiary_mobile',
            ];
         
        
            // Validate the presence of required fields
            foreach ($requiredFields as $field) {
                if (!$request->has($field)) {
                    return response()->json(['error' => 'The ' . $field . ' field is required.'], 422);
                }
            }
         
        

            // Validate the request data
            $request->validate([
                'cause' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'goal_amount' => 'required|numeric|min:0',
                'current_amount' => 'nullable|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'beneficiary_name' => 'required|string|max:255',
                'beneficiary_age' => 'required|integer|min:0',
                'beneficiary_city' => 'required|string|max:255',
                'beneficiary_mobile' => 'required|string|max:255',
            ]);


          
        
            // Create a new Campaign instance
            $campaign = new Campaign($request->only($requiredFields));
        
            // Set the status to pending
            $campaign->status = 'pending';
        
            // Set the user ID
            $campaign->user_id = $request->userInfo['id'];
        
            // Save the campaign
            $campaign->save();
        
            // Return a success response
            return response()->json([
                "message" => "Campaign created successfully",
                "userData" => $campaign,
            ], 201);
        }
        
          
        public function show($id)
        {
            $user = Campaign::findOrFail($id);
            return response()->json($user);
        }
    
        public function update(Request $request, $id)
        {
            $campaign = Campaign::findOrFail($id);  
            
            if ($campaign->user_id != $request->userInfo['id']) {
                return response()->json(['error' => 'Unauthorized action.'], 403);
            }
            
            // Validate the request data
            $request->validate([
                'cause' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'goal_amount' => 'required|numeric|min:0',
                'current_amount' => 'nullable|numeric|min:0',
                'end_date' => 'required|date|after_or_equal:start_date',
                'beneficiary_name' => 'required|string|max:255',
                'beneficiary_age' => 'required|integer|min:0',
                'beneficiary_city' => 'required|string|max:255',
                'beneficiary_mobile' => 'required|string|max:255',
            ]);

            // Exclude fields that should not be updated
            $data = $request->except(['user_id', 'start_date', 'status']);

            // Update the campaign with the request data
            $campaign->update($data);

            return response()->json([

                "message" => "campain createdSuccess",
                "userData"=> $campaign,
                "request"=> $request->userInfo['id']
                
            ],201);
        }

        public function donate(Request $request){

            $requiredFields = [
                'donor_id',
                'campaign_id',
                'amount',
            ];
        
            // Iterate over the required fields
            foreach ($requiredFields as $field) {
                // Check if the field is missing in the request
                if (!$request->has($field)) {
                    // Return an error response indicating the missing field
                    return response()->json(['error' => 'The ' . $field . ' field is required.'], 422);
                }
            }
        
            $request->validate([
                'donor_id' => 'required|exists:allusers,id',
                'campaign_id' => 'required|exists:campaigns,id',
                'amount' => 'required|numeric|min:0',
            ]);
        
            // Get user and campaign
            $user = AllUser::findOrFail($request->donor_id);
            $campaign = Campaign::findOrFail($request->campaign_id);
        
            // Validate user's balance
            if ($user->balance < $request->amount) {
                return response()->json(['error' => 'Insufficient balance'], 400);
            }
        
            // Update user's balance
            $user->balance -= $request->amount;
            $user->save();
        
            // Update campaign's current amount
            $campaign->current_amount += $request->amount;
            $campaign->save();
        
            // Check if campaign needs to be set to inactive
            if ($campaign->current_amount >= $campaign->target_amount) {
                $campaign->status = 'inactive';
                $campaign->save();
            }
        
            // Create donation record
            $donation = new Donation();
            $donation->user_id = $user->id;
            $donation->campaign_id = $campaign->id;
            $donation->amount = $request->amount;
            $donation->transaction_date = Carbon::now(); // Set transaction date to current date
            $donation->save();
        
            return response()->json(['message' => 'Donation successful'], 200);
        }
    
        public function destroy(Request $request)
        {
            $campaign = Campaign::findOrFail($request->campId);
        
            if(!$campaign){
                return response()->json(['error' => 'No campaign exists'], 403);
            }
        
            if ($campaign->user_id != $request->userInfo['id']) {
                return response()->json(['error' => 'Unauthorized action.'], 403);
            }
        
            // Check if there are any donations for this campaign
            $donationsCount = Donation::where('campaign_id', $campaign->id)->count();
        
            if ($donationsCount > 0) {
                return response()->json(['error' => 'Campaign cannot be deleted because donations exist.'], 403);
            }
        
            // If no donations exist, delete the campaign
            $campaign->delete();
            
            return response()->json($campaign);
        }
        

        public function getAllCampaignOfUserId(Request $request)
        {
            // Find all campaigns associated with the provided user ID
            $campaigns = Campaign::where('user_id', $request->userInfo['id'])->get();
            
            // Check if any campaigns were found
            // if ($campaigns->isEmpty()) {
            //     // Return a message indicating no campaigns found for the user
            //     return response()->json(['message' => 'No campaigns found for the user.'], 404);
            // }
            
            // Return the campaigns associated with the user ID
            return response()->json(['campaigns' => $campaigns], 200);
        }

        public function activeCampaigns()
        {
            // Fetch all campaigns with pending status
            $campaigns = Campaign::where('status', 'active')->get();
    
            // Return the campaigns as JSON response
            return response()->json($campaigns);
        }

        public function updateCampaignCurrentAmount(Request $request)
        {
            $campaign = Campaign::findOrFail($request->id); // Assuming 'id' is sent with the request
        
            // Remove the '_token' field from the request
            $data = $request->only('current_amount_add');
        
            // Define the validation rules for the 'current_amount' field
            $rules = [
                'current_amount_add' => 'nullable|numeric',
            ];
        
            // Run validation only on the 'current_amount' field
            $validator = Validator::make($data, $rules);
        
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        
            // Update the 'current_amount' field if present in the request
            if ($request->has('current_amount_add')) {
                $campaign->current_amount += $request->current_amount_add;
            }
        
            // Save the changes
            $campaign->save();
        
            return response()->json($campaign);
        }



public function deactivateCampaign(Request $request)
{
    
    $campaign = Campaign::findOrFail($request->campId);
    
    if ($campaign->user_id != $request->userInfo['id']) {
        return response()->json(['error' => 'Unauthorized action.'], 403);
    }

    $campaign->status = 'inactive';
    $campaign->save();

    return response()->json(['message' => 'Campaign deactivated successfully'], 200);
}

public function activateCampaign(Request $request)
{
    
    $campaign = Campaign::findOrFail($request->campId);




    if ($campaign->user_id != $request->userInfo['id']) {
        return response()->json(['error' => 'Unauthorized action.'], 403);
    }

    if ($campaign->current_amount >= $campaign->goal_amount) {
        return response()->json(['error' => 'can not activate the campaign because donation needs are fullfilled'], 403);
    }

    
    if($campaign->status == 'pending'){
        return response()->json(['error' => 'you cannot activate a campaign that is queue for approval'], 403);
    }
    $campaign->status = 'active';
    $campaign->save();

    return response()->json(['message' => 'Campaign deactivated successfully'], 200);
}

        
    }
    

