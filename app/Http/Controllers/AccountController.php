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
            return response(['errorMessage' => 'Tài khoản không tồn tại'], 400);
        }
        $match = password_verify($request->password, $user->password_hashed);
        if (!$match) {
            return response(['errorMessage' => 'Mật khẩu không chính xác'], 400);
        }
        $token = JWTAuth::encode(JWTFactory::make([
            'role' => 'admin',
            'id' => $user->id,
            'name' => $user->name,
        ]));

        return [
            'token' => $token->get(),
            'role' => $request->role,
            'user' => $user,
        ];
    }

    public function get_current_user(Request $request)
    {
        $payload = JWTAuth::parseToken()->getPayload();
        $role = $payload->get('role');
        $user = null;
        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->get('role');
        // switch ($request->role) {
        //     case 'admin':
        //         $user = Admin::where('username', $request->username)->first();
        //         break;
        //     case 'teacher':
        //         $user = Teacher::where('username', $request->username)->first();
        //         break;
        //     case 'student':
        //         $user = Student::where('username', $request->username)->first();
        //         break;

        //     default:
        //         # code...
        //         break;
        // }
        // if ($user == null) {
        //     return response(['message' => 'User not exist'], 400);
        // }
        // $match = password_verify($request->password, $user->password_hashed);
        // if (!$match) {
        //     return response(['message' => 'Password incorrect'], 400);
        // }
        // $token = JWTAuth::encode(JWTFactory::make([
        //     'role' => 'admin',
        //     'id' => $user->id,
        //     'name' => $user->name,
        // ]));

        return [
            // 'token' => $token->get(),
            'role' => $role,
            'payload' => $payload,
            'apy' => $apy,
            // 'user' => $user,
        ];
    }
}
