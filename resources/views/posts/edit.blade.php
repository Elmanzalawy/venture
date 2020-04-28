@extends('layouts.app')
@section('content')

<div class="container">
  <div class="jumbotron">
    <h1 class="center">Edit {{$post->title}}</h1>
    {{ Form::open(['action' => ['PostsController@update',$post->id], 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}
            <div class="form-group">
                {{Form::label('title','Title')}}
                {{Form::text('title','',['class'=>'form-control post-title', 'data-title'=>$post->title])}}
            </div>
    
            <div class="form-group">
                {{Form::label('text','Text')}}
                {{Form::textarea('text','',['class'=>'form-control post-text','data-text'=>$post->text])}}
            </div>
    
            <div class="form-group">
                    {{Form::label('Add image: ','Add image (Optional)')}}
                    {{Form::file('image')}}
            </div>
            <a href="{{url('posts/'.$post->id)}}" class="btn btn-danger my-2">Cancel</a>

            {{-- SPOOFING METHOD --}}
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Edit Post',['class'=>'btn btn-primary my-2'])}}
        {{ Form::close() }}
  </div>
</div>
{{-- <script src="http://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous">
</script> --}}
<script>
 var post_title = $('.post-title').attr('data-title');
 var post_text = $('.post-text').attr('data-text');
 $('.post-title').attr('placeholder',post_title);
 $('.post-text').text(post_text);
</script>      
@endsection
