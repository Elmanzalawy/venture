@extends('layouts.app')
@section('content')

<div class="container">
  <div class="jumbotron">
    <h1 class="center">Edit {{$post->title}}</h1>
    {{ Form::open(['action' => ['PostsController@update',$post->id], 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}
            <div class="form-group">
                {{Form::label('title','Title')}}
                {{Form::text('title','',['class'=>'form-control','placeholder'=>$post->title])}}
            </div>
    
            <div class="form-group">
                {{Form::label('text','Text')}}
                {{Form::textarea('text','',['class'=>'form-control','placeholder'=>$post->text])}}
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

      
@endsection