<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientUpdateUserRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //
    public function edit() {
        return view('client.pages.users.edit');
    }

    public function update(ClientUpdateUserRequest $request) {
        
        $user = User::firstWhere('id', Auth::user()->id);
        
        $user->update([
            'email' => $request->email,
            'username' => $request->username,
            'phone_number' => $request->phone_number
        ]);
        if (!is_null(request()->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        UserInfo::firstWhere('user_id', $user->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ]);
        return redirect()->back()->with('message', 'Update successfully');

    }
}
