<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

use function PHPUnit\Framework\throwException;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $user = null;
        switch ($request->role) {
            case 'admin':
                $user = Admin::where('username', $request->username)->first();
                break;
            case 'teacher':
                $user = Teacher::where('username', $request->username)->first();
                break;
            case 'student':
                $user = Student::where('username', $request->username)->first();
                break;

            default:
                # code...
                break;
        }
        if ($user == null) {
            return response(['errorMessage' => 'Bạn đã nhập sai tên đăng nhập hoặc mật khẩu'], 400);
        }
        if ($user->status != 1) {
            return response(['errorMessage' => 'Tài khoản đã ngừng hoạt động'], 400);
        }
        $match = password_verify($request->password, $user->password_hashed);
        if (!$match) {
            return response(['errorMessage' => 'Bạn đã nhập sai tên đăng nhập hoặc mật khẩu'], 400);
        }

        $payload = JWTFactory::sub($user->id)
            ->myCustomArray([
                'role' => $request->role,
                'id' => $user->id,
                'name' => $user->name,
            ])
            ->make();

        $token = JWTAuth::encode($payload);

        return [
            'token' => $token->get(),
            'role' => $request->role,
            'user' => $user,
        ];
    }

    public function get_current_user(Request $request)
    {
        $payload = JWTAuth::parseToken()->getPayload()->get('myCustomArray');
        $user = null;
        switch ($payload['role']) {
            case 'admin':
                $user = Admin::find($payload['id']);
                break;
            case 'teacher':
                $user = Teacher::find($payload['id']);
                break;
            case 'student':
                $user = Student::find($payload['id']);
                break;

            default:
                # code...
                break;
        }
        if ($user == null) {
            return response(['message' => 'User not exist'], 400);
        }

        return [
            'role' => $payload['role'],
            'user' => $user,
        ];
    }

    public function change_password(Request $request)
    {
        $payload = JWTAuth::parseToken()->getPayload()->get('myCustomArray');
        $user = null;
        switch ($payload['role']) {
            case 'admin':
                $user = Admin::find($payload['id']);
                break;
            case 'teacher':
                $user = Teacher::find($payload['id']);
                break;
            case 'student':
                $user = Student::find($payload['id']);
                break;

            default:
                # code...
                break;
        }
        if ($user == null) {
            return response(['errorMessage' => 'Bạn đã nhập sai tên đăng nhập hoặc mật khẩu'], 400);
        }
        if ($user->status != 1) {
            return response(['errorMessage' => 'Tài khoản đã ngừng hoạt động'], 400);
        }
        $match = password_verify($request->old_password, $user->password_hashed);
        if (!$match) {
            return response(['errorMessage' => 'Mật khẩu cũ không chính xác'], 400);
        }

        $password_hashed = password_hash($request->new_password, PASSWORD_BCRYPT);

        $user->password_hashed = $password_hashed;
        $user->save();

        return [
            'result' => 'success'
        ];
    }
}
