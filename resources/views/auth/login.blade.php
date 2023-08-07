@extends('layouts.app')
@section('css', '/css/login.css')
@section('content')
<section class="section-login">
<div class ="row">
	<div class="col-md-6 mx-auto p-0">
		<div class="card">
            <div class="login-box">
                <div class="login-snip">
                    <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Login</label>
                    <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
                            
                    <div class="login-space">
                        <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="login">
                                        <div class="group">
                                            <input id="email" type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  placeholder="Enter your email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"  data-type="password" placeholder="Enter your password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="group">
                                            <input id="check" type="checkbox" class="check" checked {{ old('remember') ? 'checked' : '' }}>
                                            <label for="check"><span class="icon"></span> Keep me Signed in</label>
                                        </div>

                                        <div class="group">
                                            <button type="submit" class="button">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                        <div class="hr"></div>
                                        <div class="foot">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                        </div>
                        </form>
                     </div>
                            

                        <div class="sign-up-form">
                            <form method="POST" action="{{ route('register') }}">
                            @csrf
                                <div class="group">
                                    <input id="name" type="text" class="input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Create your Username">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="group">
                                    <input id="email" type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address">
                                </div>

                                <div class="group">
                                    <input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" data-type="password" placeholder="Create your password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="group">
                                    <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password" data-type="password" placeholder="Repeat your password" >
                                </div>

                                <div class="group">
                                    <button type="submit" class="button">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                                <div class="hr"></div>
                                <div class="foot">
                                    <label for="tab-1">Already Member?</label>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
</div>

  </section>

@endsection
