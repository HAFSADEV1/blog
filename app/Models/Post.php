<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Scopes\ShowAdminDeletedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{

    use SoftDeletes;
    /**
     * Get the comments for the blog post.
     */
    protected $fillable = ['content', 'user_id', 'title'];
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->dernier();
    }

    public function scopeMostComments(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopePostsWithTagsAndCommets(Builder $query)
    {
        return $query->withCount('comments')->with(['user', 'tags']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function image()
    {
        return $this->hasOne(Image::class);
    }
    public static function boot()
    {

        static::addGlobalScope(new LatestScope);
        static::addGlobalScope(new ShowAdminDeletedScope);
        parent::boot();
        static::deleting(function (Post $post) {
            $post->comments()->delete();
        });

        static::updating(function (Post $post) {
            Cache::forget("post-show-{$post->id}");
        });

        static::restoring(function (Post $post) {
            $post->comments()->restore();
        });
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }
}
