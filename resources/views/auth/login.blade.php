<!-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
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
@endsection -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="lib/css/style.css"/>
</head>
<body>
    
        <div class="wrapper">
            <div class="title-text">
                <div class="title login">Zaloguj się</div>
                <div class="title signup">Zarejestruj się</div>
            </div>
            <div class="form-container">
                <div class="slide-controls">
                    <input type="radio" name="slider" id="login" <?php if(!isset($_SESSION['showreg'])){echo 'checked';} ?> >
                    <input type="radio" name="slider" id="signup" <?php if(isset($_SESSION['showreg'])){echo 'checked';} ?> >
                    <label for="login" class="slide login">Zaloguj</label>
                    <label for="signup" class="slide signup" id="registerbutton">Zarejestruj</label>
                    <div class="slide-tab">

                    </div>
                </div>
                <?php if(isset($_SESSION['reg_res'])) {
                                echo '<div class="notification">'.$_SESSION['reg_res'].'</div>';
                                unset($_SESSION['reg_res']);
                            } ?>
                <div class="form-inner">
                    <form class="login" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="field">
                            <input id="email_login" type="text" placeholder="E-mail" name="email" required>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                        <div class="field">
                            <input id="password_login" type="password" placeholder="Hasło" name="password" required>
                        </div>
                        <div class="pass-link"><a href="#">Forgot password?</a></div>
                        <div class="field">
                            <input id="login_button" type="submit" value="Zaloguj się">
                        </div>
                        <div class="signup-link">Nie posiadasz konta? <a href="#">Zarejestruj się!</a></div>
                    </form>
                    <form class="signup" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="field">
                            <input id="name_register" type="text" placeholder="Login" name="name" required>
                            <?php if(isset($_SESSION['e_login'])) {
                                echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                                unset($_SESSION['e_login']);
                            } ?>
                        </div>
                        <div class="field">
                            <input id="email_register" type="text" placeholder="E-mail" name="email" required>
                            <?php if(isset($_SESSION['e_email'])) {
                                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                                unset($_SESSION['e_email']);
                            } ?>
                        </div>
                        <div class="field">
                            <input id="password_register" type="password" placeholder="Hasło" name="password" required>
                        <?php if(isset($_SESSION['e_password'])) {
                                echo '<div class="error">'.$_SESSION['e_password'].'</div>';
                                unset($_SESSION['e_password']);
                            } ?>
                        </div>
                        <div class="field">
                            <input id="password_confirmation_register" type="password" placeholder="Potwierdź hasło" name="password_confirmation" required>
                        </div>
                            <?php if(isset($_SESSION['e_password2'])) {
                                echo '<div class="error">'.$_SESSION['e_password2'].'</div>';
                                unset($_SESSION['e_password2']);
                            } ?>
                        
                        <!-- <div class="checkbox" style="text-align:center; margin-top:5px; font-size:18px;">
                            <label><input id="rules" type="checkbox" value="Akceptuję regulamin" name="rules">
                                Akceptuję regulamin
                            </label>
                        </div> -->
                        <?php if(isset($_SESSION['e_rules'])) {
                                echo '<div class="error">'.$_SESSION['e_rules'].'</div>';
                                unset($_SESSION['e_rules']);
                            } ?>
                        <div class="field">
                            <input id="register_button" type="submit" name="submit" value="Zarejestruj się">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <script>
        const loginForm = document.querySelector("form.login");
        const signupForm = document.querySelector("form.signup");
        const loginBtn = document.querySelector("label.login");
        const signupBtn = document.querySelector("label.signup");
        const signupLink = document.querySelector(".signup-link a");
        signupBtn.onclick = (()=>{
            loginForm.style.marginLeft="-50%";
        });
        loginBtn.onclick = (()=>{
            loginForm.style.marginLeft="0%";
        });
        signupLink.onclick = (() => {
            signupBtn.click();
        })
    </script>
</body>
</html>

<?php
    if(isset($_SESSION['showreg'])) {
    echo 
    '<script>
        var button = document.getElementById("registerbutton");
        button.onclick();
    </script>';
    }
    unset($_SESSION['showreg']);
?>