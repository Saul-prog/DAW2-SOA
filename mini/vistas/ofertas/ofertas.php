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
<h1>Ofertas</h1>
<div class="hoja">
<?php //Generar los registros obtenidos de ofertas.
if (is_array($registros)) {
  $modelo= new ofertas;
  foreach($registros as $indice => $registro) {
    $modelo->llenar( $registro);
    $modelo->cargarOferta();
    //Opcion 1: Siguiendo el framework
    vista::generarParcial( 'ficha_oferta', array( 'oferta'=>$modelo, 'pagina'=>$pagina));
    
    //Opcion 2: incluir a mano.
    //include( 'ficha_oferta.php');
    
    //Opcion 3: aqui a mano.
    //echo '<div>'; print_r( $modelo); echo '</div>'; 
    
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
?>
</div>

<div class="salto"></div>

<?php //Generar el pie de la tabla con la informacion y paginador
vista::generarPieza( 'paginador', array( 'url'=>array('a'=>'ofertas'), 'total'=>$total, 'pagina'=>$pagina, 'lineas'=>$lineas));
?>

<div class="salto"></div>
<?php //Informar del contenido de la cesta.
/*--*x/
  $cesta= Cesta::instancia_de_sesion();
  echo '<pre>';
  echo sprintf( 
      'Hay %s artículos en la cesta con un total de %d unidades.'
    , $cesta->total_articulos()
    , $cesta->total_unidades()
  );
  echo '</pre>';
  /*--*/
?>