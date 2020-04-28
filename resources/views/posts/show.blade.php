@extends('layouts.app')
@section('content')
<style>
    .reply {
        background: rgb(230, 230, 230);
    }

    .vote-button {
        color: rgb(135, 135, 135);
    }

    .vote-button:hover {
        cursor: pointer;
    }

</style>
<div class="container">
    <div class="jumbotron ">
        <div class="card p-1">
            <div class="card-header" style="display:flex; justify-content:space-between;">
                <div name="_token" content="{{csrf_token()}}" class="votes"
                    style="align-self:center; display:flex; flex-direction:column; align-items:center; justify-content:space-between" data-user-vote='{{$user_vote ?? 0}}'>
                    <span action='{{ action('PostsController@index') }}' class="vote-button upvote fa fa-arrow-up" data-value='1'  data-post-id='{{$post->id}}'
                        onclick="vote(this)" style=""></span>
                    <span class="num-votes" style="">{{$votes}}</span>
                    <span class="vote-button downvote fa fa-arrow-down" data-value='-1' data-post-id='{{$post->id}}'
                        onclick="vote(this)" style=""></span>
                    <input type="number" name="post-id" value="{{$post->id}}" style="display:none;">

                </div>
                <h3 class="center" style="justify-self:center;">{{$post->title}}</h3>
                <div></div>
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
                <a href="{{url('posts/edit/'.$post->id)}}" class="my-2 mr-2 btn btn-sm btn-warning pull-right">Edit
                    Post</a>
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
        <p class="center my-4"><a href="{{url('login')}}">Login</a> to comment and vote.</p>
        @endif
        <hr>
        {{-- COMMENT SECTION --}}
        @include('includes.comment_section')

    </div>
</div>
</div>
</div>


<script>
    //Dynamically update Reply Model 
    function updateReplyModal(replyButton) {
        //form variables to be dynamically changed in modal. values are retrieved from the reply button data attributes.
        var comment_id = replyButton.getAttribute('data-comment-id');
        var user_id = replyButton.getAttribute('data-user-id');
        var user_name = replyButton.getAttribute('data-user-name');

        //update modal title with a new user name
        $('.modal-title').html('Reply to ' + user_name);
        //get the action path of the reply form
        var replyFormAction = $('.reply-form').attr('action');

        //change the action path of the reply form to match the current comment id
        var newAction = replyFormAction.substr(0, replyFormAction.indexOf('/reply')) + '/reply/' + comment_id;
        //update the reply form action patch 
        $('.reply-form').attr('action', newAction);
        //update the reply form textarea placeholder with the appropriate user name
        $('.reply-text').attr('placeholder', 'tell ' + user_name + ' your thoughts...');

    }

    //Dynamically update Edit Comment Modal
    function updateEditModal(editButton) {
        //form variables to be dynamically changed in modal. values are retrieved from the edit button data attributes.
        var comment_id = editButton.getAttribute('data-comment-id');
        var user_id = editButton.getAttribute('data-user-id');
        var user_name = editButton.getAttribute('data-user-name');
        var comment_text = editButton.getAttribute('data-comment-text');
        $('.comment-text').text(comment_text);

        //get the action path of the reply form
        var editFormAction = $('.edit-comment-form').attr('action');

        //change the action path of the reply form to match the current comment id
        var newAction = editFormAction.substr(0, editFormAction.indexOf('/update')) + '/update/' + comment_id;

        //update the reply form action patch 
        $('.edit-comment-form').attr('action', newAction);

    }

    //check if user has existing vote, and change upvote button color accordingly
    function checkVote(){
        var votes = $('.votes');
        var userVote = $('.votes').attr('data-user-vote');
        if(userVote==1){
            $('.upvote').toggleClass('primary-color');
            $('.downvote').removeClass('text-danger');
        }else if(userVote==-1){
            $('.upvote').removeClass('primary-color');
            $('.downvote').toggleClass('text-danger');
        }
    }
    checkVote();

    function vote(voteButton){
        var value = voteButton.getAttribute('data-value');
        var user_id = voteButton.getAttribute('data-user-id');
        var post_id = voteButton.getAttribute('data-post-id');
        var token = $('.vote-button').parent().attr('content');
        var button = voteButton;
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': token
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/vote') }}",
                  method: 'post',
                  data: {
                    value:value,
                    post_id:post_id,
                  },
                  success: function(result){
                    //update votes
                    $('.num-votes').text(result.numVotes);
                    $('.votes').attr('data-user-vote',result.userVote);
                    checkVote();
                  }});
    }

</script>

@endsection
