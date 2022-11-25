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

<div class="articulo">
    <div class="caja-sombra">
        <?php echo $articulo->referencia;
        $cantidad_mod=1;
        vista::generarPieza( 'boton_accion', array( 'texto'=>'Vaciar', 'icono'=>'cross.png',
            'activo'=>false, 'url'=>array('a'=>'compra.del','ref'=>$articulo->referencia),
            'submit'=>true));
        ?><br/>

        <div class="der">
            Precio: <?php echo $articulo->precio;?>€<br>
        </div>
        IVA:    <?php echo $articulo->iva;?>
        <br>
        Cantidad articulos: <?php echo $datos['cantidad'];?>

        <?php
        if($datos['oferta']){
             echo 'Cantidad articulos: Es una oferta';
        }

        $url= '?'.http_build_query( array('a'=>'compra.quitar', 'ref'=>$articulo->referencia,'cantidad'=>$cantidad_mod));
        echo '<a href="'.$url.'">';
            echo '<img src="recursos/menos.png" title="Quitar uno de la cesta" alt="Quitar uno de la cesta" width="16px" height="auto"/>';
            echo '</a>';
        ?>
        <?php
        $url2= '?'.http_build_query( array('a'=>'compra.add', 'ref'=>$articulo->referencia,'cantidad'=>$cantidad_mod,'oferta'=>$datos['oferta']));
        echo '<a href="'.$url2.'">';
        echo '<img src="recursos/plus.png" title="Quitar uno de la cesta" alt="Quitar uno de la cesta" width="16px" height="auto"/>';
        echo '</a>';




        ?>
        <form action="?a=compra.set" method="post">
        <input type="text" name="cantidad" id="cantidad" value="1"/>
        <input type="hidden" name="ref" id="ref" value="<?php echo $articulo->referencia?>"/>
        <input type="submit" value="Añadir">
        </form>
        <hr>

    </div>
</div>