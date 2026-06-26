<?php
declare(strict_types=1);
/**
 * security.php — Capa de seguridad centralizada
 * Incluir al inicio de CADA controlador: require_once __DIR__ . '/security.php';
 */

// ─────────────────────────────────────────────
// 1. CABECERAS DE SEGURIDAD HTTP
// ─────────────────────────────────────────────
function setSecurityHeaders(): void
{
    // Evita que el navegador "adivine" el tipo MIME
    header('X-Content-Type-Options: nosniff');
    // Protección básica contra clickjacking
    header('X-Frame-Options: SAMEORIGIN');
    // Activa el filtro XSS del navegador (legado, pero útil)
    header('X-XSS-Protection: 1; mode=block');
    // No enviar el Referer a sitios externos
    header('Referrer-Policy: strict-origin-when-cross-origin');
    // Política de permisos: deshabilitar APIs que no necesitas
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    // Content Security Policy — ajusta los dominios según tu proyecto
    header(
        "Content-Security-Policy: " .
        "default-src 'self'; " .
        "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://kit.fontawesome.com https://code.jquery.com; " .
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; " .
        "font-src 'self' https://fonts.gstatic.com https://ka-f.fontawesome.com; " .
        "img-src 'self' data: https://images.unsplash.com; " .
        "connect-src 'self'; " .
        "frame-src 'none';"
    );
    // Forzar HTTPS (solo activar cuando tengas SSL configurado)
    // header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
}

// ─────────────────────────────────────────────
// 2. PROTECCIÓN CSRF
// ─────────────────────────────────────────────

/**
 * Genera (o reutiliza) el token CSRF de la sesión actual.
 */
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Devuelve el campo oculto HTML listo para insertar en formularios.
 */
function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrfToken(), ENT_QUOTES) . '">';
}

/**
 * Valida el token CSRF enviado en el POST.
 * Si falla, termina la ejecución con HTTP 403.
 */
function csrfVerify(): void
{
    $submitted = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!hash_equals(csrfToken(), $submitted)) {
        http_response_code(403);
        die(json_encode(['error' => 'CSRF token inválido. Recarga la página e intenta de nuevo.']));
    }
}

// ─────────────────────────────────────────────
// 3. RATE LIMITING (basado en archivos — sin Redis)
// ─────────────────────────────────────────────
define('RATE_LIMIT_DIR', sys_get_temp_dir() . '/rh_ratelimit/');

function rateLimitCheck(string $key, int $maxAttempts = 5, int $windowSeconds = 300): bool
{
    if (!is_dir(RATE_LIMIT_DIR)) {
        mkdir(RATE_LIMIT_DIR, 0700, true);
    }

    $file = RATE_LIMIT_DIR . md5($key) . '.json';
    $now  = time();
    $data = ['attempts' => [], 'blocked_until' => 0];

    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true) ?? $data;
    }

    // Si está bloqueado
    if ($data['blocked_until'] > $now) {
        $wait = $data['blocked_until'] - $now;
        http_response_code(429);
        die("Demasiados intentos. Espera {$wait} segundos.");
    }

    // Limpiar intentos fuera de la ventana
    $data['attempts'] = array_filter(
        $data['attempts'],
        fn($t) => ($now - $t) < $windowSeconds
    );

    $data['attempts'][] = $now;

    if (count($data['attempts']) > $maxAttempts) {
        $data['blocked_until'] = $now + $windowSeconds;
        file_put_contents($file, json_encode($data), LOCK_EX);
        http_response_code(429);
        die("Demasiados intentos. Bloqueado por {$windowSeconds} segundos.");
    }

    file_put_contents($file, json_encode($data), LOCK_EX);
    return true;
}

/**
 * Resetea el contador de un key (llamar tras login exitoso).
 */
function rateLimitReset(string $key): void
{
    $file = RATE_LIMIT_DIR . md5($key) . '.json';
    if (file_exists($file)) {
        unlink($file);
    }
}

// ─────────────────────────────────────────────
// 4. SANITIZACIÓN SEGURA (reemplaza FILTER_SANITIZE_STRING)
// ─────────────────────────────────────────────

/**
 * Limpia una cadena para uso general (no para HTML).
 * FILTER_SANITIZE_STRING está deprecated desde PHP 8.1.
 */
