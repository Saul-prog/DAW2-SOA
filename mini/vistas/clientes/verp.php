<?php
//---------------------------------------------------------------------------
//Vista de Catalogo de ofertas...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $registros --> array con los registros de la tabla de ofertas.
//    $total --> número de registros totales de la tabla de ofertas.
//    $pagina --> numero de pagina que se esta obteniendo.
//    $lineas --> numero de lineas visibles por pagina.
//---------------------------------------------------------------------------
/*-----
depurar( array(
  'id_controlador' => aplicacion::$id_controlador,
  'id_accion' => aplicacion::$id_accion,
  'pagina' => $pagina,
  'lineas' => $lineas,
  'total' => $total,
  'registros' => $registros,
));
//-----*/


//echo $local;
?>
<h1>Pedidos</h1>
<div class="hoja">
    <?php //Generar los registros obtenidos de ofertas.
    if (is_array($registros)) {
        $modelo= new pedidolin;
        foreach($registros as $indice => $registro) {
            $modelo->llenar( $registro);
            ?>
            <div class="caja-sombra">
                <label>Referencia:</label>
                <?php echo $modelo->refArt;?><br/>
                <label>Descripción:</label>
                <?php echo $modelo->texto;?><br/>
                <label>Cantidad</label>
                <?php echo $modelo->cantidad;?><br/>
                <label>Precio</label>
                <?php echo $modelo->precio;?><br/>
                <label>IVA</label>
                <?php echo $modelo->iva;?><br/>
                <label>Importe total</label>
                <?php echo $modelo->importeBase;?><br/>
                <label>Cuota de iva</label>
                <?php echo $modelo->cuotaIva;?><br/>
                <?php


                ?>

            </div>
            <?php

        }//foreach
    } else {
        echo 'No hay datos.';
        /*----*x/
        //Probar el sistema de errores de la clase "modelo".
        $modelo= new articulo;
        depurar( 'Modelo 1= '.var_export( $modelo->listaErrores(), true));
        depurar( 'Hay errores 1= '.var_export( $modelo->hayErrores(), true));
        $modelo->ponerError( null, 'Error generico de la clase.');
        depurar( 'Hay errores 2= '.var_export( $modelo->hayErrores(), true));
        $modelo->ponerError( 'precio', 'El precio no puede ser negativo.');
        depurar( 'Hay error [null]= '.var_export( $modelo->hayErrorEn( null), true));
        depurar( 'Hay error [precio]= '.var_export( $modelo->hayErrorEn( 'precio'), true));
        depurar( 'Hay error [otro]= '.var_export( $modelo->hayErrorEn( 'otro'), true));
        //-----*/

    }//if

    $url= '?'.http_build_query( array('a'=>'clientes.pedidos'));
    echo '<a href="'.$url.'">';
        echo 'Volver';
        echo '</a>';
    ?>
</div>