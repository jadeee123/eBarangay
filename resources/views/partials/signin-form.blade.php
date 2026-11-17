<form action="{{ route('login') }}" method="POST">
    @csrf

    <h1>Sign In</h1>

    <img
        src="{{ asset('images/ebarangay.png') }}"
        alt="Barangay Cuambogan Logo"
        class="signin-logo"
    >

    <div class="input-box">
        <input
            type="email"
            name="email"
            placeholder="Email"
            value="{{ old('email') }}"
            required
        >
        <i class="bx bx-user"></i>
    </div>

    <div class="input-box">
        <input
            type="password"
            name="password"
            placeholder="Password"
            class="password-input"
            required
        >
        <i class="bx bx-show password-toggle"></i>
    </div>

    <div class="remember-forgot">
        <label>
            <input type="checkbox" name="remember" value="1">
            Remember me
        </label>
        <a href="#">Forgot password?</a>
    </div>

    @if ($errors->has('email'))
        <p class="error-message">
            {{ $errors->first('email') }}
        </p>
    @endif

    <button type="submit" class="btn">Sign In</button>

    <div class="register-link">
        <p>
            Don't have an account?
            <a href="#" class="switch-to-signup">Sign Up</a>

             <p> or Sign In with Gmail account</p>
       
            <a href="{{ route('google.redirect') }}" class="google-btn">
                <span class="google-letter">G</span></a>
        </p>
    </div>
</form>
