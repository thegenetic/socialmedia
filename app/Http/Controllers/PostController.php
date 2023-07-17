<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct() {
        // do not let post if not logged in

        // $this->middleware(['auth'])->except('index','show') ;
        $this->middleware(['auth'])->only('store','destroy') ;
    }

    public function index()
    {

        // $posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->Paginate(10);
        $posts = Post::latest()->with(['user', 'likes'])->Paginate(10);
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post){
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        // $request->user()->posts()->create([
        //     'body' => $request->body
        // ]);
        $request->user()->posts()->create($request->only('body'));

        return back();
    }

    public function destroy(Post $post){

        $this->authorize('delete', $post);
        $post->delete();
        return back();
    }
}
