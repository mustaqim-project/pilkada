<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            color: #333;
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

        .container p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .status {
            color: #16a34a;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }

        button {
            padding: 0.75rem 1.5rem;
            background-color: #6366f1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4f46e5;
        }

        .logout-btn {
            background-color: transparent;
            color: #6366f1;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9rem;
            border: none;
            transition: color 0.3s ease;
        }

        .logout-btn:hover {
            color: #4f46e5;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

        <!-- Session Status -->
        <!-- Assuming a session status check here in plain PHP -->
        <?php if (session('status') == 'verification-link-sent'): ?>
            <div class="status">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        <?php endif; ?>

        <div class="actions">
            <form method="POST" action="/email/verification-notification">
                <!-- Assuming a route to resend the verification -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit">Resend Verification Email</button>
            </form>

            <form method="POST" action="/logout">
                <!-- Assuming a route to logout -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="logout-btn">Log Out</button>
            </form>
        </div>
    </div>
</body>
</html>
