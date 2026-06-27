<?php
require '../controllers/logica_usuario.php';

// Solo administradores
if (!isset($sesion['EsAdmin']) || $sesion['EsAdmin'] !== 1) {
    header('Location: dashboard.php');
    exit;
}

$alertHtml = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['registrarVacacion'])) {
        $alertHtml = RegistrarVacaciones($_POST, $pdo);
    }
    if (isset($_POST['eliminarVacacion'])) {
        $alertHtml = borrarVacacion($_POST, $pdo);
    }
    if (isset($_POST['editarVacacion'])) {
        $alertHtml = editarVacacion($_POST, $pdo);
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <style>
        #fechaFin-wrapper,
        #edit-fechaFin-wrapper {
            transition: opacity .2s;
        }

        #fechaFin-wrapper.hidden,
        #edit-fechaFin-wrapper.hidden {
            opacity: 0;
            pointer-events: none;
            height: 0;
            overflow: hidden;
            margin: 0 !important;
        }

        /* Evita que los switches traspasen barras laterales o modales ocultos */
        .form-switch .form-check-input {
            z-index: 0 !important;
        }

        /* O, si prefieres ser estricto y aplicarlo SOLO a ese switch en particular: */
        #edit-chk-solo-dia {
            z-index: 0 !important;
            position: relative;
        }
    </style>
    <title>RH | Gestión de Vacaciones</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">

    <!-- Sidenav (solo admin) -->
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand px-4 py-3 m-0" href="../pages/dashboard.php">
                <img src="../assets/img/favicon.ico" class="navbar-brand-img" width="26" height="26" alt="logo">
                <span class="ms-1 text-sm text-dark">Recursos Humanos</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
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
                    <a class="nav-link text-primary" href="../pages/organigrama.php">
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
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Administrador
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="../pages/usuarios.php">
                        <i class="material-symbols-rounded opacity-5">groups</i>
                        <span class="nav-link-text ms-1">Usuarios</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="../pages/panel_candidatos.php">
                        <i class="material-symbols-rounded opacity-5">group_add</i>
                        <span class="nav-link-text ms-1">Candidatos</span>
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
                <li class="nav-item">
                    <a class="nav-link active bg-gradient-primary text-white" href="../pages/vacaciones.php">
                        <i class="material-symbols-rounded opacity-5">beach_access</i>
                        <span class="nav-link-text ms-1">Vacaciones</span>
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
        <div class="sidenav-footer position-absolute w-100 bottom-0">
            <div class="mx-3">
                <a class="btn btn-outline mt-4 w-100 text-primary">
                    <i class="material-symbols-rounded opacity-5">explore</i>
                    <span class="nav-link-text ms-1">Vacantes</span>
                </a>
                <?= mostrarContador($pdo) ?>
            </div>
        </div>
    </aside>

    <div class="main-content position-relative max-height-vh-100 h-100">

        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">RRHH</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Vacaciones</li>
                    </ol>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
                    <ul class="navbar-nav d-flex align-items-center justify-content-end">
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
                                <img class="avatar avatar-lg me-3" <?= isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?>>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="../pages/profile.php">
                                        <div class="d-flex py-1">
                                            <div class="my-auto"><i class="material-symbols-rounded">user_attributes</i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">Perfil</h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-password">
                                        <div class="d-flex py-1">
                                            <div class="my-auto"><i class="material-symbols-rounded">password</i></div>
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
                                            <div class="my-auto"><i class="material-symbols-rounded">logout</i></div>
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
            <div class="page-header min-height-100 border-radius-xl mt-4"></div>

            <div class="card card-body mx-2 mx-md-2 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h3 class="mb-0 h3 font-weight-bolder">Gestión de Vacaciones</h3>
                            <p class="mb-0 font-weight-normal text-sm">
                                Registra, edita y consulta las vacaciones de los colaboradores.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Leyenda de badges -->
                <div class="d-flex gap-2 mt-3 ms-2 mb-2">
                    <span class="badge bg-gradient-success">En curso</span>
                    <span class="badge bg-gradient-info">Próximas</span>
                    <span class="badge bg-gradient-secondary">Concluidas</span>
                </div>

                <div class="card-body p-3">
                    <div class="card-body pt-2 p-3">
                        <ul class="list-group">
                            <?= getPanelVacaciones($pdo) ?>
                        </ul>
                    </div>
                </div>
            </div>

            <footer class="footer py-4">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>document.write(new Date().getFullYear())</script>,
                                Desarrollado por <a href="https://www.fast-net.com.mx" class="font-weight-bold"
                                    target="_blank">FastNet</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Plugin flotante: Registrar vacación -->
        <div class="fixed-plugin">
            <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
                <i class="material-symbols-rounded py-2">beach_access</i>
            </a>
            <div class="card shadow-lg">
                <div class="card-header pb-0 pt-3">
                    <div class="float-start">
                        <h5 class="mt-3 mb-0">Registrar vacaciones</h5>
                    </div>
                    <div class="float-end mt-4">
                        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                            <i class="material-symbols-rounded">clear</i>
                        </button>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <div class="card-body pt-sm-3 pt-0">
                    <form method="POST" id="form-registrar-vac">
                        <!-- Selector de usuario con Select2 -->
                        <div class="input-group input-group-static mb-4">
                            <label for="usuario-vacacion" class="ms-0">Empleado</label>
                            <select name="usuarioId" id="usuario-vacacion" class="form-control" style="width:100%">
                                <option value="">Buscar por nombre...</option>
                            </select>
                        </div>

                        <!-- Toggle: un día vs rango -->
                        <div class="form-check form-switch mb-3 ps-0 ms-auto">
                            <input class="form-check-input mt-1" type="checkbox" id="chk-solo-dia" name="esSoloDia"
                                value="1">
                            <label class="form-check-label text-body ms-2 mb-0" for="chk-solo-dia">
                                ¿Es un solo día?
                            </label>
                        </div>

                        <!-- Fecha de inicio -->
                        <div class="input-group input-group-static my-3">
                            <label id="label-inicio">Fecha de inicio</label>
                            <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" required>
                        </div>

                        <!-- Fecha de fin -->
                        <div class="input-group input-group-static my-3" id="fechaFin-wrapper">
                            <label>Fecha de regreso</label>
                            <input type="date" name="fechaFin" id="fechaFin" class="form-control">
                        </div>

                        <hr class="horizontal dark my-3">
                        <button type="submit" name="registrarVacacion"
                            class="btn bg-gradient-primary w-100 fixed-plugin-close-button">
                            Registrar
                        </button>
                    </form>
                    <?= $alertHtml ?>
                </div>
            </div>
        </div>

    </div><!-- end main-content -->


    <!-- MODAL CONFIRMAR BORRADO -->
    <div class="modal fade" id="modal-notification" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="material-symbols-rounded text-danger me-2">warning</i>
                    <h6 class="modal-title font-weight-normal">Alerta</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body text-center">
                    <i class="material-symbols-rounded h1 text-secondary">beach_access</i>
                    <h4 class="text-gradient text-danger mt-4">Atención</h4>
                    <p>Estás a punto de eliminar el registro de vacaciones de
                        <strong><span id="modal-vac-nombre"></span></strong>.
                        Si no tiene otras vacaciones activas, el usuario será reactivado automáticamente.
                        ¿Deseas continuar?
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST">
                        <input type="hidden" name="VacacionId" id="delete-vac-id">
                        <button type="submit" name="eliminarVacacion" class="btn bg-gradient-primary">Sí,
                            continuar</button>
                    </form>
                    <button type="button" class="btn btn-link text-primary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL BORRADO -->

    <!-- MODAL LOGOUT -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="logoutModalLabel">Cerrar sesión</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <p>Estás a punto de cerrar sesión.</p>
                        <p>¿Seguro que quieres continuar?</p>
                    </div>
                    <div class="modal-footer">
                        <button name="cerrarSesion" type="submit" class="btn bg-gradient-primary">Cerrar sesión</button>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL CAMBIAR CONTRASEÑA -->
    <div class="modal fade" id="modal-password" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nueva contraseña</label>
                            <input type="password" name="password1" autocomplete="new-password" class="form-control"
                                required onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Repetir contraseña</label>
                            <input type="password" name="password2" autocomplete="new-password" class="form-control"
                                required onfocus="focused(this)" onfocusout="defocused(this)">
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

    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
        }
    </script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>

    <script>
        // ── Select2 para buscar empleados ──────────────────────────────────
        $(document).ready(function () {
            $('#usuario-vacacion').select2({
                placeholder: 'Escribe el nombre...',
                minimumInputLength: 2,
                dropdownParent: $('.fixed-plugin .card-body'),
                ajax: {
                    url: '../controllers/logica_usuario.php',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term, buscar_empleado: 1 };
                    },
                    processResults: function (data) {
                        return { results: data.results };
                    }
                }
            });
        });

        // ── Toggle solo-día en formulario de REGISTRO ──────────────────────
        (function () {
            const chk = document.getElementById('chk-solo-dia');
            const wrap = document.getElementById('fechaFin-wrapper');
            const label = document.getElementById('label-inicio');
            const finInp = document.getElementById('fechaFin');

            function toggleFin() {
                if (chk.checked) {
                    wrap.classList.add('hidden');
                    finInp.removeAttribute('required');
                    label.textContent = 'Fecha del día';
                } else {
                    wrap.classList.remove('hidden');
                    finInp.setAttribute('required', 'required');
                    label.textContent = 'Fecha de inicio';
                }
            }
            chk.addEventListener('change', toggleFin);
            toggleFin(); // estado inicial
        })();

        // ── Toggle solo-día en modal de EDICIÓN ───────────────────────────
        (function () {
            const chk = document.getElementById('edit-chk-solo-dia');
            const wrap = document.getElementById('edit-fechaFin-wrapper');
            const label = document.getElementById('edit-label-inicio');
            const finInp = document.getElementById('edit-fechaFin');

            function toggleFin() {
                if (chk.checked) {
                    wrap.classList.add('hidden');
                    finInp.removeAttribute('required');
                    label.textContent = 'Fecha del día';
                } else {
                    wrap.classList.remove('hidden');
                    finInp.setAttribute('required', 'required');
                    label.textContent = 'Fecha de inicio';
                }
            }
            chk.addEventListener('change', toggleFin);
        })();

        // ── Poblar modal de EDICIÓN ────────────────────────────────────────
        document.getElementById('modal-edit').addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            const id = btn.getAttribute('data-vac-id');
            const nombre = btn.getAttribute('data-vac-nombre');
            const inicio = btn.getAttribute('data-vac-inicio');   // YYYY-MM-DD
            const fin = btn.getAttribute('data-vac-fin');
            const soloDia = btn.getAttribute('data-es-solo-dia') === '1';

            document.getElementById('edit-vac-id').value = id;
            document.getElementById('edit-vac-nombre').textContent = nombre;
            document.getElementById('edit-fechaInicio').value = inicio;
            document.getElementById('edit-fechaFin').value = fin;

            const chk = document.getElementById('edit-chk-solo-dia');
            const wrap = document.getElementById('edit-fechaFin-wrapper');
            const label = document.getElementById('edit-label-inicio');
            chk.checked = soloDia;
            if (soloDia) {
                wrap.classList.add('hidden');
                label.textContent = 'Fecha del día';
            } else {
                wrap.classList.remove('hidden');
                label.textContent = 'Fecha de inicio';
            }
        });

        // ── Poblar modal de BORRADO ────────────────────────────────────────
        document.getElementById('modal-notification').addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('modal-vac-nombre').textContent = btn.getAttribute('data-vac-nombre');
            document.getElementById('delete-vac-id').value = btn.getAttribute('data-vac-id');
        });
    </script>

</body>

</html>