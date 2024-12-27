<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Poli - Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #4e54c8, #8f94fb);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            overflow: hidden;
        }

        .landing-container {
            text-align: center;
            padding: 50px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1.2s ease-out;
        }

        .landing-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4e54c8;
            margin-bottom: 20px;
        }

        .landing-description {
            font-size: 1rem;
            font-weight: 400;
            color: #666;
            margin-bottom: 30px;
        }

        .btn-custom {
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #4e54c8;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #3c3fad;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(78, 84, 200, 0.5);
        }

        .btn-secondary {
            background-color: #8f94fb;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #7c81f4;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(143, 148, 251, 0.5);
        }

        .icon {
            font-size: 4rem;
            color: #8f94fb;
            margin-bottom: 20px;
            animation: bounce 1.5s infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body>
    <div class="container landing-container">
        <div class="icon">
            <i class="bi bi-hospital"></i>
        </div>
        <h1 class="landing-title">Welcome to Smart Poli</h1>
        <p class="landing-description">Smarter, faster, and reliable healthcare services. Start your journey today!</p>
        <div class="d-grid gap-3 d-md-flex justify-content-md-center">
            <a href="<?php echo base_url('login'); ?>" class="btn btn-primary btn-custom">Login</a>
            <a href="<?php echo base_url('register'); ?>" class="btn btn-secondary btn-custom">Register</a>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>

</html>
