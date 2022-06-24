<?php
session_start();
$mensaje="";
if(isset($_POST['btnAccion'])){
    switch($_POST['btnAccion']){
        case 'Agregar':
            if(is_numeric(openssl_decrypt($_POST['id'],COD,KEY))){
                $ID=openssl_decrypt($_POST['id'],COD,KEY);
                $mensaje.="OK ID CORRECTO ".$ID."<br/>";
            } else {
                $mensaje.="ID Incorrecto".$ID."<br/>";
            }
            if(is_string(openssl_decrypt($_POST['nombre'],COD,KEY))){
                $NOMBRE=openssl_decrypt($_POST['nombre'],COD,KEY);
                $mensaje.= "OK NOMBRE".$NOMBRE."<br/>";
                } else { $mensaje.="Upps. Algo pasa con el nombre"."<br/>"; break;}
                if(is_numeric(openssl_decrypt($_POST['cantidad'],COD,KEY))){
                     $CANTIDAD=openssl_decrypt($_POST['cantidad'],COD,KEY);
                     $mensaje.= "OK CANTIDAD".$CANTIDAD. "<br/>";
                } else { $mensaje.="Upps. Algo pasa con la cantidad"."<br/>"; break;}
                if(is_numeric(openssl_decrypt($_POST['precio'],COD,KEY))){
                     $PRECIO=openssl_decrypt($_POST['precio'],COD,KEY);
                     $mensaje.= "OK PRECIO".$PRECIO. "<br/>";
                } else { $mensaje.="Upps. Algo pasa con el precio"."<br/>"; break;}            
            if(!isset($_SESSION['carrito'])){
                $producto=array(
                    'ID'=>$ID,
                    'NOMBRE'=>$NOMBRE,
                    'CANTIDAD'=>$CANTIDAD,
                    'PRECIO'=>$PRECIO
                );
                $_SESSION['carrito'][0]=$producto;
                $mensaje= "Producto agregado al carrito";
            } else {
               $idProductos=array_column($_SESSION['carrito'],"ID");
               if(in_array($ID, $idProductos)) {
                   echo "<script>alert('El producto ya ha sido agregado')</script>";
                   $mensaje= "";
                   break;
               } else {
                    $numeroProductos=count($_SESSION['carrito']);
                    $producto=array(
                        'ID'=>$ID,
                        'NOMBRE'=>$NOMBRE,
                        'CANTIDAD'=>$CANTIDAD,
                        'PRECIO'=>$PRECIO
                    );
                    $_SESSION['carrito'][$numeroProductos]=$producto;
                }
                    $mensaje= "Producto agregado al carrito";
            }
        break;
        case 'Eliminar':
            if(is_numeric(openssl_decrypt($_POST['id'],COD,KEY))) {
                $ID=openssl_decrypt($_POST['id'],COD,KEY);
                foreach($_SESSION[ 'carrito'] as $i=>$producto) {
                    if($producto['ID']==$ID) {
                        unset($_SESSION['carrito'][$i]);
                        $_SESSION['carrito']=array_values($_SESSION["carrito"]);
                    }
                }
            } else {
                $mensaje.="ID Incorrecto".$ID."<br/>";
            }
        break;
    }
}
?>