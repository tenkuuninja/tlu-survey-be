<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    protected $hidden = [
        'password_hashed',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
