<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{
    use HasFactory;
    
    public $table = 'users';
    protected $guarded = [];
    protected $hidden = [
        'password',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
