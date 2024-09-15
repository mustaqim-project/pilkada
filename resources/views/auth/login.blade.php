<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e1e1e 0%, #343a40 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #f1f1f1;
        }

        .login-container {
            background-color: #2c2c2c;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            color: #f1f1f1;
            margin-bottom: 1.5rem;
        }

        .login-container label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #f1f1f1;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #444;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #1e1e1e;
            color: #f1f1f1;
            transition: border-color 0.3s ease;
        }

        .login-container input:focus {
            border-color: #74ebd5;
            outline: none;
            box-shadow: 0 0 5px rgba(116, 235, 213, 0.5);
        }

        .login-container .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .login-container .remember-me input {
            margin-right: 0.5rem;
        }

        .login-container .remember-me span {
            font-size: 0.9rem;
            color: #ccc;
        }

        .login-container .forgot-password {
            text-align: right;
            margin-bottom: 1rem;
        }

        .login-container .forgot-password a {
            text-decoration: none;
            color: #74ebd5;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .login-container .forgot-password a:hover {
            color: #f1f1f1;
        }

        .login-container button {
            width: 100%;
            padding: 0.75rem;
            background-color: #74ebd5;
            color: #1e1e1e;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #ACB6E5;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                    <div class="mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                @error('password')
                    <div class="mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Remember me</span>
            </div>

            <!-- Forgot Password Link -->
            <div class="forgot-password">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit">Log in</button>
        </form>
    </div>
</body>
</html>
