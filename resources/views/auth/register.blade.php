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

    
    <form action="/register" method="post">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" id="name"><br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email"><br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password"><br>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"><br>
        <input type="submit" value="Send">
    </form>
</body>
</html>