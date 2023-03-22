<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    public function index(Request $request)
    {
        $query = GradeLevel::with('department');
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
}
