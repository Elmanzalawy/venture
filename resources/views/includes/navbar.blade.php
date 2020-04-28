<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">

    <a class="navbar-brand" href="{{ url('/index') }}"><b>{{config('app.name','Venture')}}</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav text-left">
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/posts') }}">Posts</a>
      </li>
    <!--ABOUT US-->
        <li class="nav-item">
        <a class="nav-link" href="{{ url('/about') }}">About</a>
      </li>

    
    </ul>
    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
            {!! Form::open(['action' => 'SearchController@search', 'class'=>'form-inline','method'=>'GET']) !!}

            {!! Form::text('query','', ['class'=>'form-control mr-sm-2 ml-2', 'placeholder'=>'Search posts...', 'autofill'=>'disabled']) !!}
            {!! Form::submit('Search',['class'=>'btn btn-outline-primary my-2 my-sm-0']) !!}
            
            {!! Form::close() !!}
            
      <!-- Authentication Links -->
      @guest
          <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
          @if (Route::has('register'))
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
          @endif
      @else
          <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>
                  <a class="dropdown-item" href="{{ url('/index') }}">Home</a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              </div>
          </li>
      @endguest
  </ul>
    </div>
    </nav>