<?php

namespace App\Http\Controllers\FrontController;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag_Post;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function login(){
        return view('client.login');
    }

    public function register(){
        return view('client.register');
    }

    public function index(){
        $postEdittor = Post::where('is_editors_pick',1)->first();
        $post_tag = Tag_Post::where('post_id',$postEdittor->id)->with('Tags');
        return view('client.home',[
            'postEdittor' => $postEdittor,
            'post_tag' => $post_tag
        ]);
    }

    public function detail($id){
        $post = Post::find($id);
        return view('client.post-detail',[
            'post' => $post
        ]);
    }

    public function list(){
        return view('client.list');
    }

    public function about(){
        return view('client.about');
    }

    public function profile(){
        return view('client.profile');
    }
}
