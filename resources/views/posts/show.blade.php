@extends('home')
@section('content')

<h1>Comments List</h1>

<div class="row">
    <div class="col-8">
        <span class="badge badge-primary">{{$post->title}}</span>
        <p>{{$post->content}}</p>
        <table border="0" class="table">
            <thead class="thead-dark">
                <th style="text-align: center">Body</th>
                <th style="text-align: center">Last Update</th>
                <th style="text-align: center">User Name</th>
            </thead>
            @foreach ($post->comments as $comment)
            <tr>
                <td style="text-align: center">{{$comment->body}}
                    <center>
                        <x-tags :tags="$post->tags"></x-tags>

                    </center>
                </td>
                <td style="text-align: center">{{$comment->updated_at->diffForHumans()}}</td>
                <td style="text-align: center">
                    <p class="text-muted">
                        <x-updated :date="$comment->created_at" :name="$comment->user->name"></x-updated>
                    </p>
                </td>
            </tr>
            @endforeach
        </table>
        <center>
            @include('comments.form',['id'=>$post->id])
        </center>

    </div>
    <div class="col-4">
        @include("posts.sidebar")
    </div>
    @endsection