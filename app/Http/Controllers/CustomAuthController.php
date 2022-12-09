<?php
namespace App\Http\Controllers;

use App\Events\LoginHistory;
use App\Models\Admin;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Socialite;
use Spatie\Permission\Models\Role;

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
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'facebook',
                    'password' => encrypt('my-facebook'),
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
        // dd($checktrashed);
        // $checktrashed = Admin::where('email', $request->input('email'))->onlyTrashed()->first();
        $request->validate([
            'email' => ['required',
                // function ($checktrashed, $fail) {
                //     if ($checktrashed!= null) {
                //         $fail('your account has been deleted, Please contact admin!!');
                //     }
                // },
            ],
            'password' => 'required',
        ]);
        // dd(Admin::all());
        $remember_me = $request->has('remember') ? true : false;
        if (Auth::guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {

            // dd($user);
            // dd($remember_me);
            $user = Auth::user();
            event(new LoginHistory($user));
            return redirect()->intended('home')
                ->withSuccess('Signed in');
        } else {
            // dd(Admin::where('id', '20')->onlytrashed()->find());
            $checktrashed = Admin::where('email', $request->input('email'))->onlyTrashed()->first();
            // dd($checktrashed);
            if($checktrashed != null){
                    return redirect()->route('login')->with('error', 'your account has been deleted, Please contact admin!!')->withInput();
            }

        //some stuff for soft deleted user

            // return back()->with('error','your username and password are wrong.');
            // dd($request->input('email'));
            // $users = Admin::onlyTrashed()->get();
            // // $users->email()->withTrashed()->get();
            //     // Admin::withTrashed()->find('20')->restore();
            //     // dd(Admin::onlytrashed()->where('id', '20')->find());
            //     dd($users['0']['email']);
            // dd(Admin::withTrashed()->find($request->input('email')));
            // $trashed=Admin::withTrashed()->find('19');
            // return redirect("login")->withSuccess('Login details are not valid');
            
            return redirect()->route('login')->with('error', 'Login details are not valid.')->withInput();
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
        $roles = Role::all();
        return view('auth.registration', compact('roles'));
    }

    public function customRegistration(Request $request)
    {
        $rules = ['captcha' => 'required|captcha_api:' . request('key') . ',math'];
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
            ['name' => 'required',
                'email' => 'required|email|unique:admins',
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
            if ($request->roles) {
                $check->assignRole($request->roles);
            }
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
        return Admin::create([
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
