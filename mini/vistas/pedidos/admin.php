<?php
//---------------------------------------------------------------------------
//Vista de Administracion de pedidos...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $registros --> array con los registros de la tabla de pedidos.
//    $total --> número de registros totales de la tabla de pedidos.
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
<h1>Pedidos</h1>
<div class="hoja">
<table>
<thead>
<tr>
  <th>Serie/Numero</th>
  <th>Fecha</th>
  <th>Cliente</th>
  <th>Estado</th>
  <th>Notas</th>
  <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php //Generar los registros obtenidos de pedidos.
$modelo= new pedido;
foreach($registros as $indice => $registro) {
  $modelo->cargarRegistro( $registro);
  echo '<tr class="'.(($indice % 2 == 0) ? 'par' : 'impar').'">';
  //Columna SERIE/NUMERO
  echo '<td class="cen">'.html::encode( sprintf( '%s/%06d', $modelo->serie, $modelo->numero)).'</td>';
  //Columna FECHA
  $fecha= strtotime( $modelo->fecha); 
  $fecha= (($fecha === false) ? '' : date( 'd-m-Y', $fecha));
  echo '<td class="cen">'.html::encode( $fecha).'</td>';
  //Columna CLIENTE
  $cliente= $modelo->refCli;
  if ($modelo->cargarCliente()) $cliente.= ' - '.$modelo->cliente->apellidos.', '.$modelo->cliente->nombre;
  else $cliente= '*'.$cliente;//indicar una referencia que no existe en la bd.
  echo '<td class="izq">'.html::encode( $cliente).'</td>';
  //Columna ESTADO
  echo '<td class="cen">'.html::encode( pedido::textoEstado( $modelo->estado)).'</td>';
  //Columna NOTAS
  echo '<td class="izq">'.html::encode( $modelo->notas).'</td>';
  //Columna ACCIONES
  echo '<td class="cen">';
  echo '<div class="acciones">';
  //-- echo 'Ver Modificar Eliminar';
  //if (tiene_permiso( 'pedidos.ver')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Ver', 'icono'=>'ver.png',
      'activo'=>false, 'url'=>array('a'=>'pedidos.ver', 'id'=>$modelo->clavePrimaria(), 'p'=>$pagina)));
  //if (tiene_permiso( 'pedidos.editar')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Editar', 'icono'=>'editar.png',
      'activo'=>false, 'url'=>array('a'=>'pedidos.editar', 'id'=>$modelo->clavePrimaria(), 'p'=>$pagina)));
  //if (tiene_permiso( 'pedidos.borrar')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Borrar', 'icono'=>'borrar.png',
      'activo'=>false, 'url'=>array('a'=>'pedidos.borrar', 'id'=>$modelo->clavePrimaria(), 'p'=>$pagina)));
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
vista::generarPieza( 'paginador', array( 'url'=>array('a'=>'pedidos'), 'total'=>$total, 'pagina'=>$pagina, 'lineas'=>$lineas));
?>
  </td>
  <td class="cen">
<?php //Generar el boton para CREAR.
//if (tiene_permiso( 'pedidos.crear')) {
  echo '<div class="acciones">';
  vista::generarPieza( 'boton_accion', array( 'texto'=>'Nuevo', 'icono'=>'crear.png',
    'activo'=>true, 'url'=>array('a'=>'pedidos.crear', 'p'=>$pagina)));
  echo '</div>';
//}//if
?>
  </td>
</tr>
</tfoot>
</table>
</div>