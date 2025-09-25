<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
require_once 'conn.php';

if (!isset($_SESSION['user_id'])) {
    echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Inicia Sesion para continuar.',
                    icon: 'error'
                }).then(() => {
                    window.location.href = '../pages/sign-in.php';
                });
            });
        </script>";
}

require 'sesion.php';
require 'logout.php';

function GetTableUsuarios(PDO $pdo, string $nombre, string $departamento): string
{
    $sql = "SELECT
        u.UsuarioId, u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno,
        u.Username, u.NumeroTelefono, u.TipoSangre, d.DepartamentoNombre, p.PuestoNombre,
        ce.NombreContacto, ce.Parentezco, ce.NumeroTelefono AS CEtelefono,
        u.UsuarioActivo, u.FechaRegistro, f.FotoContenido
      FROM usuarios u
      LEFT JOIN departamento d ON u.DepartamentoId = d.DepartamentoId
      LEFT JOIN puesto p        ON u.PuestoId       = p.PuestoId
      LEFT JOIN contacto_emergencia ce ON ce.UsuarioId = u.UsuarioId
      LEFT JOIN fotos f ON f.EntidadTipo = 'usuario'
                       AND f.EntidadId   = u.UsuarioId
      WHERE 1=1
    ";

    $params = [];

    // Filtro por nombre
    if ($nombre !== '') {
        $sql .= " AND (
                        u.NombreUsuario   LIKE ? OR
                        u.ApellidoPaterno LIKE ? OR
                        u.ApellidoMaterno LIKE ? OR
                        u.Username        LIKE ?

                     )";
        // clave sin dos puntos
        $params = array_fill(0, 4, "%{$nombre}%");

    }

    // Filtro por departamento
    if ($departamento !== '') {
        $sql .= " AND u.DepartamentoId = :departamento";
        $params['departamento'] = $departamento;
    }

    $sql .= " ORDER BY u.ApellidoPaterno";

    // Preparar y ejecutar
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        return '<tr><td colspan="6" class="text-center">Sin registros</td></tr>';
    }

    $html = '';
    foreach ($rows as $u) {
        $src = $u['FotoContenido']
            ? 'data:image/jpeg;base64,' . base64_encode($u['FotoContenido'])
            : '../assets/img/small-logos/user.png';

        $full = "{$u['NombreUsuario']} {$u['ApellidoPaterno']} {$u['ApellidoMaterno']}";
        $badge = $u['UsuarioActivo']
            ? '<span class="badge bg-success">Activo</span>'
            : '<span class="badge bg-secondary">Vacaciones</span>';

        $html .= '<tr>
                    <td>
                        <div class="d-flex px-2 py-1">
                        <a href="#" class="edit-photo"
                        data-bs-toggle="modal"
                        data-bs-target="#fotoPerfilModal"
                        data-user-id="' . $u['UsuarioId'] . '"
                        data-photo-src="' . $src . '">
                        <img src="' . $src . '"
                            class="avatar avatar-sm me-3 border-radius-lg"
                            style="cursor: pointer;">
                        </a>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">' . $full . '</h6>
                            <p class="text-xs text-secondary mb-0">' . htmlspecialchars($u['Username']) . '</p>
                            <p class="text-xs text-secondary mb-0">' . htmlspecialchars($u['NumeroTelefono'] ?? 'No disponible') . '</p>
                            <p class="text-xs text-secondary mb-0">' . htmlspecialchars($u['TipoSangre'] ?? 'No disponible') . '</p>
                        </div>
                        </div>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">' . ($u['PuestoNombre'] ?? 'Sin registros') . '</p>
                        <p class="text-xs text-secondary mb-0">' . ($u['DepartamentoNombre'] ?? 'Sin registros') . '</p>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">' . ($u['NombreContacto'] ?? 'Sin registros') . '</p>
                        <p class="text-xs text-secondary mb-0">' . ($u['Parentezco'] ?? 'Sin registros') . '</p>
                        <p class="text-xs text-secondary mb-0">' . ($u['CEtelefono'] ?? 'Sin registros') . '</p>
                    </td>
                    <td class="text-center text-sm">' . $badge . '</td>
                    <td class="text-center text-xs">' . date('d/m/Y', strtotime($u['FechaRegistro'])) . '</td>
                    <td class="align-middle">
                        <a href="" class="text-secondary font-weight-bold text-xs btn-edit"
                        data-user-id="' . ($u['UsuarioId']) . '"
                        data-bs-toggle="modal" data-bs-target="#modal-edit">
                        <i class="material-symbols-rounded opacity-5">edit</i>
                        </a>
                        <a href="" class="text-danger font-weight-bold text-xs"
                        data-user-id="' . ($u['UsuarioId']) . '"';
        $full = "{$u['NombreUsuario']} {$u['ApellidoPaterno']} {$u['ApellidoMaterno']}";
        $html .= 'data-user-name="' . htmlspecialchars($full) . '"
                        data-toggle="tooltip" data-original-title="Delete user" target="_blank"
                        data-bs-toggle="modal" data-bs-target="#modal-notification">
                        <i class="material-symbols-rounded opacity-5">delete</i>
                        </a>
                        <a href="" class="text-success font-weight-bold text-xs"
                        data-user-id="' . ($u['UsuarioId']) . '"
                        data-user-name="' . htmlspecialchars($full) . '"
                        data-toggle="tooltip" data-original-title="Vacations" target="_blank"
                        data-bs-toggle="modal" data-bs-target="#modal-form">
                        <i class="material-symbols-rounded opacity-5">beach_access</i>
                        </a>
                    </td>
                    </tr>';
    }

    return $html;

}

