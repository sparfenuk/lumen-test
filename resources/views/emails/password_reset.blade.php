<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Reset Password</title>
</head>
<body>
<h1>Reset Password</h1>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p>To reset your password, click the button below:</p>
<p><a href="{{ url('api/user/recover-password', $token) }}">Reset Password</a></p>
<p>If you did not request a password reset, no further action is required.</p>
</body>
</html>
