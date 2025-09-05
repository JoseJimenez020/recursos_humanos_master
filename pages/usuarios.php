<?php
require '../controllers/logica_usuario.php';
// 1) Inicializamos la variable donde guardaremos el <script> de SweetAlert
$alertHtml = '';

// 2) Si viene un POST, determinamos si es registro o actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Registro de usuario (formulario principal flotante)
    if (isset($_POST['registrarU'])) {
        $alertHtml = RegistrarUsuarioCompleto($_POST, $pdo);
    }

    // Actualización de usuario (modal de edición)
    elseif (isset($_POST['updateUser'])) {
        $alertHtml = actualizarUsuario($_POST, $pdo);
    }

    // Vacaciones de usuario (formulario principal flotante)
    if (isset($_POST['RegistrarV'])) {
        $alertHtml = RegistrarVacaciones($_POST, $pdo);
    }


}

$filterName = trim($_GET['nombreusuario'] ?? '');
$filterDept = $_GET['departamento'] ?? '';
// 3) Traemos departamentos para poblar ambos selects
$departamentos = GetDepartamento($pdo);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <title>
        RH | Lista de Usuarios
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="g-sidenav-show bg-gray-100">

    <?php
    if ($sesion['EsAdmin'] === 1) {
        echo '<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="../pages/dashboard.php" target="_blank">
        <img src="../assets/img/favicon.ico" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Recursos Humanos</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/dashboard.php">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/politicas.html">
            <i class="material-symbols-rounded opacity-5">policy</i>
            <span class="nav-link-text ms-1">Políticas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/reglamento_interno.html">
            <i class="material-symbols-rounded opacity-5">rule</i>
            <span class="nav-link-text ms-1">Reglamento Interno</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/procesos.html">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Procesos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/organigrama.html">
            <i class="material-symbols-rounded opacity-5">globe_book</i>
            <span class="nav-link-text ms-1">Organigrama</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/mision_vision.html">
            <i class="material-symbols-rounded opacity-5">public</i>
            <span class="nav-link-text ms-1">Misión, Visión</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/valores.html">
            <i class="material-symbols-rounded opacity-5">psychology</i>
            <span class="nav-link-text ms-1">Valores</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Administrador</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-gradient-primary text-white" href="../pages/usuarios.php">
            <i class="material-symbols-rounded opacity-5">groups</i>
            <span class="nav-link-text ms-1">Usuarios</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/avisos.php">
            <i class="material-symbols-rounded opacity-5">add_alert</i>
            <span class="nav-link-text ms-1">Avisos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/felicitaciones.html">
            <i class="material-symbols-rounded opacity-5">celebration</i>
            <span class="nav-link-text ms-1">Felicitaciones</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/campanias.html">
            <i class="material-symbols-rounded opacity-5">campaign</i>
            <span class="nav-link-text ms-1">Campañas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/r_vacantes.html">
            <i class="material-symbols-rounded opacity-5">explore</i>
            <span class="nav-link-text ms-1">Vacantes</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Contenido
            adicional</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/manuales.php">
            <i class="material-symbols-rounded opacity-5">collections_bookmark</i>
            <span class="nav-link-text ms-1">Capacitaciones | Manuales</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/nom035.html">
            <i class="material-symbols-rounded opacity-5">comment</i>
            <span class="nav-link-text ms-1">NOM-35</span>
          </a>
        </li>

      </ul>
    </div>
  </aside>';
    } elseif ($sesion['EsAdmin'] === 0) {
        echo '<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="../pages/dashboard.php" target="_blank">
        <img src="../assets/img/favicon.ico" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Recursos Humanos</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active bg-gradient-primary text-white" href="../pages/dashboard.php">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/politicas.html">
            <i class="material-symbols-rounded opacity-5">policy</i>
            <span class="nav-link-text ms-1">Políticas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/reglamento_interno.html">
            <i class="material-symbols-rounded opacity-5">rule</i>
            <span class="nav-link-text ms-1">Reglamento Interno</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/procesos.html">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Procesos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/organigrama.html">
            <i class="material-symbols-rounded opacity-5">globe_book</i>
            <span class="nav-link-text ms-1">Organigrama</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/mision_vision.html">
            <i class="material-symbols-rounded opacity-5">public</i>
            <span class="nav-link-text ms-1">Misión, Visión</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/valores.html">
            <i class="material-symbols-rounded opacity-5">psychology</i>
            <span class="nav-link-text ms-1">Valores</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Contenido
            adicional</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/manuales.php">
            <i class="material-symbols-rounded opacity-5">collections_bookmark</i>
            <span class="nav-link-text ms-1">Capacitaciones | Manuales</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/nom035.html">
            <i class="material-symbols-rounded opacity-5">comment</i>
            <span class="nav-link-text ms-1">NOM-35</span>
          </a>
        </li>

      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline mt-4 w-100 text-primary">
          <i class="material-symbols-rounded opacity-5">explore</i>
          <span class="nav-link-text ms-1">Vacantes</span>
        </a>
        <a class="btn btn-outline-primary w-100" href="../pages/vacantes.html" type="button">
          <span class="nav-link-text ms-1">Comercial</span>
          <i class="material-symbols-rounded opacity-5">groups</i>
          <span id="contador_vacantes">4</span>
          <i class="material-symbols-rounded opacity-5">keyboard_arrow_down</i>
        </a>
        <a class="btn btn-outline-primary w-100" href="../pages/vacantes.html" type="button">
          <span class="nav-link-text ms-1">Técnico</span>
          <i class="material-symbols-rounded opacity-5">groups</i>
          <span id="contador_vacantes">4</span>
          <i class="material-symbols-rounded opacity-5">keyboard_arrow_down</i>
        </a>
      </div>
    </div>
  </aside>';
    }
    ?>
    <!-- CONTENIDO DEL BODY -->
    <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Usuarios</li>
                    </ol>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                    </div>
                    <ul class="navbar-nav d-flex align-items-center  justify-content-end">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="avatar avatar-sm  me-3" <?php echo isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?>>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="../pages/profile.php">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="material-symbols-rounded">user_attributes</i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Perfil
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="#" data-bs-toggle="modal"
                                        data-bs-target="#logoutModal">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="material-symbols-rounded">logout</i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">Salir</h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('../assets/img/illustrations/banner-usuarios.jpg');">
                <span class="mask  bg-gradient-dark  opacity-6"></span>
            </div>
            <div class="card card-body mx-2 mx-md-2 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h3 class="mb-0 h3 font-weight-bolder">
                                Lista de Usuarios
                            </h3>
                            <p class="mb-0 font-weight-normal text-sm">
                                Consulte, edite y registre información de los usuarios activos en el sistema.
                            </p>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0 panel">
                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Nombre de usuario</label>
                                            <input type="text" name="nombreusuario" class="form-control"
                                                value="<?= htmlspecialchars($filterName) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static my-3">
                                            <select name="departamento" class="form-control" id="departamento">
                                                <option value="" selected> Departamento</option>
                                                <?php foreach ($departamentos as $d): ?>
                                                    <option value="<?= $d['DepartamentoId'] ?>"
                                                        <?= $filterDept == $d['DepartamentoId'] ?>>
                                                        <?= htmlspecialchars($d['DepartamentoNombre']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-icon btn-3 btn-primary" type="submit">
                                    <span class="btn-inner--icon"><i class="material-symbols-rounded">search</i></span>
                                    <span class="btn-inner--text">Buscar</span>
                                </button>
                                <button class="btn btn-icon btn-2 btn-primary" type="button"
                                    onclick="window.location.href='<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>'">
                                    <span class="btn-inner--icon"><i class="material-symbols-rounded">Close</i></span>
                                </button>
                            </form>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Departamento</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Contacto emergencia</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Añadido el</th>
                                        <th class="text-secondary opacity-7 ps-2"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= GetTableUsuarios($pdo, $filterName, $filterDept) ?>
                                </tbody>
                            </table>

                            <!-- MODAL NOTIFICACIÓN BORRADO -->
                            <div class="modal fade" id="modal-notification" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <i class="material-symbols-rounded text-danger me-2">warning</i>
                                            <h6 class="modal-title">Alerta</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form id="form-delete-user">
                                            <div class="modal-body text-center">
                                                <i class="material-symbols-rounded h1 text-secondary">Eliminar
                                                    Usuario</i>
                                                <h4 class="text-gradient text-danger mt-4">Atención</h4>
                                                <p>Está a punto de borrar a <strong id="modal-username"></strong>,
                                                    ¿desea continuar?</p>
                                                <input type="hidden" name="delete_user_id" id="delete-user-id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn bg-gradient-primary">Sí,
                                                    continuar.</button>
                                                <button type="button" class="btn btn-link text-primary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- FIN DEL MODAL -->

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <footer class="footer py-4 ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            Powered by
                            <a href="https://www.fast-net.com.mx" class="font-weight-bold" target="_blank">Fast-net</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <!--PLUGIN PARA MOSTRAR BOTÓN FLOTANTE-->
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="material-symbols-rounded py-2">person_add</i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Añadir nuevo usuario</h5>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-symbols-rounded">clear</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0" style="max-height: 80vh; overflow-y: auto;">
                <div class="mt-3 d-flex">
                    <form method="POST">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nombre</label>
                            <input name="nombre" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Apellido Paterno</label>
                            <input name="apellidoPaterno" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Apellido Materno</label>
                            <input name="apellidoMaterno" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-static mb-4 ">
                            <label for="exampleFormControlSelect1" class="ms-0">Tipo de Sangre</label>
                            <select class="form-control" name="tipoSangre" id="exampleFormControlSelect1">
                                <option selected>Seleccionar</option>
                                <option value="O-">O-</option>
                                <option value="O+">O+</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                        <div class="input-group input-group-static my-3">
                            <label>Fecha de nacimiento</label>
                            <input name="fechaNacimiento" type="date" class="form-control">
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <label>Departamento</label>
                            <select name="DepartamentoId" id="departamento-registro" class="form-control" required>
                                <option value="">Seleccionar</option>
                                <?= GetListaDepartamentos($departamentos) ?>
                            </select>
                        </div>
                        <!-- Selección dinámica de puesto -->
                        <div class="input-group input-group-static mb-4">
                            <label>Puesto</label>
                            <select name="PuestoId" id="puesto-registro" class="form-control">
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Email</label>
                            <input name="correo" type="email" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Número celular</label>
                            <input name="celular" type="tel" class="form-control">
                        </div>
                        <!-- Datos de contacto de emergencia -->
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nombre contacto de emergencia</label>
                            <input name="NombreContacto" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Parentesco</label>
                            <input name="Parentesco" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Número de emergencia</label>
                            <input name="NumeroEmergencia" type="tel" class="form-control">
                        </div>
                        <div class="input-group input-group-static mb-4 ">
                            <label for="exampleFormControlSelect1" class="ms-0">Base</label>
                            <select name="Base" class="form-control" id="exampleFormControl2" required>
                                <option selected>Seleccionar</option>
                                <option>Allende</option>
                                <option>Chihuahua</option>
                                <option>Ciudad del carmen</option>
                                <option>Comalcalco</option>
                                <option>Cunduacán </option>
                                <option>Delicias</option>
                                <option>Jalapa</option>
                                <option>Jalpa de Méndez</option>
                                <option>Lázaro Cárdenas</option>
                                <option>Nacajuca</option>
                                <option>Paraíso </option>
                                <option>Parrilla</option>
                                <option>Petrolera</option>
                                <option>Pichucalco</option>
                                <option>Pomoca</option>
                                <option>Tacotalpa</option>
                                <option>Teapa</option>
                                <option>Villahermosa</option>
                            </select>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Username</label>
                            <input name="username" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Contraseña</label>
                            <input name="password" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-static mb-4 ">
                            <input type="checkbox" name="admin" value="1">
                            <label for="exampleFormControlSelect1" class="ms-0">¿Es Administrador?</label>
                        </div>
                        <hr class="horizontal dark my-3">
                        <button type="submit" name="registrarU" class="btn bg-gradient-primary w-100">
                            Registrar Usuario
                        </button>

                    </form>
                    <?= $alertHtml ?>
                </div>
            </div>
        </div>
    </div>
    <!--FIN DEL PLUGIN BOTÓN FLOTANTE-->

    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('modal-edit');
            const formEdit = document.getElementById('form-edit-usuario');
            const bsModal = new bootstrap.Modal(editModal);


            editModal.addEventListener('show.bs.modal', async e => {
                const userId = e.relatedTarget.dataset.userId;
                formEdit.UsuarioId.value = userId;
                const tipoSangreSel = formEdit.TipoSangre;

                // TRAEMOS JSON PURO, NUNCA HTML
                const resp = await fetch(`../controllers/get_usuario_ajax.php?id=${userId}`);
                const u = await resp.json();

                // Rellenas los inputs
                formEdit.NombreUsuario.value = u.NombreUsuario || '';
                formEdit.ApellidoPaterno.value = u.ApellidoPaterno || '';
                formEdit.ApellidoMaterno.value = u.ApellidoMaterno || '';
                formEdit.NumeroTelefono.value = u.NumeroTelefono || '';
                formEdit.Email.value = u.Email || '';
                tipoSangreSel.value = u.TipoSangre || '';
                // 4) Rellena departamento y puesto
                const depSel = formEdit.DepartamentoId;
                depSel.value = u.DepartamentoId || '';
                // Carga puestos
                const loadPuestos = async (depId, selId) => {
                    const ps = formEdit.PuestoId;
                    ps.innerHTML = '<option>Cargando…</option>';
                    const r = await fetch(`../controllers/logica_usuario.php?DepartamentoId=${depId}`);
                    const arr = await r.json();
                    ps.innerHTML = '<option value="">Seleccione...</option>';
                    arr.forEach(p => {
                        const o = document.createElement('option');
                        o.value = p.PuestoId;
                        o.text = p.PuestoNombre;
                        if (p.PuestoId == selId) o.selected = true;
                        ps.append(o);
                    });
                };
                await loadPuestos(u.DepartamentoId, u.PuestoId);
                depSel.onchange = () => loadPuestos(depSel.value, null);
                formEdit.NombreContacto.value = u.NombreContacto || '';
                formEdit.Parentezco.value = u.Parentezco || '';
                formEdit.NumeroEmergencia.value = u.ContactoTelefono || '';
            });

            // 7) Al enviar el formulario, hacer POST AJAX a update_usuario.php
            formEdit.addEventListener('submit', async e => {
                e.preventDefault();
                const resp = await fetch('../controllers/update_usuario_ajax.php', {
                    method: 'POST',
                    body: new FormData(formEdit)
                });

                const result = await resp.json();

                await Swal.fire({
                    title: result.success ? '¡Actualizado!' : 'Error',
                    text: result.message,
                    icon: result.success ? 'success' : 'error'
                });

                if (result.success) {
                    bsEditModal.hide();
                    window.location.reload();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const editModalEl = document.getElementById('modal-edit');
            // Asegúrate de usar la misma versión de Bootstrap (5) que tu proyecto
            const bsEditModal = bootstrap.Modal.getOrCreateInstance(editModalEl);
            const formEdit = document.getElementById('form-edit-usuario');

            formEdit.addEventListener('submit', async function (e) {
                e.preventDefault();
                const data = new FormData(formEdit);

                try {
                    const resp = await fetch('../controllers/update_usuario.php', {
                        method: 'POST',
                        body: data
                    });
                    const result = await resp.json();

                    if (result.success) {
                        // 1) Cerrar el modal
                        bsEditModal.hide();

                        // 2) Mostrar alerta de éxito
                        await Swal.fire({
                            title: '¡Actualizado!',
                            text: result.message,
                            icon: 'success'
                        });

                        // 3) Opcional: recargar la página o rehacer la tabla
                        window.location.reload();
                    } else {
                        // Si hubo error, mantén el modal abierto y avisa
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            icon: 'error'
                        });
                    }
                } catch (err) {
                    console.error(err);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un fallo de comunicación.',
                        icon: 'error'
                    });
                }
            });
        });
    </script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <!--CARGAR PUESTOS FORMULARIO DE REGISTRO-->
    <script>
        document.getElementById('departamento-registro').addEventListener('change', function () {
            const departamentoId = this.value;
            const puestoSelect = document.getElementById('puesto-registro');

            // Limpia opciones anteriores
            puestoSelect.innerHTML = '<option value="">Cargando puestos...</option>';

            if (!departamentoId) {
                puestoSelect.innerHTML = '<option value="">Seleccione un puesto</option>';
                return;
            }

            fetch(`../controllers/logica_usuario.php?DepartamentoId=${departamentoId}`)
                .then(response => response.json())
                .then(data => {
                    puestoSelect.innerHTML = '<option value="">Seleccione un puesto</option>';
                    data.forEach(puesto => {
                        const option = document.createElement('option');
                        option.value = puesto.PuestoId;
                        option.textContent = puesto.PuestoNombre;
                        puestoSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    puestoSelect.innerHTML = '<option value="">Error al cargar</option>';
                    console.error('Error:', error);
                });
        });
    </script>

    <!--JS DEL MODAL DE BORRADO-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteModal = document.getElementById('modal-notification');

            // 1) Antes de mostrar el modal, le metemos ID y nombre
            deleteModal.addEventListener('show.bs.modal', event => {
                const trigger = event.relatedTarget;
                const userId = trigger.getAttribute('data-user-id');
                const userName = trigger.getAttribute('data-user-name');

                deleteModal.querySelector('#modal-username').textContent = userName;
                deleteModal.querySelector('#delete-user-id').value = userId;
            });

            // 2) Enviar la petición de borrado al servidor
            document.getElementById('form-delete-user').addEventListener('submit', e => {
                e.preventDefault();
                const id = e.target.delete_user_id.value;

                fetch('../controllers/delete_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_id: id })
                })
                    .then(res => res.json())
                    .then(json => {
                        if (json.success) {
                            // Cerrar modal
                            bootstrap.Modal.getInstance(deleteModal).hide();
                            // Recarga completa (o eliminar fila con JS)
                            const row = trigger.closest('tr');
                            row.parentNode.removeChild(row);
                        } else {
                            alert('Error al borrar: ' + json.message);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Error al comunicar con el servidor.');
                    });
            });
        });
    </script>
    <script src="../assets/js/settings.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>

    <!--MODAL PARA EDITAR USUARIO-->
    <div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Editar información</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="form-edit-usuario">
                    <input type="hidden" name="UsuarioId" id="edit-UsuarioId">
                    <div class="modal-body">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nombre</label>
                            <input name="NombreUsuario" id="edit-NombreUsuario" type="text" class="form-control"
                                required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Apellido Paterno</label>
                            <input name="ApellidoPaterno" id="edit-ApellidoPaterno" type="text" class="form-control"
                                required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Apellido Materno</label>
                            <input name="ApellidoMaterno" id="edit-ApellidoMaterno" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-static mb-4 ">
                            <label for="exampleFormControlSelect1" class="ms-0">Tipo de Sangre</label>
                            <select class="form-control" name="TipoSangre" id="edit-TipoSangre">
                                <option selected>Seleccionar</option>
                                <option value="O-">O-</option>
                                <option value="O+">O+</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B-">B-</option>
                                <option value="B+">B+</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <label>Departamento</label>
                            <select name="DepartamentoId" id="departamento" class="form-control" required>
                                <option value="">Seleccionar</option>
                                <?= GetListaDepartamentos($departamentos) ?>
                            </select>
                        </div>
                        <!-- Selección dinámica de puesto -->
                        <div class="input-group input-group-static mb-4">
                            <label>Puesto</label>
                            <select name="PuestoId" id="puesto" class="form-control" required>
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Teléfono celular</label>
                            <input name="NumeroTelefono" id="edit-NumeroTelefono" type="tel" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Email</label>
                            <input name="Email" id="edit-Email" type="email" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nombre contacto emergencia</label>
                            <input name="NombreContacto" id="edit-NombreContacto" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Parentesco contacto emergencia</label>
                            <input name="Parentezco" id="edit-Parentezco" type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Número contacto emergencia</label>
                            <input name="NumeroEmergencia" id="edit-NumeroEmergencia" type="tel" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary w-100">Guardar
                            información</button>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN DEL MODAL DE EDITAR USUARIO -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="logoutModalLabel">Cerrar sesión</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <p>Estás a punto de cerrar sesión.</p>
                        <p>¿Seguro que quieres continuar?</p>
                    </div>
                    <div class="modal-footer">
                        <button name="cerrarSesion" type="submit" class="btn bg-gradient-primary">Cerrar
                            sesión</button>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End logout modal-->

    <!--MODAL FOTO DE PERFIL-->
    <div class="modal fade" id="fotoPerfilModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar foto de perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="card bg-dark text-white border-0 mb-4">
                        <img id="modalPreviewImg" src="../assets/img/small-logos/user.png" alt="preview"
                            class="card-img">
                    </div>

                    <!-- Formulario actualizado -->
                    <form id="foto_perfil_usuario" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="UsuarioId" value="">
                        <p class="text-sm"><em>(JPEG, JPG). Tamaño máximo: 1 MB.</em></p>
                        <div class="input-group input-group-outline mb-4">
                            <label class="form-label">Selecciona una imagen</label>
                            <input type="file" name="foto" accept="image/jpeg,image/jpg" class="form-control" required>
                        </div>

                        <button type="submit" name="guardarFoto" class="btn bg-gradient-primary">Guardar</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN DEL MODAL FOTO DE PERFIL -->
    <!-- SCRIPT FOTO DE PERFIL-->
    <script>
        const fotoModal = document.getElementById('fotoPerfilModal');

        fotoModal.addEventListener('show.bs.modal', event => {
            const trigger = event.relatedTarget;
            const userId = trigger.getAttribute('data-user-id');
            const photoSrc = trigger.getAttribute('data-photo-src');

            // 1. Poner ID en el input oculto
            fotoModal.querySelector('input[name="UsuarioId"]').value = userId;

            // 2. Actualizar preview del <img>
            document.getElementById('modalPreviewImg').src = photoSrc;
        });
    </script>
    <!-- FIN DEL SCRIPT DE FOTO DE PERFIL-->

    <!--MODAL PARA REGISTRO DE VACACIONES-->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-default"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Vacaciones de <span id="vac-modal-username"></span></h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="usuarioId">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Fecha de Inicio</label>
                            <input type="date" name="fechaInicio" class="form-control">
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Fecha de Vuelta</label>
                            <input type="date" name="fechaFin" class="form-control">
                        </div>

                        <div class="text-center">
                            <button type="submit" name="RegistrarV"
                                class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0">
                                Registrar
                            </button>
                        </div>
                    </form>
                    <?= $alertHtml ?>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN DEL MODAL DE VACACIONES -->
    <!--SCRIPT MODAL VACACIONES-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const vacModal = document.getElementById('modal-form');

            vacModal.addEventListener('show.bs.modal', function (event) {
                // e.relatedTarget es el <a> que desencadenó la apertura
                const trigger = event.relatedTarget;
                const userId = trigger.getAttribute('data-user-id');
                const userName = trigger.getAttribute('data-user-name');

                // Poner nombre
                this.querySelector('#vac-modal-username').textContent = userName;
                // Poner ID oculto
                this.querySelector('input[name="usuarioId"]').value = userId;
            });
        });
    </script>
    <!--FIN SCRIPT MODAL VACACIONES-->

</body>

</html>