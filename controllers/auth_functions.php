<?php
declare(strict_types=1);
// controllers/auth_functions.php
// Incluye este archivo desde sign-in.php con: require_once __DIR__ . '/auth_functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Asume que ../controllers/conn.php define $pdo (PDO) y ya se incluyó en el archivo que requiere este.
// Si quieres que este archivo incluya conn.php por sí mismo, descomenta la línea siguiente y ajusta la ruta:
require_once 'conn.php';

// ---------------------- CANDIDATOS ----------------------

/**
 * Buscar candidato por correo o teléfono.
 * @param PDO $pdo
 * @param string|null $email
 * @param string|null $telefono (solo dígitos)
 * @return array|false
 */
function findCandidato(PDO $pdo, ?string $email, ?string $telefono)
{
    $email = $email ? trim($email) : null;
    $telefono = $telefono ? preg_replace('/\D+/', '', $telefono) : null;

    // Si no hay ni email ni teléfono, no buscar
    if (!$email && !$telefono) return false;

    $sqlParts = [];
    $params = [];

    if ($email) {
        $sqlParts[] = 'CorreoCandidato = :email';
        $params[':email'] = $email;
    }
    if ($telefono) {
        $sqlParts[] = 'NumeroCandidato = :tel';
        $params[':tel'] = $telefono;
    }

    $sql = 'SELECT * FROM candidatos WHERE ' . implode(' OR ', $sqlParts) . ' LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
}


/**
 * Buscar candidato por NombreCompleto + NumeroCandidato (login simple)
 * @param PDO $pdo
 * @param string $nombre
 * @param string $telefono
 * @return array|false
 */
function findCandidatoByNameTel(PDO $pdo, string $nombre, string $telefono)
{
    $sql = "SELECT * FROM candidatos WHERE NombreCompleto = :nombre AND NumeroCandidato = :tel LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => $nombre, ':tel' => $telefono]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
}

/**
 * Crear nuevo candidato.
 * @param PDO $pdo
 * @param array $data keys: fullname, tel, email, age, Base, Puesto
 * @return int|false último id insertado o false
 */
function createCandidato(PDO $pdo, array $data)
{
    $sql = "INSERT INTO candidatos (NombreCompleto, NumeroCandidato, CorreoCandidato, Edad, BaseAplica, PuestoAplica)
            VALUES (:nombre, :num, :correo, :edad, :base, :puesto)";
    $stmt = $pdo->prepare($sql);
    $ok = $stmt->execute([
        ':nombre' => $data['fullname'],
        ':num'    => $data['tel'],
        ':correo' => $data['email'] ?? '',
        ':edad'   => (int)($data['age'] ?? 0),
        ':base'   => $data['Base'] ?? '',
        ':puesto' => $data['Puesto'] ?? '',
    ]);
    return $ok ? (int)$pdo->lastInsertId() : false;
}

/**
 * Iniciar sesión de candidato e ir a ../pages/candidatos.php
 * @param array $candidato
 * @return void (redirige y exit)
 */
function loginCandidato(array $candidato)
{
    $_SESSION['candidato_id'] = (int)$candidato['CandidatoId'];
    $_SESSION['candidato_nombre'] = $candidato['NombreCompleto'];
    header('Location: ../pages/candidatos.php');
    exit;
}

// ---------------------- USUARIOS (empleados) ----------------------

/**
 * Buscar usuario por Username (texto).
 * @param PDO $pdo
 * @param string $username
 * @return array|false
 */
function findUsuario(PDO $pdo, string $username)
{
    $sql = "SELECT * FROM usuarios WHERE Username = :user LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
}

/**
 * Verificar credenciales de usuario. Password almacenada en Contrasena (hash).
 * @param PDO $pdo
 * @param string $username
 * @param string $password
 * @return array|false
 */
function verifyUsuario(PDO $pdo, string $username, string $password)
{
    $user = findUsuario($pdo, $username);
    if (!$user) return false;
    if (!isset($user['Contrasena'])) return false;
    if (password_verify($password, $user['Contrasena'])) return $user;
    return false;
}

/**
 * Iniciar sesión de empleado y redirigir a ../pages/dashboard.php
 * @param array $usuario
 * @return void (redirige y exit)
 */
function loginUsuario(array $usuario)
{
    $_SESSION['usuario_id'] = (int)$usuario['UsuarioId'];
    $_SESSION['usuario_username'] = $usuario['Username'];
    $_SESSION['usuario_nombre'] = ($usuario['NombreUsuario'] ?? '') . ' ' . ($usuario['ApellidoPaterno'] ?? '') . ' ' . ($usuario['ApellidoMaterno'] ?? '');
    $_SESSION['usuario_es_admin'] = !empty($usuario['EsAdmin']) ? 1 : 0;
    header('Location: ../pages/dashboard.php');
    exit;
}