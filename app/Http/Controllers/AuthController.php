<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login() {
        if (Auth::check()) {
            return redirect()->route('/');
        }
        return view('client.pages.auth.login');
    }

    public function postLogin(LoginRequest $request) {

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];


        if (Auth::attempt($data)) {
            if (Auth::user()->level == 1) {
                return redirect()->route('admin.index');
            } else {
                return redirect()->route('/');
            }
        } else {
            return redirect()->back()->withInput()->withErrors('No Match For E-Mail Address And/Or Password.');
        }
    }

    public function signup() {
        if (Auth::check()) {
            return redirect()->route('/');
        }
        return view('client.pages.auth.signup');
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(SignupRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 0,
            'status' => 1,
            'phone_number' => $request->phone_number,
            'created_at' => Carbon::now(),
        ]); 
        $user_info = UserInfo::create([
            'user_id' => $user->id,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'created_at' => Carbon::now(),
        ]);

        if ($user_info && $user) {
            $msg = 'Account created successfully';
            Auth::attempt([
                'email' => $user->email,
                'password' => $request->password
            ]);
        } else {
            $msg =  'Account created failed';
        }



        return redirect()->route('/', [
            'message' => $msg
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('/');
    }

}
