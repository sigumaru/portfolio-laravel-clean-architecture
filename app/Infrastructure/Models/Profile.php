<?php

declare(strict_types=1);

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class Profile extends Model
{
    use HasUuids;

    protected $table = 'profiles';

    protected $fillable = [
        'name',
        'title',
        'bio',
        'profile_image',
        'skills',
        'experience',
        'education',
        'social_links',
    ];

    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
        'education' => 'array',
        'social_links' => 'array',
    ];
}