<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * Get the post that owns the comment.
     */
    protected $fillable = ['body', 'user_id'];

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    //Local Scope
    public function scopeDernier(Builder $query)
    {
        return $query->orderBy(static::UPDATED_AT, 'asc');
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function (Comment $comment) {
            Cache::forget("post-show-{$comment->post->id}");
        });
    }
}
