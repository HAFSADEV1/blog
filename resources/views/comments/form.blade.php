 @auth
 <form action="{{route('posts.comments.store',['post'=>$id])}}" method="POST">
     @csrf
     <h5>Add Comment</h5>
     <textarea name="body" id="body" rows="4" class="form-control my-3"></textarea>
     <x-erros></x-erros>
     <button class="btn btn-primary btn block">Create!</button>
 </form>
 @else
 <a href="" class="btn btn-success sm">Sign In To post a comment</a>
 @endauth