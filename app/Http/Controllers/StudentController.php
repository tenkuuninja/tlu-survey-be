<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Student::with('department')->get();
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
        Student::create([
            'code' => $request->code,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'username' => $request->username,
            'password_hashed' => password_hash($request->password_hashed, PASSWORD_BCRYPT),
            'email' => $request->email,
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'sex' => $request->sex,
            'status' => $request->status,
        ]);
        return ['result' => 'success'];
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = Student::find($id);
        $item->code = $request->code;
        $item->name = $request->name;
        $item->department_id = $request->department_id;
        $item->username = $request->username;
        $item->password_hashed = password_hash($request->password_hashed, PASSWORD_BCRYPT);
        $item->email = $request->email;
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
        Student::destroy($id);
        return ['result' => 'success'];
    }
}
