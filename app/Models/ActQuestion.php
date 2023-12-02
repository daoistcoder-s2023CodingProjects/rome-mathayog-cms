<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ActQuestion extends Model
{
    use HasFactory;

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function actChoices(): HasMany
    {
        return $this->hasMany(ActChoice::class);
    }
    
    public function actHints(): HasMany
    {
        return $this->hasMany(ActHint::class);
    }

    public function filActHints(): HasMany
    {
        return $this->hasMany(FilActHint::class);
    }

    // hasOne Fil-ActQuestion
    public function filActQuestion(): HasOne
    {
        return $this->hasOne(FilActQuestion::class);
    }
}
