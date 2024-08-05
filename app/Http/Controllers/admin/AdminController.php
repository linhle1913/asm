<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(){
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.list');
        }
        return view('admin.login');
    }

    public function authenticate(Request $request){
        Auth::guard('web')->logout();
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('admin.login')->withInput()->withErrors($validator);
        }

        $user = User::where([['email',$request->email],['role',1]])->first();

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role'=>1])){
            $request->session()->put('admin',$user);
            return redirect()->route('admin.list');
        }else{
            return redirect()->route('admin.login')->with('error', 'Email hoặc mật khẩu của bạn không đúng!');
        }
    }

    public function logout(){
        Auth::logout();
        session()->forget('admin');
        return redirect()->route('admin.login');
    }

    public function index()
    {
        $posts = Post::with(['Tags', 'author'])->paginate(10);
        return view('admin.index', compact('posts'));
    }

    public function tags()
    {
        $tags = Tag::paginate(10);
        return view('admin.tags', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::with('Tags')->findOrFail($id);
        return view('admin.edit', compact(['post']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->is_active = $request->is_active;
        $post->is_editors_pick = $request->is_editors_pick;
        $post->is_trending = $request->is_trending;
        $post->save();

        return back()->with('success', 'Đã thay đổi trạng thái bài viết thành công.');
    }

    public function updateTag(Request $request){
        $tag = Tag::find($request->id);
        $tag->is_active = $request->is_active;
        $tag->save();
        return back()->with('success', 'Đã thay đổi trạng thái thẻ thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
