<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Comment;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(6);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            return view('posts.create');
        }else{
            return redirect('/login')->with('error','Login to create posts.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $this->validate($request, [
                'title'=>'required',
                'image'=> 'image|nullable|max:10000'
            ]);
            //handle file upload
            $filenameToStore = "placeholder-image.png";
            if($request->hasFile('image')){
                //Get file name with extentsion
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just extension
                $extension = $request->file('image')->getClientOriginalExtension();
                //Filename to store
                $filenameToStore = $filename."_".time().".".$extension; // making the filename unique to prpost image overwriting

                //Upload image
                $path = $request->file('image')->storeAs('public/post_images',$filenameToStore);

            }
            else{
                // $fileNameToStore = "placeholder-image.png";
            }
            //create post
            $post = new Post;
            $post->user_id = auth()->user()->id;
            $post->image = $filenameToStore;
            $post->title = $request->input('title');
            $post->text = $request->input('text');

            $post->save();

            return redirect('/posts')->with('success','Post Created');
        }else{
            return redirect('login')->with('error','Login to create posts.');
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
        $data = array(
            'post' => Post::find($id),
            'comments' => Comment::where('post_id',$id)->where('type','comment')->get(),
            'replies' => Comment::where('post_id',$id)->where('type','reply')->get(),
        );
        return view('posts.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $comments = Comment::where('post_id',$id);
        if(auth()->user()->privilege=='admin' || auth()->user()->id==$post->user_id){
        //if exists, delete post image
            if($post->image!='placeholder-image.jpg'){
                unlink('storage/post_images/'.$post->image);
            }
            if(isset($comments)){
                $comments->delete();
                $post->delete();
            }

            return redirect('posts')->with('success','Successfully deleted post.');
        }else{
            return back()->with('error','Unauthorized user.');
        }        
    }
}
