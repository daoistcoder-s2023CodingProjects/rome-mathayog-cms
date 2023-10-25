<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExeFeedback extends Model
{
    use HasFactory;

    public function exeChoice(): BelongsTo
    {
        return $this->belongsTo(ExeChoice::class);
    }
}
