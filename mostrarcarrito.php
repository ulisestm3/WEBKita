<?php
include 'carrito.php';

// Conexión a la base de datos
require_once 'conexion.php';

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

<br>
<br>
<br>
<br>
<h3 class="text-center">Productos del carrito</h3>

<a href="">Carrito (<?php echo (empty($_SESSION['CARRITO'])?0:count($_SESSION['CARRITO']));?>)</a>

<?php if(!empty($_SESSION['CARRITO'])) {; ?>

<table class="table table-light table-bordered">
    <tbody>
        <tr>
            <th width="40%">Descripción</th>
            <th width="15%" class="text-center">Cantidad</th>
            <th width="20%" class="text-center">Precio</th>
            <th width="20%" class="text-center">Total</th>
            <th width="5%">Acción</th>
        </tr>
        <?php $total=0; ?>
        <?php foreach($_SESSION['CARRITO'] as $indice=>$producto){ ?>
        <tr>
            <td width="40%"><?php echo $producto['NOMBRE']?></td>
            <td width="15%" class="text-center"><?php echo $producto['CANTIDAD']?></td>
            <td width="20%" class="text-center">C$ <?php echo $producto['PRECIO']?></td>
            <td width="20%" class="text-center">C$ <?php echo number_format($producto['PRECIO']*$producto['CANTIDAD'],2) ?></td>
            <td width="5%"> 
                <form action="mostrarcarrito.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $producto['ID'] ?>">
                    <button
                    class="btn btn-danger"
                    type="submit"
                    name="btnAccion"
                    value="Eliminar"
                    >Eliminar</button>
                </form>
            </td>
            
        </tr>
        <?php $total=$total+($producto['PRECIO']*$producto['CANTIDAD']); ?>
        <?php } ?>
        <tr>
            <td colspan="3" align="right"><h3>Total</h3></td>
            <td align="right"><h3><?php echo number_format($total,2);?></h3></td>
            <td></td>
        </tr>
        
    </tbody>
</table>

<?php }else{ ?>
    <div class="alert alert-success">
        No hay productos en el carrito
</div>
<?php  } ?>
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
