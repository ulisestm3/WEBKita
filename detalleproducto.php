<?php
// Conexión a la base de datos
require_once 'conexion.php';

// Verificar si se ha enviado el ID del producto
if (isset($_POST['txtID'])) {
    $idProducto = $_POST['txtID'];

    // Consulta para obtener los detalles del producto específico
    $sql = "SELECT * FROM tblproductos WHERE IDProducto = $idProducto AND Activo = 1";
    $resultado = mysqli_query($enlace, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $producto = mysqli_fetch_assoc($resultado);
    } else {
        echo "No se encontró el producto.";
        exit;
    }
} else {
    echo "ID de producto no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KITA-DETALLEPRODUCTO Te Cuida</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/stilo.css" rel="stylesheet" type="text/css">
    <link href="js/mai.js" rel="stylesheet">
    <style>
    .card-custom {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .card-custom img {
        object-fit: cover;
        height: 200px; /* Altura inicial de la imagen */
        transition: transform 0.3s ease, height 0.3s ease; /* Transición suave */
    }
    .card-custom img:hover {
        transform: scale(1.5); /* Escala la imagen al 150% */
        height: auto; /* Permite que la imagen se expanda */
    }
    .card-custom .card-body {
        padding: 15px;
    }
    .card-custom .card-title {
        font-size: 1.1em;
        margin-bottom: 10px;
    }
</style>

</head>
<body>
    <nav class="navbar navbar-default menu-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.html" class="navbar-brand">KITA</a>
            </div>
            <div class="collapse navbar-collapse" id="defaultNavbar1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="QuienesSomos.html">Quiénes Somos</a></li>
                    <li><a href="Productos.php">Productos</a></li>
                    <li><a href="PropositoYValores.html">Proposito Y Valores</a></li>
                    <li><a href="Contactenos.html">Contáctenos</a></li>
                    <li><a href="Formularios/login.php">Administrar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="productos" class="seccion">
        <div class="container">
            <h2 class="titulo-seccion">Detalle de Producto</h2>

             <div class="container producto-container">
            <h4>Código: <?php echo $producto['IDProducto']; ?></h4>
            <h3><?php echo $producto['Nombre']; ?></h3>
            <h4><?php echo $producto['Descripcion']; ?></h4>
            <h4>Precio: C$ <?php echo $producto['Precio']; ?></h4>
            <br>
            <form action="/admin/carrito/agregar/<?php echo $producto['IDProducto']; ?>" method="post">
                <button class="btn btn-primary comprar-btn">Agregar al carrito <i class="fas fa-shopping-cart"></i></button>
            </form>
            <br>
            <img src="<?php echo $producto['Img1']; ?>" class="card-img-top" alt="<?php echo $producto['Img1']; ?>" style="width: 100%;">
            <img src="<?php echo $producto['Img2']; ?>" class="card-img-top" alt="<?php echo $producto['Img2']; ?>" style="width: 100%;">
            <img src="<?php echo $producto['Img3']; ?>" class="card-img-top" alt="<?php echo $producto['Img3']; ?>" style="width: 100%;">
        </div>
         </div>
        </section>
        <footer>
        <section class="pie01">
            <div class="container">
                <div class="row" text align="left">
                    <div class="col-md-6">
                        <h4>Mapa del Sitio</h4>
                        <dl>
                            <dl>
                                <dt><a href="quienessomos.html">Quiénes Somos</a></dt>
                                <dt><a href="PropositoYValores.html">La Empresa</a></dt>
                                <dt><a href="Productos.html">Vehículos</a></dt>
                                <dt><a href="contactenos.html">Contáctenos</a></dt>
                            </dl>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <h4>Datos de Contacto</h4>
                        <address>
                            Dirección: Semáforos de Villa Fontana<br>
                            <abbr title="phone">Teléfono: </abbr>(+505) 2234-5678<br>
                            E-mail:<a href="mailto:info@kia.com.ni"> info@kia.com.ni</a><br>
                            Horario de atención: 8:00 a.m - 5:00 p.m<br>
                            Facebook ׀ Twitter
                        </address>
                    </div>
                </div>
            </div>
        </section>

        <section class="pie02">
            <div class="container">
                &copy; Copyright 2025 Kita
            </div>
        </section>
    </footer>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>

<?php mysqli_close($enlace); ?>
