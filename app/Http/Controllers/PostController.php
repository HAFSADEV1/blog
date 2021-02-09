<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('posts.index', [
            'posts' =>
            Post::postsWithTagsAndCommets()->get()
        ]);
    }

    public function archive()
    {
        //
        return view('posts.index', [
            'posts' =>
            Post::onlyTrashed()->withCount('comments')->get(),
            'mostComments' => Post::mostComments()->take(5)->get(),
            'activeUsers' => User::activeUsers()->take(5)->get(),
            'tab' => 'archive'
        ]);
    }

    public function all()
    {
        //
        return view('posts.index', [
            'posts' =>
            Post::withTrashed()->withCount('comments')->get(),
            'mostComments' => Post::mostComments()->take(5)->get(),
            'activeUsers' => User::activeUsers()->take(5)->get(),
            'tab' => 'all'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }



    public function store(StorePost $request)
    {
        $validateData = $request->validated();
        $validateData['user_id'] = $request->user()->id;
        $Post = Post::create($validateData);
        $request->session()->flash('status', 'post created successfully');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $postShow = Cache::remember("post-show-{$id}", 60, function () use ($id) {
            return Post::with(['comments', 'tags', 'comments.user'])->findOrFail($id); //eager
        });
        return view('posts.show', [
            'post' => $postShow
        ]);
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        //  if (Gate::denies('post.update', $post)) {
        //     abort(403,"You can't Edit this Post!!");
        // }
        $this->authorize('edit', $post);
        return view('posts.edit', ['post' => $post]);
    }
    public function update(StorePost $request, $id)
    {
        $post = Post::findOrFail($id);
        //   if (Gate::denies('post.update', $post)) {
        //     abort(403,"You can't Update this Post!!");
        // }
        $this->authorize('delete', $post);

        $post->content = $request->input('content');
        $post->save();
        $request->session()->flash('status', 'post was updated');
        return redirect()->route('posts.index');
    }
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        $post->delete();
        ////Or
        //Post::destroy($id)
        $request->session()->flash('status', 'post was Deleted');
        return redirect()->route('posts.index');
    }
    public function restore($id)
    {
        $post = Post::onlyTrashed()->where('id', $id)->first();
        $this->authorize('restore', $post);
        $post->restore();
        return redirect()->back();
    }
    public function forcedelete($id)
    {
        $post = Post::onlyTrashed()->where('id', $id)->first();
        $this->authorize('forcedelete', $post);
        $post->forcedelete();
        return redirect()->back();
    }
}