function GetDepartamento($pdo)
{
    $query = "SELECT * FROM departamento";
    $result = $pdo->prepare($query);
    $result->execute();
    $fetch = $result->fetchAll(PDO::FETCH_ASSOC);
    return $fetch;
}
$departamentos = GetDepartamento($pdo);

function GetListaDepartamentos($departamentos)
{
    $options = '';
    foreach ($departamentos as $depto) {
        $value = htmlspecialchars($depto['DepartamentoId']); // Asegúrate de usar la clave correcta para el ID
        $label = htmlspecialchars($depto['DepartamentoNombre']); // Asegúrate de usar la clave correcta para el nombre
        $options .= "<option value=\"$value\">$label</option>\n";
    }
    return $options;
}
function GetPuestosPorDepartamento($pdo, $departamentoId)
{
    $query = "SELECT PuestoId, PuestoNombre FROM puesto WHERE DepartamentoId = :departamentoId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':departamentoId', $departamentoId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
if (isset($_GET['DepartamentoId'])) {
    header('Content-Type: application/json');
    $puestos = GetPuestosPorDepartamento($pdo, $_GET['DepartamentoId']);
    echo json_encode($puestos);
    exit;
}

function CorreoExiste($email, $pdo)
{

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE Email = :email");
    $stmt->execute(array(':email' => $email));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($user !== false);
}

function UsuarioExiste($usuario, $pdo)
{

    $usuario = filter_var($usuario, FILTER_SANITIZE_EMAIL);
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE Username = :usuario");
    $stmt->execute(array(':usuario' => $usuario));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($user !== false);
}

function RegistrarUsuarioCompleto(array $post, PDO $pdo): string
{
    // 1) Sanitizar y validar inputs
    $nombre = filter_var($post['nombre'], FILTER_SANITIZE_STRING);
    $apellidoP = filter_var($post['apellidoPaterno'], FILTER_SANITIZE_STRING);
    $apellidoM = filter_var($post['apellidoMaterno'], FILTER_SANITIZE_STRING);
    $email = filter_var($post['correo'], FILTER_VALIDATE_EMAIL);
    $fechaNac = filter_var($post['fechaNacimiento'], FILTER_SANITIZE_STRING);
    $tipoSangre = filter_var($post['tipoSangre'], FILTER_SANITIZE_STRING);
    $departamentoId = filter_var($post['DepartamentoId'], FILTER_VALIDATE_INT);
    $puestoId = filter_var($post['PuestoId'], FILTER_VALIDATE_INT);
    $base = filter_var($post['Base'], FILTER_SANITIZE_STRING);
    $celular = filter_var($post['celular'], FILTER_SANITIZE_STRING);
    $username = filter_var($post['username'], FILTER_SANITIZE_STRING);
    $password = $post['password'] ?? '';
    $esAdmin = isset($post['admin']) ? 1 : 0;
    $nombreCont = trim(filter_var($post['NombreContacto'], FILTER_SANITIZE_STRING));
    $parentesco = trim(filter_var($post['Parentezco'], FILTER_SANITIZE_STRING));
    $numEmergencia = trim(filter_var($post['NumeroEmergencia'], FILTER_SANITIZE_STRING));

    // 2) Validaciones mínimas obligatorias
    if (
        !$nombre || !$apellidoP || !$departamentoId || !$puestoId
        || !$username || !$password || !$base
    ) {
        return alertScript('Error', 'Faltan datos obligatorios.', 'error');
    }

    // 3) Duplicados: correo y usuario
    $chk = $pdo->prepare("SELECT 1 FROM usuarios WHERE Username = :u");
    $chk->execute(['u' => $username]);
    if ($chk->fetch()) {
        return alertScript('Error', 'El nombre de usuario ya está en uso.', 'error');
    }

    try {
        $pdo->beginTransaction();

        // 4.1) Insertar en usuarios (incluye Base y FechaRegistro=CURDATE())
        $sqlU = "
          INSERT INTO usuarios
            (Username, Contrasena,
             NombreUsuario, ApellidoPaterno, ApellidoMaterno,
             FechaNacimiento, TipoSangre,
             DepartamentoId, PuestoId,
             NumeroTelefono, Email,
             Base, FechaRegistro,
             EsAdmin, UsuarioActivo)
          VALUES
            (:usr, :pwd,
             :nom, :pat, :mat,
             :fn,  :ts,
             :dep, :pst,
             :cel, :e,
             :base, CURDATE(),
             :adm, 1)
        ";
        $stU = $pdo->prepare($sqlU);
        $stU->execute([
            'usr' => $username,
            'pwd' => password_hash($password, PASSWORD_DEFAULT),
            'nom' => $nombre,
            'pat' => $apellidoP,
            'mat' => $apellidoM,
            'fn' => $fechaNac,
            'ts' => $tipoSangre,
            'dep' => $departamentoId,
            'pst' => $puestoId,
            'cel' => $celular,
            'e' => $email ?: null,
            'base' => $base,
            'adm' => $esAdmin
        ]);
        $usuarioId = $pdo->lastInsertId();

        // 4.2) Insertar contacto de emergencia si al menos uno de los tres campos tiene valor
        if ($nombreCont !== '' || $parentesco !== '' || $numEmergencia !== '') {
            $sqlCE = "INSERT INTO contacto_emergencia
                (NombreContacto, Parentezco, NumeroTelefono, UsuarioId)
            VALUES
                (:nc, :par, :tel, :uid)
            ";
            $stCE = $pdo->prepare($sqlCE);
            $stCE->execute([
                'nc' => $nombreCont !== '' ? $nombreCont : null,
                'par' => $parentesco !== '' ? $parentesco : null,
                'tel' => $numEmergencia !== '' ? $numEmergencia : null,
                'uid' => $usuarioId
            ]);
        }
        $pdo->commit();

        return alertScript(
            '¡Éxito!',
            'Usuario registrado correctamente.',
            'success',
            'usuarios.php'
        );

    } catch (PDOException $e) {
        $pdo->rollBack();
        return alertScript(
            'Error',
            'No se pudo registrar: ' . $e->getMessage(),
            'error'
        );
    }
}

function alertScript(string $title, string $text, string $icon, string $redir = null): string
{
    // 1) Preparamos el objeto de opciones de Swal
    $swalOptions = [
        'title' => $title,
        'text' => $text,
        'icon' => $icon
    ];
    // 2) Codificamos a JSON para JS (escapa comillas, barras, tildes, etc.)
    $jsonOpts = json_encode($swalOptions, JSON_UNESCAPED_UNICODE);

    // 3) Si hay redirección, la añadimos como JS puro pero escapada
    $jsRedir = $redir
        ? 'window.location.href = ' . json_encode($redir, JSON_UNESCAPED_UNICODE) . ';'
        : '';

    // 4) Devolvemos un único <script> con código limpio
    return <<<HTML
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire($jsonOpts).then(function() {
      $jsRedir
    });
  });
