<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Credentials</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Hello {{ $user->name }},</h2>

    <p>Your listing has been submitted. We created an <b>Admin account</b> for you.</p>

    <p><b>Login Email:</b> {{ $user->email }}</p>
    <p><b>Password:</b> {{ $plainPassword }}</p>

    <p>
        Please login here:
        <a href="{{ url('/login') }}">{{ url('/login') }}</a>
    </p>

    <p style="color:#d00;"><b>Note:</b> Please change your password after login.</p>

    <p>Thanks,<br/>Team</p>
</body>
</html>
