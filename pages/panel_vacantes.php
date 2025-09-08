<?php
require '../controllers/logica_vacantes.php';
$alertHtml = '';
// Registro de usuario (formulario principal flotante)
if (isset($_POST['registrarVacante'])) {
    $alertHtml = RegistrarVacante($_POST, $pdo);
}
if (isset($_POST['editarVacante'])) {
    $alertHtml = actualizarVacante($_POST, $pdo);
}
$vacanteId = isset($_GET['vacante_id'])
    ? (int) $_GET['vacante_id']
    : 0;

$filterDept = $_GET['departamento'] ?? '';
$departamentos = GetDepartamento($pdo);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <style>
        .pre-wrap {
            white-space: pre-wrap;
            /* Preserva saltos de línea */
            word-break: break-word;
            /* Ajusta líneas largas */
        }
    </style>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <title>
        RH | Registro de Vacantes
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
                    <a class="nav-link text-primary" href="../pages/felicitaciones.html">
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
                    <a class="nav-link active bg-gradient-primary text-white" href="../pages/panel_vacantes.php">
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
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
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
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Vacantes</li>
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
                                <li>
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
                style="background-image: url('../assets/img/illustrations/banner-vacantes.jpg');">
                <span class="mask  bg-gradient-dark  opacity-6"></span>
            </div>
            <div class="card card-body mx-2 mx-md-2 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h3 class="mb-0 h3 font-weight-bolder">
                                Registro de vacantes
                            </h3>
                            <p class="mb-0 font-weight-normal text-sm">
                                Consulte, edite y registre información de las vacantes activas en el sistema.
                            </p>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Puesto</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Departamento</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Descripción</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Fecha de ingreso</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= GetTableVacantes($pdo) ?>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>

                <!--MODAL PARA VER LAS RECOMENDACIONES-->
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-normal" id="exampleModalLongTitle">Recomendaciones
                                </h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body font-weight-light">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nombre</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Número</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    CV</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Quien recomienda</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= GetTableRecomendaciones($pdo, $vacanteId) ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-primary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN DEL MODAL DE RECOMENDACIONES-->

                <!-- Script para ver los documentos en la misma página -->
                <script>
                    function verPDFSweetAlert(url) {
                        Swal.fire({
                            title: 'Vista previa del CV',
                            html: `<iframe src="${url}" width="100%" height="700px" style="border:none;"></iframe>`,
                            width: '75%',
                            showCloseButton: true,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'swal2-pdf-modal'
                            }
                        });
                    }
                </script>
                <!--Fin del Script para ver documentos-->
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
                                <a href="https://www.fast-net.com.mx" class="font-weight-bold"
                                    target="_blank">Fast-net</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

        <div class="fixed-plugin">
            <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
                <i class="material-symbols-rounded py-2">forms_add_on</i>
            </a>
            <div class="card shadow-lg">
                <div class="card-header pb-0 pt-3">
                    <div class="float-start">
                        <h5 class="mt-3 mb-0">Añadir nueva vacante</h5>
                    </div>
                    <div class="float-end mt-4">
                        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                            <i class="material-symbols-rounded">clear</i>
                        </button>
                    </div>
                    <!-- End Toggle Button -->
                </div>
                <hr class="horizontal dark my-1">
                <div class="card-body pt-sm-3 pt-0">

                    <!-- Navbar Fixed -->
                    <form method="POST">
                        <div class="input-group input-group-static mb-4">
                            <label>Departamento</label>
                            <select name="DepartamentoId" id="departamento-vacante" class="form-control" required>
                                <option value="">Seleccionar</option>
                                <?= GetListaDepartamentos($departamentos) ?>
                            </select>
                        </div>
                        <!-- Selección dinámica de puesto -->
                        <div class="input-group input-group-static mb-4">
                            <label>Puesto</label>
                            <select name="PuestoId" id="puesto-vacante" class="form-control">
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                        <div class="input-group input-group-dynamic ">
                            <textarea class="form-control" rows="10" name="descripcionVacante" id="descripcion-vacante"
                                placeholder="Escriba una pequeña descripcion de lo que trata el puesto."
                                spellcheck="false"></textarea>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Fecha de ingreso</label>
                            <input type="date" name="fechaIngreso" id="fecha-ingreso" class="form-control">
                        </div>
                        <hr class="horizontal dark my-3">
                        <button type="submit" name="registrarVacante"
                            class="btn bg-gradient-primary w-100 toast-btn fixed-plugin-close-button">
                            Registrar Vacante</button>
                    </form>
                    <?= $alertHtml ?>

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
        <script>
            document.getElementById('departamento-vacante').addEventListener('change', function () {
                const departamentoId = this.value;
                const puestoSelect = document.getElementById('puesto-vacante');

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
        <!--MODAL PARA EDITAR VACANTE-->
        <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-default"
            aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title font-weight-normal" id="modal-title-default">
                            Editar información</h6>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Editando la información de la vacante para
                        <p id="vacante-nombre" name="vacante-nombre"></p>
                        </p>
                        <form method="POST" id="form-edit-vacante">
                            <input type="hidden" name="VacanteId" value="">

                            <div class="input-group input-group-dynamic ">
                                <textarea class="form-control" rows="10" name="Descripcion"
                                    placeholder="Escriba una pequeña descripcion de lo que trata el puesto."
                                    spellcheck="false"></textarea>
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Fecha de ingreso</label>
                                <input type="date" name="FechaIngreso" class="form-control">
                            </div>
                            <div class="input-group input-group-static mb-4 ">
                                <input type="checkbox" id="chk-status" name="Status" value="1">
                                <label for="chk-status" class="ms-0">¿Está
                                    Activa?</label>
                            </div>
                            <hr class="horizontal dark my-3">
                            <div class="text-center">
                                <button type="submit" name="editarVacante"
                                    class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0 toast-btn"
                                    data-bs-dismiss="modal" data-target="successToast">Guardar
                                    información</button>
                                <button type="button" class="btn btn-link text-primary ml-auto"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--FIN DEL MODAL PARA EDITAR VACANTE-->
        <script>
            const modal = document.getElementById('modal-edit');
            modal.addEventListener('show.bs.modal', function (event) {
                const btn = event.relatedTarget;
                const vacanteId = btn.getAttribute('data-vacante-id');
                const descripcion = btn.getAttribute('data-descripcion');
                const fechaIngreso = btn.getAttribute('data-fecha');
                const statusChecked = btn.getAttribute('data-status') === '1';
                const puestoNombre = btn.getAttribute('data-puesto-nombre');

                modal.querySelector('input[name="VacanteId"]').value = vacanteId;
                modal.querySelector('textarea[name="Descripcion"]').value = descripcion;
                modal.querySelector('input[name="FechaIngreso"]').value = fechaIngreso;

                // Apuntar al checkbox por su ID y marcar/desmarcar
                const chk = modal.querySelector('#chk-status');
                chk.checked = statusChecked;
                modal.querySelector('#vacante-nombre').textContent = puestoNombre;
            });
        </script>
        <!-- Script para ver los documentos en la misma página -->
        <script>
            function verPDFSweetAlert(url) {
                Swal.fire({
                    title: 'Vista previa del manual',
                    html: `<iframe src="${url}" width="100%" height="700px" style="border:none;"></iframe>`,
                    width: '70%',
                    showCloseButton: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal2-pdf-modal'
                    }
                });
            }
        </script>
        <!--Fin del script para ver documentos-->
        <script>
            // Espera a que el DOM esté listo
            document.addEventListener('DOMContentLoaded', function () {
                const modalEl = document.getElementById('exampleModalLong');

                modalEl.addEventListener('show.bs.modal', function (event) {
                    // Botón que disparó el modal
                    const button = event.relatedTarget;
                    const vacId = button.getAttribute('data-vacante-id');
                    const tbody = modalEl.querySelector('tbody');

                    tbody.innerHTML = '<tr><td colspan="4" class="text-center">Cargando…</td></tr>';

                    // fetch en lugar de $.get
                    fetch('../controllers/ver_recomendaciones.php?id=' + vacId)
                        .then(resp => {
                            if (!resp.ok) throw new Error('Network error');
                            return resp.text();
                        })
                        .then(html => { tbody.innerHTML = html; })
                        .catch(() => {
                            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Error al cargar</td></tr>';
                        });
                });
            });
        </script>
</body>

</html>