<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use Hash;
use Socialite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mews\Captcha\Facades\Captcha;   
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFB()
    {
        return Socialite::driver('facebook')->redirect();
    }
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('social_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                return redirect('/home');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'social_type'=> 'facebook',
                    'password' => encrypt('my-facebook')
                ]);
                Auth::login($newUser);
                return redirect("dashboard")->withSuccess('You have signed-in');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

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
        // dd(Admin::all());
        $remember_me = $request->has('remember') ? true : false;
        if (Auth::guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {
            $user = auth()->user();
            // dd($user);
            // dd($remember_me);
            return redirect()->intended('home')
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
        Session::flush();
        Auth::guard('admin')->logout();

        return Redirect('login');
    }
}
