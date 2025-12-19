@extends("layouts.app")

@section('content')
 <div id="register__page">
        <div id="register__container">
            <form action="{{ route("register", ['locale' => app()->getLocale()]) }}" method="POST">
                @csrf
                <div id="register__card">
                    <div id="register__header">
                        <h1 id="register__logo">LeCharme</h1>
                        <p id="register__subtitle">@lang('register.subtitle')</p>
                    </div>

                    <form id="registerForm">
                        <div id="register__form-group-1">
                            <label for="fullName">@lang('register.fullname_placeholder')</label>
                            <input
                                type="text"
                                id="fullName"
                                name="name"
                                placeholder="@lang('register.fullname_placeholder')"
                                required
                                autocomplete="name"
                            >
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        <div id="register__form-group-2">
                            <label for="email">@lang('register.email')</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="@lang('register.email_placeholder')"
                                required
                                autocomplete="email"
                            >
                        </div>

                         @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        <div id="register__form-group-3">
                            <label for="password">@lang('register.password')</label>
                            <div id="register__password-wrapper-1">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="new-password"
                                >
                                <button type="button" id="passwordToggle">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>
                         @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                         @enderror
                        <button type="submit" id="register__submit-btn">
                            <span>@lang('register.register')</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </form>

                    <div id="register__divider">
                        <span>@lang('register.or')</span>
                    </div>

                    <button id="googleRegister">
                        <svg width="20" height="20" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span>@lang('register.register_google')</span>
                    </button>

                    <div id="register__signup-link">
                        <p>@lang('register.have_account') <a href="{{ locale_route('login') }}">@lang('register.login')</a></p>
                    </div>
            </form>
                </div>
        </div>
    </div>

@endsection
