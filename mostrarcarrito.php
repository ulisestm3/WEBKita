<?php
include 'carrito.php'; // Aquí ya debe estar la lógica de aumentar/disminuir productos

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
            height: 200px;
            transition: transform 0.3s ease, height 0.3s ease;
        }
        .card-custom img:hover {
            transform: scale(1.5);
            height: auto;
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
                    <li><a href="mostrarcarrito.php">Carrito (<?php echo (empty($_SESSION['CARRITO']) ? 0 : count($_SESSION['CARRITO'])); ?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

<br><br><br><br>
<h3 class="text-center">Productos del carrito</h3>

<?php if (!empty($_SESSION['CARRITO'])) { ?>
<table class="table table-light table-bordered">
    <tbody>
        <tr>
            <th width="40%">Descripción</th>
            <th width="15%" class="text-center">Cantidad</th>
            <th width="20%" class="text-center">Precio</th>
            <th width="20%" class="text-center">Total</th>
            <th width="5%">Acción</th>
        </tr>
        <?php $total = 0; ?>
        <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
        <tr>
            <td><?php echo $producto['NOMBRE']; ?></td>
            
            <td class="text-center">
                <!-- Botón para disminuir cantidad -->
                <form action="mostrarcarrito.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $producto['ID']; ?>">
                    <button type="submit" name="btnAccion" value="Disminuir" class="btn btn-warning btn-xs">−</button>
                </form>

                <!-- Input de cantidad -->
            <form action="mostrarcarrito.php" method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $producto['ID']; ?>">
                <input type="number" name="cantidad" value="<?php echo $producto['CANTIDAD']; ?>" min="1" class="form-control input-sm text-center" style="width: 60px; display: inline-block;" onchange="this.form.submit()">
            </form>


                <!-- Botón para aumentar cantidad -->
                <form action="mostrarcarrito.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $producto['ID']; ?>">
                    <button type="submit" name="btnAccion" value="Aumentar" class="btn btn-success btn-xs">+</button>
                </form>
            </td>

            <td class="text-center">C$ <?php echo $producto['PRECIO']; ?></td>
            <td class="text-center">C$ <?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'], 2); ?></td>
            <td>
                <!-- Botón para eliminar producto -->
                <form action="mostrarcarrito.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $producto['ID']; ?>">
                    <button class="btn btn-danger" type="submit" name="btnAccion" value="Eliminar">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php $total += $producto['PRECIO'] * $producto['CANTIDAD']; ?>
        <?php } ?>
        <tr>
            <td colspan="3" align="right"><h3>Total</h3></td>
            <td align="right"><h3>C$ <?php echo number_format($total, 2); ?></h3></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">
                <form action="pagar.php" method="post">
                    <div class="alert alert-success" role="alert">
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input id="email" class="form-control" type="email" name="email" placeholder="Escribe tu correo" required>
                        </div>
                        <small id="emailhelp" class="form-text text-muted">Los productos se enviarán a este correo.</small>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="btnAccion">Proceder a pagar</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>
<?php } else { ?>
    <div class="alert alert-success">No hay productos en el carrito</div>
<?php } ?>

<footer>
    <!-- pie de página -->
</footer>

<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

<?php mysqli_close($enlace); ?>
