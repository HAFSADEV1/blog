<x-card title="Active Users">
    @foreach ($mostComments as $post)
    <li class="list-group-item"><a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->content}}</a></li>
    <li class="list-group-item"><span class="badge badge-success">{{$post->comments_count}} </span></li>
    @endforeach
</x-card>

<x-card title="Active Users" :items="collect($activeUsers)->pluck('posts_count')">
</x-card>

<x-card title="Active Users In Last Month" :items="collect($mostActiveUserInLastMonth )->pluck('name')">
</x-card>