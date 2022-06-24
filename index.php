<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>
<br>
        <!-- <h3 class="d-inline">Lista de los modulos mas comunes de discord.</h3> -->
        <?php if($mensaje!="") { ?>
        <div class="alert alert-success mt-3">
            <?php echo $mensaje; ?>
            <a href="mostrar-carrito.php" class="badge bg-success text-decoration-none">Ver carrito</a>
        </div>
        <?php } ?>
        <div class="row d-flex justify-content-center">
        <?php
            $sentencia=$pdo->prepare("SELECT * FROM `tblproductos`");
            $sentencia->execute();
            $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach($listaProductos as $producto){ ?>
            <div class="col-md-3 col-sm-6 col-xs-5">
                <div class="card bg-dark m-3">
                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" title="<?php echo $producto['Nombre'];?>" data-bs-content="<?php echo $producto['Descripcion'];?>">
                        <img class="card-img-top" style="height: 220px; object-fit: contain; object-position: center;" title="<?php echo $producto['Nombre'];?>" alt="<?php echo $producto['Nombre'];?>" src="<?php echo $producto['Imagen'];?>">
                    </span>
                    <div class="card-body d-flex flex-column justify-content-center align-items-center align-self-center" style="height: 180px">
                        <span><?php echo $producto['Nombre']; ?></span>
                        <h5 class="card-title my-3">$<?php echo $producto['Precio']; ?></h5>
                         <form action="" method="post">
                            <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'],COD,KEY);?>">
                            <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'],COD,KEY);?>">
                            <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'],COD,KEY);?>">
                            <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD,KEY);?>">
                            <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">Agregar al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                        return new bootstrap.Popover(popoverTriggerEl)
                    });
</script>
<?php include 'templates/pie.php'; ?>