 <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllUserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
    
    //Route::resource('/allusers', \App\Http\Controllers\AllUserController::class);//->middleware(\App\Http\Middleware\ValidateToken::class);

    Route::post('/login',[App\Http\Controllers\AllUserController::class, 'login']);
    Route::post('/register',[App\Http\Controllers\AllUserController::class, 'store']);
    // Route::get('/profile',[App\Http\Controllers\AllUserController::class, 'store']);
    Route::post('/userDetails',[App\Http\Controllers\AllUserController::class, 'show'])->middleware('checkUserRole');

    Route::post('/updateUser',[App\Http\Controllers\AllUserController::class, 'update'])->middleware('checkUserRole');


   


    Route::get('/getUsers',[App\Http\Controllers\AllUserController::class, 'index']);
    

    
    // Route::put('/update/{id}',[App\Http\Controllers\AllUserController::class, 'update']);
    // Route::delete('/delete/{id}',[App\Http\Controllers\AllUserController::class, 'destroy']);








    Route::post('/createDonationEntry',[App\Http\Controllers\DonationController::class, 'store']);

    Route::post('/getUserAllDonations',[App\Http\Controllers\DonationController::class, 'userDonations'])->middleware('checkUserRole');

    Route::post('/getAllCampaignDonations',[App\Http\Controllers\DonationController::class, 'campaignDonations']);
    


   





    Route::get('/getcampaign',[App\Http\Controllers\CampaignController::class, 'index']);
    Route::get('/details/{id}',[App\Http\Controllers\CampaignController::class, 'show']);
    Route::post('/updateCampaignCurrentAmount',[App\Http\Controllers\CampaignController::class, 'updateCampaignCurrentAmount']);

    Route::post('/deactivateCampaignById',[App\Http\Controllers\CampaignController::class, 'deactivateCampaign'])->middleware('checkUserRole');
    Route::post('/activateCampaign',[App\Http\Controllers\CampaignController::class, 'activateCampaign'])->middleware('checkUserRole');

    
    


    

    

    


    Route::post('/campaign',[App\Http\Controllers\CampaignController::class, 'store'])->middleware('checkUserRole');
    Route::get('/getAllActiveCampaigns',[App\Http\Controllers\CampaignController::class, 'activeCampaigns']);
    Route::post('/getAllCampaignsWithId',[App\Http\Controllers\CampaignController::class, 'getAllCampaignOfUserId'])->middleware('checkUserRole');
    Route::post('/campaign/update',[App\Http\Controllers\CampaignController::class, 'update']);
    Route::post('/campaign/donate',[App\Http\Controllers\CampaignController::class, 'donate']);
    Route::post('/campaign/destroy',[App\Http\Controllers\CampaignController::class, 'destroy'])->middleware('checkUserRole');




    Route::post('/dashboard',[App\Http\Controllers\AllUserController::class, 'Dashboard'])->middleware('checkUserRole');




    

    
    
    


    // Route::get('/', function () {
    //     return view('welcome');
    // });
    
    // Route::get('/login', [App\Http\Controllers\AdminController::class, 'index']);
    // Route::post('/login', [App\Http\Controllers\AdminController::class, 'login'])->name('login');
    // Route::get('/dashboard',  [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    // Route::put('/approve/{id}', [App\Http\Controllers\DashboardController::class, 'approve'])->name('approve');
    // Route::put('/deny/{id}', [App\Http\Controllers\DashboardController::class, 'deny'])->name('deny');