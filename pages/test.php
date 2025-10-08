<!DOCTYPE html>
<?php
require '../controllers/dashboard.php';
?>
<html lang="es">

<head>
    <style>
        /* 1.3 Cuando el <li> tenga .active mostramos tooltip */
        .tree li.active .tooltip {
            display: block;
        }

        /* (Opcional) si quieres desplegar la lista también bajo el árbol */
        .tree li.active>ul {
            display: block;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .tree-container {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            /* Alinea los árboles por su tope */
            gap: 10px;
            /* Separación horizontal */
            padding: 5px;
            overflow-x: auto;
            /* Scroll horizontal si desborda */
            width: 100%;
        }

        .tree {
            flex: 0 0 auto;
            /* Cada árbol mantiene su ancho mínimo */
            min-width: 100px;
            /* Ajusta según tu diseño */
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
            transition: .5s;
        }

        .tree li {
            display: inline-table;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 5px;
            transition: .5s;
        }

        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #ccc;
            width: 51%;
            height: 15px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #ccc;
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 1px solid #ccc;
            border-radius: 0px 5px 0px 0px;
        }

        .tree li:first-child::after {
            border-radius: 5px 0px 0px 0px;
        }

        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1px solid #ccc;
            width: 0;
            height: 20px;
        }

        .tree p {
            border: 1px solid #ccc;
            padding: 6px;
            display: inline-grid;
            border-radius: 5px;
            text-decoration-line: none;
            border-radius: 5px;
            transition: .5s;
        }

        .tree p img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px !important;
            border-radius: 100px;
            margin: auto;
        }

        .tree p span {
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #666;
            padding: 4px 6px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        /* Hover */
        .tree li p:hover,
        .tree li p:hover img,
        .tree li p:hover span,
        .tree li p:hover+ul li p {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
            box-shadow: 0px 0px 8px -5px #5f5f5f;
        }

        .tree li p:hover+ul li::after,
        .tree li p:hover+ul li::before,
        .tree li p:hover+ul::before,
        .tree li p:hover+ul ul::before {
            border-color: #94a0b4;
        }
    </style>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>
        RH | Organigrama
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
                    <span class="nav-link-text ms-1">Inicio</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/politicas.php">
                    <i class="material-symbols-rounded opacity-5">policy</i>
                    <span class="nav-link-text ms-1">Políticas</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/reglamento_interno.php">
                    <i class="material-symbols-rounded opacity-5">rule</i>
                    <span class="nav-link-text ms-1">Reglamento Interno</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/procesos.php">
                    <i class="material-symbols-rounded opacity-5">receipt_long</i>
                    <span class="nav-link-text ms-1">Procesos</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link active bg-gradient-primary text-white" href="../pages/organigrama.php">
                    <i class="material-symbols-rounded opacity-5">globe_book</i>
                    <span class="nav-link-text ms-1">Organigrama</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/mision_vision.php">
                    <i class="material-symbols-rounded opacity-5">public</i>
                    <span class="nav-link-text ms-1">Misión, Visión</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/valores.php">
                    <i class="material-symbols-rounded opacity-5">psychology</i>
                    <span class="nav-link-text ms-1">Valores</span>
                </a>
                </li>
                <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Administrador</h6>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/usuarios.php">
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
                <a class="nav-link text-primary" href="../pages/felicitaciones.php">
                    <i class="material-symbols-rounded opacity-5">celebration</i>
                    <span class="nav-link-text ms-1">Felicitaciones</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/campanias.php">
                    <i class="material-symbols-rounded opacity-5">campaign</i>
                    <span class="nav-link-text ms-1">Campañas</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/panel_vacantes.php">
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
                <a class="nav-link text-primary" href="../pages/nom035.php">
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
                    ' . mostrarContador($pdo) . '
                </div>
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
                <a class="nav-link text-primary" href="../pages/dashboard.php">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Inicio</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/politicas.php">
                    <i class="material-symbols-rounded opacity-5">policy</i>
                    <span class="nav-link-text ms-1">Políticas</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/reglamento_interno.php">
                    <i class="material-symbols-rounded opacity-5">rule</i>
                    <span class="nav-link-text ms-1">Reglamento Interno</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/procesos.php">
                    <i class="material-symbols-rounded opacity-5">receipt_long</i>
                    <span class="nav-link-text ms-1">Procesos</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link active bg-gradient-primary text-white" href="../pages/organigrama.php">
                    <i class="material-symbols-rounded opacity-5">globe_book</i>
                    <span class="nav-link-text ms-1">Organigrama</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/mision_vision.php">
                    <i class="material-symbols-rounded opacity-5">public</i>
                    <span class="nav-link-text ms-1">Misión, Visión</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-primary" href="../pages/valores.php">
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
                <a class="nav-link text-primary" href="../pages/nom035.php">
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
                    ' . mostrarContador($pdo) . '
                </div>
            </div>
        </aside>';
    }
    ?>

    <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">RRHH</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Organigrama</li>
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
                                <img <?php echo isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?> class="avatar avatar-lg  me-3 ">
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
                                        data-bs-target="#modal-password">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="material-symbols-rounded">password</i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">Cambiar contraseña</h6>
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
            <div class="page-header min-height-100 border-radius-xl mt-4">
            </div>
            <div class="card card-body mx-2 mx-md-2 mt-n6 p-3">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="../assets/img/favicon.ico" alt="Logo de FastNet" class="w-100 shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h3 class="mb-0 h3 font-weight-bolder">
                                Organigrama
                            </h3>
                        </div>
                    </div>
                    <div class="card-body p-3 card text-white border-0">
                        <div class="tree-container">
                            <div class="tree">
                                <ul>
                                    <li> <?= getContenedorPuesto(22, $pdo) ?>
                                        <ul>
                                            <li data-toggle="tooltip" data-original-title="Recomendaciones"
                                                target="_blank" data-bs-toggle="modal"
                                                data-bs-target="#construccion"
                                            ><?= getContenedorPuesto(6, $pdo) ?>
                                                <ul>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png"
                                                                alt=""><span>Construcción</span></p>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><?= getContenedorPuesto(39, $pdo) ?>
                                                <ul>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png" alt="">
                                                            <span>Técnicos</span>
                                                            <span>Cajera</span>
                                                            <span>Agentes de cambaceo</span>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><?= getContenedorPuesto(48, $pdo) ?>
                                            </li>
                                            <li data-toggle="tooltip" data-original-title="Recomendaciones"
                                                target="_blank" data-bs-toggle="modal"
                                                data-bs-target="#lidernoc">
                                                <?= getContenedorPuesto(32, $pdo) ?>
                                                <ul>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png"
                                                                alt=""><span>Líder
                                                                NOC</span></p>
                                                    </li>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png"
                                                                alt=""><span>Monitoristas
                                                                NOC</span></p>
                                                    </li>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png"
                                                                alt=""><span>Desarrollo de
                                                                Software</span></p>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><?= getContenedorPuesto(60, $pdo) ?>
                                                <ul>
                                                    <li><?= getContenedorPuesto(74, $pdo) ?>
                                                        <ul>
                                                            <li>
                                                                <p><img src="../assets/img/small-logos/user.png"
                                                                        alt=""><span>Técnicos</span>
                                                                    <span>Cajera</span>
                                                                    <span>Agentes de cambaceo</span>
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li><?= getContenedorPuesto(108, $pdo) ?>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li> <?= getContenedorPuesto(69, $pdo) ?>
                                            </li>
                                            <li data-toggle="tooltip" data-original-title="Recomendaciones"
                                                target="_blank" data-bs-toggle="modal"
                                                data-bs-target="#centro"> <?= getContenedorPuesto(2, $pdo) ?>
                                                <ul>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png"
                                                                alt=""><span>Técnicos</span></p>
                                                    </li>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png"
                                                                alt=""><span>Supervisor Call
                                                                Center</span></p>
                                                        <ul>
                                                            <li>
                                                                <p><img src="../assets/img/small-logos/user.png"
                                                                        alt=""><span>Agentes
                                                                        Call Center</span></p>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png"
                                                                alt=""><span>Supervisor Mesa
                                                                Técnica</span></p>
                                                        <ul>
                                                            <li>
                                                                <p><img src="../assets/img/small-logos/user.png"
                                                                        alt=""><span>Mesa
                                                                        Técnica</span></p>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><?= getContenedorPuesto(40, $pdo) ?>
                                            </li>
                                            <li><?= getContenedorPuesto(64, $pdo) ?>
                                                <ul>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png"
                                                                alt=""><span>Mantenimiento</span></p>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><?= getContenedorPuesto(33, $pdo) ?>
                                                <ul>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png"
                                                                alt=""><span>Técnicos</span>
                                                            <span>Cajeras</span>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tree-container">
                            <div class="tree">
                                <ul>
                                    <li><?= getContenedorPuesto(23, $pdo) ?>
                                        <ul>
                                            <li><?= getContenedorPuesto(30, $pdo) ?>
                                            </li>
                                            <li><?= getContenedorPuesto(4, $pdo) ?></li>
                                            <li><?= getContenedorPuesto(142, $pdo) ?></li>
                                            <li> <?= getContenedorPuesto(123, $pdo) ?>
                                            </li>
                                            <li> <?= getContenedorPuesto(125, $pdo) ?>
                                            </li>
                                            <li> <?= getContenedorPuesto(124, $pdo) ?>
                                                <ul>
                                                    <li> <?= getContenedorPuesto(116, $pdo) ?></li>
                                                </ul>
                                            </li>
                                            <li> <?= getContenedorPuesto(71, $pdo) ?>
                                                <ul>
                                                    <li><?= getContenedorPuesto(91, $pdo) ?>
                                                        <ul>
                                                            <li><?= getContenedorPuesto(25, $pdo) ?></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li> <?= getContenedorPuesto(5, $pdo) ?>
                                                <ul>
                                                    <li> <?= getContenedorPuesto(92, $pdo) ?> </li>
                                                </ul>
                                            </li>
                                            <li data-toggle="tooltip" data-original-title="Recomendaciones"
                                                target="_blank" data-bs-toggle="modal"
                                                data-bs-target="#carmen"> <?= getContenedorPuesto(61, $pdo) ?>
                                                <ul>
                                                    <li>
                                                        <p><img src="../assets/img/small-logos/user.png">
                                                            <span>Técnicos</span>
                                                            <span>Cajera</span>
                                                            <span>Agentes de cambaceo</span>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <footer class="footer py-4">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            Desarrollado por
                            <a href="https://www.fast-net.com.mx" class="font-weight-bold" target="_blank">FastNet</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script src="../assets/js/settings.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
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

    <!--MODAL CAMBIAR CONTRASEÑA-->
    <div class="modal fade" id="modal-password" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Cambiar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form role="form text-left" method="post">
                    <div class="modal-body">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nueva contraseña</label>
                            <input type="password" name="password1" autocomplete="new-password" autofocus=""
                                class="form-control" required="" id="id_password1" onfocus=" focused(this)"
                                onfocusout="defocused(this)">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Repetir contraseña</label>
                            <input type="password" name="password2" autocomplete="new-password" class="form-control"
                                required="" id="id_password2" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="actualizarPass" class="btn bg-gradient-primary">Cambiar</button>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--FIN DEL MODAL PARA CAMBIAR CONTRASEÑA-->

    <!--MODAL PARA VER LAS PERSONAS A CARGO-->

    <?= getModalSubordinados("lidernoc", [44, 23, 4], ["Villahermosa"], $pdo) ?>

    <?= getModalSubordinados("construccion", [27], ["Villahermosa"], $pdo) ?>

    <?= getModalSubordinados("carmen", [24, 25, 37, 38, 17, 40], ["Ciudad del carmen"], $pdo) ?>

    <?= getModalSubordinados("centro", [24, 25, 37, 38, 12, 14, 13, 15], ["Villahermosa"], $pdo) ?>
    
    <!--FIN DEL MODAL DE LAS PERSONAS A CARGO -->

</body>

</html>