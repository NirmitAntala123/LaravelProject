<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'Laravel Role Admin')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    @yield('styles')
   
</head>

<body>
    @php
     $user = Auth::guard('admin')->user();
 @endphp
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="#">Laravel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               
                           <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                            </li>
                            @else
                                @if ($user->can('admin.view'))
                                    <li><a class="nav-link {{ Route::is('admins.index') ? 'active' : '' }}" href="{{ route('admins.index') }}">Manage Admins</a></li>
                                @endif
                                @if ($user->can('role.view'))
                                    <li><a class="nav-link {{ Route::is('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">Manage Role</a></li>
                                @endif
                                @if ($user->can('company.view'))
                                    <li><a class="nav-link {{ Route::is('companies') ? 'active' : '' }}" href="{{ route('companies') }}">Manage Company</a></li>
                                @endif
                                <li class="nav-item dropdown">
                                    
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <img src="/image/{{$user->image}}" alt="Avatar" class="avatar">    {{ Auth::user()->name }}<span class="caret"></span>
                                    </a>
    
    
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @if ($user->can('profile.view'))
                                        <a class="nav-link" href="{{ route('profile.index') }}">Profile</a>
                                        @endif
                                        <a class="nav-link" href="#">Settings</a>
                                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                                    
                                    </div>
                                </li>
                            @endguest
                        </ul>

            </div>
           
        </div>
       
    </nav>
    {{-- @if ($message = Session::get('success'))
        <p class="alert alert-success">{{ $message }}</p>
    @endif --}}

    <div class="container">

       
 
         <!-- main content area start -->
         {{-- <div class="main-content"> --}}
             {{-- @include('backend.layouts.partials.header') --}}
             @yield('content')
         {{-- </div> --}}
         <!-- main content area end -->
        
         
     </div>
    {{-- @include('scripts') --}}
    {{-- @yield('content') --}}
    @yield('scripts')
</body>

  
</html>
