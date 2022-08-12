@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
            <div class="row">
                <!-- Logo & Information Panel-->
                <div class="col-lg-6">
                    <div class="info d-flex align-items-center">
                        <div class="content">
                            <div class="logo">
                                <img src = "{{ asset('images/lyonhart.png') }}" width="120px" height="120px;"/>
                                <h1>Lyonhart Chronicles</h1>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>

                <!-- Form Panel    -->
                <div class="col-lg-6">
                    <div class="form d-flex align-items-center">
                        <div class="content">
                            <form class="form-validate mb-4" method="POST" action="{{ route('login') }}" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input id="email" type="email" class="input-material @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                    <label for="email" class="label-material">{{ __('E-Mail Address') }}</label>
                                </div>

                                <div class="form-group">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input id="password" type="password" class="input-material @error('password') is-invalid @enderror input-material" name="password" required>
                                    <label for="login-password" class="label-material">{{ __('Password') }}</label>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </form>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-pass">Forgot Password?</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('js/template/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/template/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/template/front.js') }}"></script>
