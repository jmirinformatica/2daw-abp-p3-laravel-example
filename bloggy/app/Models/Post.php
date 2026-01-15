<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'author_id',
        'status_id'
    ];
    
    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commented()
    {
        return $this->belongsToMany(User::class, 'comments');
    }
    
    public function commentedByUser(User $user)
    {
        $count = Comment::where([
            ['author_id',  '=', $user->id],
            ['post_id', '=', $this->id],
        ])->count();

        return $count > 0;
    }

    public function commentedByAuthUser()
    {
        $user = auth()->user();
        return $this->commentedByUser($user);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    
    public function isPublished()
    {
        return $this->status_id === Status::PUBLISHED;
    }

    // Computed attributes
    
    public function excerpt() : Attribute
    {
        return Attribute::make(
            get: function () {        
                return substr($this->body, 0, 20) . "...";
            }
        );
    }   
}
