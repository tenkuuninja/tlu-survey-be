<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    public function index(Request $request)
    {
        $query = GradeLevel::where('name', 'like', '%' . $request->query('search', '') . '%')
            ->orWhere('code', 'like', '%' . $request->query('search', '') . '%');
        $data = $query->get();
        
        return ['data' => $data];
    }
}
