<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExeChoice extends Model
{
    use HasFactory;

    public function exeQuestion(): BelongsTo
    {
        return $this->belongsTo(ExeQuestion::class);
    }

    public function exeFeedback(): HasOne
    {
        return $this->hasOne(ExeFeedback::class);
    }
}
