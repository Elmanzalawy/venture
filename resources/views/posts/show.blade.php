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

            <div class="card-footer">
                <span class="pull-left" style="margin-top:0.75em;">Posted on {{$post->created_at}} by
                {{DB::table('users')->where('id',$post->user_id)->value('name')}}</span>

               @if(!Auth::guest())
               @if(auth()->user()->id == $post->user_id || auth()->user()->privilege=='admin')

               {{-- DELETE POST --}}
               {!!Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST',
               'class'=>'pull-right'])!!}
               
               {{-- SPOOFING METHOD --}}
               {{Form::hidden('_method','DELETE')}}
               {{Form::submit('Delete',['class'=>'btn btn-sm pull-right btn-danger my-2'])}}
               {!!Form::close()!!}
               @endif

               @if(auth()->user()->id == $post->user_id)
               {{-- EDIT POST --}}
               <a href="{{url('posts/edit/'.$post->id)}}" class="my-2 mr-2 btn btn-sm btn-warning pull-right">Edit Post</a>
               @endif
               @endif
            </div>
        </div>

        @if(!Auth::guest())
        {{ Form::open(['action' => ['CommentsController@store',$post->id],'class'=>'my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}

        <div class="form-group">
            {{Form::label('text','Comment as '.auth()->user()->name)}}
            {{Form::textarea('text','',['class'=>'form-control','placeholder'=>'What are your thoughts?'])}}
        </div>

        {{-- SPOOFING METHOD --}}
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Comment',['class'=>'btn btn-primary'])}}
        {{ Form::close() }}
        @else
        <p class="center my-4"><a href="{{url('login')}}">Login</a> to comment.</p>
        @endif
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
                    <button class="btn btn-lg pull-left btn-primary fa fa-reply reply-btn" onclick="updateReplyModal(this)" data-user-id='{{$comment->user_id}}' data-user-name='{{DB::table('users')->where('id',$comment->user_id)->value('name')}}' data-comment-id='{{$comment->id}}' data-toggle="modal"
                        data-target="#reply-modal"> Reply</button>
                    @endif
                    @if(!Auth::guest())
                    @if(auth()->user()->id == $comment->user_id || auth()->user()->privilege=='admin')
                    {{-- DELETE POST --}}
                    {!!Form::open(['action'=>['CommentsController@destroy', $comment->id], 'method'=>'POST',
                    'class'=>'pull-right'])!!}
                    {{-- SPOOFING METHOD --}}
                    {{Form::hidden('_method','DELETE')}}
                    {{Form::submit('Delete',['class'=>'btn btn-sm pull-right btn-danger'])}}
                    {!!Form::close()!!}
                    @endif
                    @if(auth()->user()->id == $comment->user_id)
                    <button class="btn btn-sm pull-right btn-primary edit-btn mr-2" onclick="updateEditModal(this)" data-user-id='{{$comment->user_id}}' data-user-name='{{DB::table('users')->where('id',$comment->user_id)->value('name')}}' data-comment-id='{{$comment->id}}' data-comment-text='{{$comment->text}}' data-toggle="modal"
                        data-target="#edit-comment-modal">Edit Comment</button>
                    @endif
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
                      {{-- <button class="btn btn-lg pull-left btn-primary fa fa-reply reply-btn" onclick="updateReplyModal(this)" data-user-id='{{$reply->user_id}}' data-user-name='{{DB::table('users')->where('id',$reply->user_id)->value('name')}}' data-comment-id='{{$reply->id}}' data-toggle="modal"
                              data-target="#reply-modal"> Reply</button> --}}
                         
                          @if(auth()->user()->id == $reply->user_id || auth()->user()->privilege=='admin')
                          {{-- DELETE POST --}}
                          {!!Form::open(['action'=>['CommentsController@destroy', $reply->id], 'method'=>'POST',
                          'class'=>'pull-right'])!!}
                          {{-- SPOOFING METHOD --}}
                          {{Form::hidden('_method','DELETE')}}
                          {{Form::submit('Delete',['class'=>'btn btn-sm pull-right btn-danger'])}}
                          {!!Form::close()!!}
                          @endif

                          @if(auth()->user()->id == $reply->user_id)
                    <button class="btn btn-sm pull-right btn-primary edit-btn mr-2" onclick="updateEditModal(this)" data-user-id='{{$reply->user_id}}' data-user-name='{{DB::table('users')->where('id',$reply->user_id)->value('name')}}' data-comment-id='{{$reply->id}}' data-comment-text='{{$reply->text}}' data-toggle="modal"
                        data-target="#edit-comment-modal">Edit Reply</button>
                    @endif
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
            @if(!Auth::guest())
            <div class="modal fade" id="reply-modal" tabindex="1" role="dialog"
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
                        {{ Form::open(['action' => ['CommentsController@storeReply',$comment->id],'class'=>'reply-form', 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}

                        <div class="form-group">
                            {{Form::label('text','Reply as '.auth()->user()->name)}}
                            {{Form::textarea('text','',['class'=>'reply-text form-control','placeholder'=>'Tell '.DB::table('users')->where('id',$comment->user_id)->value('name').' your thoughts...'])}}
                        </div>

                        {{-- SPOOFING METHOD --}}
                        {{Form::hidden('_method','PUT')}}
                        {{Form::submit('Reply',['class'=>'btn btn-primary'])}}
                        {{ Form::close() }}
                    </div>

                </div>
            </div>
        </div>
            @endif
            @else
            <p class="center">No comments yet.</p>
            @endif


            {{-- EDIT COMMENT MODAL --}}
            @if(!Auth::guest())
            <div class="modal fade" id="edit-comment-modal" tabindex="1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(['action' => ['CommentsController@update',1],'class'=>'edit-comment-form', 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}

                        <div class="form-group">
                            {{Form::label('text','Edit as '.auth()->user()->name)}}
                            {{Form::textarea('text','',['class'=>'comment-text form-control','placeholder'=>''])}}
                        </div>

                        {{-- SPOOFING METHOD --}}
                        {{Form::hidden('_method','PUT')}}
                        {{Form::submit('Edit',['class'=>'btn btn-primary'])}}
                        {{ Form::close() }}
                    </div>

                </div>
            </div>
        </div>
            @endif
        </div>
    </div>
</div>
</div>

<script>
//Dynamically update Reply Model 
function updateReplyModal(replyButton){
  //form variables to be dynamically changed in modal. values are retrieved from the reply button data attributes.
  var comment_id = replyButton.getAttribute('data-comment-id');
  var user_id = replyButton.getAttribute('data-user-id');
  var user_name = replyButton.getAttribute('data-user-name');

  //update modal title with a new user name
  $('.modal-title').html('Reply to '+user_name);
  //get the action path of the reply form
  var replyFormAction = $('.reply-form').attr('action');

  //change the action path of the reply form to match the current comment id
  var newAction = replyFormAction.substr(0,replyFormAction.indexOf('/reply'))+'/reply/'+comment_id;
  //update the reply form action patch 
  $('.reply-form').attr('action',newAction);
  //update the reply form textarea placeholder with the appropriate user name
  $('.reply-text').attr('placeholder','tell '+user_name+' your thoughts...');
  
}

//Dynamically update Edit Comment Modal
function updateEditModal(editButton){
//form variables to be dynamically changed in modal. values are retrieved from the edit button data attributes.
  var comment_id = editButton.getAttribute('data-comment-id');
  var user_id = editButton.getAttribute('data-user-id');
  var user_name = editButton.getAttribute('data-user-name');
  var comment_text = editButton.getAttribute('data-comment-text');
  $('.comment-text').text(comment_text);

   //get the action path of the reply form
   var editFormAction = $('.edit-comment-form').attr('action');

//change the action path of the reply form to match the current comment id
var newAction = editFormAction.substr(0,editFormAction.indexOf('/update'))+'/update/'+comment_id;

//update the reply form action patch 
$('.edit-comment-form').attr('action',newAction);

}
</script>

@endsection
