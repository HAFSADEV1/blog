@extends('home')
@section('content')
<form action="{{route('posts.update',['post'=>$post->id])}}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @include('posts.form')
    <button type="submit" class="btn btn-block btn-success">Update</button>
</form>
@endsection