</script>
HTML;
}

function actualizarUsuario(array $post, PDO $pdo): array
{
    $usuarioId = filter_var($post['UsuarioId'], FILTER_VALIDATE_INT);
    $nombreUsuario = filter_var($post['NombreUsuario'], FILTER_SANITIZE_STRING);
    $apellidoPaterno = filter_var($post['ApellidoPaterno'], FILTER_SANITIZE_STRING);
    $apellidoMaterno = filter_var($post['ApellidoMaterno'], FILTER_SANITIZE_STRING);
    $email = filter_var($post['Email'], FILTER_VALIDATE_EMAIL);
    $numeroTelefono = filter_var($post['NumeroTelefono'], FILTER_SANITIZE_STRING);
    $departamentoId = filter_var($post['DepartamentoId'], FILTER_VALIDATE_INT);
    $puestoId = filter_var($post['PuestoId'], FILTER_VALIDATE_INT);
    $nombreContacto = filter_var($post['NombreContacto'], FILTER_SANITIZE_STRING);
    $parentezco = filter_var($post['Parentezco'], FILTER_SANITIZE_STRING);
    $numeroEmergencia = filter_var($post['NumeroEmergencia'], FILTER_SANITIZE_STRING);
    $tiposValidos = ['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];
    $tipoSangre = filter_var($post['TipoSangre'], FILTER_SANITIZE_STRING);
    $esAdmin = !empty($post['EsAdmin']) ? 1 : 0;
    if (!in_array($tipoSangre, $tiposValidos, true)) {
        throw new Exception('Tipo de sangre inválido.');
    }
    // 2) Iniciar transacción
    $pdo->beginTransaction();

    // 3) Actualizar tabla usuarios
    $sqlUser = "UPDATE usuarios SET
            NombreUsuario       = :nombreUsuario,
            ApellidoPaterno     = :apellidoPaterno,
            ApellidoMaterno     = :apellidoMaterno,
            Email               = :email,
            TipoSangre          = :tipoSangre,
            NumeroTelefono      = :numeroTelefono,
            DepartamentoId      = :departamentoId,
            PuestoId            = :puestoId,
            EsAdmin             = :esAdmin
          WHERE UsuarioId = :usuarioId
        ";
    $stmt = $pdo->prepare($sqlUser);
    $stmt->execute([
        'nombreUsuario' => $nombreUsuario,
        'apellidoPaterno' => $apellidoPaterno,
        'apellidoMaterno' => $apellidoMaterno,
        'email' => $email,
        'tipoSangre' => $tipoSangre,
        'numeroTelefono' => $numeroTelefono,
        'departamentoId' => $departamentoId,
        'puestoId' => $puestoId,
        'esAdmin' => $esAdmin,
        'usuarioId' => $usuarioId
    ]);

    // 4) Verificar si ya existe un contacto de emergencia
    $chk = $pdo->prepare(
        "SELECT ContactoId 
             FROM contacto_emergencia 
            WHERE UsuarioId = :usuarioId"
    );
    $chk->execute(['usuarioId' => $usuarioId]);
    $existe = (bool) $chk->fetchColumn();

    if ($existe) {
        // 4a) Actualizar contacto existente
        $sqlCE = "UPDATE contacto_emergencia SET
                NombreContacto = :nombreContacto,
                Parentezco     = :parentezco,
                NumeroTelefono = :numeroEmergencia
              WHERE UsuarioId = :usuarioId
            ";
    } else {
        // 4b) Insertar nuevo contacto
        $sqlCE = "INSERT INTO contacto_emergencia
                (NombreContacto, Parentezco, NumeroTelefono, UsuarioId)
              VALUES
                (:nombreContacto, :parentezco, :numeroEmergencia, :usuarioId)
            ";
    }
    $stmt = $pdo->prepare($sqlCE);
    $stmt->execute([
        'nombreContacto' => $nombreContacto,
        'parentezco' => $parentezco,
        'numeroEmergencia' => $numeroEmergencia,
        'usuarioId' => $usuarioId
    ]);

    try {
        $pdo->commit();
        return [
            'success' => true,
            'message' => 'Información actualizada correctamente.'
        ];
    } catch (PDOException $e) {
        $pdo->rollBack();
        return [
            'success' => false,
            'message' => 'No se pudo actualizar: ' . $e->getMessage()
        ];
    }
}

function eliminarUsuario(PDO $pdo, int $userId): array
{
    try {
        $sql = "DELETE FROM usuarios WHERE UsuarioId = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $userId]);

        // Si quisieras saber cuántas filas afectó:
        // $deleted = $stmt->rowCount();

        return [
            'success' => true,
            'message' => null
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

/**
 * Inserta o actualiza la foto de perfil de un usuario.
 *
 * @param resource $fotoContenido Contenido binario de la imagen
 * @param int      $usuarioId     ID del usuario
 * @param PDO      $pdo           Conexión PDO
 * @return bool                   Verdadero si la operación fue exitosa
 */
function updateUsuarioFoto($fotoContenido, $usuarioId, $pdo)
{
    // 1. Buscamos si ya hay una foto asociada
    $sql = "
        SELECT FotoId
          FROM fotos
         WHERE EntidadTipo = 'usuario'
           AND EntidadId    = :id
        LIMIT 1
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $usuarioId]);

    // 2. Si existe, actualizamos; si no, insertamos
    if ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sql2 = "
            UPDATE fotos
               SET FotoContenido = :foto
             WHERE FotoId        = :fotoId
        ";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':foto', $fotoContenido, PDO::PARAM_LOB);
        $stmt2->bindParam(':fotoId', $fila['FotoId'], PDO::PARAM_INT);
        return $stmt2->execute();
    } else {
        $sql2 = "
            INSERT INTO fotos (FotoContenido, EntidadTipo, EntidadId)
            VALUES (:foto, 'usuario', :id)
        ";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':foto', $fotoContenido, PDO::PARAM_LOB);
        $stmt2->bindParam(':id', $usuarioId, PDO::PARAM_INT);
        return $stmt2->execute();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardarFoto'])) {
    // Validación subida
    if (
        isset($_FILES['foto']) &&
        $_FILES['foto']['error'] === UPLOAD_ERR_OK &&
        $_FILES['foto']['size'] <= 3_048_576   // 1 MB
    ) {
        // Leemos el binario
        $fotoBinaria = file_get_contents($_FILES['foto']['tmp_name']);
        $usuarioId = (int) $_POST['UsuarioId'];

        // Ejecutamos inserción/actualización
        if (updateUsuarioFoto($fotoBinaria, $usuarioId, $pdo)) {
            echo "
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Éxito!',
                    text:  'Foto actualizada correctamente.',
                    icon:  'success'
                }).then(function() {
                    // recarga toda la página para refrescar la imagen
                    window.location.href = window.location.pathname;
                });
            });
            </script>
            ";
        } else {
            // Error en la BD
            echo "
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('Error', 'No se pudo guardar la foto.', 'error');
            });
            </script>
            ";
        }
    } else {
        // Error en la subida
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire('Error', 'Asegúrate de subir un JPEG/jpg menor a 1 MB.', 'error');
        });
        </script>
        ";
    }
}


