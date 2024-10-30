<?php
require_once 'config.php';
require_once 'errors.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$users = getAllUsers($conn);
$currentUser = getUserById($conn, $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-users me-2"></i>User Dashboard
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3 text-dark user-profile" data-bs-toggle="modal" data-bs-target="#profileModal" style="cursor: pointer;">
                    <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($currentUser['username']); ?>
                </span>
                <a href="logout.php" class="btn btn-logout text-white">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container dashboard">
        <?php echo showMessages(); ?>
        <div class="welcome-section">
            <h2 class="mb-4">
                <i class="fas fa-chart-line me-2"></i>Dashboard Overview
            </h2>
            <div class="stats-container">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3><?php echo count($users); ?></h3>
                    <p class="mb-0">Total Users</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-clock"></i>
                    <h3><?php echo date('M Y'); ?></h3>
                    <p class="mb-0">Current Period</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-check"></i>
                    <h3>Active</h3>
                    <p class="mb-0">Your Status</p>
                </div>
            </div>
        </div>

        <h3 class="mb-4 text-white">
            <i class="fas fa-users me-2"></i>Registered Users
        </h3>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($users as $index => $user): ?>
                <div class="col" style="--animation-order: <?php echo $index; ?>">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <div class="user-avatar">
                                    <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                                </div>
                                <span><?php echo htmlspecialchars($user['username']); ?></span>
                            </h5>
                            <div class="user-info">
                                <p class="mb-2">
                                    <i class="fas fa-envelope me-2"></i>
                                    <?php echo htmlspecialchars($user['email']); ?>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Joined: <?php echo date('d M Y', strtotime($user['created_at'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Perfil de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Información
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                                <i class="fas fa-key me-2"></i>Cambiar Contraseña
                            </button>
                        </li>

                    </ul>
                    <div class="tab-content p-3" id="profileTabsContent">
                        <!-- Información del perfil -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="mb-3">
                                <label class="fw-bold">Username:</label>
                                <p><?php echo htmlspecialchars($currentUser['username']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Email:</label>
                                <p><?php echo htmlspecialchars($currentUser['email']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Fecha de registro:</label>
                                <p><?php echo date('d M Y', strtotime($currentUser['created_at'])); ?></p>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <form action="update_password.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Contraseña Actual</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>