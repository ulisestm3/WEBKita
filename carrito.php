<?php
session_start();

$mensaje="";

// Verificar si se ha enviado el ID del producto
if (isset($_POST['btnAccion'])) {
    
    switch($_POST['btnAccion']){
        case 'Agregar':
            if(is_numeric($_POST['id'])){
                $ID=$_POST['id'];
                $mensaje.="Ok id Correcto ".$ID."<br/>";
            }
            else{
                $mensaje.="Id Incorrecto ".$ID."<br/>";
            }
                if(is_string($_POST['nombre'])){
                    $NOMBRE=$_POST['nombre'];
                    $mensaje.="Ok nombre Correcto ".$NOMBRE."<br/>";
                }else{$mensaje.="Nombre Incorrecto ".$NOMBRE."<br/>";    break;}

                if(is_numeric($_POST['cantidad'])){
                    $CANTIDAD=$_POST['cantidad'];
                    $mensaje.="Ok cantidad Correcto ".$CANTIDAD."<br/>";
                }else{$mensaje.="Cantidad Incorrecta ".$CANTIDAD."<br/>";    break;}

                if(is_numeric($_POST['precio'])){
                    $PRECIO=$_POST['precio'];
                    $mensaje.="Ok precio Correcto ".$PRECIO."<br/>";
                }else{$mensaje.="Precio Incorrecto ".$PRECIO."<br/>";    break;}

            if(!isset($_SESSION['CARRITO'])){
                $producto=array(
                    'ID'=>$ID,
                    'NOMBRE'=>$NOMBRE,
                    'CANTIDAD'=>$CANTIDAD,
                    'PRECIO'=>$PRECIO,
                );
                $_SESSION['CARRITO'][0]=$producto;
                $mensaje= "Producto agregado al carrito";
            }else{
                $idProductos=array_column($_SESSION['CARRITO'],"ID");
                if(in_array($ID, $idProductos)){
                    echo "<script>alert('El producto ya ha sido seleccionado...');</script>";

                }else{
                $NumeroProductos=count($_SESSION['CARRITO']);
                $producto=array(
                    'ID'=>$ID,
                    'NOMBRE'=>$NOMBRE,
                    'CANTIDAD'=>$CANTIDAD,
                    'PRECIO'=>$PRECIO,
                );
                $_SESSION['CARRITO'][$NumeroProductos]=$producto;
                $mensaje= "Producto agregado al carrito";
                }
            }
            
        break;
        case 'Eliminar':
            if(is_numeric($_POST['id'])){
                $ID=$_POST['id'];
                foreach($_SESSION['CARRITO'] as $indice=>$producto){
                    if($producto['ID']==$ID){
                        unset($_SESSION['CARRITO'][$indice]);
                        
                    }
                }
            }
            else{
                $mensaje.="Id Incorrecto ".$ID."<br/>";
            }
        break;
    }
}
?>