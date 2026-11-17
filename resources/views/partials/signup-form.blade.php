@if ($errors->any())
    <div style="color: red;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form action="{{ route('register') }}" method="POST">'
    @csrf
    <h1>Sign Up</h1>

<img
    src="{{ asset('images/ebarangay.png') }}"
    alt="Barangay Cuambogan Seal"
    class="signin-logo"
>

    <div class="input-box">

        <input type="text" name="name" placeholder="Username" required>
        <i class="bx bx-user"></i>
    </div>

    <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
        <i class="bx bx-envelope"></i>
    </div>

    <div class="input-box">
         <input type="password" name="password" placeholder="Password" class="password-input" required>
         <i class="bx bx-show password-toggle"></i>

  </div>

     <div class="input-box">
         <input type="password" name="password_confirmation" placeholder="Confirm Password" class="password-input" required>
         <i class="bx bx-show password-toggle"></i>
  </div>
    
        <button type="submit" class="btn">Sign Up</button>

        <div class="register-link">
            <p>Already have an account?
                <a href="#" class="switch-to-signin">Sign In</a></p>
        </div>

        <div class="gmail-section">

            <div class="divider">
                <span>or</span>
            </div>

           <p> or Sign Up with Gmail account</p>
       
            <a href="{{ route('google.redirect') }}" class="google-btn">
                <span class="google-letter">G</span></a>
        </div>

</form>