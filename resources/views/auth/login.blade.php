<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}} </title>
</head>
<body>
 
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form action="/login" method="post">
        @csrf
        <label for="email">Email</label>
        <input type="email" name="email" id="email"><br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password"><br>
        <label for="remember">Remember Me</label>
        <input type="checkbox" name="remember" id="remember"><br>
        
        <input type="submit" value="Send">
    </form>
    <a href="{{route('forgot-password')}}">Sifremi Unuttum</a>


    <a href="{{ route('auth.google') }}">
        <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" style="margin-left: 3em;">
    </a>
</body>
</html>