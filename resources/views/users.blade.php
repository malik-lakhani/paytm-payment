<!DOCTYPE html>
<html lang="en">
<head>
    <title>Get Ticket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid">
    <div class="card" style="margin-top: 30px">
    <div class="card-header lighten-1">
        <div class="searchdiv">
            <h4>Users</h4>
            <input
              type="text"
              id="searchusers"
              name="search"
              onkeypress="handleKeyPress(event)"
              placeholder="Search"
              class="form-control search-users"
              value="{{ isset($filter) ? $filter : '' }}"
            >
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead style="background-color: #6f6c6c94;">
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Adhar No</th>
                    <th scope="col" class="text-center">Tickets</th>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">Email</th>
                    <th scope="col" class="text-center">Mobile No</th>
                    <th scope="col" class="text-center">Address</th>
                </tr>
            </thead>
            <tbody>

                @foreach($users as $user)
                    <tr data-toggle="collapse" data-target=".order1{{$user->id}}">
                        <th scope="row" class="text-center">{{$user->id}}</th>
                        <td class="text-center">{{$user->adhar_no}}</td>
                        <td class="text-center">
                            @foreach($user->tickets as $ticket)
                                {{ $ticket->ticket_unique_id ? $ticket->ticket_unique_id : '-' }},
                            @endforeach
                        </td class="text-center">
                        <td class="text-center">{{$user->name}}</td>
                        <td class="text-center">{{$user->email}}</td>
                        <td class="text-center">{{$user->mobile_no}}</td>
                        <td>{{ $user->address ? $user->address : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            {{ $users->appends(Request::except('page'))->links() }}
          </ul>
        </nav>
    </div>
</div>
</div>


<!--===============================================================================================-->
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
