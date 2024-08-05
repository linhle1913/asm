<!DOCTYPE html>
<html>
<head>
    <title>Quên mật khẩu</title>
</head>
<body>
    <h2>Thay đổi mật khẩu của bạn</h2>
    <p>Xin chào {{ $user->name }},</p>
    <p>Email này được gửi đến bạn bởi vì bạn đã yêu cầu đổi mật khẩu.</p>
    <p>Nhấn vào link này để đến trang thay đổi mật khẩu: </p>
    <a href="{{ $resetLink }}"
       style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px;">
        Thay đổi mật khẩu
    </a>
    <p>Cảm ơn, <br>{{ config('app.name') }}</p>
</body>
</html>
