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
        $posts = Post::orderBy('title', 'ASC')->where('user_id', Auth::user()->id)->paginate(10);
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

        if (!empty($request->thumbnail)) {
            $image = $request->thumbnail;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/post'), $imageName);
            $post->thumbnail = $imageName;
            $post->save();
        }


        foreach ($request->tag as $tag) {
            $tag_id = explode(',', $tag);
            $post->Tags()->attach($tag_id);
        }

        return redirect()->route('author.index')->with('success', 'Bài viết của bạn đã đăng thành công. Bài viết bạn sẽ được duyệt trong thời gian tới.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tags = Tag::all();
        $post = Post::with('Tags')->findOrFail($id);
        return view('client.author.edit', compact(['post', 'tags']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'tag' => 'required|min:1',
            'content' => 'required',
            'thumbnail' => 'image'
        ]);

        if ($validator->fails()) {
            return redirect()->route('author.edit', $id)->withInput()->withErrors($validator);
        }

        $post = Post::findOrFail($id);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->slug = \Str::slug($request->title);
        $post->save();

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && file_exists(public_path('uploads/post/' . $post->thumbnail))) {
                unlink(public_path('uploads/post/' . $post->thumbnail));
            }

            $image = $request->thumbnail;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/post'), $imageName);
            $post->thumbnail = $imageName;
            $post->save();
        }


        $post->tags()->sync($request->tag);

        return back()->with('success', 'Bài viết của bạn đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->thumbnail && file_exists(public_path('uploads/post/') . $post->thumbnail)) {
            unlink(public_path('uploads/post/') . $post->thumbnail);
        }
        $post->delete();
        return response()->json(['message' => 'Bài viết đã được xóa thành công.'], 200);
    }
}

/**
 * Display the specified resource.
 */
