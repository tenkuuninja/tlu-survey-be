<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Models\Classs;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Classs::with('teacher.department')->with('subject.department')
            ->where('code', 'like', '%' . $request->query('search') . '%')
            ->orWhere('name', 'like', '%' . $request->query('search') . '%')
            ->get();
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
            'grade_level_id' => $request->grade_level_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'status' => $request->status,
        ]);
        return ['result' => 'success'];
    }

    /**
     * Display the specified resource.
     */
    public function show(Classs $classs)
    {
        $data = UserModel::with('Classs')->with('StudentClass')
            ->where([
                ['role', 'student'],
                ['users.id', 'student_classes.user_id'],
                ['student_class.class_id', 'class.id']
            ])
            ->get();
<<<<<<< Updated upstream
        return ['data' => $data];
=======
        return['data' => $data];
>>>>>>> Stashed changes
    }

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
        $item->grade_level_id = $request->grade_level_id;
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
        Classs::destroy($id);
        return ['result' => 'success'];
    }

    /**
     * Add more student to class
     */
    public function add(Request $request)
    {
        StudentClass::create([
            'user_id' => $request->user_id,
            'class_id' => $request->class_id
        ]);
        return ['result' => 'success'];
    }

    public function delete($id)
    {
        StudentClass::destroy($id);
        return ['result' => 'success'];
    }

    public function get_list_student($id,)
    {
        $class = Classs::with('student_classes.student')->find($id);

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
            'user_id' => $student_id,
        ], [
            'class_id' => $class_id,
            'user_id' => $student_id,
        ]);
        return ['result' => 'success'];
    }

    public function delete_student_from_class($class_id, $student_id)
    {
        StudentClass::where([
            'class_id' => $class_id,
            'user_id' => $student_id,
        ])->delete();
        return ['result' => 'success'];
    }
}
