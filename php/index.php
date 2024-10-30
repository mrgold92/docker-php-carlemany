<?php
require_once 'config.php';
require_once 'errors.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <?php echo showMessages(); ?>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="authTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab">
                                    <i class="fas fa-user-plus me-2"></i>Register
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="authTabsContent">
                            <div class="tab-pane fade show active" id="login" role="tabpanel">
                                <form action="login.php" method="post">
                                    <div class="mb-4">
                                        <label class="form-label">Username</label>
                                        <div class="input-group">
                                            <input type="text" name="username" class="form-control" placeholder="Enter your username">
                                            <span class="input-icon">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control" placeholder="Enter your password">
                                            <span class="input-icon toggle-password" onclick="togglePassword(this)">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login
                                    </button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="register" role="tabpanel">
                                <form action="register.php" method="post">
                                    <div class="mb-4">
                                        <label class="form-label">Username</label>
                                        <div class="input-group">
                                            <input type="text" name="username" class="form-control" placeholder="Choose a username">
                                            <span class="input-icon">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Email</label>
                                        <div class="input-group">
                                            <input type="email" name="email" class="form-control" placeholder="Enter your email">
                                            <span class="input-icon">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control" placeholder="Create a password">
                                            <span class="input-icon toggle-password" onclick="togglePassword(this)">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-user-plus me-2"></i>Register
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(element) {
            const input = element.parentElement.previousElementSibling;
            const icon = element.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>