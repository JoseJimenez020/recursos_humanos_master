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

/**
 * Devuelve bloques HTML para el timeline de vacaciones activas.
 *
 * @param PDO $pdo Conexión PDO a la base de datos
 * @return string  Bloques HTML o mensaje de ausencia de vacaciones
 */
function GetTimelineVacaciones(PDO $pdo): string
{
    // 1) Fecha de hoy para filtro
    $hoy = date('Y-m-d');

    // 2) Consulta uniendo usuarios con vacaciones activas
    $sql = "
      SELECT 
        u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno,
        v.FechaInicio, v.FechaFin
      FROM vacaciones v
      JOIN usuarios   u ON u.UsuarioId = v.UsuarioId
      WHERE v.FechaFin >= :hoy
      ORDER BY v.FechaInicio ASC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['hoy' => $hoy]);
    $vacaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3) Si no hay vacaciones activas
    if (empty($vacaciones)) {
        return <<<HTML
<div class="text-center text-secondary py-3">
  No hay nadie de vacaciones por el momento
</div>
HTML;
    }

    // 4) Clases posibles para el icono
    $clases = ['text-success', 'text-danger', 'text-info', 'text-warning', 'text-primary'];

    // 5) Generar bloques
    $html = '';
    foreach ($vacaciones as $v) {
        // Nombre completo
        $nombre = htmlspecialchars(
            "{$v['NombreUsuario']} {$v['ApellidoPaterno']} {$v['ApellidoMaterno']}"
        );

        // Formato dd/mm/yy
        $inicio = date('d/m/y', strtotime($v['FechaInicio']));
        $fin = date('d/m/y', strtotime($v['FechaFin']));

        // Selección aleatoria de color
        $colorIcono = $clases[array_rand($clases)];

        $html .= <<<HTML
<div class="timeline-block mb-3">
  <span class="timeline-step">
    <i class="material-symbols-rounded {$colorIcono} text-gradient">hotel</i>
  </span>
  <div class="timeline-content">
    <h6 class="text-dark text-sm font-weight-bold mb-0">{$nombre}</h6>
    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
      Del {$inicio} al {$fin}
    </p>
  </div>
</div>
HTML;
    }

    return $html;
}
