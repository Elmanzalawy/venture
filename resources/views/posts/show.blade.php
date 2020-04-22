@extends('layouts.app')
@section('content')
<style>
.reply{
  background: rgb(230,230,230);
}
</style>
<div class="container">
    <div class="jumbotron ">
        <div class="card p-1">
            <div class="card-header">
                <h3 class="center">{{$post->title}}</h3>

            </div>

            @isset($post->text)
            <div class="card-body">
                <p>{{$post->text}}</p>
            </div>
            @endisset
            @isset($post->image)
            <a href="{{url('storage/post_images/'.$post->image)}}" target="_blank"><img style="width:100%;"
                    src="{{url('storage/post_images/'.$post->image)}}" alt=""></a>
            @endisset

            @if(auth()->user()->id == $post->user_id || auth()->user()->privilege=='admin')
            <div class="card-footer">
                <span class="pull-left" style="margin-top:0.75em;">Posted on {{$post->created_at}} by
                    {{DB::table('users')->where('id',$post->user_id)->value('name')}}</span>
                {{-- DELETE POST --}}
                {!!Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST',
                'class'=>'pull-right'])!!}
                {{-- SPOOFING METHOD --}}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete',['class'=>'btn btn-sm pull-right btn-danger my-2'])}}
                {!!Form::close()!!}
            </div>
            @endif
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
        <hr>
        {{-- COMMENT SECTION --}}
        <div class="comment-section">
            @if(count($comments)>0)
            @foreach ($comments as $comment)
            <div class="card comment p-2 my-2">
                <div class="card-body">
                    <div class="card-title">
                        <p class="username"><span
                                class="primary-color">{{DB::table('users')->where('id',$comment->user_id)->value('name')}}</span> commented on {{$comment->created_at}}</p>
                    </div>
                    <div class="card-text">
                        <p class='text'>{{$comment->text}}</p>
                    </div>
                </div>
                <div class="card-footer">
                    @if(!Auth::guest())
                    <button class="btn btn-lg pull-left btn-primary fa fa-reply" data-toggle="modal"
                        data-target="#contact-designer-modal"> Reply</button>
                    @endif
                    @if(auth()->user()->id == $comment->user_id || auth()->user()->privilege=='admin')
                    {{-- DELETE POST --}}
                    {!!Form::open(['action'=>['CommentsController@destroy', $comment->id], 'method'=>'POST',
                    'class'=>'pull-right'])!!}
                    {{-- SPOOFING METHOD --}}
                    {{Form::hidden('_method','DELETE')}}
                    {{Form::submit('Delete',['class'=>'btn btn-sm pull-right btn-danger'])}}
                    {!!Form::close()!!}
                    @endif
                </div>

                {{-- REPLIES --}}
                @if(count($replies)>0)
                @foreach ($replies as $reply)
                  @if($reply->parent_comment_id == $comment->id)
                  <div class="card reply p-2 my-2">
                      <div class="card-body">
                          <div class="card-title">
                              <p class="username"><span
                                      class="primary-color">{{DB::table('users')->where('id',$reply->user_id)->value('name')}}</span> replied on {{$reply->created_at}}</p>
                          </div>
                          <div class="card-text">
                              <p class='text'>{{$reply->text}}</p>
                          </div>
                      </div>
                      <div class="card-footer">
                          @if(!Auth::guest())
                          <button class="btn btn-lg pull-left btn-primary fa fa-reply" data-toggle="modal"
                              data-target="#contact-designer-modal"> Reply</button>
                          @endif
                          @if(auth()->user()->id == $reply->user_id || auth()->user()->privilege=='admin')
                          {{-- DELETE POST --}}
                          {!!Form::open(['action'=>['CommentsController@destroy', $reply->id], 'method'=>'POST',
                          'class'=>'pull-right'])!!}
                          {{-- SPOOFING METHOD --}}
                          {{Form::hidden('_method','DELETE')}}
                          {{Form::submit('Delete',['class'=>'btn btn-sm pull-right btn-danger'])}}
                          {!!Form::close()!!}
                          @endif
                      </div>
                  </div>
                  @endif
                @endforeach
                @endif
            </div>
                @endforeach
            </div>
            {{-- REPLY MODAL --}}
            <div class="modal fade" id="contact-designer-modal" tabindex="1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reply to
                                {{DB::table('users')->where('id',$comment->user_id)->value('name')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ Form::open(['action' => ['CommentsController@storeReply',$comment->id],'class'=>'', 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}

                            <div class="form-group">
                                {{Form::label('text','Reply as '.auth()->user()->name)}}
                                {{Form::textarea('text','',['class'=>'form-control','placeholder'=>'Tell '.DB::table('users')->where('id',$comment->user_id)->value('name').' your thoughts...'])}}
                            </div>

                            {{-- SPOOFING METHOD --}}
                            {{Form::hidden('_method','PUT')}}
                            {{Form::submit('Reply',['class'=>'btn btn-primary'])}}
                            {{ Form::close() }}
                        </div>

                    </div>
                </div>
            </div>
            @else
            <p class="center">No comments yet.</p>
            @endif
        </div>
    </div>
</div>
</div>



@endsection
