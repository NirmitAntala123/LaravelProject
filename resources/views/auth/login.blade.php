@extends('dashboard')
@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    @php if(auth()->user())
                    {
                       $login_email = Auth::user()->email;
                       $login_pass  = Auth::user()->password;
                    //    echo bcrypt($login_pass);
                       $is_remember = "checked='checked'";
                    }
                    else{
                       $login_email ='';
                       $login_pass = '';
                       $is_remember = "";
                     }
                    @endphp
                    <h3 class="card-header text-center">Login</h3>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login.custom') }}">
                            @csrf
                            <div class="form-group mb-3">
                            <input type="text" placeholder="Email" id="email" class="form-control" name="email" value='{{$login_email}}'required
                                    autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Password" id="password" class="form-control" name="password" value='{{$login_pass}}' required>
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{$is_remember}}> {{ __('Remember Me') }} 
                                    </label>
                                </div>
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Signin</button>
                            </div>
                            <div class="d-grid mx-auto">
                                <a href="{{ url('auth/facebook') }}" style="margin-top: 0px !important;background: green;color: #ffffff;padding: 5px;border-radius:5px;text-align: center;text-decoration: none;" class="ml-2">
                                    Facebook Login
                                  </a> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection