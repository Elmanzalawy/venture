@extends('layouts.app')
@section('content')

<div class="container">
  <div class="jumbotron">
    <h1 class="center">Posts</h1>
    <a href="{{url('posts/create')}}" class="btn btn-outline-primary my-2">Create Post</a>
    @foreach ($posts as $post)
      <div class="card" style="background:var(--secondary-color) !important;">
        <h4 class="center">{{$post->title}}</h4>
          <p class="p-2" style="color:white;">{{$post->text}}</p>
          @isset($post->image)
            <img src="{{url('storage/post_images/'.$post->image)}}" alt="">   
          @endisset
      </div>
    @endforeach
  </div>
</div>

      
@endsection