@extends('layouts.app')
@section('content')

<div class="container">
  <div class="jumbotron">
    <div class="card p-1">
        <h3 class="center">{{$post->title}}</h3>
        <hr>
        <p>{{$post->text}}</p>
        @isset($post->image)
            <img style="width:100%;" src="{{url('storage/post_images/'.$post->image)}}" alt="">
        @endisset
    </div>

    {{ Form::open(['action' => ['CommentsController@store',$post->id],'class'=>'my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}
            
            <div class="form-group">
                {{Form::label('text','Comment as '.auth()->user()->name)}}
                {{Form::textarea('text','',['class'=>'form-control','placeholder'=>'What are your thoughts?'])}}
            </div>

            {{-- SPOOFING METHOD --}}
          {{Form::hidden('_method','PUT')}}
            {{Form::submit('Comment',['class'=>'btn btn-primary'])}}
        {{ Form::close() }}

        {{-- COMMENT SECTION --}}
        <div class="p-2">
          @foreach ($comments as $comment)
            <div class="card comment p-2 my-2">
              <p class="username"><span class="primary-color">{{DB::table('users')->where('id',$comment->user_id)->value('name')}}</span> on {{$comment->created_at}}</p>
              <p class='text'>{{$comment->text}}</p>
            </div>    
          @endforeach
        </div>
  </div>
</div>

      
@endsection