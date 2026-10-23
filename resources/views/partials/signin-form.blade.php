 <form action="">
        <h1>Sign In</h1>

        <form action="">
    <img
        src="{{ asset('images/ebarangay.png') }}"
        alt="Barangay Cuambogan Logo"
        class="signin-logo"
    >

        <div class="input-box">
            <input type="text" placeholder="Username"
            required>
            <i class="bx bx-user"></i>
        </div>

        <div class="input-box">
            <input type="password" placeholder="Password" class="password-input" required>
            <i class="bx bx-show password-toggle"></i>
        </div>

        <div class="remember-forgot">
            <label><input type="checkbox"> Remember me</label>
            <a href="#"> Forgot password?</a>
        </div>

        <button type="submit" class="btn">Sign In</button>

        <div class="register-link">
            <p>Don't have an account?<a
            href="#" class="switch-to-signup">Sign Up</a></p>
</div>
</form>