<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Exception;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login','register']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if(!Auth::attempt($credentials)) {
            return response()->json([
                'login_status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        } else {
            $user = Auth::user();
            $role = $user->roles->pluck('name')[0];
            $token = $user->createToken('AuthToken')->accessToken;
            return response()->json([
                'login_status' => 'success',
                'user' => $user,
                'token' => $token,
                'role' => $role,
            ]);
        }
    }

    public function register(Request $request)
    {
        try
        {
            DB::beginTransaction();
                $user = User::create([
                    'name' => ucwords($request->name),
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                ]);
            DB::commit();
            $role = Role::firstOrCreate(
                ['name' => 'admin'],
                ['guard_name' => 'web']
            );
            $user->assignRole($role);
            $token = $user->createToken('AuthToken')->accessToken;
            return response()->json([
                'admin_status' => 'success',
                'message' => 'User created successfully.',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'admin_status' => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
