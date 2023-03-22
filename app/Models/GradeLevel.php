<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeLevel extends Model
{
    use HasFactory;
    
    public $timestamps = false; 
    protected $guarded = [];
    
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