function ActualizarPassword($password1, $password2, $UsuarioId, $pdo)
{

    $password1 = filter_var($password1, FILTER_SANITIZE_STRING);
    $password2 = filter_var($password2, FILTER_SANITIZE_STRING);

    if ($password1 !== $password2) {
        $error = "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Las contraseñas no coinciden.',
                        icon: 'error'
                    }).then(() => {
                    window.location.href = '';
                });
            });
            </script>";
        return $error;
    }

    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);


    try {
        // Inserción principal
        $stmt = $pdo->prepare("UPDATE usuarios SET 
            Contrasena = :password
        WHERE UsuarioId = :id");

        $stmt->execute([
            ':password' => $hashed_password,
            ':id' => $UsuarioId
        ]);

        $exito = "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Contraseña actualizada exitosamente.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = '';
                    });
                });
            </script>";

        return $exito;

    } catch (PDOException $e) {
        echo "Error al actualizar los datos: " . $e->getMessage();
        $error = "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrio un error inesperado.',
                        icon: 'error'
                    }).then(() => {
                    window.location.href = '';
                });
            });
            </script>";
        return $error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizarPass'])) {
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    echo ActualizarPassword($password1, $password2, $_SESSION['user_id'], $pdo);

}

function RegistrarVacaciones(array $post, PDO $pdo): string
{
    // 1) Sanitizar fechas
    $usuarioId = filter_var($post['usuarioId'], FILTER_VALIDATE_INT);
    $fechaInicio = trim(strip_tags($post['fechaInicio']));
    $fechaFin = trim(strip_tags($post['fechaFin']));

    if (strtotime($fechaFin) <= strtotime($fechaInicio)) {
        return alertScript('Error', 'La fecha de regreso debe ser mayor.', 'error');
    }

    try {
        $pdo->beginTransaction();

        // 2) Insertar en vacaciones
        $stmt = $pdo->prepare(
            "INSERT INTO vacaciones (FechaInicio, FechaFin, UsuarioId)
           VALUES (:ini, :fin, :usrid)"
        );
        $stmt->execute([
            'ini' => $fechaInicio,
            'fin' => $fechaFin,
            'usrid' => $usuarioId
        ]);

        // 3) Marcar al usuario como inactivo
        $upd = $pdo->prepare(
            "UPDATE usuarios
              SET UsuarioActivo = 0
            WHERE UsuarioId     = :usrid"
        );
        $upd->execute(['usrid' => $usuarioId]);

        $pdo->commit();

        return alertScript(
            '¡Éxito!',
            'Vacaciones registradas y usuario desactivado correctamente.',
            'success',
            'usuarios.php'
        );

    } catch (PDOException $e) {
        $pdo->rollBack();
        return alertScript(
            'Error',
            'No se pudo registrar: ' . $e->getMessage(),
            'error'
        );
    }
}

