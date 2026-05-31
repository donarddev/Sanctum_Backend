<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saint extends Model
{
    protected $fillable = [
        'name',
        'feast_month',
        'feast_day',
        'title',
        'short_story',
        'full_story',
        'image_path',
        'virtue',
        'life_lesson',
        'prayer',
        'source_name',
        'source_url',
    ];
}