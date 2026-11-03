<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    const DRAFT     = 1;
    const PUBLISHED = 2;
    const HIDDEN    = 3;

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;
}