function InsertDocumentacion($nombreDocumento, $contenidoArchivo, $departamentoId, PDO $pdo)
{
    try {
        // Iniciamos transacción para garantizar atomicidad
        $pdo->beginTransaction();

        // 1. Insertar en tabla documentos
        $sqlDoc = "
            INSERT INTO documentos (NombreDocumento, DocumentoContenido)
            VALUES (:nombre, :contenido)
        ";
        $stmtDoc = $pdo->prepare($sqlDoc);
        $stmtDoc->bindParam(':nombre', $nombreDocumento, PDO::PARAM_STR);
        $stmtDoc->bindParam(':contenido', $contenidoArchivo, PDO::PARAM_LOB);
        $stmtDoc->execute();

        // Recuperamos el ID recién insertado
        $documentoId = $pdo->lastInsertId();

        // 2. Insertar en tabla manuales con fecha de PHP
        $fechaHoy = date('Y-m-d');
        $sqlMan = "
            INSERT INTO manuales (DepartamentoId, DocumentoId, FechaModificacion)
            VALUES (:depId, :docId, :fecha)
        ";
        $stmtMan = $pdo->prepare($sqlMan);
        $stmtMan->bindParam(':depId', $departamentoId, PDO::PARAM_INT);
        $stmtMan->bindParam(':docId', $documentoId, PDO::PARAM_INT);
        $stmtMan->bindParam(':fecha', $fechaHoy, PDO::PARAM_STR);
        $stmtMan->execute();

        // Confirmamos cambios
        $pdo->commit();
        return true;

    } catch (PDOException $e) {
        // Deshacemos si hay error
        $pdo->rollBack();
        error_log('Error en al subir documentación: ' . $e->getMessage());
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardarDocumentos'])) {
    $nombreDocumento = trim($_POST['nombreDocumento']);
    $departamentoId = (int) $_POST['DepartamentoId'];

    if (empty($nombreDocumento) || $departamentoId <= 0) {
        echo "<script>Swal.fire('Error', 'Faltan datos obligatorios.', 'error');</script>";
        exit;
    }

    if (
        isset($_FILES['archivo']) &&
        $_FILES['archivo']['error'] === UPLOAD_ERR_OK
    ) {
        $fileTmp = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $size = $_FILES['archivo']['size'];
        $mimeType = mime_content_type($fileTmp);
        $blob = file_get_contents($fileTmp);

        $allowedExt = ['pdf'];
        $maxSize = 5 * 1024 * 1024;  // 5MB

        if (!in_array($ext, $allowedExt)) {
            echo "<script>Swal.fire('Error', 'Sólo se permiten PDFs.', 'error');</script>";
        } elseif ($size > $maxSize) {
            echo "<script>Swal.fire('Error', 'El archivo supera 5MB.', 'error');</script>";
        } else {
            if (InsertDocumentacion($nombreDocumento, $blob, $departamentoId, $pdo)) {
                echo "
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire('¡Éxito!','Documento guardado.','success')
                      .then(() => window.location.href='manuales.php');
                  });
                </script>";
            } else {
                echo "<script>Swal.fire('Error','No se pudo guardar el documento.','error');</script>";
            }
        }
    } else {
        echo "<script>Swal.fire('Error','No se seleccionó archivo.','error');</script>";
    }
}
/**
 * Devuelve las filas HTML de la tabla de manuales
 * para un departamento dado.
 *
 * @param PDO   $pdo             Conexión PDO
 * @param int   $departamentoId  ID del departamento
 * @return string                HTML de las filas (<tr>…</tr>)
 */
