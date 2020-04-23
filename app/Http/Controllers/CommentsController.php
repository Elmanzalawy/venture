<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use DB;
class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->user_name = auth()->user()->name;
        $comment->post_id = $id;
        $comment->text = $request->text;
        $comment->type = 'comment';
        $comment->save();

        return back()->with('success','Comment created');
    }
    //Reply to existing comments
    public function storeReply(Request $request, $id)
    {
        if (Auth::check()) {
            $this->validate($request, [
                'text'=>'required',
            ]);
        $comment = new Comment;
        $post = Post::find(DB::table('comments')->where('id',$id)->value('post_id'));
        $comment->user_id = auth()->user()->id;
        $comment->user_name = auth()->user()->name;
        $comment->post_id = $post->id;
        $comment->text = $request->text;
        $comment->parent_comment_id = $id;
        $comment->type = 'reply';
        $comment->save();

        return back()->with('success','Comment created');
        }else{
            return view('posts/index')->with('error','Unauthorized user.');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
       if(auth()->user()->id == $comment->user_id){
        $comment->text = $request->text;
        $comment->save();
        return back()->with('success','Comment edited.');
       }else{
        return redirect('posts.index')->with('error','Unauthorized user.');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if(auth()->user()->privilege=='admin' || auth()->user()->id==$comment->user_id){
            $comment->delete();
            return back()->with('success','Successfully Deleted Comment');
        }else{
            return back()->with('error','Unauthorized user.');
        }        
    }
}
