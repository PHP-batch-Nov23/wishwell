<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaigns</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom CSS styles here if needed -->
    <style>
        /* Add your custom CSS styles here */
        .container {
            
            margin-top: 170px;
            text-align: center; /* Align contents center horizontally */
            padding-left:15px;
            padding-right:15px;
        }

        .table {
            margin: 0 auto; /* Center the table horizontally */
            width: 90%; 
        }
    </style>
</head>
<body>
@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h1>Campaigns</h1>
        <!-- <div class="table-responsive"> -->
        <table class="table table-bordered ">
            <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>UserId</th>
                    <th>Cause</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Goal Amount</th>
                    <th>Current Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Beneficiary Name</th>
                    <th>Beneficiary Age</th>
                    <th>Beneficiary City</th>
                    <th>Beneficiary Mobile</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($campaigns as $campaign)
                    <tr>
                        <td>{{$campaign->id}}</td>
                        <td>{{$campaign->user_id}}</td>
                        <td>{{ $campaign->cause }}</td>
                        <td>{{ $campaign->title }}</td>
                        <td>{{ $campaign->description }}</td>
                        <td>{{ $campaign->goal_amount }}</td>
                        <td>{{ $campaign->current_amount }}</td>
                        <td>{{ $campaign->start_date }}</td>
                        <td>{{ $campaign->end_date }}</td>
                        <td>{{ $campaign->beneficiary_name }}</td>
                        <td>{{ $campaign->beneficiary_age }}</td>
                        <td>{{ $campaign->beneficiary_city }}</td>
                        <td>{{ $campaign->beneficiary_mobile }}</td>
                        <td>{{$campaign->created_at}}</td>
                        <td>{{$campaign->updated_at}}</td>
                        <td>{{ $campaign->status }}</td>
                        <td>
                            @if($campaign->status == 'pending')
                            <form action="{{ route('approve',['id' => $campaign->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form action="{{ route('deny',['id' => $campaign->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">Deny</button>
                        </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional CSS styles if needed */
    </style>
</head>
<body>
@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h1>All Users</h1>
        <!-- <div class="table-responsive"> Make the table responsive -->
            <table class="table table-striped table-bordered">
                <thead class="thead-dark"> <!-- Dark header -->
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of Birth</th>
                        <th>Sex</th>
                        <th>Age</th>
                        <th>PAN</th>
                        <th>Balance</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>

                        <!-- You can add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                    @if(isset($allusers))
                        @foreach($allusers as $alluser)
                            <tr>
                                <td>{{ $alluser->id }}</td>
                                <td>{{ $alluser->name }}</td>
                                <td>{{ $alluser->email }}</td>
                                <td>{{ $alluser->dob }}</td>
                                <td>{{ $alluser->sex }}</td>
                                <td>{{ $alluser->age }}</td>
                                <td>{{ $alluser->pan }}</td>
                                <td>{{ $alluser->balance }}</td>
                                <td>{{ $alluser->address }}</td>
                                <td>{{ $alluser->city }}</td>
                                <td>{{ $alluser->role }}</td>
                                <td>{{$alluser->created_at}}</td>
                                <td>{{$alluser->updated_at}}</td>
                                <td>
                                    <form action="{{ route('disable', $alluser->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Disable</button>
                                    </form>
                                </td>
                                <!-- You can add more columns as needed -->
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">No users found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom CSS styles here if needed -->
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <h1>Donations</h1>
        <!-- <div class="table-responsive"> -->
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Donor Id</th>
                        <th>Campaign Id</th>
                        <th>Amount</th>
                        <th>Transaction Date</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                        <tr>
                            <td>{{$donation->id}}</td>
                            <td>{{ $donation->donor_id }}</td>
                            <td>{{ $donation->campaign_id }}</td>
                            <td>{{ $donation->amount }}</td>
                            <td>{{ $donation->transaction_date }}</td>
                            <td>{{$donation->created_at}}</td>
                            <td>{{$donation->updated_at}}</td>
                                <!-- Add any actions here if needed -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>