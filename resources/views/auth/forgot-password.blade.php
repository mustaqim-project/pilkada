<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .container {
            background-color: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            max-width: 450px;
            width: 100%;
            text-align: center;
        }

        .message {
            color: #555;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        label {
            font-size: 1rem;
            color: #333;
            display: block;
            margin-bottom: 0.4rem;
        }

        input {
            width: 100%;
            padding: 0.9rem;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus {
            border-color: #764ba2;
            box-shadow: 0 4px 12px rgba(118, 75, 162, 0.2);
        }

        .error {
            color: #e3342f;
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .submit-btn {
            padding: 0.8rem 2rem;
            background-color: #764ba2;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .submit-btn:hover {
            background-color: #5e3b99;
            transform: translateY(-2px);
        }

        .submit-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        /* Small screen adjustments */
        @media (max-width: 600px) {
            .container {
                padding: 2rem;
                max-width: 350px;
            }

            .message {
                font-size: 1rem;
            }

            input, .submit-btn {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            Forgot your password? No worries! Enter your email below, and we'll send you a reset link.
        </div>

        <!-- Session Status -->
        <?php if (session('status')): ?>
            <div class="message" style="color: green;">
                <?= session('status'); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/password/email">
            <input type="hidden" name="_token" value="<?= csrf_token(); ?>">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="<?= old('email'); ?>" required autofocus>
                <!-- Display validation error -->
                <?php if ($errors->has('email')): ?>
                    <div class="error"><?= $errors->first('email'); ?></div>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="submit-container">
                <button type="submit" class="submit-btn">Send Reset Link</button>
            </div>
        </form>
    </div>
</body>
</html>
