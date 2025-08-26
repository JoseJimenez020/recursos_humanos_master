<?php
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

function GetTableUsuarios(PDO $pdo): string
{
    $sql = "
      SELECT 
        u.UsuarioId,
        u.NombreUsuario,
        u.ApellidoPaterno,
        u.ApellidoMaterno,
        u.Email,
        u.NumeroTelefono,
        d.DepartamentoNombre,
        p.PuestoNombre,
        ce.NombreContacto,
        ce.Parentezco,
        ce.NumeroTelefono AS CEtelefono,
        u.UsuarioActivo,
        u.FechaRegistro,
        f.FotoContenido
      FROM usuarios u
      LEFT JOIN departamento d 
        ON u.DepartamentoId = d.DepartamentoId
      LEFT JOIN puesto p 
        ON u.PuestoId = p.PuestoId
      LEFT JOIN contacto_emergencia ce 
        ON ce.UsuarioId = u.UsuarioId
      LEFT JOIN fotos f 
        ON f.EntidadTipo = 'usuario' 
       AND f.EntidadId   = u.UsuarioId
      ORDER BY u.ApellidoPaterno;
    ";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        return '<tr><td colspan="6" class="text-center">Sin registros</td></tr>';
    }

    $html = '';
    foreach ($rows as $u) {
        // Foto de perfil (si no existe, imagen por defecto)
        $src = $u['FotoContenido']
            ? 'data:image/jpeg;base64,' . base64_encode($u['FotoContenido'])
            : '../assets/img/small-logos/user.png';

        // Nombre completo
        $full = "{$u['NombreUsuario']} {$u['ApellidoPaterno']} {$u['ApellidoMaterno']}";

        // Estado: Activo vs Vacaciones
        $badge = $u['UsuarioActivo']
            ? '<span class="badge badge-sm bg-gradient-success">Activo</span>'
            : '<span class="badge badge-sm bg-gradient-secondary">Vacaciones</span>';

        // Componer fila
        $html .= '<tr>
  <td>
    <div class="d-flex px-2 py-1">
      <div><img src="' . $src . '" class="avatar avatar-sm me-3 border-radius-lg"></div>
      <div class="d-flex flex-column justify-content-center">
        <h6 class="mb-0 text-sm">' . $full . '</h6>
        <p class="text-xs text-secondary mb-0">' . htmlspecialchars($u['Email']) . '</p>
        <p class="text-xs text-secondary mb-0">' . htmlspecialchars($u['NumeroTelefono']) . '</p>
      </div>
    </div>
  </td>
  <td>
    <p class="text-xs font-weight-bold mb-0">' . ($u['PuestoNombre'] ?? 'Sin registros') . '</p>
    <p class="text-xs text-secondary mb-0">' . ($u['DepartamentoNombre'] ?? 'Sin registros') . '</p>
  </td>
  <td>
    <p class="text-xs font-weight-bold mb-0">' . ($u['NombreContacto'] ?? 'Sin registros') . '</p>
    <p class="text-xs text-secondary mb-0">' . ($u['Parentezco'] ?? '') . '</p>
    <p class="text-xs text-secondary mb-0">' . ($u['CEtelefono'] ?? '') . '</p>
  </td>
  <td class="align-middle text-center text-sm">' . $badge . '</td>
  <td class="align-middle text-center">
    <span class="text-secondary text-xs font-weight-bold">' . date('d/m/Y', strtotime($u['FechaRegistro'])) . '</span>
  </td>
  <td class="align-middle">
    <td class="align-middle">
                                            <a href=""
                                            class="text-secondary font-weight-bold text-xs btn-edit"
                                            data-user-id="' . ($u['UsuarioId']) . '"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-edit">
                                            <i class="material-symbols-rounded opacity-5">edit</i>
                                            </a>
                                            <a href="" class="text-danger font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Delete user" target="_blank"
                                                data-bs-toggle="modal" data-bs-target="#modal-notification">
                                                <i class="material-symbols-rounded opacity-5">delete</i>
                                            </a>
                                            <a href="" class="text-success font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Vacations" target="_blank"
                                                data-bs-toggle="modal" data-bs-target="#modal-form">
                                                <i class="material-symbols-rounded opacity-5">beach_access</i>
                                            </a>
                                        </td>
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

function RegistrarUsuarioCompleto(array $post, array $file, PDO $pdo): string
{
    // 1. Sanitizar y validar
    $nombre = strtoupper(filter_var($post['nombre'], FILTER_SANITIZE_STRING));
    $apellidoP = strtoupper(filter_var($post['apellidoPaterno'], FILTER_SANITIZE_STRING));
    $apellidoM = strtoupper(filter_var($post['apellidoMaterno'], FILTER_SANITIZE_STRING));
    $email = filter_var($post['correo'], FILTER_VALIDATE_EMAIL);
    $fechaNac = filter_var($post['fechaNacimiento'], FILTER_SANITIZE_STRING);
    $tipoSangre = filter_var($post['tipoSangre'], FILTER_SANITIZE_STRING);
    $depId = filter_var($post['DepartamentoId'], FILTER_VALIDATE_INT);
    $puestoId = filter_var($post['PuestoId'], FILTER_VALIDATE_INT);
    $base = filter_var($post['Base'], FILTER_SANITIZE_STRING);
    $username = filter_var($post['username'], FILTER_SANITIZE_STRING);
    $password = $post['password'];
    $esAdmin = isset($post['admin']) ? 1 : 0;
    $nombreCont = strtoupper(filter_var($post['NombreContacto'], FILTER_SANITIZE_STRING));
    $parentesco = strtoupper(filter_var($post['Parentesco'], FILTER_SANITIZE_STRING));
    $numEmergencia = filter_var($post['NumeroEmergencia'], FILTER_SANITIZE_STRING);

    // 2. Verificar duplicados
    if (CorreoExiste($email, $pdo)) {
        return alertScript('Error', 'Ya hay un usuario registrado con este correo', 'error');
    }
    if (UsuarioExiste($username, $pdo)) {
        return alertScript('Error', 'Nombre de usuario ya existe', 'error');
    }

    // 3. Manejo de la foto
    if (empty($file['fotoPerfil']) || $file['fotoPerfil']['error'] !== UPLOAD_ERR_OK) {
        return alertScript('Error', 'Error al cargar la foto', 'error');
    }
    if ($file['fotoPerfil']['size'] > 1_048_576) {
        return alertScript('Error', 'La foto excede 1 MB', 'error');
    }
    $mime = mime_content_type($file['fotoPerfil']['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/jpg', 'image/png'], true)) {
        return alertScript('Error', 'Formato de foto no válido', 'error');
    }
    $fotoBin = file_get_contents($file['fotoPerfil']['tmp_name']);

    // 4. Transacción: usuarios + contacto + fotos
    try {
        $pdo->beginTransaction();

        // 4.1 Insertar usuario
        $sqlUser = "
          INSERT INTO usuarios 
                   (Username, Contrasena, NombreUsuario, ApellidoPaterno, ApellidoMaterno,
                    FechaNacimiento, TipoSangre, DepartamentoId, PuestoId,
                    NumeroTelefono, TelefonoAlternativo, Email, EsAdmin, Base, UsuarioActivo)
            VALUES (:user, :pass, :nom, :pat, :mat, :fn, :ts, :dep, :puesto,
                    :tel, :alt, :email, :admin, :base, 1, CURDATE())";
        $stmt = $pdo->prepare($sqlUser);
        $stmt->execute([
            ':user' => $username,
            ':pass' => password_hash($password, PASSWORD_DEFAULT),
            ':nom' => $nombre,
            ':pat' => $apellidoP,
            ':mat' => $apellidoM,
            ':fn' => $fechaNac,
            ':ts' => $tipoSangre,
            ':dep' => $depId,
            ':puesto' => $puestoId,
            ':tel' => $post['celular'],
            ':alt' => $post['telefonoAlternativo'],
            ':email' => $email,
            ':admin' => $esAdmin,
            ':base' => $base,
        ]);
        $usuarioId = $pdo->lastInsertId();

        // 4.2 Insertar contacto de emergencia
        $sqlCE = "
          INSERT INTO contacto_emergencia
                   (NombreContacto, Parentezco, NumeroTelefono, UsuarioId)
            VALUES (:nContact, :parent, :num, :uid)";
        $stmt = $pdo->prepare($sqlCE);
        $stmt->execute([
            ':nContact' => $nombreCont,
            ':parent' => $parentesco,
            ':num' => $numEmergencia,
            ':uid' => $usuarioId,
        ]);

        // 4.3 Insertar foto de perfil en tabla fotos
        $sqlFoto = "INSERT INTO fotos 
        (FotoContenido, EntidadTipo, EntidadId)
        VALUES 
        (:blob, 'usuario', :uid)";
        $stmt = $pdo->prepare($sqlFoto);

        // Vinculas ambos parámetros
        $stmt->bindParam(':blob', $fotoBin, PDO::PARAM_LOB);
        $stmt->bindParam(':uid', $usuarioId, PDO::PARAM_INT);

        // Ejecutas sin pasar array
        $stmt->execute();

        $pdo->commit();
        return alertScript(
            '¡Éxito!',
            'Usuario registrado exitosamente',
            'success',
            'usuarios.php'
        );

    } catch (PDOException $e) {
        $pdo->rollBack();
        // Aquí podrías loguear 
        $e->getMessage();
        return alertScript('Error', 'Ocurrió un fallo al guardar' . $e . ' ', 'error');
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

/*function actualizarUsuario(array $post, PDO $pdo): string
{
    $usuarioId = filter_var($post['UsuarioId'], FILTER_VALIDATE_INT);
    $nombreUsuario = strtoupper(filter_var($post['NombreUsuario'], FILTER_SANITIZE_STRING));
    $apellidoPaterno = strtoupper(filter_var($post['ApellidoPaterno'], FILTER_SANITIZE_STRING));
    $apellidoMaterno = strtoupper(filter_var($post['ApellidoMaterno'], FILTER_SANITIZE_STRING));
    $email = filter_var($post['Email'], FILTER_VALIDATE_EMAIL);
    $numeroTelefono = filter_var($post['NumeroTelefono'], FILTER_SANITIZE_STRING);
    $telefonoAlternativo = filter_var($post['TelefonoAlternativo'], FILTER_SANITIZE_STRING);
    $departamentoId = filter_var($post['DepartamentoId'], FILTER_VALIDATE_INT);
    $puestoId = filter_var($post['PuestoId'], FILTER_VALIDATE_INT);
    $nombreContacto = strtoupper(filter_var($post['NombreContacto'], FILTER_SANITIZE_STRING));
    $parentezco = strtoupper(filter_var($post['Parentezco'], FILTER_SANITIZE_STRING));
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
            TelefonoAlternativo = :telefonoAlternativo,
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
            'telefonoAlternativo' => $telefonoAlternativo,
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
}*/


function actualizarUsuario(array $post, PDO $pdo): array
{
    $usuarioId = filter_var($post['UsuarioId'], FILTER_VALIDATE_INT);
    $nombreUsuario = strtoupper(filter_var($post['NombreUsuario'], FILTER_SANITIZE_STRING));
    $apellidoPaterno = strtoupper(filter_var($post['ApellidoPaterno'], FILTER_SANITIZE_STRING));
    $apellidoMaterno = strtoupper(filter_var($post['ApellidoMaterno'], FILTER_SANITIZE_STRING));
    $email = filter_var($post['Email'], FILTER_VALIDATE_EMAIL);
    $numeroTelefono = filter_var($post['NumeroTelefono'], FILTER_SANITIZE_STRING);
    $telefonoAlternativo = filter_var($post['TelefonoAlternativo'], FILTER_SANITIZE_STRING);
    $departamentoId = filter_var($post['DepartamentoId'], FILTER_VALIDATE_INT);
    $puestoId = filter_var($post['PuestoId'], FILTER_VALIDATE_INT);
    $nombreContacto = strtoupper(filter_var($post['NombreContacto'], FILTER_SANITIZE_STRING));
    $parentezco = strtoupper(filter_var($post['Parentezco'], FILTER_SANITIZE_STRING));
    $numeroEmergencia = filter_var($post['NumeroEmergencia'], FILTER_SANITIZE_STRING);
    // 2) Iniciar transacción
        $pdo->beginTransaction();

        // 3) Actualizar tabla usuarios
        $sqlUser = "UPDATE usuarios SET
            NombreUsuario       = :nombreUsuario,
            ApellidoPaterno     = :apellidoPaterno,
            ApellidoMaterno     = :apellidoMaterno,
            Email               = :email,
            NumeroTelefono      = :numeroTelefono,
            TelefonoAlternativo = :telefonoAlternativo,
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
            'telefonoAlternativo' => $telefonoAlternativo,
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