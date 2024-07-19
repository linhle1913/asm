<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Tag_Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('title', 'ASC')->paginate(10);
        return view('client.author.list', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tag = Tag::orderBy('name', 'ASC')->where('is_active', 0)->get();
        return view('client.author.create', [
            'tag' => $tag
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'tag' => 'required|min:1',
            'content' => 'required',
            'thumbnail' => 'image'
        ]);

        if ($validator->fails()) {
            return redirect()->route('author.create')->withInput()->withErrors($validator);
        };

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->slug = \Str::slug($request->title);
        $post->save();

        if(!empty($request->thumbnail)){
            $image = $request->thumbnail;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('uploads/post'),$imageName);
            $post->thumbnail = $imageName;
            $post->save();
        }

        $postId = $post->id;

        foreach ($request->tag as $tag) {
            $tag_id = explode(',', $tag);
            $tags = last($tag_id);
            $tag_post = new Tag_Post();
            $tag_post->tag_id = $tags;
            $tag_post->post_id = $postId;
            $tag_post->save();
        }

        return redirect()->route('author.index')->with('success', 'Bài viết của bạn đã đăng thành công. Bài viết bạn sẽ được duyệt trong thời gian tới.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $tag = Tag::orderBy('name', 'ASC')->where('is_active', 0)->get();
        $tag_post = Tag_Post::where('post_id', $id)->get('tag_id');
        return view('client.author.edit', [
            'post' => $post,
            'tag' => $tag,
            'tag_post' => $tag_post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request, Post $post)
    {
        $post = Post::find($id);
        $tag_post = Tag_Post::where('post_id', $id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'tag' => 'required|min:1',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('author.create')->withInput()->withErrors($validator);
        };

        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->slug = \Str::slug($request->title);
        $post->save();

        $postId = $post->id;

        if ($request->tag == $tag_post) {
            foreach ($request->tag as $tag) {
                $tag_id = explode(',', $tag);
                $tags = last($tag_id);
                $tag_post = new Tag_Post();
                $tag_post->tag_id = $tags;
                $tag_post->post_id = $postId;
                $tag_post->save();
            }
        } else {
            foreach ($request->tag as $tag) {
                $tag_id = explode(',', $tag);
                $tags = last($tag_id);
                $tag_post->tag_id = $tags;
                $tag_post->post_id = $postId;
                $tag_post->save();
            }
        }


        return redirect()->route('author.index')->with('success', 'Bài viết của bạn đã đăng thành công. Bài viết bạn sẽ được duyệt trong thời gian tới.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}

/**
 * Display the specified resource.
 */
