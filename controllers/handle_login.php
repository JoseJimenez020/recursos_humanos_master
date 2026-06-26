<?php
declare(strict_types=1);
// controllers/handle_login.php
// Este controlador procesa los POST provenientes de sign-in.php
// Incluir desde sign-in.php justo antes de renderizar la vista:
// require_once __DIR__ . '/handle_login.php';

// Requiere la conexión ya creada en ../controllers/conn.php
require_once 'conn.php';            // debe definir $pdo (PDO)
require_once 'auth_functions.php';  // funciones anteriores

if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

// ---------- CANDIDATO (botón name="candidato") ----------
if (isset($_POST['candidato'])) {
    $fullname = trim($_POST['fullname'] ?? '');
    $telRaw   = trim($_POST['tel'] ?? '');
    $tel      = preg_replace('/\D+/', '', $telRaw);
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: null;
    $age      = isset($_POST['age']) ? (int)$_POST['age'] : 0;
    $base     = trim($_POST['Base'] ?? '');
    $puesto   = trim($_POST['Puesto'] ?? '');

    if ($fullname === '' || $tel === '') {
        $_SESSION['login_error'] = 'Nombre y teléfono son obligatorios para candidatos';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }

    // 1) Intentar login directo por nombre+tel
    $exists = findCandidatoByNameTel($pdo, $fullname, $tel);
    if ($exists) {
        loginCandidato($exists);
    }

    // 2) Buscar por correo o teléfono para evitar duplicados
    $found = findCandidato($pdo, $email, $tel);
    if ($found) {
        loginCandidato($found);
    }

    // 3) Crear nuevo
    $newId = createCandidato($pdo, [
        'fullname' => $fullname,
        'tel'      => $tel,
        'email'    => $email,
        'age'      => $age,
        'Base'     => $base,
        'Puesto'   => $puesto,
    ]);

    if ($newId === false) {
        $_SESSION['login_error'] = 'Error al registrar candidato, intenta más tarde';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }

    $stmt = $pdo->prepare('SELECT * FROM candidatos WHERE CandidatoId = :id LIMIT 1');
    $stmt->execute([':id' => $newId]);
    $c = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($c) loginCandidato($c);

    $_SESSION['login_error'] = 'Registro creado pero no se pudo iniciar sesión';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
    exit;
}

// ---------- USUARIO / EMPLEADO (botón name="login") ----------
if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $_SESSION['login_error'] = 'Usuario y contraseña requeridos';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }

    $user = verifyUsuario($pdo, $username, $password);
    if ($user) {
        // Verificar UsuarioActivo si es necesario
        if (isset($user['UsuarioActivo']) && (int)$user['UsuarioActivo'] !== 1) {
            $_SESSION['login_error'] = 'Usuario inactivo';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        }
        loginUsuario($user);
    }

    $_SESSION['login_error'] = 'Credenciales inválidas';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
    exit;
}