<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Subject::all();
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
        Subject::create([
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
    public function show(Subject $subject)
    {
        //
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
        $item = Subject::find($id);
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
        Subject::destroy($id);
        return ['result' => 'success'];
    }
}
