<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilActHint extends Model
{
    use HasFactory;

    public function filActQuestion(): BelongsTo
    {
        return $this->belongsTo(FilActQuestion::class);
    }
}
