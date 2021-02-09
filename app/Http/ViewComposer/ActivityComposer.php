<?php

namespace App\Http\ViewComposer;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{

    public function compose(View $view)
    {
        $mostComments = Cache::remember('mostComments', now()->addMinutes(10), function () {
            return Post::mostComments()->take(5)->get();
        });
        $activeUsers = Cache::remember('activeUsers', now()->addMinutes(10), function () {
            return User::activeUsers()->take(5)->get();
        });
        $mostActiveUserInLastMonth = Cache::remember('mostActiveUserInLastMonth', now()->addMinutes(1), function () {
            return User::mostActiveUserInLastMonth()->take(5)->get();
        });

        $view->with([
            'mostComments' => $mostComments,
            'activeUsers' => $activeUsers,
            'mostActiveUserInLastMonth' => $mostActiveUserInLastMonth
        ]);
    }
}
