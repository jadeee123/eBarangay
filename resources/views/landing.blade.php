<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>eBarangay</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">

</head>
<body>

    <nav class="navbar">
        <div class="container">

            <a href="#" class="logo">
                eBarangay
            </a>

            <div class="nav-links">
                <a href="#about">About</a>
                <a href="#how">How it Works</a>
                <a href="#contact">Contact</a>
            </div>

        </div>
    </nav>

   <section class="hero" id="about">

    <div class="container">

        <div class="row align-items-center justify-content-center">

            <div class="col-lg-6">

                <div class="hero-content">

                    <div class="welcome">
                        YOUR BARANGAY, MADE SIMPLE
                    </div>

                    <h1>
                        Your Barangay,
                        <span>Just a Click Away.</span>
                    </h1>

                    <p>
                        eBarangay brings essential barangay services closer to you.
                        Submit your requests, track their progress, and stay updated
                        without the hassle of long lines and repeated visits.
                    </p>

                    <div class="hero-buttons">

                        <a href="#" class="signin-btn">
                            Sign In
                        </a>

                        <a href="#Sign Up" class="signup-btn">
                            Sign Up
                        </a>

                    </div>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="illustration">

                    <div class="circle circle-one"></div>

                    <div class="circle circle-two"></div>

                    <div class="sun"></div>

                    <div class="building">

                        <div class="building-roof"></div>

                        <div class="building-body">

                            <div class="building-top">
                                BARANGAY
                            </div>

                            <div class="building-columns">

                                <div class="column"></div>

                                <div class="main-door">
                                    <span></span>
                                </div>

                                <div class="column"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

    <section class="how" id="how">

        <div class="container">

        <div class="how-heading">
            <h2>How eBarangay Works</h2>
            <p>Simple steps to access your barangay services online.</p>
        </div>

            <div class="how-content">

                <div class="how-item">
                    <div class="how-number">01</div>

                    <div>
                        <h3>Request Online</h3>
                        <p>
                            Submit your barangay service request
                            from wherever you are.
                        </p>
                    </div>
                </div>

                <div class="how-item">
                    <div class="How-number">02</div>

                    <div>
                        <h3>Track Your Request</h3>
                        <p>
                            Easily check the progress of your
                            submitted request.
                        </p>
                    </div>
                </div>

                <div class="how-item">
                    <div class="how-number">03</div>

                    <div>
                        <h3>Stay Updated</h3>
                        <p>
                            Know when your request is ready
                            and when it can be claimed.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <section class="contact" id="contact">

        <div class="container">

            <div class="contact-box">

                <div>
                    <small>GET IN TOUCH</small>

                    <h2>
                        Need help with a barangay service?
                    </h2>

                    <p>
                        Visit or contact your barangay office
                        for inquiries and assistance.
                    </p>
                </div>

                <div class="contact-icon">
                    ✉
                </div>

            </div>

        </div>

    </section>

    <footer>

        <div class="container">

            <div class="footer-content">

                <div>
                    <div class="footer-logo">
                        e-Barangay
                    </div>

                    <p>
                        Simple and accessible barangay services
                        for everyone.
                    </p>
                </div>

            </div>

            <div class="footer-bottom">
                © 2026 eBarangay. All rights reserved.
            </div>

        </div>

    </footer>

<div class="modal" id="signinModal">

    <div class="signin-content">
        <div class="wrapper">

        <button class="close-btn" type="button">
        <i class="bx bx-x"></i>
        </button>
        @include('partials.signin-form')
        </div>
    </div>

 </div>

 <div class="modal signup-modal" id="signupModal">
        <div class="wrapper">

        <button class="close-btn signup-close-btn" type="button">
        <i class="bx bx-x"></i>
        </button>

        @include('partials.signup-form')

        </div>
 </div>

<script src="{{ asset('js/landing.js') }}"></script>

</body>
</html>