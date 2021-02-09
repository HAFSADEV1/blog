<?php

namespace App\Models;

use App\Scopes\ShowAdminDeletedScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeActiveUsers(Builder $query)
    {
        return $query->withCount('posts')->orderBy('posts_count', 'desc');
    }
    public function scopeMostActiveUserInLastMonth(Builder $query)
    {
        return $query->withCount('posts')->where(function (Builder $query) {
            $query->whereBetween(static::UPDATED_AT, [now()->subMonth(5), now()]);
        })->having('posts_count', '>', '2')->orderBy('posts_count', 'desc');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
