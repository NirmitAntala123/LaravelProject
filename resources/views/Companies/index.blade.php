<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel 8 CRUD Tutorial From Scratch</title>
    <meta name="_token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

        });
    </script>

</head>

<body class='de'>
    <div class="container mt-2"id='container'>
        <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
            <div class="container">
                <a class="navbar-brand mr-auto" href="#">PositronX</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                            </li>
                        @endguest

                    </ul>

                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Laravel 8 CRUD Example Tutorial</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('companies.create') }}"> Create Company</a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }} </p>
            </div>
        @endif

        <input type="text" id="search" class="form-control" placeholder="Search by DBQuery.....">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Company Name</th>
                    <th>Company Email</th>
                    <th>Company Address</th>
                    <th>File/image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tbody" class="reload">
            </tbody>
        </table>
        <input id="myInput" type="text" class="form-control" placeholder="Search by JQuery.....">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Company Name</th>
                    <th>Company Email</th>
                    <th>Company Address</th>
                    <th>File/image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="myTable" class="reload">
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->id }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->address }}</td>
                        <td><img src="/image/{{ $company->image }}" width="100px"></td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('companies.edit', $company->id) }}">Edit</a>
                            <button type="buttom" class="btn btn-danger delete"
                                id="{{ $company->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="buttom" class="btn btn-primary" id="showjson">ShowJSONdata</button>
        <div>
            <table class="table table-bordered table-hover" id="showdata">
                <thead>
                    <tr>
                        <th>userId</th>
                        <th>Id</th>
                        <th>title</th>
                        <th>body</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @php
                    $url = 'https://jsonplaceholder.typicode.com/posts';
                    $json = json_decode(file_get_contents($url), true);
                    @endphp
                    @foreach ($json as $jsondata)
                    <tr>
                        <td>{{ $jsondata["userId"] }}</td>
                        <td>{{ $jsondata["id"] }}</td>
                        <td>{{ $jsondata["title"] }}</td>
                        <td>{{ $jsondata["body"] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
        @php
            $i = 1;
            // Get the current URL without the query string...
            echo url()->current();
            
            // Get the current URL including the query string...
            echo url()->full();
            
            // Get the full URL for the previous request...
            echo url()->previous();
            echo Auth::user()->email;
        @endphp
        {{ $companies->links() }}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script>
            function loadlink() {
                currLoc = $(location).attr("href");
                console.log(currLoc);
                // $("#container").load(currLoc, function() {
                //     $('#container').unwrap();
                // });
                var spinner = "<img src='http://i.imgur.com/pKopwXp.gif' alt='loading...' />";
                $(".reload").html(spinner).load(currLoc);
                
            }
            
            $(document).on('click', '.delete', function(e) {
                var id = $(this).attr("id");
              
                // e.preventDefault();
                swal({
                        title: `Are you sure you want to delete this record?`,
                        text: "If you delete this, it will be gone forever.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((isConfirm) => {
                        if (isConfirm) {
                            $.ajax({
                                url: "{{ url('companies') }}" + '/' + id,
                                type: "POST",
                                data: {
                                    '_method': 'DELETE',
                                    '_token': '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    swal(
                                        "Deleted!",
                                        "Your record has been deleted.",
                                        "success"
                                    ).then(() => {
                                        loadlink();
                                    });
                                }
                            });
                        }
                    });
            });
            $('#search').on('keyup', function() {
                $value = $(this).val();
                $.ajax({
                    type: 'get',
                    url: '{{ URL::to('companies') }}',
                    data: {
                        'search': $value
                    },
                    success: function(data) {
                        $('#tbody').html(data);
                    }
                });

            })
            $('#showjson').on('click', function() {
                $("#showdata").toggle();
            })
        </script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'csrftoken': '{{ csrf_token() }}'
                }
            });
        </script>
</body>

</html>
