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
    $ClientID="Aci0X-JgYogHdef0PMy9SNngabzbVHytAkJ8JLH-GQhzca-ie0w9ByVXFnFdc1YsdR_9ZOFexkm3-7gC";
    $Secret="ECR274wyC25f3WI0FxMJRg_9JpbWLC_V_w8JGjLGBnc_x-HdOzOyZ4eeu1ciduLIcC_mftpHQtB1iPhn";

        $Login= curl_init("https://api-m.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($Login,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($Login,CURLOPT_USERPWD,$ClientID.":".$Secret);
        curl_setopt($Login,CURLOPT_POSTFIELDS,"grant_type=client_credentials");
        $Respuesta=curl_exec($Login);

        $objRespuesta=json_decode($Respuesta);

        $AccessToken=$objRespuesta->access_token;

        //print_r($AccessToken);

        // Validar que paymentID fue recibido
        if (!isset($_GET['paymentID'])) {
            die("Error: No se recibió el paymentID.");
        }

        $paymentID = $_GET['paymentID'];

        // Obtener detalles del pago
        $venta = curl_init("https://api-m.sandbox.paypal.com/v1/payments/payment/$paymentID");
        curl_setopt($venta, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($venta, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $AccessToken" // CORRECCIÓN: Se agrega espacio después de "Bearer"
        ]);

        $RespuestaVenta = curl_exec($venta);

        

        // Manejo de errores en cURL
        if (curl_errno($venta)) {
            die("cURL Error: " . curl_error($venta));
        }

        //curl_close($venta);

        // Mostrar la datos de la API de PayPal

        $objDatosTransaccion=json_decode($RespuestaVenta);

        $state=$objDatosTransaccion->state;
        $email=$objDatosTransaccion->payer->payer_info->email;
        $total=$objDatosTransaccion->transactions[0]->amount->total;
        $currency=$objDatosTransaccion->transactions[0]->amount->currency;
        $custom=$objDatosTransaccion->transactions[0]->custom;

        

        $clave=explode("#", $custom);

        $SID=$clave[0];
        $claveVenta=$clave[1];

        curl_close($venta);
        curl_close($Login);

        if($state=="approved"){
            $mensajePaypal="<h3>Pago aprobado</h3>";

            $sentencia=$enlace->prepare("UPDATE `tblventas` SET `PaypalDatos` = ?, `Status` = 'Aprobado' WHERE `tblventas`.`ID` = ?;");
            // Enlazamos parámetros con `bind_param()`
            $sentencia->bind_param("si", $RespuestaVenta , $claveVenta);
            $sentencia->execute();

            $sentencia=$enlace->prepare("UPDATE `tblventas` SET `Status` = 'Completado' WHERE `ClaveTransaccion` = ? AND `Total` = ? AND `ID` = ?");
            // Enlazamos parámetros con `bind_param()`
            $sentencia->bind_param("idi", $SID, $total , $claveVenta);
            $sentencia->execute();

            $completado=$sentencia->affected_rows;

            //session_destroy();    

        }else{
            $mensajePaypal="<h3>Hay un problema con el pago de paypal</h3>";
        }

?>

<div class="jumbotron" align="center">
    <h1 class="display-4">Pago procesado:</h1>
    <hr class="my-4">
    <p class="lead"><?php echo $mensajePaypal; ?></p>
    <p>
        <?php
            if($completado>=1){
                $sentencia=$enlace->prepare("SELECT * FROM tbldetalleventa, tblproductos WHERE tbldetalleventa.IdProducto=tblproductos.IDProducto AND tbldetalleventa.IdVenta=?;");
                // Enlazamos parámetros con `bind_param()`
                $sentencia->bind_param("i", $claveVenta);
                $sentencia->execute();
                $resultado = $sentencia->get_result(); 
                $listaProductos=$resultado->fetch_all(MYSQLI_ASSOC); 
                session_destroy();   
                //print_r($listaProductos);
            }else{
    
            }

        ?>

            Este es su código de transacción guardar para generar su factura: <br>
            <?php print_r($SID);?>

            <form action="facturacion.php" method="POST">
                <input type="hidden" name="claveTransaccion" value="<?php echo $SID; ?>">
                <button type="submit">Generar Factura</button>
            </form>

    </p>
</div>

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
