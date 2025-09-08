<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

function RegistrarVacante(array $post, PDO $pdo): string
{
    $puestoId = filter_var($post['PuestoId'], FILTER_VALIDATE_INT);
    $descripcion = filter_var($post['descripcionVacante'], FILTER_SANITIZE_STRING);
    $fechaIng = filter_var($post['fechaIngreso'], FILTER_SANITIZE_STRING);

    try {
        $pdo->beginTransaction();

        $sqlVac = "INSERT INTO vacantes 
        (PuestoId, Descripcion, FechaIngreso, Status) 
        VALUES 
        (:pid, :dc, :fi, 1)";
        $stVa = $pdo->prepare($sqlVac);
        $stVa->execute([
            ':pid' => $puestoId,
            ':dc' => $descripcion,
            ':fi' => $fechaIng
        ]);

        $pdo->commit();

        return alertScript(
            '¡Éxito!',
            'Vacante registrada correctamente.',
            'success',
            'panel_vacantes.php'
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

function GetTableVacantes(PDO $pdo): string
{
    $sql = "SELECT v.VacanteId, v.Descripcion, v.FechaIngreso, v.Status, d.DepartamentoNombre, p.PuestoNombre, p.DepartamentoId
    FROM vacantes v
    LEFT JOIN puesto p ON v.PuestoId = p.PuestoId
    LEFT JOIN departamento d ON d.DepartamentoId = p.DepartamentoId
    WHERE 1=1 ORDER BY d.DepartamentoNombre";

    $params = [];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        return '<tr><td colspan="6" class="text-center">Sin registros</td></tr>';
    }

    $html = '';
    foreach ($rows as $v) {
        $badge = $v['Status']
            ? '<span class="badge badge-sm bg-gradient-success">Activa</span>'
            : '<span class="badge badge-sm bg-gradient-secondary">Inactiva</span>';
        $decrip = nl2br(htmlspecialchars($v['Descripcion'], ENT_QUOTES, 'UTF-8'));
        $html .= '<tr>
                <td>
                    <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">' . $v['PuestoNombre'] . '</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">' . $v['DepartamentoNombre'] . '</p>
                </td>
                <td>
                    <p class="text-xs mb-0 pre-wrap">' . $decrip . '</p>
                </td>
                <td class="align-middle text-center text-sm">
                  ' . $badge . '
                </td>
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">' . date('d/m/Y', strtotime($v['FechaIngreso'])) . '</span>
                </td>
                <td class="align-middle">
                    <a href="" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user"
                        target="_blank" 
                        data-vacante-id="' . $v['VacanteId'] . '"                        
                        data-vacante-name="' . htmlspecialchars($v['PuestoNombre']) . '"
                        data-descripcion="' . htmlspecialchars($v['Descripcion'], ENT_QUOTES, 'UTF-8') . '"
                        data-fecha="' . $v['FechaIngreso'] . '"
                        data-status="' . $v['Status'] . '"
                        data-bs-toggle="modal" 
                        data-bs-target="#modal-edit">
                        Editar
                    </a>
                    <a href="" class="text-success font-weight-bold text-xs" data-toggle="tooltip"
                        data-original-title="Recomendations" 
                        target="_blank" 
                        data-vacante-id="' . $v['VacanteId'] . '"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalLong">
                        Recomendaciones
                    </a>
                </td>
                </tr>';
    }
    return $html;
}
/**
 * Actualiza una vacante y devuelve el HTML del alertScript.
 *
 * @param  array  $data  Los datos enviados por POST.
 * @param  PDO    $pdo   Conexión PDO a la base de datos.
 * @return string        El <script> generado por alertScript().
 */
function actualizarVacante(array $data, PDO $pdo): string
{
    // 1) Sanitizar y preparar datos
    $id = isset($data['VacanteId']) ? (int) $data['VacanteId'] : 0;
    $desc = isset($data['Descripcion']) ? trim($data['Descripcion']) : '';
    $fecha = $data['FechaIngreso'] ?? '';
    $status = isset($data['Status']) ? 1 : 0;

    // 2) Consulta UPDATE
    $sql = "UPDATE vacantes
            SET Descripcion   = :desc,
                FechaIngreso  = :fecha,
                Status        = :status
            WHERE VacanteId = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':desc' => $desc,
        ':fecha' => $fecha,
        ':status' => $status,
        ':id' => $id
    ]);

    // 3) Construir mensaje de respuesta
    if ($stmt->rowCount() > 0) {
        $title = '¡Listo!';
        $text = 'La vacante se ha actualizado correctamente.';
        $icon = 'success';
    } else {
        $title = 'Sin cambios';
        $text = 'No se detectaron modificaciones.';
        $icon = 'info';
    }

    // 4) Devolver el <script> con alertScript, redirigiendo a panel_vacantes.php
    return alertScript($title, $text, $icon, 'panel_vacantes.php');
}

