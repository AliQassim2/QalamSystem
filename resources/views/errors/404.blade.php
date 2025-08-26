<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            padding: 80px 20px;
        }

        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 20px;
            letter-spacing: 10px;
        }

        .message {
            font-size: 2rem;
            color: #374151;
            margin-bottom: 10px;
        }

        .description {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .home-link {
            display: inline-block;
            padding: 12px 32px;
            background: #6366f1;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1rem;
            transition: background 0.2s;
        }

        .home-link:hover {
            background: #4338ca;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-code">404</div>
        <div class="message">Oops! Page Not Found</div>
        <div class="description">
            The page you are looking for might have been removed,<br>
            had its name changed, or is temporarily unavailable.
        </div>
        <a href="{{ url('/') }}" class="home-link">Go to Homepage</a>
    </div>
</body>

</html>