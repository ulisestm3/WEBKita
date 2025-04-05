<?php
session_start();
$mensaje = "";

if (isset($_POST['btnAccion'])) {
    switch ($_POST['btnAccion']) {
        case 'Agregar':
            $ID = $_POST['id'];
            $NOMBRE = $_POST['nombre'];
            $CANTIDAD = $_POST['cantidad'];
            $PRECIO = $_POST['precio'];

            if (!isset($_SESSION['CARRITO'])) {
                $_SESSION['CARRITO'] = array();
            }

            $productoExistente = false;

            foreach ($_SESSION['CARRITO'] as &$producto) {
                if ($producto['ID'] == $ID) {
                    // Si el producto ya existe, aumentar la cantidad
                    $producto['CANTIDAD'] += $CANTIDAD;
                    $productoExistente = true;
                    $mensaje = "Cantidad actualizada en el carrito";
                    break;
                }
            }
            unset($producto); // Evitar problemas con referencias en foreach

            if (!$productoExistente) {
                // Agregar un nuevo producto solo si no existía antes
                $_SESSION['CARRITO'][] = array(
                    'ID' => $ID,
                    'NOMBRE' => $NOMBRE,
                    'CANTIDAD' => $CANTIDAD,
                    'PRECIO' => $PRECIO
                );
                $mensaje = "Producto agregado al carrito";
            }
            break;

        case 'Eliminar':
            if (isset($_POST['id'])) {
                $ID = $_POST['id'];
                foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                    if ($producto['ID'] == $ID) {
                        unset($_SESSION['CARRITO'][$indice]);
                        $_SESSION['CARRITO'] = array_values($_SESSION['CARRITO']); // Reindexar array
                        $mensaje = "Producto eliminado del carrito";
                        break;
                    }
                }
            }
            break;

        case 'Aumentar':
            if (isset($_POST['id'])) {
                $ID = $_POST['id'];
                foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                    if ($producto['ID'] == $ID) {
                        $_SESSION['CARRITO'][$indice]['CANTIDAD'] += 1;
                        $mensaje = "Cantidad aumentada";
                        break;
                    }
                }
            }
            break;

        case 'Disminuir':
            if (isset($_POST['id'])) {
                $ID = $_POST['id'];
                foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                    if ($producto['ID'] == $ID && $producto['CANTIDAD'] > 1) {
                        $_SESSION['CARRITO'][$indice]['CANTIDAD'] -= 1;
                        $mensaje = "Cantidad disminuida";
                        break;
                    }
                }
            }
            break;

        case 'Actualizar':
            // Lógica de actualización manual de la cantidad
            if (isset($_POST['id']) && isset($_POST['cantidad'])) {
                $id = $_POST['id'];
                $nuevaCantidad = intval($_POST['cantidad']);
                if ($nuevaCantidad > 0) {
                    foreach ($_SESSION['CARRITO'] as &$producto) {
                        if ($producto['ID'] == $id) {
                            $producto['CANTIDAD'] = $nuevaCantidad;
                            $mensaje = "Cantidad actualizada en el carrito";
                            break;
                        }
                    }
                }
            }
            break;
    }
}

?>
