<nav class="navbar navbar-expand-md navbar-dark navbar-rc shadow-sm">
    <div class="container">
        {{-- Brand / Logo --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-redcapital-head.png') }}" alt="RedCapital" height="36" />
        </a>

        {{-- Botón hamburguesa (visible < md) abre el offcanvas lateral --}}
        <button class="navbar-toggler d-md-none" type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasMain"
                aria-controls="offcanvasMain"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- ====== NAVBAR INLINE (>= md) ====== --}}
        <div class="collapse navbar-collapse d-none d-md-flex" id="navbarInline">
            {{-- Lado izquierdo (links) --}}
            <ul class="navbar-nav me-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cotizaciones.index') }}">
                            {{ __('messages.quotes') }}
                        </a>
                    </li>

                    @if (Auth::check() && (bool) Auth::user()->admin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('usuarios.index') }}">
                                {{ __('messages.users') }}
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- Lado derecho (auth) --}}
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->nombre ?? '' }} {{ Auth::user()->apellido ?? '' }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('perfil.edit') }}">
                                {{ __('messages.profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('messages.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>

        {{-- ====== OFFCANVAS (móviles) ====== --}}
        <div class="offcanvas offcanvas-end d-md-none" tabindex="-1" id="offcanvasMain" aria-labelledby="offcanvasMainLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasMainLabel">{{ config('app.name', 'Intranet Cotizaciones') }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                {{-- Links principales --}}
                <div class="mb-3">
                    <div class="text-uppercase small text-muted mb-2">{{ __('messages.menu') }}</div>
                    <ul class="nav flex-column">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cotizaciones.index') }}">
                                    {{ __('messages.quotes') }}
                                </a>
                            </li>
                            @if (Auth::check() && (bool) Auth::user()->admin)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('usuarios.index') }}">
                                        {{ __('messages.users') }}
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>

                {{-- Sección de cuenta --}}
                <div class="mt-auto">
                    <div class="text-uppercase small text-muted mb-2">{{ __('messages.account') }}</div>
                    <ul class="nav flex-column">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('perfil.edit') }}">{{ __('messages.profile') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form-offcanvas').submit();">
                                   {{ __('messages.logout') }}
                                </a>
                                <form id="logout-form-offcanvas" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- Botón flotante de idioma (dropup) --}}
<div class="lang-switcher">
    <div class="btn-group dropup">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false" title="{{ __('messages.language') }}">
            🌐
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('locale.switch', ['lang' => 'es']) }}">{{ __('messages.spanish') }}</a></li>
            <li><a class="dropdown-item" href="{{ route('locale.switch', ['lang' => 'en']) }}">{{ __('messages.english') }}</a></li>
        </ul>
    </div>
</div>
