<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        /**************************************************/        
        'avatar'
        /**************************************************/
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    // Authorization methods

    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    public function isPublisher(): bool
    {
        return !$this->isAdmin();
    }

    // Filament methods

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasVerifiedEmail();
    }
    
    public function getFilamentAvatarUrl(): ?string
    {
        return Storage::url($this->avatar);
    }

    // File methods

    public function uploadAvatar(UploadedFile $upload)
    {
        $uploadName = $upload->getClientOriginalName();
        $uploadSize = $upload->getSize();
        Log::debug("Storing file '{$uploadName}' ($uploadSize)...");
        $path = $upload->storeAs(
            "avatars/{$this->id}", // Path
            $uploadName,    // Filename
            'public'        // Disk
        );
        Log::debug("Uploaded file stored at $path");
        $this->avatar = $path;
    }

    // Computed attributes
    
    public function avatarUrl() : Attribute
    {
        return Attribute::make(
            get: function () {        
                $path = $this->avatar;
                if (empty($path) || str_starts_with($path, 'http')) {
                    return $path;
                } else {
                    return asset(Storage::url($path));
                }
            }
        );
    }    
}
