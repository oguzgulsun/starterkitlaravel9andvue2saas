<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification - {{env('APP_NAME')}} </title>
    
</head>
<body>
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            A new email verification link has been emailed to you!
        </div>
    @endif

    Devam Etmek İçin Mail Adresini Onaylamanız Gerekmektedir.

    Email Onayını tekrar göndermek için

    <form action="/email/verification-notification" method="post">
    @csrf
    <input type="submit" value="Yeniden Gönder">
    </form>

</body>
</html>