<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{

        public function index(Request $request)
        {
            $donations = Donation::all();
            return response()->json($donations);
        }
    
        public function store(Request $request)
        {
            //print_r ($request);
            //  return response()->json($request);

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
                'campaign_id' => 'required|numeric|exists:campaigns,id',
                'amount' => 'required|numeric|min:0',
            ]);


    
            $user = new Donation();
            $user->transaction_date = now();
            $user->fill($request->input());
            $user->save();
            return response()->json($user);
        }
          
        public function show($id)
        {
            $user = Donation::findOrFail($id);
            return response()->json($user);
        }

        public function userDonations(Request $request){
            $donations = Donation::where('donor_id', $request->userInfo['id'])->get();
            return response()->json($donations);
        }

        public function campaignDonations(Request $request){
          
            $donations = Donation::where('campaign_id', $request->campaign)->join('allusers', 'donations.donor_id', '=', 'allusers.id')->select('donations.amount', 'allusers.name as donor_name')->get();
            return response()->json($donations);

        }
    
        public function update(Request $request, $id)
        {
            
         $user = Donation::findOrFail($id);
         $request->validate([
            'donor_id' => 'required|exists:allusers,id',
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
         ]);
    
            $user->fill($request->input());
            $user->save();
            return response()->json($user);
        }
    
        public function destroy($id)
        {
         $user = Donation::findOrFail($id);
         $user->delete();
         return response()->json($user);
        }
    
    }
    
