<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Poli - Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .landing-container {
            text-align: center;
            padding: 40px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }

        .landing-title {
            font-size: 3rem;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 20px;
        }

        .landing-description {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .btn-custom {
            padding: 12px 30px;
            font-size: 1.2rem;
            border-radius: 50px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-secondary {
            background-color: #6610f2;
            border: none;
        }

        .icon {
            font-size: 5rem;
            color: #6610f2;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container landing-container">
        <div class="icon">
            <i class="bi bi-hospital"></i>
        </div>
        <h1 class="landing-title">Welcome to Smart Poli</h1>
        <p class="landing-description">Efficient and smarter solutions for your medical services. Get started now!</p>
        <div class="d-grid gap-3 d-md-flex justify-content-md-center">
            <a href="<?php echo base_url('login'); ?>" class="btn btn-primary btn-custom">Login</a>
            <a href="<?php echo base_url('register'); ?>   " class="btn btn-secondary btn-custom">Register</a>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>

</html>