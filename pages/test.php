<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <title>
        Recursos Humanos
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

<body class="bg-gray-200">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->

                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('../assets/img/bg-sign-in.jpg');">
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Iniciar Sesión</h4>
                                </div>
                            </div> <br>

                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab"
                                            href="#profile-tabs-icons" role="tab" aria-controls="preview"
                                            aria-selected="true">
                                            <span class="material-symbols-rounded align-middle mb-1">
                                                badge
                                            </span>
                                            Empleados
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab"
                                            href="#dashboard-tabs-icons" role="tab" aria-controls="code"
                                            aria-selected="false">
                                            <span class="material-symbols-rounded align-middle mb-1">
                                                person_check
                                            </span>
                                            Candidatos
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="tab-content">

                                <div class="card-body tab-pane fade show active" id="profile-tabs-icons">
                                    <form role="form" class="text-start" method="POST">
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Usuario</label>
                                            <input type="text" name="username" class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label" type="password">Contraseña</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-check form-switch d-flex align-items-center mb-3">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label mb-0 ms-3" for="rememberMe">Recordar
                                                usuario</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="login"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">Entrar</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-body tab-pane fade" id="dashboard-tabs-icons">
                                    <form role="form" class="text-start" method="POST">
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Nombre completo</label>
                                            <input type="text" name="fullname" class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Número de teléfono</label>
                                            <input type="tel" name="tel" class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label" type="password">Correo electrónico</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label" type="password">Edad</label>
                                            <input type="number" name="age" class="form-control">
                                        </div>
                                        <div class="input-group input-group-static mb-4 ">
                                            <label for="exampleFormControlSelect1" class="ms-0">¿A qué base está
                                                aplicando?</label>
                                            <select name="Base" class="form-control" id="exampleFormControl2" required>
                                                <option value="" selected>Seleccionar</option>
                                                <option>Allende</option>
                                                <option>Chihuahua</option>
                                                <option>Ciudad del carmen</option>
                                                <option>Comalcalco</option>
                                                <option>Cunduacán </option>
                                                <option>Delicias</option>
                                                <option>Jalapa</option>
                                                <option>Jalpa de Méndez</option>
                                                <option>Lázaro Cárdenas</option>
                                                <option>Mérida</option>
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
                                        <div class="input-group input-group-static mb-4 ">
                                            <label for="exampleFormControlSelect1" class="ms-0">¿A qué puesto está
                                                aplicando?</label>
                                            <select name="Puesto" class="form-control" id="exampleFormControl2" required>
                                                <option value="" selected>Seleccionar</option>
                                                <option>Abogado</option>
                                                <option>Auxiliar Contable</option>
                                                <option>Desarrollo de Software</option>
                                                <option>Diseñador/a Gráfico</option>
                                                <option>Ejecutivo de ventas empresarial</option>
                                                <option>Agente Call Center</option>
                                                <option>Mesa de Control</option>
                                                <option>Auxiliar de cobranza</option>
                                                <option>Técnico/a</option>
                                                <option>Cajero/a</option>
                                                <option>Limpieza</option>
                                                <option>Monitorista NOC</option>
                                                <option>Ayudante de Técnico</option>
                                                <option>Construcción</option>
                                                <option>Coach de Ventas</option>
                                                <option>Agente de Cambaceo</option>
                                                <option>Mantenimiento</option>
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="candidato"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">Entrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-6 my-auto">
                            <div class="copyright text-center text-sm text-white text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                Desarrollado por
                                <a href="https://www.fast-net.com.mx" class="font-weight-bold text-white"
                                    target="_blank">FastNet</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
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
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // IDs: inputs must tener name/ID username, password y checkbox rememberMe
        const usernameInput = document.querySelector('input[name="username"]');
        const passwordInput = document.querySelector('input[name="password"]');
        const rememberCheckbox = document.getElementById('rememberMe');

        // Al cargar, rellena si existe
        document.addEventListener('DOMContentLoaded', () => {
            const savedUser = localStorage.getItem('rh_username');
            if (savedUser) usernameInput.value = savedUser;
            const savedPass = localStorage.getItem('rh_password');
            if (savedPass) passwordInput.value = savedPass;
            const remember = localStorage.getItem('rh_remember') === '1';
            rememberCheckbox.checked = remember;
        });

        // Al enviar el formulario
        document.querySelector('form').addEventListener('submit', () => {
            if (rememberCheckbox.checked) {
                localStorage.setItem('rh_username', usernameInput.value);
                localStorage.setItem('rh_password', passwordInput.value);
                localStorage.setItem('rh_remember', '1');
            } else {
                localStorage.removeItem('rh_username');
                localStorage.removeItem('rh_password');
                localStorage.setItem('rh_remember', '0');
            }
        });
    </script>
</body>

</html>