function getVistaVacantes(PDO $pdo): string
{
    $sql = "SELECT v.VacanteId, v.FechaIngreso, v.Descripcion, v.Status, d.DepartamentoNombre, p.PuestoNombre, p.DepartamentoId
    FROM vacantes v
    LEFT JOIN puesto p ON v.PuestoId = p.PuestoId
    LEFT JOIN departamento d on d.DepartamentoId = p.DepartamentoId
    WHERE Status=1 ORDER BY d.DepartamentoNombre";

    $params = [];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        return '<li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column">
                        <h6 class="mb-3 text-sm">Por el momento no hay vacantes disponibles</h6>
                    </div>
                </li>';
    }
    $html = '';
    foreach ($rows as $v) {
        $decrip = nl2br(htmlspecialchars($v['Descripcion'], ENT_QUOTES, 'UTF-8'));
        $html .= '<li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column">
                        <h6 class="mb-3 text-sm">' . $v['PuestoNombre'] . '</h6>
                        <span class="mb-2 text-xs">Fecha de inicio: <span class="text-dark font-weight-bold ms-sm-2">' . date('d/m/Y', strtotime($v['FechaIngreso'])) . '</span></span>
                        <span class="mb-2 text-xs">Departamento: <span class="text-dark ms-sm-2 font-weight-bold"> ' . $v['DepartamentoNombre'] . ' </span></span>
                        <span class="text-xs">Descripción: <span class="text-dark ms-sm-2 font-weight-bold">' . $decrip . '</span></span>
                    </div>
                    <div class="ms-auto text-end">
                        <a class="btn btn-link text-primary text-gradient px-3 mb-0"
                            href="javascript:;"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-form"
                            data-vacante-id="' . $v['VacanteId'] . '"
                            data-usuario-id="' . $_SESSION['user_id'] . '">
                           <i class="material-symbols-rounded text-sm me-2">attach_email</i>Recomendar a alguien</a>
                    </div>
                </li>';
    }
    return $html;
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

/**
 * Inserta el documento y la recomendación en la BD dentro de una transacción.
 * Lanza excepción si algo falla.
 */
