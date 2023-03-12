<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function option () {
        return $this->hasOne(SurveyOption::class);
    }

    public function questions () {
        return $this->hasMany(Question::class);
    }

}
