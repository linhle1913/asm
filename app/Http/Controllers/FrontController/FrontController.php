<?php

namespace App\Http\Controllers\FrontController;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function login(){
        return view('client.login');
    }

    public function register(){
        return view('client.register');
    }

    public function index(){
        $editor_posts = Post::with(['Tags', 'author'])->where([['is_editors_pick',1],['is_active',1]])->take(1)->get();
        $trending_posts = Post::with(['Tags', 'author'])->where([['is_trending',1],['is_active',1]])->take(5)->get();
        $popular_posts = Post::with(['Tags', 'author'])->where('is_active',1)->orderBy('views','desc')->take(1)->get();
        $new_posts = Post::with(['Tags', 'author'])->where('is_active',1)->orderBy('created_at','desc')->take(3)->get();
        $authors = User::where('role',0)->get();
        $tags = Tag::where('is_active',1)->get();
        return view('client.home',compact(['tags','editor_posts','trending_posts','authors','popular_posts','new_posts']));
    }

    public function detail($id){
        $post = Post::with(['Tags', 'author'])->find($id);
        $comments = Comment::with(['user'])->where('post_id',$id)->paginate(5);
        $post->views = $post->views + 1;
        $post->save();
        return view('client.post-detail',[
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function list($id){
        $user = '';
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
        }
        $authors = User::where('role',0)->get();
        $tags = Tag::all();
        $tagName = Tag::find($id);
        $tagId = $id;
        $posts = Post::whereHas('Tags', function ($query) use ($tagId) {
            $query->where([['id', $tagId],['is_active',1]]);
        })
        ->with('author')
        ->get();
        return view('client.list', compact('authors','tags','user','posts','tagName'));
    }

    public function search(Request $request){
        $authors = User::where('role',0)->get();
        $tags = Tag::all();
        $query = $request->input('query');
        $posts = Post::where([['title', 'LIKE', "%{$query}%"],['is_active',1]])->with(['Tags', 'author'])->get();
        return view('client.search', compact('posts','query','authors','tags'));
    }

    public function about(){
        return view('client.about');
    }

    public function profile(){
        return view('client.profile');
    }
}
