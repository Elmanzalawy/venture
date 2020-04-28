@extends('layouts.app')
@section('content')
<style>
body{
    margin-top:0 !important;
}
.jumbotron{
    padding-top: 6rem;
}

</style>
<div class="container">
    <div class="jumbotron">
        <h1 class="center my-4">About {{config('app.name')}}</h1>
        <p>{{config('app.name')}} is a social media platform where users can interact online by creating post and through comments. Users can also reply to other comments and vote on posts.</p>
        <hr>
        <h4>Features</h4>
        <ul>
            <li>Registered users can create new posts.</li>
            <li>Users can browse and search for existing posts.</li>
            <li>Registered users can comment on posts.</li>
            <li>Registered users can reply to comments.</li>
            <li>Registered users can upvote / downvote posts.</li>
            <li>Users can edit or delete their own posts and comments.</li>
            <li>Admins can delete posts belonging to other users.</li>
        </ul>
        <hr>
        <h4>Techologies Used</h4>
        <ul>
            <li>PHP 7.3.1</li>
            <li>MySQL 8.0.15</li>
            <li>Laravel Framework 7.6.2</li>
            <li>HTML</li>
            <li>CSS</li>
            <li>JavaScript</li>
            <li>Bootstrap Framework 4.4</li>
            <li>jQuery Library</li>
        </ul>
        <hr>
        <h4>Misc.</h4>
        <a href="https://github.com/Elmanzalawy/venture.git" target="_blank">Source code</a><br>

        <span>Coded by </span><a href="mailto:mohamed.elmanzalawy98@gmail.com" target="_blank">Mohamed Elmanzalawy</a>
    </div>
</div>


@endsection
