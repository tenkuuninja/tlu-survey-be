<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Models\Classs;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payload = JWTAuth::parseToken()->getPayload()->get('myCustomArray');

        $query = Classs::with('teacher.department')
            ->with('subject.department')
            ->with('grade_level');

        if (strlen($request->query('grade_level', '')) > 0) {
            $query = $query->where('grade_level_id', $request->query('grade_level'));
        }

        if (strlen($request->query('search', '')) > 0) {
            $search = $request->query('search');
            $query = $query->where(function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        }
        switch ($payload['role']) {
            case 'teacher':
                $query = $query->where('teacher_id', $payload['id']);
                break;
            case 'student':
                $query = $query->whereIn(
                    'id',
                    StudentClass::where('student_id', $payload['id'])
                        ->select('class_id')
                        ->get()
                );
                break;

            default:
                # code...
                break;
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
        if (Classs::where('code', $request->code)->exists()) {
            return response(['errorMessage' => 'Mã lớp đã tồn tại'], 400);
        }

        Classs::create([
            'code' => $request->code,
            'name' => $request->name,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'status' => $request->status,
        ]);
        return ['result' => 'success'];
    }

    /**
     * Display the specified resource.
     */
    // public function show(Classs $classs)
    // {
    //     $data = UserModel::with('Classs')->with('StudentClass')
    //         ->where([
    //             ['role', 'student'],
    //             ['users.id', 'student_classes.user_id'],
    //             ['student_class.class_id', 'class.id']
    //         ])
    //         ->get();
    //     return ['data' => $data];
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Classs::find($id);
        if ($user->code != $request->code && Classs::where('code', $request->code)->exists()) {
            return response(['errorMessage' => 'Mã lớp đã tồn tại'], 400);
        }

        $item = Classs::find($id);
        $item->code = $request->code;
        $item->name = $request->name;
        $item->subject_id = $request->subject_id;
        $item->teacher_id = $request->teacher_id;
        $item->status = $request->status;
        $item->save();
        return ['result' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $check = StudentClass::where('class_id', $id)->exists();
        if ($check) {
            return response(['errorMessage' => 'Lớp học này vẫn còn sinh viên học'], 409);
        }
        Classs::destroy($id);
        return ['result' => 'success'];
    }

    /**
     * Add more student to class
     */
    // public function add(Request $request)
    // {
    //     StudentClass::create([
    //         'user_id' => $request->user_id,
    //         'class_id' => $request->class_id
    //     ]);
    //     return ['result' => 'success'];
    // }

    // public function delete($id)
    // {
    //     StudentClass::destroy($id);
    //     return ['result' => 'success'];
    // }

    public function get_list_student($id,)
    {
        $class = Classs::with('student_classes.student.department')->find($id);

        $students = [];

        foreach ($class->student_classes as $record) {
            array_push($students, $record->student);
        }

        return ['data' => $students];
    }

    public function add_student_to_class($class_id, $student_id)
    {
        StudentClass::updateOrCreate([
            'class_id' => $class_id,
            'student_id' => $student_id,
        ], [
            'class_id' => $class_id,
            'student_id' => $student_id,
        ]);
        return ['result' => 'success'];
    }

    public function delete_student_from_class($class_id, $student_id)
    {
        StudentClass::where([
            'class_id' => $class_id,
            'student_id' => $student_id,
        ])->delete();
        return ['result' => 'success'];
    }
}
