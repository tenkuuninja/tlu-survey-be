<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSurveySection extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    const CREATED_AT = 'completed_at';
}
