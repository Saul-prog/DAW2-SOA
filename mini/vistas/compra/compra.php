<?php
modelo::usar( 'compra');
//---------------------------------------------------------------------------
//Vista de cesta de la compra...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $registros --> array con los registros de la tabla de compra.
//    $total --> número de registros totales de la tabla de compra.
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
    <h1>Cesta de la compra</h1>
    <div class="hoja">
<?php //Generar los registros obtenidos de la compra.
if (is_array($registros)) {
    $modelo= new compra;
    $cantidad_final=0;
    foreach($registros as $indice => $datos) {
        var_dump($datos);
        echo '<br>';
        $modelo->rellenar($indice,$datos);
        $modelo->cantidad=$datos['cantidad'];
        //Opcion 1: Siguiendo el framework
        vista::generarParcial( 'ficha_compra', array( 'compra'=>$modelo, 'pagina'=>$pagina));

        //Opcion 2: incluir a mano.
        //include( 'ficha_oferta.php');

        //Opcion 3: aqui a mano.
        //echo '<div>'; print_r( $modelo); echo '</div>';
        $cantidad_final= $cantidad_final+($datos['cantidad']);
    }//foreach
        echo '<div> <H2>Cantidad total: '.$cantidad_final.'</H2>';
} else {
    echo 'No hay datos.';
}