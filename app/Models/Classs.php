<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classs extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function student_classes(): HasMany
    {
        return $this->hasMany(StudentClass::class, 'class_id');
    }
}
