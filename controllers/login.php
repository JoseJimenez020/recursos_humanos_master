<?php
session_start();
require_once 'conn.php';
require '../controllers/sesion.php';

if (isset($_SESSION['user_id'])) {
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Bienvenido " . $sesion['NombreUsuario'] . " " . $sesion['ApellidoPaterno'] . " " . $sesion['ApellidoMaterno'] . ".',
                icon: 'success'
            }).then(() => {
                window.location.href = '../pages/dashboard.php';
            });
        });
    </script>";
}

function verificarCredenciales($username, $password, $pdo)
{

    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);


    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE Username = :usuario");

    $stmt->execute(array(':usuario' => $username));

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['Contrasena'])) {
            $_SESSION['user_id'] = $user['UsuarioId'];
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (verificarCredenciales($username, $password, $pdo)) {

        $stmt = $pdo->prepare('SELECT NombreUsuario, ApellidoPaterno, ApellidoMaterno FROM usuarios WHERE UsuarioId = :id');
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $sesion = null;

        if (count($results) > 0) {
            $sesion = $results;
        }

        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Has iniciado sesión.',
                    text: 'Bienvenido " . $sesion['NombreUsuario'] . " " . $sesion['ApellidoPaterno'] . " " . $sesion['ApellidoMaterno'] . ".', 
                    icon: 'success'
                }).then(() => {
                    window.location.href = '../pages/dashboard.php';
                });
            });
        </script>";
    } else {
        echo " 
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'La contraseña o el usuario son incorrectos.',
                    icon: 'error'
                });
            });
        </script>";
    }
}

function candidatoExistente(PDO $pdo, string $email, string $telefono)
{
    $sql = "SELECT * FROM candidatos WHERE CorreoRecomendado = :email OR NumeroRecomendado = :tel LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email, ':tel' => $telefono]);
    return $stmt->fetch() ?: false;
}

/**
 * Inserta un nuevo candidato y retorna el id insertado (int) o false en fallo.
 */
function registrarCandidato(PDO $pdo, array $data)
{
    $sql = "INSERT INTO candidatos (NombreCompleto, NumeroRecomendado, CorreoRecomendado, Edad, BaseAplica, PuestoAplica)
            VALUES (:nombre, :num, :correo, :edad, :base, :puesto)";
    $stmt = $pdo->prepare($sql);

    $params = [
        ':nombre' => $data['fullname'],
        ':num' => $data['tel'],
        ':correo' => $data['email'],
        ':edad' => (int) $data['age'],
        ':base' => $data['Base'],
        ':puesto' => $data['Puesto'],
    ];

    if ($stmt->execute($params)) {
        return (int) $pdo->lastInsertId();
    }
    return false;
}

/**
 * Crea la sesión del candidato (almacena id y nombre) y redirige al dashboard.
 */
function iniciarSesionCandidato(array $candidato)
{
    // session_start() debe haberse llamado antes (está en db.php)
    $_SESSION['candidato_id'] = (int) $candidato['CandidatoId'];
    $_SESSION['candidato_nombre'] = $candidato['NombreCompleto'];
    // Puedes añadir más datos si lo requieres (con cuidado)
    header('Location: ../pages/candidatos.php');
    exit;
}
?>