function sanitizeString(?string $value, int $maxLength = 500): string
{
    if ($value === null) return '';
    $value = trim($value);
    $value = strip_tags($value);          // elimina etiquetas HTML/PHP
    $value = mb_substr($value, 0, $maxLength);
    return $value;
}

/**
 * Escapa para salida en HTML.
 */
function escHtml(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Valida y sanitiza un entero. Retorna null si no es válido.
 */
function sanitizeInt($value): ?int
{
    $filtered = filter_var($value, FILTER_VALIDATE_INT);
    return ($filtered !== false) ? (int)$filtered : null;
}

/**
 * Valida email. Retorna null si no es válido.
 */
function sanitizeEmail(?string $value): ?string
{
    if ($value === null) return null;
    $email = filter_var(trim($value), FILTER_VALIDATE_EMAIL);
    return $email !== false ? $email : null;
}

// ─────────────────────────────────────────────
// 5. VALIDACIÓN DE ARCHIVOS SUBIDOS
// ─────────────────────────────────────────────

/**
 * Verifica que un archivo subido sea seguro.
 * Retorna true si es válido, lanza Exception si no.
 */
function validateUploadedFile(array $file, array $allowedMimes, array $allowedExts, int $maxBytes = 3145728): bool
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("Error en la subida del archivo (código: {$file['error']}).");
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        throw new RuntimeException("Archivo no reconocido como subida HTTP válida.");
    }
    if ($file['size'] > $maxBytes) {
        $mb = round($maxBytes / 1048576, 1);
        throw new RuntimeException("El archivo supera el tamaño máximo permitido ({$mb} MB).");
    }

    // Verificar extensión
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts, true)) {
        throw new RuntimeException("Extensión no permitida: .{$ext}");
    }

    // Verificar MIME real (no el que reporta el navegador)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $realMime = $finfo->file($file['tmp_name']);
    if (!in_array($realMime, $allowedMimes, true)) {
        throw new RuntimeException("Tipo de archivo no permitido: {$realMime}");
    }

    // Verificar que no sea un script disfrazado
    $dangerousSignatures = ['<?php', '<?=', '<script', 'eval(', 'base64_decode('];
    $content = file_get_contents($file['tmp_name'], false, null, 0, 1024);
    foreach ($dangerousSignatures as $sig) {
        if (stripos($content, $sig) !== false) {
            throw new RuntimeException("El archivo contiene contenido no permitido.");
        }
    }

    return true;
}

// ─────────────────────────────────────────────
// 6. PROTECCIÓN DE SESIÓN
// ─────────────────────────────────────────────

/**
 * Configura opciones seguras de sesión.
 * Llamar ANTES de session_start().
 */
function secureSessionConfig(): void
{
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
               || (int)($_SERVER['SERVER_PORT'] ?? 80) === 443;

    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_secure', $isHttps ? '1' : '0');  // Solo HTTPS en producción
    ini_set('session.cookie_samesite', 'Strict');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.gc_maxlifetime', '3600');

    session_set_cookie_params([
        'lifetime' => 3600,
        'path'     => '/',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
}

/**
 * Regenera el ID de sesión para prevenir Session Fixation.
 * Llamar después de un login exitoso.
 */
function secureSessionRegenerate(): void
{
    session_regenerate_id(true);
}

/**
 * Verifica que la sesión no haya sido hijacked.
 * Compara el User-Agent y la IP almacenados al hacer login.
 */
function sessionIntegrityCheck(): void
{
    $ua  = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $ip  = $_SERVER['REMOTE_ADDR'] ?? '';

    if (!isset($_SESSION['_ua'])) {
        $_SESSION['_ua'] = hash('sha256', $ua);
        $_SESSION['_ip'] = hash('sha256', $ip);
        return;
    }

    $uaMismatch = !hash_equals($_SESSION['_ua'], hash('sha256', $ua));
    // La IP puede cambiar en móvil/proxies, solo lanza alerta si AMBOS cambian
    $ipMismatch = !hash_equals($_SESSION['_ip'], hash('sha256', $ip));

    if ($uaMismatch && $ipMismatch) {
        session_unset();
        session_destroy();
        http_response_code(401);
        header('Location: /');
        exit;
    }
}

// ─────────────────────────────────────────────
// INICIALIZACIÓN AUTOMÁTICA
// ─────────────────────────────────────────────
setSecurityHeaders();
