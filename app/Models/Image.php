<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

            // Update the uploader field with the first name of the user
            if ($user) {
                $image->uploader = $user->firstname ?? $user->email;
            }
        });
    }
}
