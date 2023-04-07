<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Likes;
use App\Models\Lıkes;
use App\Models\Reviews;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function ReviewStore(Request $request)
    {
        $blogid = $request->blog_id;
        $request->validate(
            [
                'comment' => 'required',
            ],
            [
                'comment.required' => 'Yorum Girmek Zorunlu.',
            ]

        );

        Reviews::insert([
            'blog_id' => $blogid,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Yorumunuz Başarı İle Eklendi.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function LikeBlog(Request $request)
    {
        $blogid = $request->blog_id;
        $exists = Likes::where('user_id', Auth::id())->where('blog_id', $blogid)->first();

        if (!$exists) {
            Likes::insert([
                'blog_id' => $blogid,
                'user_id' => Auth::id(),
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Blog Beğenildi.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Blog Daha Önce Beğenilmiş.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }
}
