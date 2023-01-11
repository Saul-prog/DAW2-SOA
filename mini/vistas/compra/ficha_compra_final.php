<?php
//---------------------------------------------------------------------------
//Vista de FICHA de articulo que va embebida dentro de las vistas de
//CONSULTA o BORRADO.
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "articulo" a visualizar o "null" si
//                hubo error de carga.
//    $error  --> Mensaje de error o cadena vacia si no hubo.
//---------------------------------------------------------------------------
/*-----
depurar( array(
  'id_controlador' => aplicacion::$id_controlador,
  'id_accion' => aplicacion::$id_accion,
  'modelo' => $modelo,
  'error' => $error,
));
//-----*/?>

    <div class="caja-sombra">
        <?php echo $articulo->referencia;?><br/>
        <div class="der">
            Precio: <?php echo $articulo->precio;?>€<br>
        </div>
        IVA:    <?php echo $articulo->iva;?>
        <br>
        Precio total: <?php echo $articulo->precio*$datos['cantidad'];?>
        <hr>
    </div>
