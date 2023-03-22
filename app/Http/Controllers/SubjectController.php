<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Models\Classs;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query  = Subject::with('department');
        if (strlen($request->query('department', '')) > 0) {
            $query = $query->where('department_id', $request->query('department'));
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
        if (Subject::where('code', $request->code)->exists()) {
            return response(['errorMessage' => 'Mã môn đã tồn tại'], 400);
        }

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
        $user = Subject::find($id);
        if ($user->code != $request->code && Subject::where('code', $request->code)->exists()) {
            return response(['errorMessage' => 'Mã môn đã tồn tại'], 400);
        }

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
        $check = Classs::where('subject_id', $id)->exists();
        if ($check) {
            return response(['errorMessage' => 'Môn học này đang có lớp học dạy'], 409);
        }
        Subject::destroy($id);
        return ['result' => 'success'];
    }
}
