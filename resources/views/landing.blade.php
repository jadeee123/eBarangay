
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>eBarangay | Barangay Cuambogan</title>

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
</head>
<body>

   <!-- navbar -->
    <nav class="navbar">
        <div class="container nav-container">

            <a href="#about" class="brand">
                <img src="{{ asset('images/ebarangay.png') }}"
                     alt="Barangay Cuambogan Seal">
                <span>eBarangay</span>
            </a>

            <button class="nav-toggle" id="navToggle"
                    type="button" aria-label="Toggle navigation"
                    aria-expanded="false">
                <i class="bx bx-menu"></i>
            </button>

            <div class="nav-links" id="navLinks">
                <a href="#about">About</a>
                <a href="#how">How It Works</a>
                <a href="#contact">Contact</a>
                <button type="button" class="nav-signin signin-btn">
                    Sign In
                </button>
            </div>

        </div>
    </nav>

    <!-- about -->
    <section class="hero" id="about">
        <div class="hero-overlay"></div>

        <div class="container hero-container">
            <div class="hero-content">

                <div class="welcome">
                    <i class="bx bx-map-pin"></i>
                    BARANGAY CUAMBOGAN · TAGUM CITY
                </div>

                <h1>
                    Your Barangay,<br>
                    <span>Just a Click Away.</span>
                </h1>

                <p>
                    Access barangay services with greater convenience.
                    Submit your requests, track their progress, and
                    stay informed without unnecessary trips to the office.
                </p>

                <div class="hero-buttons">
                    <button type="button" class="primary-btn signin-btn">
                        Sign In <i class="bx bx-right-arrow-alt"></i>
                    </button>

                    <button type="button" class="secondary-btn signup-btn">
                        Create an Account
                    </button>
                </div>

                <div class="hero-note">
                    <i class="bx bx-check-circle"></i>
                    Simple and accessible barangay services
                </div>

            </div>
        </div>

        <a href="#how" class="scroll-indicator" aria-label="Explore services">
            <i class="bx bx-down-arrow-alt"></i>
        </a>
    </section>

    <!-- works -->
    <section class="how" id="how">
        <div class="container">

            <div class="section-heading">
                <span class="eyebrow">A SIMPLER WAY TO GET STARTED</span>
                <h2>How eBarangay Works</h2>
                <p>
                    Three simple steps to manage your barangay service requests.
                </p>
            </div>

            <div class="how-content">

                <article class="how-item">
                    <div class="how-icon">
                        <i class="bx bx-file"></i>
                    </div>
                    <span class="how-number">01</span>
                    <h3>Submit a Request</h3>
                    <p>
                        Choose a barangay service and submit your request online.
                    </p>
                </article>

                <article class="how-item">
                    <div class="how-icon">
                        <i class="bx bx-list-check"></i>
                    </div>
                    <span class="how-number">02</span>
                    <h3>Track Your Request</h3>
                    <p>
                        Check your request status and follow its progress.
                    </p>
                </article>

                <article class="how-item">
                    <div class="how-icon">
                        <i class="bx bx-calendar-check"></i>
                    </div>
                    <span class="how-number">03</span>
                    <h3>Stay Updated</h3>
                    <p>
                        Check updates and find out when your document
                        is ready for claiming.
                    </p>
                </article>

            </div>
        </div>
    </section>

    <!-- contact -->
    <section class="contact" id="contact">
        <div class="container">

            <div class="contact-box">
                <div class="contact-content">
                    <span class="eyebrow">WE'RE HERE TO HELP</span>
                    <h2>Need assistance with a barangay service?</h2>
                    <p>
                        For questions or assistance with your requests,
                        please contact or visit the Barangay Cuambogan office.
                    </p>
                </div>

                <div class="contact-icon">
                    <i class="bx bx-support"></i>
                </div>
            </div>

        </div>
    </section>

    <!-- footer -->
    <footer class="footer">
        <div class="container">

            <div class="footer-content">
                <a href="#about" class="footer-brand">
                    <img src="{{ asset('images/ebarangay.png') }}"
                         alt="Barangay Cuambogan Seal">
                    <span>eBarangay</span>
                </a>

                <p>
                    Making barangay services more convenient and accessible.
                </p>
            </div>

            <div class="footer-bottom">
                <span>© 2026 eBarangay. All rights reserved.</span>
                <a href="#about">Back to top ↑</a>
            </div>

        </div>
    </footer>

    <!-- sign in, exixting form -->
    <div class="modal" id="signinModal">
        <div class="signin-content">
            <div class="wrapper">

                <button class="close-btn" type="button"
                        aria-label="Close sign in">
                    <i class="bx bx-x"></i>
                </button>

                @include('partials.signin-form')

            </div>
        </div>
    </div>

   <!-- signup , exixting form -->
    <div class="modal signup-modal" id="signupModal">
        <div class="wrapper">

            <button class="close-btn signup-close-btn" type="button"
                    aria-label="Close sign up">
                <i class="bx bx-x"></i>
            </button>

            @include('partials.signup-form')

        </div>
    </div>

    <script src="{{ asset('js/landing.js') }}"></script>

</body>
</html>
