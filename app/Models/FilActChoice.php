<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FilActChoice extends Model
{
    use HasFactory;

    public function filActQuestion(): BelongsTo
    {
        return $this->belongsTo(FilActQuestion::class);
    }

    public function filActFeedback(): HasOne
    {
        return $this->hasOne(FilActFeedback::class);
    }

    public function actChoice(): BelongsTo
    {
        return $this->belongsTo(ActChoice::class);
    }

}
