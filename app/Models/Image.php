<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['image_url', 'uploader', 'uploader_id'];

    protected static function booted()
    {
        static::creating(function ($image) {
            // Get the currently authenticated user
            $user = Auth::user();

            // Update the uploader field with the first name of the user also the uploader_id = current authenticated user:id
            if ($user) {
                $image->uploader = $user->firstname ?? $user->email;
                $image->uploader_id = $user->id;
            }

            // Update the preview_url field with the image_url
            if ($image->image_url) {
                $image->preview_url = $image->image_url;
            }
        });
    }

    // add a eloquent relationship to the user model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