function GetTableManuales(
    PDO $pdo,
    int $departamentoId,
    bool $isAdmin,
    string $filterName = '',
    string $filterDept = ''
): string {
    $sql = "
      SELECT
        m.ManualId,
        doc.NombreDocumento,
        d.DepartamentoNombre,
        m.FechaModificacion
      FROM manuales m
      JOIN documentos doc ON m.DocumentoId   = doc.DocumentoId
      JOIN departamento d ON m.DepartamentoId = d.DepartamentoId
      WHERE 1=1
    ";
    $params = [];

    // Si no es admin, forzamos filtro por su departamento
    if (!$isAdmin) {
        $sql .= " AND m.DepartamentoId = ? ";
        $params[] = $departamentoId;
    }

    // Filtro de nombre (solo admin)
    if ($isAdmin && $filterName !== '') {
        $sql .= " AND doc.NombreDocumento LIKE ? ";
        $params[] = "%{$filterName}%";
    }

    // Filtro de departamento (solo admin)
    if ($isAdmin && $filterDept !== '') {
        $sql .= " AND m.DepartamentoId = ? ";
        $params[] = $filterDept;
    }

    $sql .= " ORDER BY m.FechaModificacion DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        return '<tr><td colspan="5" class="text-center">No hay manuales disponibles</td></tr>';
    }

    // Construir filas
    $html = '';
    foreach ($rows as $m) {
        $viewUrl = "../controllers/ver_manual.php?id={$m['ManualId']}";
        $titulo = htmlspecialchars($m['NombreDocumento'], ENT_QUOTES);
        $departName = htmlspecialchars($m['DepartamentoNombre'], ENT_QUOTES);
        $fecha = date('d/m/Y', strtotime($m['FechaModificacion']));

        $html .= "<tr>
                    <td>
                      <div class=\"d-flex px-2 py-1\">
                        <img src=\"../assets/img/icons/pdf-logo.png\"
                             class=\"avatar avatar-sm me-3 border-radius-lg\" alt=\"pdf\">
                        <div class=\"d-flex flex-column justify-content-center\">
                          <h6 class=\"mb-0 text-sm\">{$titulo}</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class=\"text-xs font-weight-bold mb-0\">{$departName}</p>
                    </td>
                    <td class=\"text-center text-sm\">
                      <form method=\"POST\" style=\"display:inline\">
                        <input type=\"hidden\" name=\"manualId\" value=\"{$m['ManualId']}\">
                        <button type=\"submit\" name=\"download\"
                                class=\"badge bg-gradient-success\">
                          <i class=\"fas fa-download d-block\"></i> Descargar
                        </button>
                      </form>
                      <span class=\"badge bg-gradient-secondary\"
                            style=\"cursor:pointer\"
                            onclick=\"verPDFSweetAlert('{$viewUrl}')\">
                        Ver
                      </span>
                    </td>
                    <td class=\"align-middle text-center text-xs\">{$fecha}</td>";

        // Añadir botón delete solo si es admin
        if ($isAdmin) {
            $html .= "<td class=\"align-middle text-center\">
                        <a href=\"#\" class=\"btn btn-link text-danger border-0 btn-delete-manual\"
                           data-manual-id=\"{$m['ManualId']}\"
                           data-manual-name=\"{$titulo}\"
                           data-bs-toggle=\"modal\"
                           data-bs-target=\"#modal-notification\">
                          <i class=\"material-symbols-rounded text-lg\">delete</i>
                        </a>
                      </td>";
        }

        $html .= "</tr>";
    }

    return $html;
}

