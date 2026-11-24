<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title',
    'body',
    'author_id',
    'status_id',
])]
class Post extends Model
{
    use HasFactory;

    // Relationships

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function user(): BelongsTo
    {
        return $this->author();
    }
    
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function commented(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'comments',
            'post_id',
            'author_id'
        );
    }

    public function commentedByUser(User $user): bool
    {
        return Comment::where([
            ['author_id', '=', $user->id],
            ['post_id', '=', $this->id],
        ])->exists();
    }

    public function commentedByAuthUser(): bool
    {
        $user = auth()->user();

        return $user !== null && $this->commentedByUser($user);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    // Business logic

    public function isPublished(): bool
    {
        return $this->status_id === Status::PUBLISHED;
    }

    // Computed attributes

    protected function excerpt(): Attribute
    {
        return Attribute::make(
            get: fn () => substr($this->body, 0, 20) . '...'
        );
    }
}
