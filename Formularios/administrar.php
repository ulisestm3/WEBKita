<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir al formulario de inicio de sesión
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KITA Te Cuida</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/stilo.css" rel="stylesheet" type="text/css">
    <style>
        /* Estilos personalizados */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .menu-fixed {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .content {
            margin-top: 80px; /* Espacio para alejar el contenido de la barra de navegación */
            text-align: center;
        }

        .navbar-toggle {
            border: none;
            background: transparent !important;
        }

        .navbar-toggle .icon-bar {
            width: 22px;
            transition: all 0.2s;
        }

        .navbar-toggle .top-bar {
            transform: rotate(45deg);
            transform-origin: 10% 10%;
        }

        .navbar-toggle .middle-bar {
            opacity: 0;
        }

        .navbar-toggle .bottom-bar {
            transform: rotate(-45deg);
            transform-origin: 10% 90%;
        }

        .navbar-toggle.collapsed .top-bar {
            transform: rotate(0);
        }

        .navbar-toggle.collapsed .middle-bar {
            opacity: 1;
        }

        .navbar-toggle.collapsed .bottom-bar {
            transform: rotate(0);
        }

        footer {
            margin-top: auto;
            background-color: #f8f9fa;
            padding: 20px 0;
        }

        .pie01 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }

        .pie02 {
            text-align: center;
            font-size: 14px;
            color:rgb(231, 209, 122);
        }
        .container-agregar {
    display: flex; /* Usa flexbox para organizar los elementos */
    gap: 20px; /* Espacio entre los elementos */
    justify-content: center; /* Centra los elementos horizontalmente */
    align-items: center; /* Alinea los elementos verticalmente */
    margin-top: 20px; /* Espacio superior opcional */
        }

        .img-agregar {
            text-align: center; /* Alinea el contenido (imagen y texto) al centro */
        }

        .img-agregar img {
            display: block; /* Asegura que la imagen esté en bloque */
            margin: 0 auto; /* Centra la imagen dentro del contenedor */
        }

        .img-agregar h5 {
            margin-top: 10px; /* Espacio entre la imagen y el texto */
            font-size: 16px; /* Tamaño de fuente ajustable */
            color: var(--color3); /* Usa un color consistente con tu diseño */
        }
    </style>
</head>
<body>
    <!-- INICIO DEL MENU DE NAVEGACIÓN -->
    <nav class="navbar navbar-default menu-fixed">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar top-bar"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>
                </button>
                <a class="navbar-brand">KITA</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="defaultNavbar1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="crudProductos.php">Productos</a></li>
                    <li><a href="crudCategorias.php">Categorías</a></li>
                    <li><a href="logout.php">Salir</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- FIN DEL MENÚ DE NAVEGACIÓN -->

    <!-- CONTENIDO PRINCIPAL -->
    <div class="content">
        <?php
        echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['usuario']) . "</h1>";
        echo "<p>Esta es la página de administración.</p>";
        echo '<a href="logout.php" class="btn btn-primary">Cerrar sesión</a>';
        ?>

<div class="container-agregar">
    <div class="img-agregar">
        <a href="crudProductos.php"><img src="../Images/anadir-articulo.png" alt="Administrar producto" width="80" height="80"></a>
        <h5>Productos</h5>
    </div>
    <div class="img-agregar">
        <a href="crudCategorias.php"><img src="../Images/categorias.png" alt="Administrar categoria" width="80" height="80"></a>
        <h5>Categorías</h5>
    </div>
</div>

    <!-- INICIO PIE DE PÁGINA -->
<footer>
	       <!--Sección 01-->
	       <section class="pie01">
            <div class="container">
               <div class="row" text align="left"> <!--Inicio de la 1ra Fila-->
                  <!--Mapa del Sitio-->
                  <div class="col-md-6">
                     <h4>Mapa del Sitio</h4>
                     <dl>
                        <dl>
                           <!--<dt><a href="index.html">Inicio</a></dt>-->
                           <dt><a href="quienessomos.html">Quiénes Somos</a></dt>
                           <dt><a href="PropositoYValores.html">La Empresa</a></dt>
                           <dt><a href="Productos.html">Productos</a></dt>
                           <dt><a href="contactenos.html">Contáctenos</a></dt>
                        </dl>
                     </dl>
                  </div>
                  <!--Datos de Contactos-->
                  <div class="col-md-6">
                     <h4>Datos de Contacto</h4>
                     <address>
                         Dirección: Semáforos de Villa Fontana<br> 
                         <abbr title="phone">Teléfono: </abbr>(+505) 2234-5678<br> 
                         E-mail:<a href="ventas.jabonkita@gmail.com"> ventas.jabonkita@gmail.com</a><br> 
                         Horario de atención: 8:00 a.m - 5:00 p.m<br> 
                         Facebook ׀ Twitter 
                     </address>
                  </div>
               </div><!--Cierre de la Fila-->
           </div>
        </section>
 
	
	       <!--Sección 02-->
	       <section class="pie02">
	           <div class="container">
			     &copy; Copyright 2025 Kita	
		       </div>
	       </section>
</footer>
<!-- FIN PIE DE PÁGINA -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="js/jquery-1.11.3.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="js/bootstrap.js"></script>

</body>
</html>