/**
 * Descarga el PDF asociado a un manual.
 *
 * @param int $manualId  ID de la tabla manuales
 * @param PDO $pdo       Conexión PDO
 */
function DescargarDocumento(int $manualId, PDO $pdo)
{
    // 1) Consultar contenido y nombre desde manuales → documentos
    $sql = "
        SELECT
            doc.DocumentoContenido   AS contenido,
            doc.NombreDocumento      AS nombre
        FROM manuales m
        JOIN documentos doc
            ON m.DocumentoId = doc.DocumentoId
        WHERE m.ManualId = :id
        LIMIT 1
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $manualId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2) Si no existe, inyectar SweetAlert y regresar
    if (!$row) {
        echo "
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se encontró el manual solicitado.'
            });
          });
        </script>";
        return;
    }

    // 3) Preparar descarga
    $contenido = $row['contenido'];
    $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $row['nombre']) . '.pdf';
    $mimeType = 'application/pdf';
    $length = strlen($contenido);

    // 4) Enviar headers y contenido
    header("Content-Type: $mimeType");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: $length");

    echo $contenido;
    exit;
}

function mostrarContador($pdo): string
{
    $sql = "SELECT COUNT(*) FROM `vacantes` WHERE `Status` = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $contador = $stmt->fetchColumn(); // Obtiene directamente el número

    $html = '<a class="btn btn-outline-primary w-100" href="../pages/vacantes.php" type="button">
                <span class="nav-link-text ms-1">Activas</span>
                <i class="material-symbols-rounded opacity-5">groups</i>
                <span id="contador_vacantes">' . $contador . '</span>
                <i class="material-symbols-rounded opacity-5">keyboard_arrow_down</i>
            </a>';

    return $html;
}

function GetUsuariosPorDepartamento($pdo, $departamentoId)
{
    $query = "SELECT UsuarioId, CONCAT(NombreUsuario, ' ', ApellidoPaterno, ' ', ApellidoMaterno) AS NombreCompleto FROM usuarios WHERE DepartamentoId = :departamentoId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':departamentoId', $departamentoId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
if (isset($_GET['DepartamentoUsuId'])) {
    header('Content-Type: application/json');
    $puestos = GetUsuariosPorDepartamento($pdo, $_GET['DepartamentoUsuId']);
    echo json_encode($puestos);
    exit;
}

function RegistrarFelicitacion(array $post, PDO $pdo): string
{
    $usuarioId = filter_var($post['UsuarioId'], FILTER_VALIDATE_INT);
    $mensaje = filter_var($post['MensajeFelicitacion'], FILTER_SANITIZE_STRING);

    if (
        !$usuarioId || !$mensaje
    ) {
        return alertScript('Error', 'Faltan datos obligatorios.', 'error');
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare(
            "INSERT INTO felicitaciones (UsuarioId, MensajeFelicitacion)
            VALUES (:usid, :msj)"
        );
        $stmt->execute([
            ':usid' => $usuarioId,
            ':msj' => $mensaje
        ]);
        $pdo->commit();

        return alertScript(
            '¡Éxito!',
            'Mensaje registrado correctamente.',
            'success'
        );

    } catch (PDOException $e) {
        $pdo->rollBack();
        return alertScript(
            'Error',
            'No se pudo registrar: ' . $e->getMessage(),
            'error'
        );
    }

}

function getPanelFelicitaciones(PDO $pdo): string
{
    $sql = "SELECT u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno, 
                   f.FelicitacionId, f.MensajeFelicitacion, foto.FotoContenido
            FROM felicitaciones f
            LEFT JOIN usuarios u ON u.UsuarioId = f.UsuarioId
            LEFT JOIN fotos foto ON foto.EntidadTipo = 'usuario'
                                 AND foto.EntidadId   = u.UsuarioId
            WHERE 1=1";
    $params = [];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        return '<li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column">
                        <h6 class="mb-3 text-sm">Sin resultados</h6>
                        <span class="mb-2 text-xs">
                            No hay felicitaciones hechas por el momento
                        </span>
                    </div>
                </li>';
    }

    $html = '';
    foreach ($rows as $fe) {
        $src = $fe['FotoContenido']
            ? 'data:image/jpeg;base64,' . base64_encode($fe['FotoContenido'])
            : '../assets/img/small-logos/user.png';

        $full = "{$fe['NombreUsuario']} {$fe['ApellidoPaterno']} {$fe['ApellidoMaterno']}";
        $html .= '<li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
    <div class="me-3">
        <img src="' . $src . '" alt="usuario" class="avatar-sm2">
    </div>
    <div class="d-flex flex-column">
        <h6 class="mb-3 text-sm">' . $full . '</h6>
        <span class="mb-2 text-xs">Mensaje de felicitación: <span class="text-dark font-weight-bold ms-sm-2">' . $fe['MensajeFelicitacion'] . '
            </span></span>
    </div>
    <div class="ms-auto text-end">
        <a class="btn btn-link text-danger text-gradient px-3 mb-0 btn-delete-felic" 
        data-fe-id="' . $fe['FelicitacionId'] . '"
        data-nombre="' . $full . '"
        href="javascript:;" target="_blank"
            data-bs-toggle="modal" data-bs-target="#modal-notification"><i
                class="material-symbols-rounded text-sm me-2">delete</i>Borrar</a>
        
        <a class="btn btn-link text-dark px-3 mb-0" 
        data-felicitacion-id="' . $fe['FelicitacionId'] . '"
        data-contenido="' . $fe['MensajeFelicitacion'] . '"
        href="javascript:;" target="_blank" data-bs-toggle="modal"
            data-bs-target="#modal-edit"><i class="material-symbols-rounded text-sm me-2">edit</i>Editar</a>
    </div>
</li>';
    }
    return $html;


}

