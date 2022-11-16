@extends('dashboard')

@section('title')
    User Profile
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .form-check-label {
            text-transform: capitalize;
        }
    </style>
@endsection

@section('content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">User Profile</h4>
                    
                    <ul class="breadcrumbs pull-left">
                        <h5>Profile crearted_at</h5>
                        {{-- <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
                       
                        <li>{{ $admin->created_at->diffForHumans(now(), Carbon\CarbonInterface::DIFF_RELATIVE_AUTO, true, 6) }}
                        {{-- </li>
                        <li>{{ $admin->created_at->diffForHumans(now(), Carbon\CarbonInterface::DIFF_RELATIVE_AUTO, true, 5) }}
                        </li>
                        <li>{{ $admin->created_at->diffForHumans(now(), Carbon\CarbonInterface::DIFF_RELATIVE_AUTO, true, 4) }}
                        </li>
                        <li>{{ $admin->created_at->diffForHumans(now(), Carbon\CarbonInterface::DIFF_RELATIVE_AUTO, true, 3) }}
                        </li>
                        <li>{{ $admin->created_at->diffForHumans(now(), Carbon\CarbonInterface::DIFF_RELATIVE_AUTO, true, 2) }}
                        </li> --}}
                        <li>{{ $admin->created_at->diffForHumans() }}</li>
                        <li>{{ $admin->created_at->diffForHumans(['parts' => 5]) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- page title area end -->

    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">User Name - {{ $admin->name }}</h4>
                        @include('messages')
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <div class="user-profile-img">

                                    <img src="/image/{{ $admin->image }}" alt="image" name='image' class="avatar1">
                                    <div class="user-title">
                                        <center>
                                            <h4>
                                                {{ $admin->name }}
                                            </h4>
                                        </center>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <b>User Name</b> :: {{ $admin->name }}<br><br>
                                <b>Assign Roles</b> :: {{ $admin->roles[0]->name }}<br><br>
                                <b>Admin Username</b> :: {{ $admin->username }}<br><br>
                                <b>Email</b> :: {{ $admin->email }}<br><br>
                            </div>
                        </div>

                        <a href="{{ route('profile.edit', $admin->id) }}" class="btn btn-primary mt-4 pr-4 pl-4">Edit
                            User</a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        })
    </script>
@endsection
