<?php
include 'global/config.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>
<br>
<a href="index.php" style="color: #fff;"><span class="material-icons">arrow_back_ios</span></a>
<h3 class="d-inline mt-5">Lista del carrito</h3>
<?php if(!empty($_SESSION['carrito'])) { ?>
<table class="table table-dark table-bordered mt-3">
    <tbody>
        <tr>
            <th width="40%">Descripción del producto</th>
            <th width="15%" class="text-center">Cantidad</th>
            <th width="20%" class="text-center">Precio</th>
            <th width="20%" class="text-center">Total</th>
            <th width="5%">--</th>
        </tr>
        <?php $total=0; ?>
        <?php foreach($_SESSION[ 'carrito'] as $i=>$producto) { ?>
        <tr>
            <td width="40%"><?php echo $producto['NOMBRE']?></td>
            <td width="15%" class="text-center"><?php echo $producto['CANTIDAD']; ?></td>
            <td width="20%" class="text-center">$<?php echo $producto['PRECIO']; ?></td>
            <td width="20%" class="text-center">$<?php echo number_format($producto['PRECIO']*$producto['CANTIDAD'],2); ?></td>
            <td width="5%"> 
            <form action="" method="post">
                <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'],COD,KEY); ?>">
                <button class="btn btn-danger" 
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
            <td align="right"><h3>$<?php echo number_format($total,2);?></h3></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">
                <form action="pagar.php" method="post">
                    <div class="alert alert-success" role="alert">
                        <div class="form-group">
                            <label for="my-input">Correo de contacto:</label>
                            <input id="email" class="form-control" type="email" name="email" placeholder="Escribe tu correo" required>
                        </div>                        
                        <small id="emailHelp" class="form-text text-muted">Los productos se enviaran a este correo.</small>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg" type="submit" name="btnAccion" value="proceder">Proceder a pagar >></button>
                    </div>
                </form>
            </td>
        </tr>
    </tbody>
</table>
<?php } else { ?>
<div class="alert alert-success mt-5">No hay productos en el carrito...</div>
<?php } ?>
<?php include 'templates/pie.php'; ?>