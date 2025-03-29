<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-align: center;
        }
        .error-container {
            max-width: 600px;
        }
        .error-code {
            font-size: 100px;
            font-weight: bold;
        }
        .error-text {
            font-size: 22px;
            margin-bottom: 20px;
        }
        .btn-custom {
            background: white;
            color: #764ba2;
            font-weight: bold;
        }
        .error-svg {
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <svg class="error-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
            <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8.01 8.01 0 0 1-8 8zm-3-7a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm6 0a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm-5.07 3h4.14a1 1 0 1 1 0 2H8.93a1 1 0 0 1 0-2z"/>
        </svg>
        <div class="error-code">404</div>
        <div class="error-text">Oops! The page you're looking for can't be found.</div>
        <a href="<?=base_url('dashboard')?>" class="btn btn-custom px-4 py-2">Back to Dashboard</a>
    </div>
</body>
</html>
