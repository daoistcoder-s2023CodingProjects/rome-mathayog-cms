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

    // belongsTo ActQuestion
    public function actQuestion(): BelongsTo
    {
        return $this->belongsTo(ActQuestion::class);
    }

    // Update activity_id when creating a new record
    protected static function booted()
    {
        static::creating(function ($filActQuestion) {
            // Get the act_question_id from the request
            $actQuestion = ActQuestion::find($filActQuestion->act_question_id);

            // Update the activity_id and other fields
            if ($actQuestion) {
                $filActQuestion->activity_id = $actQuestion->activity_id;
                $filActQuestion->question_graphics = $actQuestion->question_graphics ?? null;
                $filActQuestion->learning_tools = $actQuestion->learning_tools ?? null;
                $filActQuestion->question_type = $actQuestion->question_type ?? null;
            }
        });
    }
    
    public function filActChoices(): HasMany
    {
        return $this->hasMany(FilActChoice::class);
    }

    public function filActHints(): HasMany
    {
        return $this->hasMany(FilActHint::class);
    }
}
