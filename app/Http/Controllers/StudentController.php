<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classs;
use App\Models\StudentClass;
use App\Models\UserModel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = UserModel::with('department')
            ->with('grade_level')
            ->where('role', 'student');
            
        if (strlen($request->query('department', '')) > 0) {
            $query = $query->where('department_id', $request->query('department'));
        }
        if (strlen($request->query('grade_level', '')) > 0) {
            $query = $query->where('grade_level_id', $request->query('grade_level'));
        }
        if (strlen($request->query('class', '')) > 0) {
            $query = $query
                ->whereIn(
                    'id',
                    StudentClass::where('class_id', $request->query('class'))
                        ->select('student_id')
                        ->get()
                );
        }
        if (strlen($request->query('search', '')) > 0) {
            $search = $request->query('search');
            $query = $query->where(function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $data = $query->get();
        return ['data' => $data];
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'code' => ['required'],
            'department_id' => ['required'],
            'grade_level_id' => ['required'],
            'username' => ['required'],
            'password' => ['required', 'min:8', 'max:20'],
            'citizen_id' => ['required'],
            'address' => ['required'],
            'phone_number' => ['required', 'regex:/^(84|0[3|5|7|8|9])+([0-9]{8})$/g'],
        ]);

        if (UserModel::where('code', $request->code)->exists()) {
            return response(['errorMessage' => 'Mã sinh viên đã tồn tại'], 400);
        }

        if (UserModel::where('username', $request->username)->exists()) {
            return response(['errorMessage' => 'Tên đăng nhập đã tồn tại'], 400);
        }

        if (UserModel::where('phone_number', $request->phone_number)->exists()) {
            return response(['errorMessage' => 'Số điện thoại đã tồn tại'], 400);
        }

        if (UserModel::where('citizen_id', $request->citizen_id)->exists()) {
            return response(['errorMessage' => 'Căn cước công dân đã tồn tại'], 400);
        }

        UserModel::create([
            'name' => $request->name,
            'code' => $request->code,
            'department_id' => $request->department_id,
            'grade_level_id' => $request->grade_level_id,
            'username' => $request->username,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'email' => $request->code . '@e.tlu.edu.vn',
            'citizen_id' => $request->citizen_id,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'sex' => $request->sex,
            'status' => $request->status,
            'role' => 'student',
        ]);

        return ['result' => 'success'];
    }

    /**
     * Display the specified resource.
     */
    public function show(UserModel $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserModel $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'code' => ['required'],
            'department_id' => ['required'],
            'grade_level_id' => ['required'],
            'username' => ['required'],
            'password' => ['min:8', 'max:20'],
            'citizen_id' => ['required'],
            'address' => ['required'],
            'phone_number' => ['required', 'regex:/^(84|0[3|5|7|8|9])+([0-9]{8})$/g'],
        ]);

        $user = UserModel::find($id);
        if ($user->code != $request->code && UserModel::where('code', $request->code)->exists()) {
            return response(['errorMessage' => 'Mã sinh viên đã tồn tại'], 400);
        }

        if ($user->username != $request->username && UserModel::where('username', $request->username)->exists()) {
            return response(['errorMessage' => 'Tên đăng nhập đã tồn tại'], 400);
        }

        if ($user->phone_number != $request->phone_number && UserModel::where('phone_number', $request->phone_number)->exists()) {
            return response(['errorMessage' => 'Số điện thoại đã tồn tại'], 400);
        }

        if ($user->citizen_id != $request->citizen_id && UserModel::where('citizen_id', $request->citizen_id)->exists()) {
            return response(['errorMessage' => 'Căn cước công dân đã tồn tại'], 400);
        }

        $item = UserModel::find($id);
        $item->name = $request->name;
        $item->department_id = $request->department_id;
        $item->grade_level_id = $request->grade_level_id;
        $item->username = $request->username;
        if (isset($request->password) && strlen($request->password) > 0) {
            $item->password = password_hash($request->password, PASSWORD_BCRYPT);
        }
        $item->citizen_id = $request->citizen_id;
        $item->name = $request->name;
        $item->address = $request->address;
        $item->phone_number = $request->phone_number;
        $item->sex = $request->sex;
        $item->status = $request->status;
        $item->save();
        return ['result' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        UserModel::destroy($id);
        return ['result' => 'success'];
    }
}
