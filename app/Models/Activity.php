<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasFactory;

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function actQuestions(): HasMany
    {
        return $this->hasMany(ActQuestion::class);
    }

    // hasMany filActQuestions
    public function filActQuestions(): HasMany
    {
        return $this->hasMany(FilActQuestion::class);
    }
}
