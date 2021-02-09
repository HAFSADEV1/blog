@extends('home')
@section('content')
<form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
    @include('posts.form')

    <button type="submit" class="btn btn-primary m-2">Create</button>

</form>
@endsection