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
//-----*/
?>
    <div class="articulo">
        <div class="caja-sombra">
            <?php echo $modelo->referencia;?><br/>
            <div class="der">
                Precio: <?php echo $modelo->precio;?>€<br>
            </div>
            IVA:    <?php echo $modelo->iva;?>
            <br>
            Precio total: <?php echo $modelo->precio*$datos['cantidad'];?>
        </div>
    </div>
<?php