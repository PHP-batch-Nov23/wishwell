<?php

namespace App\Http\Controllers;
use App\Models\Campaign;
use App\Models\AllUser;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
         $campaigns = Campaign::all();
         $allusers  = AllUser::all();
         $donations = Donation::all();
         return view('dashboard', compact('campaigns', 'allusers','donations'));


        
    }

    public function approve($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->status = 'active';
        $campaign->save();

        return redirect()->route('dashboard')->with('success', 'Campaign approved successfully');
    }

    public function deny($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->status = 'inactive';
        $campaign->save();

        return redirect()->route('dashboard')->with('success', 'Campaign denied successfully');
    }
    public function disable($id)
    {
        $user = AllUser::findOrFail($id); // Find the user by ID
        $user->delete(); // Delete the user

        return redirect()->route('dashboard')->with('success', 'User disabled successfully.');
    }

}