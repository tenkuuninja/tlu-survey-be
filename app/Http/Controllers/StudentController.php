<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = UserModel::with('department')
            ->where([['name', 'like', '%' . $request->query('search') . '%'], ['role', 'student']])
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
        UserModel::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'username' => $request->username,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'email' => $request->email,
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
        $item = UserModel::find($id);
        $item->name = $request->name;
        $item->department_id = $request->department_id;
        $item->username = $request->username;
        $item->password = password_hash($request->password, PASSWORD_BCRYPT);
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
        UserModel::destroy($id);
        return ['result' => 'success'];
    }
}
