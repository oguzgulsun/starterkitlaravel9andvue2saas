<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}} </title>
</head>
<body>
 
    @if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form action="/reset-password" method="post">
        @csrf

        <input type="hidden" name="token" value="{{$request['token']}}">
        <input type="hidden" name="email" value="{{$request['email']}}">
        <label for="password">Password</label>
        <input type="password" name="password" id="password"><br>
        <label for="password_confirmation">Password Confirm</label>
        <input type="password" name="password_confirmation" id="password_confirmation"><br>

        <input type="submit" value="Send">
    </form>
</body>
</html>