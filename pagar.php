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

     /* Media query for mobile viewport */
     @media screen and (max-width: 400px) {
        #paypal-button-container {
            width: 100%;
        }
    }
    
    /* Media query for desktop viewport */
    @media screen and (min-width: 400px) {
        #paypal-button-container {
            width: 250px;
            display: inline-block;
        }
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
                    <li><a href="mostrarcarrito.php">Carrito (<?php echo (empty($_SESSION['CARRITO'])?0:count($_SESSION['CARRITO']));?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

<br>
<br>
<br>
<br>


<?php
if($_POST){
    $total=0;
    $SID=session_id();
    $Correo=$_POST['email'];
    foreach($_SESSION['CARRITO'] as $indice=>$producto){
        $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);
        
    }
    // Preparamos la consulta con `?` en lugar de `:parametro`
    $sentencia = $enlace->prepare("INSERT INTO tblventas 
    (ClaveTransaccion, PaypalDatos, Fecha, Correo, Total, Status) 
    VALUES (?, '', NOW(), ?, ?, 'Pendiente')");

    // Verificamos que la consulta se haya preparado correctamente
    if ($sentencia === false) {
    die("Error en la consulta: " . $enlace->error);
    }

    // Enlazamos parámetros con `bind_param()`
    $sentencia->bind_param("ssd", $SID, $Correo, $total);

    $sentencia->execute();
    $idVenta = $enlace->insert_id;

    foreach($_SESSION['CARRITO'] as $indice=>$producto){
        $sentencia = $enlace->prepare("INSERT INTO tbldetalleventa 
        (IdVenta, IdProducto, PrecioUnitario, Cantidad, Comprado) 
        VALUES (?, ?, ?, ?, '0')");

        $sentencia->bind_param("iidd", $idVenta, $producto['ID'], $producto['PRECIO'], $producto['CANTIDAD']);
        $sentencia->execute();
    }
}
?>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div class="jumbotron" align="center">
    <h1 class="display-4">LISTO PARA PAGAR!</h1>
    <hr class="my-4">
    <p class="lead">El monto de tu pedido es:
        <h3>C$ <?php echo number_format($total,2); ?></h3> 
        <div id="paypal-button-container"></div>
    </p>
    <p>Esperando confirmación del pago <br>
    <strong>Para aclaraciones | ventas.jabonkita@gmail.com</strong>
    </p>
</div>

<script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'gold'   // gold | blue | silver | black
        },
 
        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create
 
        client: {
            sandbox:    'Aci0X-JgYogHdef0PMy9SNngabzbVHytAkJ8JLH-GQhzca-ie0w9ByVXFnFdc1YsdR_9ZOFexkm3-7gC',
            production: ''
        },
 
        // Wait for the PayPal button to be clicked
        

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '<?php echo $total; ?>', currency: 'USD' }, 
                            description:"Compra de productos a Jabon Kita: $<?php echo number_format($total); ?>",
                            custom:"<?php echo $SID ?>#<?php echo $idVenta ?>"
                        }
                    ]
                }
            });
        },
 
        // Wait for the payment to be authorized by the customer
 
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                console.log(data);
                window.location="verificador.php?paymentToken="+data.paymentToken+"&paymentID="+data.paymentID;
            });
        }
    
    }, '#paypal-button-container');
 
</script>


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
