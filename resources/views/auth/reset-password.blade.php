<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        label {
            font-size: 1rem;
            color: #333;
            display: block;
            margin-bottom: 0.5rem;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 0.5rem;
            font-size: 1rem;
            outline: none;
        }

        input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.3);
        }

        .error {
            color: #e3342f;
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .submit-btn {
            padding: 0.75rem 1.5rem;
            background-color: #6366f1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #4f46e5;
        }

        .submit-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="/password/reset">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                <!-- Error message -->
                <?php if ($errors->has('email')): ?>
                    <div class="error"><?= $errors->first('email') ?></div>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
                <!-- Error message -->
                <?php if ($errors->has('password')): ?>
                    <div class="error"><?= $errors->first('password') ?></div>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                <!-- Error message -->
                <?php if ($errors->has('password_confirmation')): ?>
                    <div class="error"><?= $errors->first('password_confirmation') ?></div>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="submit-container">
                <button type="submit" class="submit-btn">Reset Password</button>
            </div>
        </form>
    </div>
</body>
</html>
