
@extends('dashboard')

@section('title')
Admin Edit - Admin Panel
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
                <h4 class="page-title pull-left">profile Edit</h4>
                <ul class="breadcrumbs pull-left">
                    {{-- <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
                    <li><a href="{{ route('profile.index') }}">User Profilfe</a></li>
                   
                </ul>
            </div>
        </div>
        {{-- <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div> --}}
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit profile - {{ $admin->name }}</h4>
                    @include('messages')

                    <form action="{{ route('profile.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                       

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <div class="form-row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <div class="user-profile-img">
                                           
                                            <img src="/image/{{ $admin->image }}" alt="image" name='image' class="avatar1">
                                            <div class="user-title">
                                                <center> <h4>
                                                    {{ $admin->name }}
                                                </h4></center>
                                            </div>
                                            <input type="file" name="image" class="form-control" placeholder="image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="username">Admin Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $admin->username }}">

                                <label for="name">Admin Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $admin->name }}">
                           
                                <label for="email">Admin Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $admin->email }}">

                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password" placeholder="Enter Password">

                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">

                           
                            </div>
                            </div>
                       


                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Admin</button>
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