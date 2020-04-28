@extends('layouts.app')

@section('content')
<style>
    body {
        margin-top: 0 !important;
    }

</style>

<div class="waveWrapper waveAnimation">

    <div class="waveWrapperInner bgTop">
        <div class="wave waveTop" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-top.png')">
        </div>
    </div>
    <div class="waveWrapperInner bgMiddle">
        <div class="wave waveMiddle" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-mid.png')">
        </div>
    </div>
    <div class="waveWrapperInner bgBottom">
        <div class="wave waveBottom" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-bot.png')">
        </div>
    </div>

</div>
<div id="stage">

    <div class="container">
        <div class="stage-caption">
            <h1 class="mt-2 mb-2" style="color:white;"><span class="primary-color">V</span>enture</h1>
            <p class="lead " style="color:white;">{{config('app.name')}} is a social media platform where users can interact online through posts. Users can also communicate with each other through comments.</p>

            @if(Auth::guest())
              <a href="register" class="btn btn-lg btn-outline-primary">Join Us</a>
            @endif
        </div>
    </div>


</div>




@endsection
