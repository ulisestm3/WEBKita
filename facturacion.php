<?php
require_once 'conexion.php';

$claveTransaccion = $_POST['claveTransaccion'] ?? null;

if ($claveTransaccion) {
    $stmt = $enlace->prepare("SELECT PaypalDatos FROM tblventas 
        WHERE ClaveTransaccion = ? AND Status = 'Completado' AND PaypalDatos IS NOT NULL AND PaypalDatos != '' 
        ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $claveTransaccion);
    $stmt->execute();
    $stmt->bind_result($paypalJson);
    $stmt->fetch();
    $stmt->close();

    if ($paypalJson) {
        // Por si viene con slashes escapados
        $paypalJson = stripslashes($paypalJson);

        // Intentamos decodificar
        $objDatosTransaccion = json_decode($paypalJson);

        if ($objDatosTransaccion) {
            $state = $objDatosTransaccion->state;
            $payment_id = $objDatosTransaccion->id;
            $intent = $objDatosTransaccion->intent;
            $cart = $objDatosTransaccion->cart;

            // Payer info
            $payment_method = $objDatosTransaccion->payer->payment_method;
            $payer_status = $objDatosTransaccion->payer->status;
            $email = $objDatosTransaccion->payer->payer_info->email;
            $first_name = $objDatosTransaccion->payer->payer_info->first_name;
            $last_name = $objDatosTransaccion->payer->payer_info->last_name;
            $payer_id = $objDatosTransaccion->payer->payer_info->payer_id;
            $phone = $objDatosTransaccion->payer->payer_info->phone;
            $country_code = $objDatosTransaccion->payer->payer_info->country_code;

            // Shipping address (payer)
            $recipient_name = $objDatosTransaccion->payer->payer_info->shipping_address->recipient_name;
            $line1 = $objDatosTransaccion->payer->payer_info->shipping_address->line1;
            $city = $objDatosTransaccion->payer->payer_info->shipping_address->city;
            $state_shipping = $objDatosTransaccion->payer->payer_info->shipping_address->state;
            $postal_code = $objDatosTransaccion->payer->payer_info->shipping_address->postal_code;
            $country_shipping = $objDatosTransaccion->payer->payer_info->shipping_address->country_code;

            // Transaction info (solo se usa el primer objeto [0])
            $total = $objDatosTransaccion->transactions[0]->amount->total;
            $currency = $objDatosTransaccion->transactions[0]->amount->currency;
            $subtotal = $objDatosTransaccion->transactions[0]->amount->details->subtotal;
            $shipping = $objDatosTransaccion->transactions[0]->amount->details->shipping;
            $insurance = $objDatosTransaccion->transactions[0]->amount->details->insurance;
            $handling_fee = $objDatosTransaccion->transactions[0]->amount->details->handling_fee;
            $shipping_discount = $objDatosTransaccion->transactions[0]->amount->details->shipping_discount;
            $discount = $objDatosTransaccion->transactions[0]->amount->details->discount;

            $merchant_id = $objDatosTransaccion->transactions[0]->payee->merchant_id;
            $payee_email = $objDatosTransaccion->transactions[0]->payee->email;
            $description = $objDatosTransaccion->transactions[0]->description;
            $custom = $objDatosTransaccion->transactions[0]->custom;
            $clave = explode("#", $custom);
            $SID = $clave[0];
            $claveVenta = $clave[1];

            $soft_descriptor = $objDatosTransaccion->transactions[0]->soft_descriptor;

            // Shipping address (item_list)
            $item_shipping_name = $objDatosTransaccion->transactions[0]->item_list->shipping_address->recipient_name;
            $item_shipping_line1 = $objDatosTransaccion->transactions[0]->item_list->shipping_address->line1;
            $item_shipping_city = $objDatosTransaccion->transactions[0]->item_list->shipping_address->city;
            $item_shipping_state = $objDatosTransaccion->transactions[0]->item_list->shipping_address->state;
            $item_shipping_postal_code = $objDatosTransaccion->transactions[0]->item_list->shipping_address->postal_code;
            $item_shipping_country_code = $objDatosTransaccion->transactions[0]->item_list->shipping_address->country_code;

            // Related resources - Sale
            $sale_id = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->id;
            $sale_state = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->state;
            $sale_total = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->amount->total;
            $sale_currency = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->amount->currency;
            $sale_subtotal = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->amount->details->subtotal;

            $sale_payment_mode = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->payment_mode;
            $sale_protection_eligibility = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->protection_eligibility;
            $sale_protection_eligibility_type = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->protection_eligibility_type;

            $transaction_fee = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->transaction_fee->value;
            $transaction_fee_currency = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->transaction_fee->currency;

            $parent_payment = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->parent_payment;
            $sale_create_time = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->create_time;
            $sale_update_time = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->update_time;

            // Global timestamps
            $create_time = $objDatosTransaccion->create_time;
            $update_time = $objDatosTransaccion->update_time;
        } else {
            echo "<p style='color:red;'>❌ Error al leer los datos de PayPal (JSON mal formado)</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ No se encontró una venta completada con esa clave de transacción.</p>";
    }
} else {
    echo "<p style='color:red;'>❌ No se recibió la clave de transacción.</p>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KITA | Factura Electronica</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/stilo.css" rel="stylesheet" type="text/css">
    <link href="js/mai.js" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
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
            /* Ajusta la altura de la imagen */
        }

        .card-custom .card-body {
            padding: 15px;
        }

        .card-custom .card-title {
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .factura {
            background: #fff;
            padding: 50px;
            padding-top: 70px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .encabezado {
            text-align: center;
            margin-bottom: 20px;
        }

        .empresa {
            font-size: 24px;
            font-weight: bold;
        }

        .datos-cliente,
        .datos-factura {
            margin-bottom: 20px;
        }

        .datos-cliente h3,
        .datos-factura h3 {
            margin-bottom: 10px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f8f8f8;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        .navbar-default {
            margin: 0;
            padding: 0;
            border: none;
            /* Eliminar cualquier borde adicional */
        }

        .menu-fixed {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            /* Asegura que esté por encima de otros elementos */
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px; /* Ajusta según sea necesario */
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

    <section class="Factura" id="facturaSection">

        <div class="factura">
            <div class="encabezado">
                <div class="empresa">Jabon Kita S.A.</div>
                <div class="ruc">RUC: 000-000-0000000</div>
                <div class="direccion">Dirección: Managua, Nicaragua</div>
                <div class="contacto">ventas.jabonkita@gmail.com</div>
                <br><br>
                <div class="Fecha" style="text-align: right;">Fecha de Emisión: <?php echo $sale_create_time;  ?> <br> <br></div>
            </div>

            <!-- DATOS DEL CLIENTE -->
            <div class="datos-cliente">
                <h3>Datos del Cliente</h3>
                <p>
                    <!-- PHP: Obtener datos del cliente desde la base de datos -->
                    <?php    ?>
                    Nombre: <?php echo $first_name;   ?> <?php echo $last_name;   ?><br>
                    Dirección: <?php echo $line1; ?>, <?php echo $city; ?>, <?php echo $state_shipping; ?>, <?php echo $country_shipping; ?> <br>
                    Email: <?php echo  $email;  ?>
                </p>
            </div>

            <!-- DATOS DE LA FACTURA -->
            <div class="datos-factura">
                <h3>Factura</h3>
                <p>
                    <!-- PHP: Obtener info de la factura -->
                    <?php   ?>
                    Número: FAC-<?php echo $claveVenta;  ?> <br>
                    Cod. Transacción: <?php echo $SID;  ?><br>
                    Metodo de pago: <?php echo $payment_method;  ?><br>

                </p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">Cantidad</th>
                        <th style="text-align: center;">Descripción</th>
                        <th style="text-align: center;">Precio Unitario</th>
                        <th style="text-align: center;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sentencia = $enlace->prepare("SELECT cantidad, tblproductos.Nombre, PrecioUnitario
          FROM tbldetalleventa 
          JOIN tblproductos ON tbldetalleventa.IDProducto = tblproductos.IDProducto
          WHERE tbldetalleventa.IdVenta = ?;");
                    $sentencia->bind_param("i", $claveVenta);
                    $sentencia->execute();

                    $resultado = $sentencia->get_result();
                    $grantotal = 0;

                    while ($row = $resultado->fetch_assoc()) {
                        $cantidad = $row['cantidad'];
                        $nombre = $row['Nombre'];
                        $precio = $row['PrecioUnitario'];
                        $subtotal = $cantidad * $precio;
                        $grantotal += $subtotal;

                        echo "<tr>
                  <td style='text-align: right;'>$cantidad</td>
                  <td style='text-align: left;'>$nombre</td>
                  <td style='text-align: right;'>C$" . number_format($precio, 2) . "</td>
                  <td style='text-align: right;'>C$" . number_format($subtotal, 2) . "</td>
                </tr>";
                    }

                    // Fila de Total
                    echo "<tr>
              <td colspan='3' style='text-align: right; font-weight: bold;'>Total a pagar:</td>
              <td style='text-align: right; font-weight: bold;'>C$" . number_format($grantotal, 2) . "</td>
            </tr>";
                    ?>
                </tbody>
            </table>

    </section>

    <!-- Botón para descargar la factura como PDF -->
    <div class="button-container">
        <button onclick="downloadPDF()" class="btn btn-primary">Descargar Factura como PDF</button>
    </div>

</body>

<script>
        function downloadPDF() {
            const element = document.getElementById('facturaSection');
            const opt = {
                margin: 1,
                filename: 'factura.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // New Promise-based usage:
            html2pdf().from(element).set(opt).save();
        }
    </script>

<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>

</html>

<?php mysqli_close($enlace); ?>