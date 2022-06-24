<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>
<?php
if($_POST) {
    $total=0;
    $SID=session_id();
    $Correo=$_POST['email'];
    foreach($_SESSION[ 'carrito'] as $i=>$producto) {
        $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);
    }
    $sentencia=$pdo->prepare("INSERT INTO `tblventas` 
                        (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `Status`)
                VALUES (NULL,:ClaveTransaccion, '', NOW(), :Correo, :Total, 'pendiente');");
    $sentencia->bindParam(":ClaveTransaccion",$SID);
    $sentencia->bindParam(":Correo",$Correo);
    $sentencia->bindParam(":Total",$total);
    $sentencia->execute();
    $idVenta=$pdo->lastInsertId();
    foreach($_SESSION['carrito'] as $i=>$producto) {
        $sentencia=$pdo->prepare("INSERT INTO `tbldetalleventa`
                (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`)
        VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0');");
        $sentencia->bindParam(":IDVENTA",$idVenta);
        $sentencia->bindParam(":IDPRODUCTO",$producto['ID']);
        $sentencia->bindParam(":PRECIOUNITARIO",$producto['PRECIO']);
        $sentencia->bindParam(":CANTIDAD",$producto['CANTIDAD']);
        $sentencia->execute();

    }
}
?>
<script src="https://www.paypal.com/sdk/js?client-id=Aeq6W_-_MdTC2eQt0s4k_BzD7eihulGG5QpovOcN7l7I9ZVl1bpsiwcLgdMqoVMwMk7y5_ZMuSwDyeee&currency=USD"></script> 
<div class="mt-5 p-2 text-center bg-dark text-white rounded">
    <h1 class="display-4">¡Paso Final!</h1>
    <hr class="my-4">
    <p class="lead">Estas a punto de pagar con paypal la cantidad:
        <h4>$<?php echo number_format($total,2); ?></h4>
    </p>
    <div id="paypal-button-container"></div>
    <p>Los productos podrán ser enviados una vez que se procese el pago.</br>
        <strong>(Para aclaraciones: hello@peropaquepo.com)</strong>
    </p>
</div>
<script>
      paypal.Buttons({
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '<?php echo $total; ?>'
              },
              description: "Compra de Mind Shop: $<?php echo number_format($total,2); ?>",
              reference_id: "<?php echo $SID; ?>#<?php echo openssl_encrypt($idVenta,COD,KEY); ?>"
            }]
          });
        },
        style: {
                layout: 'horizontal'
            },
        onApprove: (data, actions) => {
          return actions.order.capture().then(function(orderData) {
            window.location="verificador.php?facilitatorAccessToken="+data.facilitatorAccessToken+"&orderID="+data.orderID+"&payerID="+data.payerID;
          });
        }
      }).render('#paypal-button-container');
</script>
<?php include 'templates/pie.php'; ?>