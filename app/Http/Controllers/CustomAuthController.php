<?php
namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mews\Captcha\Facades\Captcha;   

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $remember_me = $request->has('remember') ? true : false;
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {
            $user = auth()->user();
            // dd($user);
            // dd($remember_me);
            return redirect()->intended('companies')
                ->withSuccess('Signed in');
        } else {
            // return back()->with('error','your username and password are wrong.');

            return redirect("login")->withSuccess('Login details are not valid');
        }

        // $credentials = $request->only('email', 'password');
        // if (Auth::attempt($credentials)) {
        //     return redirect()->intended('companies')
        //                 ->withSuccess('Signed in');
        // }

        // return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {
        $rules = ['captcha' => 'required|captcha_api:'. request('key') . ',math'];
        // $validator = validator()->make(request()->all(), $rules);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'invalid captcha',
        //     ]);
    
        // } else {
        //     //do the job
        // }
        $validator = Validator::make(
            $request->all(),
            [   'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'captcha' => 'required|captcha',
            ],
            ['captcha.captcha' => 'Enter valid captcha code shown in image'],
            // $rules
        ); // create the validations

        if ($validator->fails()) //check all validations are fine, if not then redirect and show error messages
        {
            return back()->withInput()->withErrors($validator);
        } else {
            $data = $request->all();
            // dd($data);
// exit;
            $check = $this->create($data);

            return redirect("dashboard")->withSuccess('You have signed-in');
            return response()->json(["status" => true, "message" => "Form submitted successfully"]);
        }

    }
    public function refreshCaptcha()
    { 
    
        return app('captcha')->generate();

    }
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withSuccess('registretion Successfully Done');
    }

    public function signOut()
    {
        // Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
