<div class="comment-section">
    @if(count($comments)>0)
    @foreach ($comments as $comment)
    <div class="card comment p-2 my-2">
        <div class="card-body">
            <div class="card-title">
                <p class="username"><span
                        class="primary-color">{{DB::table('users')->where('id',$comment->user_id)->value('name')}}</span>
                    commented on {{$comment->created_at}}</p>
            </div>
            <div class="card-text">
                <p class='text'>{{$comment->text}}</p>
            </div>
        </div>

        <div class="card-footer">
            {{-- VOTES --}}
            {{-- <div name="_token" content="{{csrf_token()}}" class="votes pull-left mr-4"
            style="margin-top:0.25em;" data-user-vote='{{$user_vote ?? 0}}'>
            <span action='{{ action('PostsController@index') }}' class="vote-button upvote fa fa-arrow-up"
                data-value='1' data-post-id='{{$post->id}}' onclick="vote(this)" style=""></span>
            <span class="num-votes" style="">{{$votes}}</span>
            <span class="vote-button downvote fa fa-arrow-down" data-value='-1' data-post-id='{{$post->id}}'
                onclick="vote(this)" style=""></span>
            <input type="number" name="post-id" value="{{$post->id}}" style="display:none;">

        </div> --}}

        @if(!Auth::guest())
        <button class="btn btn-lg pull-left btn-primary fa fa-reply reply-btn" onclick="updateReplyModal(this)"
            data-user-id='{{$comment->user_id}}'
            data-user-name='{{DB::table('users')->where('id',$comment->user_id)->value('name')}}'
            data-comment-id='{{$comment->id}}' data-toggle="modal" data-target="#reply-modal">
            Reply</button>
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
        <button class="btn btn-sm pull-right btn-primary edit-btn mr-2" onclick="updateEditModal(this)"
            data-user-id='{{$comment->user_id}}'
            data-user-name='{{DB::table('users')->where('id',$comment->user_id)->value('name')}}'
            data-comment-id='{{$comment->id}}' data-comment-text='{{$comment->text}}' data-toggle="modal"
            data-target="#edit-comment-modal">Edit</button>
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
                        class="primary-color">{{DB::table('users')->where('id',$reply->user_id)->value('name')}}</span>
                    replied on {{$reply->created_at}}</p>
            </div>
            <div class="card-text">
                <p class='text'>{{$reply->text}}</p>
            </div>
        </div>
        <div class="card-footer">
            @if(!Auth::guest())
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
            <button class="btn btn-sm pull-right btn-primary edit-btn mr-2" onclick="updateEditModal(this)"
                data-user-id='{{$reply->user_id}}'
                data-user-name='{{DB::table('users')->where('id',$reply->user_id)->value('name')}}'
                data-comment-id='{{$reply->id}}' data-comment-text='{{$reply->text}}' data-toggle="modal"
                data-target="#edit-comment-modal">Edit</button>
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
<div class="modal fade" id="reply-modal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
<div class="modal fade" id="edit-comment-modal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
