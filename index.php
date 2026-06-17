<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Drive Moto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg fixed-top">

        <div class="container">

            <a class="navbar-brand" href="#">
                DRIVE MOTO
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="menu">

                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item">
                        <a class="nav-link" href="#inicio">Inicio</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#beneficios">Beneficios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>

                    <li class="nav-item ms-3">

                        <a href="login.php" class="btn-login">
                            Iniciar Sesión
                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <!-- HERO -->

<section class="hero" id="inicio">

    <div class="container">

        <div class="row align-items-center min-vh-100">

            <div class="col-lg-6 text-center text-lg-start">

                <span class="badge-custom">
                    🚀 Disponible 24/7
                </span>

                <h1>
                    Transporte y Delivery
                    <span>Más Rápido</span>
                    en tu Ciudad
                </h1>

                <p>
                    Conecta clientes y motorizados en tiempo real.
                    Solicita viajes, envíos y delivery desde cualquier lugar.
                </p>

                <div class="hero-buttons">

                    <a href="register.php" class="btn-primary-custom">
                        Crear Cuenta
                    </a>

                    <a href="login.php" class="btn-secondary-custom">
                        Iniciar Sesión
                    </a>

                </div>

            </div>

            <div class="col-lg-6 text-center">

                <img src="img/moto.png" class="hero-image img-fluid">

            </div>

        </div>

    </div>

</section>

    <!-- STATS -->

    <section class="stats">

        <div class="container">

            <div class="row text-center">

                <div class="col-md-3">
                    <div class="stat-box">
                        <h2>10K+</h2>
                        <span>Usuarios</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-box">
                        <h2>5K+</h2>
                        <span>Viajes</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-box">
                        <h2>300+</h2>
                        <span>Motorizados</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-box">
                        <h2>24/7</h2>
                        <span>Servicio</span>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- SERVICIOS -->

    <section class="services" id="servicios">

        <div class="container">

            <h2 class="section-title">
                Nuestros Servicios
            </h2>

            <div class="row g-4">

                <div class="col-lg-3">
                    <div class="service-card">
                        <i class="bi bi-scooter"></i>
                        <h4>Taxi Moto</h4>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="service-card">
                        <i class="bi bi-box-seam"></i>
                        <h4>Delivery</h4>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="service-card">
                        <i class="bi bi-lightning-charge"></i>
                        <h4>Express</h4>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="service-card">
                        <i class="bi bi-building"></i>
                        <h4>Empresas</h4>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- BENEFICIOS -->

    <section class="benefits" id="beneficios">

        <div class="container">

            <h2 class="section-title">
                ¿Por qué elegirnos?
            </h2>

            <div class="row">

                <div class="col-lg-4">

                    <div class="benefit-card">

                        <i class="bi bi-clock-fill"></i>

                        <h4>Rapidez</h4>

                        <p>
                            Llegamos en minutos.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="benefit-card">

                        <i class="bi bi-shield-check"></i>

                        <h4>Seguridad</h4>

                        <p>
                            Conductores verificados.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="benefit-card">

                        <i class="bi bi-cash-coin"></i>

                        <h4>Precios Justos</h4>

                        <p>
                            Negociación transparente.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- CTA -->

    <section class="cta">

        <div class="container text-center">

            <h2>
                ¿Listo para comenzar?
            </h2>
<a href="register.php" class="btn-primary-custom">
    Crear Cuenta
</a>

        </div>

    </section>

    <!-- FOOTER -->

    <footer id="contacto">

        <div class="container">

            <h3>DRIVE MOTO</h3>

            <p>
                Plataforma moderna de transporte y delivery.
            </p>

            <p>
                © 2026 Todos los derechos reservados
            </p>

        </div>

    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>