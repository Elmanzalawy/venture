@extends('layouts.app')
@section('content')
<style>
.card-text{
}
</style>
<div class="container">
    <div class="jumbotron">
        <h1 class="center">Posts</h1>
        <a href="{{url('posts/create')}}" class="btn btn-outline-primary my-2">Create Post</a>
        @if(count($posts)>0)
        @foreach ($posts as $post)
        <a href="{{url('posts/'.$post->id)}}" style="text-decoration:none !important;">
          <div class="card p-1 my-2" >
                  <div class="row">
                  @if($post->image != 'placeholder-image.png')
                  <div class="col-md-4 col-sm-4">
                      <img style="width:100%;" src="{{url('storage/post_images/'.$post->image)}}" alt="">
                  </div>
                  <div class="col-md-8 col-sm-8" style="display:flex; flex-direction:column; justify-content: space-between;">
                      <div class="card-title" style="justify-self:center;">
                        <h4 class="center" style="align-self:flex-start">{{$post->title}}</h4>
                      </div>
                      <p class="p-2 card-text" style="color:var(--secondary-color);">{{$post->text}}</p>
                      <div class="card-footer py-1" style="align-self:flex-end; width:100%;">
                        <p class="small" style="margin-top:0.75em; color:var(--secondary-color);">Posted on {{$post->created_at}} by {{DB::table('users')->where('id',$post->user_id)->value('name')}}</p>
                      </div>
                  </div>
                  @else
                  <div class="col-md-12 col-sm-12">
                      <h4 class="center">{{$post->title}}</h4>
                      <p class="p-2 card-text"style="color:var(--secondary-color);" >{{$post->text}}</p>
                      <div class="card-footer py-1" style="align-self:flex-end; width:100%;">
                        <p class="small" style="margin-top:0.75em; color:var(--secondary-color);">Posted on {{$post->created_at}} by {{DB::table('users')->where('id',$post->user_id)->value('name')}}</p>
                      </div>
                  </div>
                  @endif
              </div>
          </div>
        </a>
        @endforeach
        @else
        <p class="center">No posts founds.</p>
        @endif
    </div>
</div>


@endsection
