<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Post;
use App\Comment;
class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        $data = array(
        'posts' => Post::where('title','LIKE',"%$query%")->orWhere('text','LIKE',"%$query%")->orWhere('user_name','LIKE',"%$query%")->orWhere('id',Comment::where('text','LIKE',"%$query%")->orWhere('user_name','LIKE',"%$query%")->value('post_id'))->get(),
        // 'comments' => Comment::where('text','LIKE',"%$query%")->orWhere('user_name','LIKE',"%$query%")->get(),
        );
        return view('search.index')->with($data);
    }   
}
