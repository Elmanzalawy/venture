@extends('layouts.app')
@section('content')

<div class="container">
  <div class="jumbotron">
    <h1 class="center">Create Post</h1>
    {{ Form::open(['action' => 'PostsController@store', 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}
            <div class="form-group">
                {{Form::label('title','Title')}}
                {{Form::text('title','',['class'=>'form-control','placeholder'=>'Title'])}}
            </div>
    
            <div class="form-group">
                {{Form::label('text','Text')}}
                {{Form::textarea('text','',['class'=>'form-control','placeholder'=>'Insert text here...'])}}
            </div>
    
            <div class="form-group">
                    {{Form::label('Add image: ','Add image (Optional)')}}
                    {{Form::file('image')}}
            </div>
            <a href="{{url('posts/create')}}" class="btn btn-danger my-2">Cancel</a>

            {{Form::submit('Create Post',['class'=>'btn btn-primary my-2'])}}
        {{ Form::close() }}
  </div>
</div>

      
@endsection