@extends('home')
@section('content')

</nav>
<h1>Posts List</h1>
<div class="row">
    <div class="col-8">
        <table border="0" class="table m-2">
            <th>Content</th>
            <th>Comment Count</th>
            <th>Edit</th>
            <th>Delete</th>
            @foreach ($posts as $post)
            <tr>

                <td>
                    @if ($post->created_at->diffInHours()<1) <x-badge type="success">New</x-badge>
                        @else
                        <x-badge type="dark">Old</x-badge>
                        @endif
                        @if ($post->Trashed())
                        <del>
                            {{$post->content}}
                        </del>
                        @else
                        <a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->content}}</a>
                        @endif
                        <br>

                        <x-tags :tags="$post->tags"></x-tags>
                        @if($post->image)
                        <img src="{{$post->image->url()}}" alt="">
                        @endif
                </td>
                <td>@if ($post->comments_count)
                    <p>{{$post->comments_count}} Comments</p>
                    @else
                    <p>No Comments Yet!!</p>
                    @endif
                </td>

                <td>
                    @auth
                    @can('update',$post)
                    <p class="text-muted">
                        <x-updated :date="$post->updated_at" :name="$post->user->name"></x-updated>
                    </p>
                    <a href="{{route('posts.edit',['post'=>$post->id])}}" class="btn btn-warning">Edit</a>
                </td>
                @endcan
                <td>
                    @cannot('delete',$post)
                    <x-badge type="danger">You Cant delete This Post</x-badge>
                    @endcannot
                    @if (!$post->deleted_at)
                    @can('delete',$post)
                    <form method="POST" action="{{route('posts.destroy',['post'=>$post->id])}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger m-2">DeLete</button>
                    </form>
                    @endcan
                    @else
                    @can('restore',$post)
                    <form method="POST" action="{{ url('/posts/'.$post->id.'/restore') }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success m-2">Restore</button>
                    </form>
                    @endcan
                    <!-- Force delete -->
                    @can('forcedelete',$post)
                    <form method="POST" action="{{ url('/posts/'.$post->id.'/forcedelete') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger m-2">Force Delete</button>
                    </form>
                    @endcan
                    @endif
                    @endauth
                </td>
            </tr>
            @endforeach
        </table>

    </div>
    <div class="col-4">
        @include("posts.sidebar")
    </div>


    @endsection