function borrarFelicitacion(array $post, PDO $pdo): string
{
    $feliId = filter_var($post['FelicitacionId'] ?? null, FILTER_VALIDATE_INT);

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("DELETE FROM felicitaciones WHERE FelicitacionId = :id");
        $stmt->execute([':id' => $feliId]);

        $pdo->commit();

        return alertScript(
            '¡Éxito!',
            'Mensaje eliminado correctamente.',
            'success'
        );

    } catch (PDOException $e) {
        $pdo->rollBack();
        return alertScript(
            'Error',
            'No se pudo eliminar: ' . $e->getMessage(),
            'error'
        );
    }
}

function editarFelicitacion(array $post, PDO $pdo): string
{
    $feliId = filter_var($post['feliId'] ?? null, FILTER_VALIDATE_INT);
    $mensaje = filter_var($post['mensajeFeli'] ?? '', FILTER_SANITIZE_STRING);

    try {
        $pdo->beginTransaction();
        $sql = "UPDATE felicitaciones 
              SET MensajeFelicitacion = :msj
              WHERE FelicitacionId = :idf";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':msj' => $mensaje,
            ':idf' => $feliId,
        ]);

        $pdo->commit();

        return alertScript(
            '¡Éxito!',
            'Información actualizada correctamente.',
            'success'
        );

    } catch (PDOException $e) {
        $pdo->rollBack();
        return alertScript(
            'Error',
            'No se pudo actualizar la información: ' . $e->getMessage(),
            'error'
        );
    }
}
function getAvisosDash(PDO $pdo): string
{
    $sql = "SELECT 
        a.AvisoId, a.TituloAviso, a.Fecha, a.DescripcionAviso, 
        a.EsCampana, f.FotoContenido, u.NombreUsuario, u.ApellidoPaterno
        FROM avisos a
        LEFT JOIN usuarios u ON u.UsuarioId = a.UsuarioId
        LEFT JOIN fotos f ON f.EntidadTipo = 'aviso'
                         AND f.EntidadId = a.AvisoId
        WHERE EsCampana = 0";

    $params = [];

    // Preparar y ejecutar
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        return '<div class="col-md-4 mb-4">
          <div class="card" data-animation="false">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                  <a class="d-block blur-shadow-image">
                  </a>
              </div>
              <div class="card-body text-center">
                  <h5 class="font-weight-normal mt-3">
                      <a href="">Sin registros</a>
                  </h5>
                  <p class="mb-0">Por el momento no hay información disponible
                  </p>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer d-flex">
              </div>
          </div>
      </div>';
    }

    $html = '';
    foreach ($rows as $a) {
        $src = $a['FotoContenido']
            ? 'data:image/jpeg;base64,' . base64_encode($a['FotoContenido'])
            : '../assets/img/small-logos/alerta.png';
        $full = "{$a['NombreUsuario']} {$a['ApellidoPaterno']}";

        // truncate to 152 chars
        $desc = strip_tags($a['DescripcionAviso']);
        if (mb_strlen($desc) > 150) {
            $desc = mb_substr($desc, 0, 150) . '…';
        }

        $html .= '<div class="card" data-animation="true">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <a class="d-block blur-shadow-image">
            <img src="' . $src . '"
                alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
        </a>
        <div class="colored-shadow"
            style="background-image: url(&quot;' . $src . '&quot;);">
        </div>
    </div>
    <div class="card-body text-center">
        <div class="d-flex mt-n6 mx-auto">
            <a class="btn btn-link text-primary ms-auto border-0" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="">
            </a>
            <button class="btn btn-link text-info me-auto border-0" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="">
            </button>
        </div>
        <h5 class="font-weight-normal mt-3">
            <a href="javascript:;">' . $a['TituloAviso'] . '</a>
        </h5>
        <p class="mb-0">
            ' . $desc . '
        </p>
    </div>
    <hr class="dark horizontal my-0">
    <div class="card-footer d-flex">
        <p class="font-weight-normal my-auto">' . date('d/m/Y', strtotime($a['Fecha'])) . '</p>
        <i class="material-symbols-rounded position-relative ms-auto text-lg me-1 my-auto">person</i>
        <p class="text-sm my-auto">' . $full . '</p>
    </div>
</div>';
    }
    return $html;
}