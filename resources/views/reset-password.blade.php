<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>
    <h1>You have requested a password reset</h1>
    <p>Your recovery link is <a href="http://127.0.0.1:8000/reset-password/{{ $token }}">http://127.0.0.1:8000/reset-password/{{ $token }}</a></p>
    <p>Thank you</p>
</body>
</html>