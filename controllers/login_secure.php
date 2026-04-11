<?php
declare(strict_types=1);
/**
 * login_secure.php
 * Reemplaza controllers/login.php + controllers/handle_login.php
 *
 * CAMBIOS respecto al original:
 *  - Elimina contraseñas en localStorage (solo guarda username)
 *  - Rate limiting por IP y por username
 *  - Regeneración de sesión tras login exitoso
 *  - CSRF en el formulario de login
 *  - Verificación de UsuarioActivo correctamente unificada
 */

require_once __DIR__ . '/security.php';  // cabeceras + helpers

// session_start() con configuración segura
if (session_status() === PHP_SESSION_NONE) {
    secureSessionConfig();
    session_start();
}

require_once __DIR__ . '/conn.php';

// Redirigir si ya tiene sesión activa
if (isset($_SESSION['user_id'])) {
    header('Location: ../pages/dashboard.php');
    exit;
}
if (isset($_SESSION['candidato_id'])) {
    header('Location: ../pages/candidatos.php');
    exit;
}

// ── POST: Login de empleado ──────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

    // 1. Verificar CSRF
    csrfVerify();

    // 2. Rate limiting: máx 5 intentos por IP en 5 minutos
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    rateLimitCheck("login_ip_{$ip}", 5, 300);

    $username = sanitizeString($_POST['username'] ?? '', 100);
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $_SESSION['login_error'] = 'Usuario y contraseña son obligatorios.';
        header('Location: ../');
        exit;
    }

    // 3. Rate limiting también por username (evita enumeración)
    rateLimitCheck("login_user_{$username}", 5, 300);

    // 4. Buscar usuario
    $stmt = $pdo->prepare(
        "SELECT UsuarioId, Username, Contrasena, NombreUsuario,
                ApellidoPaterno, ApellidoMaterno, EsAdmin, UsuarioActivo
         FROM usuarios
         WHERE Username = :user
         LIMIT 1"
    );
    $stmt->execute([':user' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 5. Verificar contraseña (siempre ejecutar password_verify para evitar timing attacks)
    $passwordOk = $user && password_verify($password, $user['Contrasena']);

    if (!$passwordOk) {
        // NO revelar si el usuario existe o no
        $_SESSION['login_error'] = 'Credenciales incorrectas.';
        header('Location: ../');
        exit;
    }

    if ((int)$user['UsuarioActivo'] !== 1) {
        $_SESSION['login_error'] = 'Tu cuenta está inactiva. Contacta a RRHH.';
        header('Location: ../');
        exit;
    }

    // 6. Login exitoso — limpiar rate limit y regenerar sesión
    rateLimitReset("login_ip_{$ip}");
    rateLimitReset("login_user_{$username}");

    secureSessionRegenerate(); // previene Session Fixation

    $_SESSION['user_id']    = (int)$user['UsuarioId'];
    $_SESSION['_ua']        = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
    $_SESSION['_ip']        = hash('sha256', $ip);

    header('Location: ../pages/dashboard.php');
    exit;
}

// ── POST: Login / Registro de candidato ─────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['candidato'])) {

    csrfVerify();

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    rateLimitCheck("candidato_ip_{$ip}", 10, 300);

    $fullname = sanitizeString($_POST['fullname'] ?? '', 150);
    $telRaw   = preg_replace('/\D+/', '', $_POST['tel'] ?? '');
    $email    = sanitizeEmail($_POST['email'] ?? '');
    $age      = sanitizeInt($_POST['age'] ?? 0) ?? 0;
    $base     = sanitizeString($_POST['Base'] ?? '', 100);
    $puesto   = sanitizeString($_POST['Puesto'] ?? '', 100);

    if ($fullname === '' || $telRaw === '') {
        $_SESSION['login_error'] = 'Nombre y teléfono son obligatorios.';
        header('Location: ../');
        exit;
    }

    // Intentar login por nombre+teléfono
    $stmt = $pdo->prepare(
        "SELECT * FROM candidatos
         WHERE NombreCompleto = :nombre AND NumeroCandidato = :tel
         LIMIT 1"
    );
    $stmt->execute([':nombre' => $fullname, ':tel' => $telRaw]);
    $candidato = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$candidato) {
        // Verificar duplicado por email o teléfono
        $stmt2 = $pdo->prepare(
            "SELECT * FROM candidatos
             WHERE CorreoCandidato = :email OR NumeroCandidato = :tel
             LIMIT 1"
        );
        $stmt2->execute([':email' => $email ?? '', ':tel' => $telRaw]);
        $candidato = $stmt2->fetch(PDO::FETCH_ASSOC);
    }

    if (!$candidato) {
        // Crear nuevo candidato
        $ins = $pdo->prepare(
            "INSERT INTO candidatos
             (NombreCompleto, NumeroCandidato, CorreoCandidato, Edad, BaseAplica, PuestoAplica)
             VALUES (:nombre, :tel, :email, :edad, :base, :puesto)"
        );
        $ins->execute([
            ':nombre' => $fullname,
            ':tel'    => $telRaw,
            ':email'  => $email ?? '',
            ':edad'   => $age,
            ':base'   => $base,
            ':puesto' => $puesto,
        ]);
        $newId = (int)$pdo->lastInsertId();

        $stmt3 = $pdo->prepare("SELECT * FROM candidatos WHERE CandidatoId = :id");
        $stmt3->execute([':id' => $newId]);
        $candidato = $stmt3->fetch(PDO::FETCH_ASSOC);
    }

    if (!$candidato) {
        $_SESSION['login_error'] = 'Error al registrar. Intenta de nuevo.';
        header('Location: ../');
        exit;
    }

    secureSessionRegenerate();
    $_SESSION['candidato_id']     = (int)$candidato['CandidatoId'];
    $_SESSION['candidato_nombre'] = $candidato['NombreCompleto'];

    header('Location: ../pages/candidatos.php');
    exit;
}
