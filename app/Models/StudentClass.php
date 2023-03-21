<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentClass extends Model
{
    use HasFactory;

    public $timestamps = false; 
    protected $guarded = [];

    public function student(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'student_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classs::class, 'class_id');
    }

}
