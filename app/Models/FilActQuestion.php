<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FilActQuestion extends Model
{
    use HasFactory;

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function filActChoices(): HasMany
    {
        return $this->hasMany(FilActChoice::class);
    }
    
    public function filActHints(): HasMany
    {
        return $this->hasMany(FilActHint::class);
    }

    // belongsTo ActQuestion
    public function actQuestion(): BelongsTo
    {
        return $this->belongsTo(ActQuestion::class);
    }
}
