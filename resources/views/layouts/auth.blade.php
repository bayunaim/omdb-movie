<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OMDB-MOVIE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('{{ asset('images/bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: rgba(0, 0, 0, 0.75);
            padding: 2rem;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            color: #fff;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }

        .login-box h2 {
            margin-bottom: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .btn-primary {
            background-color: #e50914;
            border: none;
        }

        .btn-primary:hover {
            background-color: #b00610;
        }

        a {
            color: #aaa;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
