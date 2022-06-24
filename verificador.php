<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>
<?php
    $Login= curl_init(LINKAPI."/v1/oauth2/token");
    curl_setopt($Login,CURLOPT_RETURNTRANSFER,TRUE);
    curl_setopt($Login,CURLOPT_USERPWD,CLIENTID.":".SECRET);
    curl_setopt($Login, CURLOPT_POSTFIELDS,"grant_type=client_credentials");
    $Respuesta=curl_exec($Login);
    $objRespuesta=json_decode($Respuesta);
    $AccessToken=$objRespuesta->access_token;
    $venta=curl_init(LINKAPI."/v2/checkout/orders/".$_GET['orderID']);
    curl_setopt($venta,CURLOPT_HTTPHEADER,array("Content-Type: application/json","Authorization: Bearer ".$AccessToken));
    curl_setopt($venta,CURLOPT_RETURNTRANSFER,TRUE);
    $RespuestaVenta=curl_exec($venta);
    $objDatosTransaccion=json_decode($RespuestaVenta);
    $state=$objDatosTransaccion->status;
    $email=$objDatosTransaccion->payer->email_address;
    $total=$objDatosTransaccion->purchase_units[0]->amount->value;
    $currency=$objDatosTransaccion->purchase_units[0]->amount->currency_code;
    $reference_id=$objDatosTransaccion->purchase_units[0]->reference_id;
    $clave=explode('#',$reference_id);
    $SID=$clave[0];
    $claveVenta=openssl_decrypt($clave[1],COD,KEY);
    curl_close($venta);
    curl_close($Login);
    if($state=='COMPLETED') {
        $mensajePaypal="<h3>Pago aprobado</h3>";
        $sentencia=$pdo->prepare("UPDATE `tblventas` 
                    SET `PaypalDatos` =:PaypalDatos,
                    `status` = 'aprobado'
                    WHERE `tblventas`.`ID` =:ID;");
        $sentencia->bindParam(":ID",$claveVenta);
        $sentencia->bindParam(":PaypalDatos",$RespuestaVenta);
        $sentencia->execute();
        $sentencia=$pdo->prepare("UPDATE tblventas SET status='completo'
                                        WHERE ClaveTransaccion=:ClaveTransaccion
                                        AND Total=:TOTAL
                                        AND ID=:ID");
        $sentencia->bindParam(':ClaveTransaccion',$SID);
        $sentencia->bindParam(':TOTAL',$total);
        $sentencia->bindParam(':ID',$claveVenta);
        $sentencia->execute();
        $completado=$sentencia->rowCount();
        session_destroy();
    } else {
        $mensajePaypal="<h3>Hay un problema con el pago contactanos en nuestro correo o whatsapp</h3>"; //AÑADIR LINKS
    }
?>
<div class="mt-5 p-2 text-center bg-dark text-white rounded">
    <h1 class="display-4">¡Listo!</h1>
    <hr class="my-4">
    <p class="lead"><?php echo $mensajePaypal; ?></p>
    <?php
    if ($completado>=1) {
        $sentencia=$pdo->prepare("SELECT * FROM tbldetalleventa,tblproductos
                                    WHERE tbldetalleventa.IDPRODUCTO=tblproductos.ID
                                    AND tbldetalleventa.IDVENTA=:ID");
        $sentencia->bindParam(':ID',$claveVenta);
        $sentencia->execute();
        $ListaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>
    <div class="row">
        <?php foreach($ListaProductos as $producto) { ?>
        <div class="col-2">
            <div class="card">
                <img class="card-img-top" src="<?php echo $producto['Imagen']; ?>">
                <div class="card-body" style="color: #000;">
                    <p class="card-text"><?php echo $producto['Nombre']; ?></p>
                    <?php if($producto['DESCARGADO']<DESCARGASPERMITIDAS) { ?>
                    <form action="descargas.php" method="post">
                        <input type="hidden" name="IDVENTA" id="" value="<?php echo openssl_encrypt($claveVenta,COD,KEY); ?>">
                        <input type="hidden" name="IDPRODUCTO" id="" value="<?php echo openssl_encrypt($producto['IDPRODUCTO'],COD,KEY); ?>">
                        <!-- <button class="btn btn-success" type="submit">Descargar</button> -->
                        <h5>
                        Se le enviara el producto desde hello@peropaquepo.com
                        </h5>
                    </form>
                    <?php } else { ?>
                        <!-- <button class="btn btn-success" type="button" disabled >Descargar</button> -->
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php include 'templates/pie.php'; ?>