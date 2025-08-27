<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
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
}

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
        RH | Control Usuarios
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
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
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
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Administrador
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link  active bg-gradient-primary text-white" href="../pages/usuarios.php">
                        <i class="material-symbols-rounded opacity-5">groups</i>
                        <span class="nav-link-text ms-1">Usuarios</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="../pages/avisos.html">
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
                    <a class="nav-link text-primary" href="../pages/manuales.html">
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
                <li class="nav-item">
                    <a class="nav-link text-primary" href="../pages/sign-in.html">
                        <i class="material-symbols-rounded opacity-5">login</i>
                        <span class="nav-link-text ms-1">Salir</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
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
                                    <a class="dropdown-item border-radius-md" href="../pages/profile.html">
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
                                <li>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
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
                                Control de Usuarios
                            </h3>
                            <p class="mb-0 font-weight-normal text-sm">
                                Consulte, edite y registre información de los usuarios activos en el sistema.
                            </p>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
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
                                        <th class="text-secondary opacity-7 ps-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= GetTableUsuarios($pdo) ?>
                                </tbody>
                            </table>

                            <!--MODAL PARA REGISTRO DE VACACIONES-->
                            <div class="modal fade" id="modal-form" tabindex="-1" role="dialog"
                                aria-labelledby="modal-default" aria-hidden="true">
                                <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title font-weight-normal" id="modal-title-default">
                                                Vacaciones</h6>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Ingrese las fechas de inicio y final para las vacaciones de
                                                @Nombre_Usuario</p>
                                            <form role="form text-left">
                                                <div class="input-group input-group-outline my-3">
                                                    <label class="form-label">Fecha de Inicio</label>
                                                    <input type="date" class="form-control" onfocus="focused(this)"
                                                        onfocusout="defocused(this)">
                                                </div>
                                                <div class="input-group input-group-outline my-3">
                                                    <label class="form-label">Fecha de vuelta</label>
                                                    <input type="date" class="form-control" onfocus="focused(this)"
                                                        onfocusout="defocused(this)">
                                                </div>
                                                <div class="text-center">
                                                    <button type="button"
                                                        class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0 toast-btn"
                                                        data-bs-dismiss="modal"
                                                        data-target="successToast">Registrar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIN DEL MODAL DE VACACIONES -->

                            <!-- MODAL NOTIFICACIÓN BORRADO -->
                            <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog"
                                aria-labelledby="modal-notification" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <i class="material-symbols-rounded text-danger me-2">
                                                warning
                                            </i>
                                            <h6 class="modal-title font-weight-normal" id="modal-title-notification">
                                                Alerta</h6>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="py-3 text-center">
                                                <i class="material-symbols-rounded h1 text-secondary">
                                                    Borrar Usuario
                                                </i>
                                                <h4 class="text-gradient text-danger mt-4">Atención</h4>
                                                <p>Está a punto de borrar a @Nombre_Usuario, ¿Está seguro que desea
                                                    continuar?</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-primary toast-btn"
                                                data-bs-dismiss="modal" data-target="warningToast">Sí,
                                                continuar.</button>
                                            <button type="button" class="btn btn-link text-primary ml-auto"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIN DEL MODAL NOTIFICACIÓN BORRADO -->
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
                <!-- Sidenav Type -->

                <!-- Navbar Fixed -->
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
                            <select class="form-control" name="tipoSangre" id="exampleFormControlSelect1" required>
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
                            <label class="form-label">Email</label>
                            <input name="correo" type="email" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Número celular</label>
                            <input name="celular" type="tel" class="form-control" required>
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
                            <input name="NumeroEmergencia" type="tel" class="form-control" required>
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

    <!-- NOTIFICACIONES A UN COSTADO DE LA PANTALLA-->
    <div class="position-fixed bottom-1 end-1 z-index-2">
        <div class="toast fade hide p-2 bg-white" role="alert" aria-live="assertive" id="successToast"
            aria-atomic="true">
            <div class="toast-header border-0">
                <i class="material-symbols-rounded text-success me-2">
                    check
                </i>
                <span class="me-auto font-weight-bold">¡Éxito! </span>
                <small class="text-body">Justo Ahora</small>
                <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
            </div>
            <hr class="horizontal dark m-0">
            <div class="toast-body">
                información registrada correctamente
            </div>
        </div>
        <div class="toast fade hide p-2 mt-2 bg-gradient-info" role="alert" aria-live="assertive" id="infoToast"
            aria-atomic="true">
            <div class="toast-header bg-transparent border-0">
                <i class="material-symbols-rounded text-white me-2">
                    notifications
                </i>
                <span class="me-auto text-white font-weight-bold">Material Dashboard </span>
                <small class="text-white">11 mins ago</small>
                <i class="fas fa-times text-md text-white ms-3 cursor-pointer" data-bs-dismiss="toast"
                    aria-label="Close"></i>
            </div>
            <hr class="horizontal light m-0">
            <div class="toast-body text-white">
                Hello, world! This is a notification message.
            </div>
        </div>
        <div class="toast fade hide p-2 mt-2 bg-white" role="alert" aria-live="assertive" id="warningToast"
            aria-atomic="true">
            <div class="toast-header border-0">
                <i class="material-symbols-rounded text-warning me-2">
                    warning
                </i>
                <span class="me-auto font-weight-bold">¡Alerta! </span>
                <small class="text-body">Justo Ahora</small>
                <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
            </div>
            <hr class="horizontal dark m-0">
            <div class="toast-body">
                información eliminada correctamente.
            </div>
        </div>
        <div class="toast fade hide p-2 mt-2 bg-white" role="alert" aria-live="assertive" id="dangerToast"
            aria-atomic="true">
            <div class="toast-header border-0">
                <i class="material-symbols-rounded text-danger me-2">
                    dangerous
                </i>
                <span class="me-auto text-gradient text-danger font-weight-bold">¡Error! </span>
                <small class="text-body">Justo Ahora</small>
                <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
            </div>
            <hr class="horizontal dark m-0">
            <div class="toast-body">
                Hubo un error al procesar la información.
            </div>
        </div>
    </div>
    <!-- FIN DE LAS NOTIFICACIONES -->

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

                // TRAEMOS JSON PURO, NUNCA HTML
                const resp = await fetch(`../controllers/get_usuario_ajax.php?id=${userId}`);
                const u = await resp.json();

                // Rellenas los inputs
                formEdit.NombreUsuario.value = u.NombreUsuario || '';
                formEdit.ApellidoPaterno.value = u.ApellidoPaterno || '';
                formEdit.ApellidoMaterno.value = u.ApellidoMaterno || '';
                formEdit.NumeroTelefono.value = u.NumeroTelefono || '';
                formEdit.Email.value = u.Email || '';
                // 4) Rellena departamento y puesto
                const depSel = formEdit.DepartamentoId;
                depSel.value = u.DepartamentoId || '';
                // Carga puestos y marca
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
    <script>
        document.getElementById('departamento').addEventListener('change', function () {
            const departamentoId = this.value;
            const puestoSelect = document.getElementById('puesto');

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
                            <input name="ApellidoMaterno" id="edit-ApellidoMaterno" type="text" class="form-control"
                                >
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <label>Departamento</label>
                            <select name="DepartamentoId" id="edit-DepartamentoId" class="form-control">
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <label>Puesto</label>
                            <select name="PuestoId" id="edit-PuestoId" class="form-control">
                                <option value="">Seleccione un puesto</option>
                            </select>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Teléfono celular</label>
                            <input name="NumeroTelefono" id="edit-NumeroTelefono" type="tel" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Email</label>
                            <input name="Email" id="edit-Email" type="email" class="form-control" required>
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
</body>

</html>