function registrarRecomendacion(PDO $pdo, array $post, array $file): string
{
    // 1) Sanitizar y validar
    $vacanteId = filter_var($post['VacanteId'] ?? null, FILTER_VALIDATE_INT);
    $usuarioId = filter_var($post['UsuarioId'] ?? null, FILTER_VALIDATE_INT);
    $nombreRec = trim(filter_var($post['nombreRecomendado'] ?? '', FILTER_SANITIZE_STRING));
    $telefonoRec = trim(filter_var($post['telefonoRecomendado'] ?? '', FILTER_SANITIZE_STRING));
    $emailRec = filter_var($post['emailRecomendado'] ?? '', FILTER_VALIDATE_EMAIL);
    $nombreDoc = $file['name'];
    $binario = file_get_contents($file['tmp_name']);

    try {
        $pdo->beginTransaction();

        // 2) Insertar en documentos
        $sqlDoc = "INSERT INTO documentos (NombreDocumento, DocumentoContenido)
                   VALUES (:nombre, :contenido)";
        $stDoc = $pdo->prepare($sqlDoc);
        $stDoc->execute([
            ':nombre' => $nombreDoc,
            ':contenido' => $binario
        ]);
        $docId = $pdo->lastInsertId();

        // 3) Insertar en recomendaciones
        $sqlRec = "INSERT INTO recomendaciones
                   (VacanteId, NombreRecomendado, Email,
                    NumeroRecomendado, DocumentoId, UsuarioId)
                   VALUES
                   (:vac, :nom, :email, :tel, :doc, :usr)";
        $stRec = $pdo->prepare($sqlRec);
        $stRec->execute([
            ':vac' => $vacanteId,
            ':nom' => $nombreRec,
            ':email' => $emailRec,
            ':tel' => $telefonoRec,
            ':doc' => $docId,
            ':usr' => $usuarioId
        ]);

        $pdo->commit();

        return alertScript(
            '¡Listo!',
            'La recomendación se envió correctamente.',
            'success',
            'vacantes.php'
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

/**
 * Devuelve las filas HTML de la tabla de recomendaciones
 * para la vacante cuyo ID llega en $vacanteId.
 */
function GetTableRecomendaciones(PDO $pdo, int $vacanteId): string
{
    // 1) Consulta básica con unión a documentos y usuarios
    $sql = "
        SELECT
            r.RecomendacionId,
            r.NombreRecomendado,
            r.Email,
            r.NumeroRecomendado,
            d.DocumentoId,
            d.NombreDocumento,
            u.NombreUsuario,
            u.ApellidoPaterno,
            u.ApellidoMaterno
        FROM recomendaciones r
        LEFT JOIN documentos d ON d.DocumentoId = r.DocumentoId
        LEFT JOIN usuarios u ON u.UsuarioId = r.UsuarioId
        WHERE r.VacanteId = :VacanteId
        ORDER BY r.RecomendacionId
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':VacanteId' => $vacanteId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2) Si no hay recomendaciones
    if (empty($rows)) {
        return '<tr><td colspan="4" class="text-center">Sin recomendaciones</td></tr>';
    }

    // 3) Construcción de cada fila
    $html = '';
    foreach ($rows as $rec) {
        // Nombre recomendado + mailto
        $nombreRec = htmlspecialchars($rec['NombreRecomendado'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($rec['Email'], ENT_QUOTES, 'UTF-8');
        $mailto = "mailto:{$email}";

        // Número limpio y enlace a WhatsApp
        $numeroRaw = preg_replace('/\D+/', '', $rec['NumeroRecomendado']);
        $waLink = "https://wa.me/{$numeroRaw}";
        // Formato (XX) XXX XXXX
        $numeroFormateado = sprintf(
            '(%s) %s %s',
            substr($numeroRaw, 0, 2),
            substr($numeroRaw, 2, 3),
            substr($numeroRaw, 5)
        );

        // Badge para el CV
        $viewUrl = "../controllers/ver_cv.php?id={$rec['DocumentoId']}";

        // Quien recomienda
        $quien = htmlspecialchars(
            trim("{$rec['NombreUsuario']} {$rec['ApellidoPaterno']} {$rec['ApellidoMaterno']}"),
            ENT_QUOTES,
            'UTF-8'
        );

        $html .= "
            <tr>
                <td>
                    <div class=\"d-flex px-2 py-1\">
                        <div class=\"d-flex flex-column justify-content-center\">
                            <h6 class=\"mb-0 text-sm\">{$nombreRec}</h6>
                            <a href=\"{$mailto}\" class=\"text-xs text-secondary mb-0\">{$email}</a>
                        </div>
                    </div>
                </td>
                <td>
                    <a href=\"{$waLink}\" class=\"text-xs font-weight-bold mb-0\">{$numeroFormateado}</a>
                </td>
                <td class=\"align-middle text-center text-sm\">
                    <span class=\"badge bg-gradient-success\"
                            style=\"cursor:pointer\"
                            onclick=\"verPDFSweetAlert('{$viewUrl}')\">
                        Ver
                      </span>
                </td>
                <td class=\"align-middle text-center\">
                    <span class=\"text-secondary text-xs font-weight-bold\">{$quien}</span>
                </td>
            </tr>
        ";
    }

    return $html;
}