<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilActFeedback extends Model
{
    use HasFactory;

    public function filActChoice(): BelongsTo
    {
        return $this->belongsTo(FilActChoice::class);
    }

    public function actChoice(): BelongsTo
    {
        return $this->belongsTo(ActChoice::class);
    }
}
