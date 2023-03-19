<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Models\Classs;
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
    public function show(Classs $classs)
    {
<<<<<<< HEAD
        $data = Usermodel::with('Classs')->with('student_classes')
            ->where('role', 'student')
            ->where('users.id', 'student_classes.user_id')
            ->where('student_class.class_id', 'class.id')
=======
        $data=Usermodel::with('Classs')->with('StudentClass')
            ->where('role','student')
            ->where('users.id','student_classes.user_id')
            ->where('student_class.class_id','class.id')
>>>>>>> 2eb6c171372363ac80f8e637e40a8afed0954a9a
            ->get();
        return ['data' => $data];
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
        Classs::destroy($id);
        return ['result' => 'success'];
    }

    /**
     * Add more student to class
     */
    Public function add(Request $request)
    {
        StudentClass::create([
            'user_id'=> $request->user_id
            'class_id'=> $request->class_id
        ]);
        return ['result'=> 'success'];
    }

    Public function delete($id)
    {
        StudentClass::delete($user_id);
        return ['result' => 'success'];
    }
}
