<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request,$id)
    {
        Comment::create([
            'post_id' => $id,
            'user_id' => Auth::user()->id,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được thêm!');
    }
}
