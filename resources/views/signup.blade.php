<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up eBarangay</title>

    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="modal signup-modal standalone">
    <div class="wrapper">

     <button class="close-btn signup-close-btn" type="button">
        <i class="bx bx-x"></i>
        </button>
        @include('partials.signup-form')
    </div>
</div>
    
</body>
</html>