<header>
      <nav class="navbar navbar-expand navbar-light bg-white shadow-sm">
            <div class="container">

                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto d-flex align-items-center">
                              <a href="{{ url('http://localhost:5174/') }}">
                                    <li class="nav-item">
                                          <img src="/img/logoBnBlateral.png" alt="" class="logo">
                                    </li>
                              </a>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                              <!-- Authentication Links -->
                              @guest
                              <li class="nav-item">
                                    <a class="nav-link btn btn_boolbnb text-white mx-1" href="{{ route('login') }}">{{ __('Accedi') }}</a>
                              </li>
                              @if (Route::has('register'))
                              <li class="nav-item">
                                    <a class="nav-link btn btn_boolbnb text-white" href="{{ route('register') }}">{{ __('Registrati') }}</a>
                              </li>
                              @endif
                              @else
                              <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                          {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                {{ __('Disconnetti') }}
                                          </a>

                                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                          </form>
                                    </div>
                              </li>
                              @endguest
                        </ul>
                  </div>
            </div>
      </nav>
</header>

<style scoped lang="scss">
      .logo {
            width: 100px;
      }
</style>