@csrf
<div class="form-group">
    <lable for="id">id:</lable>
    <input type="text" name="id" id="id" value="{{old('id',$post->id ?? null)}}" class="form-control">
</div>
<div class="form-group">

    <lable for="content">Title:</lable>
    <input name="title" id="title" type="text" value="{{old('content',$post->title ?? null)}}" class="form-control">
</div>
<div class="form-group">

    <lable for="content">Content:</lable>
    <input name="content" id="content" type="text" value="{{old('content',$post->content ?? null)}}" class="form-control">
</div>
<div class="form-group">
    <lable for="picture">Add picture</lable>
    <input type="file" name="picture" id="picture" class="form-control-file">
</div>
<x-erros myClass="warning"></x-erros>