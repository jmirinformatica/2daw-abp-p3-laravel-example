<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\Attributes\Translatable;
use Spatie\Translatable\HasTranslations;

#[Fillable([
    'name',
])]
#[Translatable([
    'name'
])]
class Status extends Model
{
    use HasFactory, HasTranslations;

    public const DRAFT = 1;
    public const PUBLISHED = 2;
    public const HIDDEN = 3;

    public $timestamps = false;
}
