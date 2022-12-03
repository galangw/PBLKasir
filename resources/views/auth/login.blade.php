@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8 mt-auto">
                <div class="card justify-content-center mt-5" style="">
                    <div class="card-header text-center">{{ __('LOGIN') }}</div>

                    <div class="card-body justify-content-center ">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3  justify-content-center">


                                <div class="col-md-6 offset-sm-1 text-center">
                                    <input style="" id="email" type="email" placeholder="Email Address"
                                        class="form-control @error('email') is-invalid @enderror  justify-content-center"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center ">


                                <div class="col-md-6 offset-sm-1 text-center">
                                    <input style="" id="password" type="password"
                                        class=" justify-content-center form-control @error('password') is-invalid @enderror"
                                        placeholder="Password" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-6 offset-sm-1 ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label style="font-size:12px;color:#495057;margin-right:1px;"
                                            class="form-check-label" for="remember">
                                            {{ __('Ingat Saya') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3  justify-content-center">


                                <div class="col-md-6 offset-sm-1 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block button-login ">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-0 justify-content-center">
                                <div class="col-md-8 offset-sm-1 text-center">


                                    @if (Route::has('password.request'))
                                        <a style="color:#3F0071 " class="btn btn-link"
                                            href="{{ route('password.request') }}">
                                            {{ __('Lupa Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
