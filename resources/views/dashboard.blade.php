<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #e9f7ef; }
        .welcome-box { background: #d4edda; color: #155724; padding: 2rem; border-radius: 8px; text-align: center; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="welcome-box">
        @if (session('success'))
            <h1>{{ session('success') }}</h1>
            <p>Selamat datang kembali, <strong>{{ session('name') }}</strong>!</p>
            <a href="{{ route('login-form') }}">Kembali ke Login</a>
        @endif
    </div>
</body>
</html>