<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fonts/finder-icons.woff2') }}" rel="stylesheet" type="font/woff2">
    <link href="{{ asset('assets/css/finder-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/flaticon.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>


    <div class="login-34">
        <div class="container">
            <div class="row login-box">
                <div class="col-lg-6 bg-color-15 pad-0 none-992 align-self-center bg-img">
                    <div class="info clearfix">
                        <img src="{{ asset('assets/images/login-img.png') }}" alt="bg" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6 pad-0 form-info">
                    <div class="form-section align-self-center">
                        <h1>Welcome!</h1>
                        <h3>Sign Into Your Account</h3>
                        <div class="clearfix"></div>
                        <div class="btn-section clearfix">
                            <a href="/login" class="link-btn active btn-1 active-bg">Login</a>
                            <a href="/register" class="link-btn btn-2 default-bg">Register</a>
                        </div>
                        <div class="clearfix"></div>
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="form-group form-box">
                                <label for="first_field" class="form-label">Email address</label>
                                <input name="email" type="email" class="form-control" id="first_field"
                                    placeholder="Email Address" aria-label="Email Address">
                            </div>
                            <div class="form-group form-box">
                                <label for="second_field" class="form-label">Password</label>
                                <input name="password" type="password" class="form-control" autocomplete="off"
                                    id="second_field" placeholder="Password" aria-label="Password">
                            </div>
                            <div class="checkbox form-group form-box">
                                <div class="form-check checkbox-theme">
                                    <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Remember me
                                    </label>
                                </div>
                                <a href="forgot-password.html" class="forgot-password">Forgot Password</a>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn-md btn-theme w-100">Login</button>
                            </div>
                            <div class="form-group mt-3">
                                <a href="" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                                    <img src="https://developers.google.com/identity/images/g-logo.png"
                                        alt="Google"
                                        style="width:18px; margin-right:10px;">
                                    Login with Google
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/gsap.js') }}"></script>
    <script src="{{ asset('assets/js/gsap-animation.js') }}"></script>
    <script src="{{ asset('assets/js/splitText.js') }}"></script>
    <script src="{{ asset('assets/js/ScrollTrigger.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>