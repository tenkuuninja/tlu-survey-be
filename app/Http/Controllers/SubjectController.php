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
        $data = Subject::with('department')->get();
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
            'description' => $request->description,
            'credit_number' => $request->credit_number,
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
        $item->description = $request->description;
        $item->credit_number = $request->credit_number;
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
