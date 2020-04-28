@extends('layouts.app')
@section('content')
<style>
.card-text{
}
</style>
<div class="container">
    <div class="jumbotron">
        <h1 class="center">Search Results</h1>
        @if(count($posts)>0)
        @foreach ($posts as $post)
        <a href="{{url('posts/'.$post->id)}}" style="text-decoration:none !important;">
          <div class="card p-1 my-2" >
                  <div class="row">
                  @if($post->image != 'placeholder-image.png')
                  <div class="col-md-4 col-sm-4">
                      <img class="post-image" style="width:100%;" src="{{url('storage/post_images/'.$post->image)}}" alt="">
                  </div>
                  <div class="col-md-8 col-sm-8" style="display:flex; flex-direction:column; justify-content: space-between;">
                      <div class="card-title" style="justify-self:center;">
                        <h4 class="center" style="align-self:flex-start">{{$post->title}}</h4>
                      </div>
                      <p class="p-2 card-text" style="color:var(--secondary-color);">{{ Str::limit($post->text, 250)}}</p>

                      <div class="card-footer py-1" style="align-self:flex-start; width:100%;">
                  
                        <span class="small pull-left" style="margin-top:0.25em; color:var(--secondary-color);">{{DB::table('votes')->where('post_id',$post->id)->where('value',1)->count() - DB::table('votes')->where('post_id',$post->id)->where('value',-1)->count()}} votes</span>

                        <span class="small pull-right" style="margin-top:0.25em; color:var(--secondary-color);">Posted on {{$post->created_at}} by {{DB::table('users')->where('id',$post->user_id)->value('name')}}</span>
                      </div>
                  </div>
                  @else
                  <div class="col-md-12 col-sm-12" style="display:flex; flex-direction:column; justify-content: space-between;">
                      <div class="card-title" style="justify-self:center;">
                        <h4 class="center" style="align-self:flex-start">{{$post->title}}</h4>
                      </div>
                      <p class="p-2 card-text" style="color:var(--secondary-color);">{{ Str::limit($post->text, 250)}}</p>

                      <div class="card-footer py-1" style="align-self:flex-start; width:100%;">
                  
                        <span class="small pull-left" style="margin-top:0.25em; color:var(--secondary-color);">{{DB::table('votes')->where('post_id',$post->id)->where('value',1)->count() - DB::table('votes')->where('post_id',$post->id)->where('value',-1)->count()}} votes</span>

                        <span class="small pull-right" style="margin-top:0.25em; color:var(--secondary-color);">Posted on {{$post->created_at}} by {{DB::table('users')->where('id',$post->user_id)->value('name')}}</span>
                      </div>
                  </div>
                  @endif
              </div>
          </div>
        </a>
        @endforeach
    
        @else
        <p class="center">No results found.</p>
        @endif

        
    </div>
</div>


@endsection
