<?php
function getErrorMessage($error_code) {
    $errors = [
        'invalid' => 'Usuario o contraseña incorrectos',
        'exists' => 'El usuario o email ya existe',
        'empty_fields' => 'Todos los campos son obligatorios',
        'invalid_email' => 'El formato del email no es válido',
        'invalid_username' => 'El nombre de usuario debe tener entre 3 y 50 caracteres',
        'password_short' => 'La contraseña debe tener al menos 6 caracteres',
        'db_error' => 'Error de conexión con la base de datos',
        'password_mismatch' => 'Las contraseñas no coinciden',
        'wrong_password' => 'La contraseña actual es incorrecta',
        'update_failed' => 'Error al actualizar los datos',
        'user_not_found' => 'Usuario no encontrado',
        'email_exists' => 'El email ya está en uso',
        'default' => 'Ha ocurrido un error'
    ];

    return $errors[$error_code] ?? $errors['default'];
}

function getSuccessMessage($success_code) {
    $success = [
        'registered' => '¡Registro exitoso! Ya puedes iniciar sesión',
        'password_updated' => 'Contraseña actualizada correctamente',
        'profile_updated' => 'Perfil actualizado correctamente',
        'email_updated' => 'Email actualizado correctamente',
        'default' => 'Operación realizada con éxito'
    ];

    return $success[$success_code] ?? $success['default'];
}

function showMessages() {
    $output = '';
    
    if (isset($_GET['error'])) {
        $error_msg = getErrorMessage($_GET['error']);
        $output .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($error_msg) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if (isset($_GET['success'])) {
        $success_msg = getSuccessMessage($_GET['success']);
        $output .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($success_msg) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    return $output;
}
?>