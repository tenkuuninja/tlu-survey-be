<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSurvey extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CREATED_AT = 'completed_at';
    const UPDATED_AT = null;

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }
}
