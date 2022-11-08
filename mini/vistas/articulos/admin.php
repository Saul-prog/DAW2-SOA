<?php
//---------------------------------------------------------------------------
//Vista de Administracion de articulos...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $registros --> array con los registros de la tabla de articulos.
//    $total --> número de registros totales de la tabla de articulos.
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
?>
<h1>Articulos</h1>
<div class="hoja">
<table>
<thead>
<tr>
  <th>Ref.</th>
  <th>Descripción</th>
  <th>Precio</th>
  <th>%IVA</th>
  <th>Notas</th>
  <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php //Generar los registros obtenidos de articulos.
$modelo= new articulo;
foreach($registros as $indice => $registro) {
  $modelo->llenar( $registro);
  echo '<tr class="'.(($indice % 2 == 0) ? 'par' : 'impar').'">';
  echo '<td class="cen">'.html::encode( $modelo->referencia).'</td>';
  echo '<td class="cen">'.html::encode( $modelo->texto).'</td>';
  echo '<td class="der">'.sprintf( '%0.2f', $modelo->precio).'</td>';
  echo '<td class="der">'.sprintf( '%0.2f', $modelo->iva).'</td>';
  echo '<td class="izq">'.html::encode( $modelo->notas).'</td>';
  echo '<td class="cen">';
  echo '<div class="acciones">';
  //-- echo 'Ver Modificar Eliminar';
  //if (tiene_permiso( 'articulos.ver')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Ver', 'icono'=>'ver.png',
      'activo'=>false, 'url'=>array('a'=>'articulos.ver', 'id'=>$modelo->referencia, 'p'=>$pagina)));
  //if (tiene_permiso( 'articulos.editar')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Editar', 'icono'=>'editar.png',
      'activo'=>false, 'url'=>array('a'=>'articulos.editar', 'id'=>$modelo->referencia, 'p'=>$pagina)));
  //if (tiene_permiso( 'articulos.borrar')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Borrar', 'icono'=>'borrar.png',
      'activo'=>false, 'url'=>array('a'=>'articulos.borrar', 'id'=>$modelo->referencia, 'p'=>$pagina)));
  echo '</div>';
  echo '</td>';
  echo '</tr>';
}//foreach
?>
</tbody>
<tfoot>
<tr>
  <td colspan="5">
<?php //Generar el pie de la tabla con la informacion y paginador
vista::generarPieza( 'paginador', array( 'url'=>array('a'=>'articulos'), 'total'=>$total, 'pagina'=>$pagina, 'lineas'=>$lineas));
?>
  </td>
  <td class="cen">
<?php //Generar el boton para CREAR.
//if (tiene_permiso( 'articulos.crear')) {
  echo '<div class="acciones">';
  vista::generarPieza( 'boton_accion', array( 'texto'=>'Nuevo', 'icono'=>'crear.png',
    'activo'=>true, 'url'=>array('a'=>'articulos.crear', 'p'=>$pagina)));
  echo '</div>';
//}//if
?>
  </td>
</tr>
</tfoot>
</table>
</div>