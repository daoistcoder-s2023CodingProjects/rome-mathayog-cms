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

    // belongsTo ActChoice
    public function actChoice(): BelongsTo
    {
        return $this->belongsTo(ActChoice::class);
    }

    // Update activity_id when creating a new record
    protected static function booted()
    {
        static::creating(function ($filActChoice) {
            // Get the act_choice_id from the request
            $actChoice = ActChoice::find($filActChoice->act_choice_id);

            // Update the choice_graphics and correct fields
            if ($actChoice) {
                $filActChoice->act_question_id = $actChoice->act_question_id;
                $filActChoice->choice_graphics = $actChoice->choice_graphics ?? null;
                $filActChoice->correct = $actChoice->correct ?? null;
            }
        });
    }

    public function filActFeedback(): HasOne
    {
        return $this->hasOne(FilActFeedback::class);
    }
}
