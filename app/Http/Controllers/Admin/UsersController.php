<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Orders\ByActive;
use App\Filters\Users\ByKeyword;
use App\Filters\Users\ByGender;
use App\Filters\Users\ByLevel;
use App\Filters\Users\ByStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Order;
use App\Models\ProductInOrder;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    //
    public function index() {

        $orderBy = [];

        if(!is_null(request()->sort_by)) {
            switch (request()->sort_by) {
                case 0:
                    $orderBy = ['created_at', 'desc'];
                    break;
                case 1:
                    $orderBy = ['created_at', 'asc'];
                    break;
            }
        }

        $pipelines = [
            ByKeyword::class,
            ByGender::class,
            ByLevel::class,
            ByStatus::class,
        ];

        $pipeline = Pipeline::send(User::query())
        ->through($pipelines)
        ->thenReturn();


        if($orderBy) {
            $users = $pipeline->orderBy('users.'.$orderBy[0], $orderBy[1])->paginate(10);
        } else {
            $users = $pipeline->paginate(10);
        }

        return view('admin.pages.users.index', ['users' => $users]);
    }

    public function store(StoreUserRequest $request) {

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'status' => $request->status,
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

        $msg = $user && $user_info
        ? '<div class="alert alert-success alert-dismissible">User created successfully</div>' 
        : '<div class="alert alert-danger alert-dismissible">User created failed</div>';

        return redirect()->route('admin.users.index')->with('message', $msg);
    }
    public function create() {
        return view('admin.pages.users.create');
    }

    public function show(User $user) {
        
        $pipelines = [
            ByActive::class,
        ];

        $pipeline = Pipeline::send(Order::query())
        ->through($pipelines)
        ->thenReturn();


        $orders = $pipeline->where('user_id', $user->id)->paginate(10);

        return view('admin.pages.users.show', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user) {

        $update_user = $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'level' => $request->level,
            'status' => $request->status,
            'phone_number' => $request->phone_number,
            'updated_at' => Carbon::now(),
        ]); 
        if (!is_null(request()->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        $update_user_info = UserInfo::where('user_id', $user->id)
        ->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'updated_at' => Carbon::now(),
        ]);

        $msg = $update_user && $update_user_info
        ? '<div class="alert alert-success alert-dismissible">User updated successfully</div>' 
        : '<div class="alert alert-danger alert-dismissible">User updated failed</div>';

        return redirect()->route('admin.users.index')->with('message', $msg);
    }

    public function destroy(User $user) {

        if (User::where('level', 1)->get()->count() > 1) {
            UserInfo::where('user_id', $user->id)->delete();
    
            $check = $user->delete();
        } else {
            $check = false;
        }

        $msg = $check
        ? '<div class="alert alert-success alert-dismissible">User deleted successfully</div>' 
        : '<div class="alert alert-danger alert-dismissible">User deleted failed</div>';

        return redirect()->route('admin.users.index')->with('message', $msg);
        
    }

    public function edit(User $user) {
        return view('admin.pages.users.edit1', ['user' => $user]);
    }

    public function changeStatus(Request $request, User $user) {
        $check = $user->update([
            'status' => $request->status,
        ]);

        $status_word = $request->status == 0 ? 'blocked' : 'unblocked';
        if ($check) {
            $msg = '<div class="alert alert-success alert-dismissible">User ' . $status_word . ' successfully</div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">User ' . $status_word . ' failed</div>';
        }
    
        return redirect()->route('admin.users.index')->with('message', $msg);
    }


    public function getSlug(Request $request) {
        $slug = Str::slug($request->name);
        return $slug;
    }

    

}
