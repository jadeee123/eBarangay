<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In eBarangay</title>

    <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    

</head>

<body>
<div class="modal">
<div class="wrapper">
   @include('partials.signin-form')
</div>    
</div>

</body>
</html>