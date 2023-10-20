<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    use HasFactory;

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function exeQuestions(): HasMany
    {
        return $this->hasMany(ExeQuestion::class);
    }
}