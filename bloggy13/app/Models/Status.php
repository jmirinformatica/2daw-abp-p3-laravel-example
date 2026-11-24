<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
])]
class Status extends Model
{
    use HasFactory;

    public const DRAFT = 1;
    public const PUBLISHED = 2;
    public const HIDDEN = 3;

    public $timestamps = false;
}
