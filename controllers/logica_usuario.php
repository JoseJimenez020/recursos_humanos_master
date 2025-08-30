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


function GetFoto($id, $pdo)
{
    $query = "SELECT FotoContenido FROM fotos WHERE EntidadTipo = 'usuario' AND EntidadId = :id";
    $result = $pdo->prepare($query);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $fetch = $result->fetch(PDO::FETCH_ASSOC);


    return ($fetch && !empty($fetch['AsesorFoto']))
        ? 'data:image/jpeg;base64,' . base64_encode($fetch['AsesorFoto'])
        : '../assets/img/small-logos/user.png';
}

function GetTableUsuarios(PDO $pdo, string $nombre, string $departamento): string
{
    $sql = "SELECT
        u.UsuarioId, u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno,
        u.Username, u.NumeroTelefono, d.DepartamentoNombre, p.PuestoNombre,
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
                        <img src="' . $src . '" class="avatar avatar-sm me-3 border-radius-lg">
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">' . $full . '</h6>
                            <p class="text-xs text-secondary mb-0">' . htmlspecialchars($u['Username']) . '</p>
                            <p class="text-xs text-secondary mb-0">' . htmlspecialchars($u['NumeroTelefono'] ?? 'No disponible') . '</p>
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

/*
function actualizarUsuario(array $post, PDO $pdo): string
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

    try {
        // 2) Iniciar transacción
        $pdo->beginTransaction();

        // 3) Actualizar tabla usuarios
        $sqlUser = "UPDATE usuarios SET
            NombreUsuario       = :nombreUsuario,
            ApellidoPaterno     = :apellidoPaterno,
            ApellidoMaterno     = :apellidoMaterno,
            Email               = :email,
            NumeroTelefono      = :numeroTelefono,
            DepartamentoId      = :departamentoId,
            PuestoId            = :puestoId
          WHERE UsuarioId = :usuarioId
        ";
        $stmt = $pdo->prepare($sqlUser);
        $stmt->execute([
            'nombreUsuario' => $nombreUsuario,
            'apellidoPaterno' => $apellidoPaterno,
            'apellidoMaterno' => $apellidoMaterno,
            'email' => $email,
            'numeroTelefono' => $numeroTelefono,
            'departamentoId' => $departamentoId,
            'puestoId' => $puestoId,
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

        // 5) Confirmar transacción
        $pdo->commit();

        return alertScript(
            '¡Éxito!',
            'Información actualizada correctamente.',
            'success',
            '../pages/usuarios.php'
        );

    } catch (PDOException $e) {
        // 6) Revertir en caso de error
        $pdo->rollBack();
        // Opcional: log($e->getMessage());
        return alertScript(
            'Error',
            'No se pudo actualizar: ' . $e->getMessage(),
            'error'
        );
    }
}
*/

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
    $tiposValidos = ['O-', 'O+', 'A+', 'A-', 'AB+', 'AB-'];
    $tipoSangre = filter_var($post['TipoSangre'], FILTER_SANITIZE_STRING);
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
            PuestoId            = :puestoId
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
