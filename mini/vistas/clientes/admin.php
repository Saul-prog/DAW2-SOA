<?php
//---------------------------------------------------------------------------
//Vista de Administracion de clientes...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $registros --> array con los registros de la tabla de clientes.
//    $total --> número de registros totales de la tabla de clientes.
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
<h1>Clientes</h1>
<div class="hoja">
<table>
<thead>
<tr>
  <th>Ref.</th>
  <th>Cif/Nif</th>
  <th>Nombre</th>
  <th>Apellidos</th>
  <th>Dom.Fiscal</th>
  <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php //Generar los registros obtenidos de clientes.
$cli= new cliente;
foreach($registros as $indice => $registro) {
  $cli->llenar( $registro);
  echo '<tr class="'.(($indice % 2 == 0) ? 'par' : 'impar').'">';
  echo '<td class="cen">'.html::encode( $cli->referencia).'</td>';
  echo '<td class="cen">'.html::encode( $cli->cifnif).'</td>';
  echo '<td class="izq">'.html::encode( $cli->nombre).'</td>';
  echo '<td class="izq">'.html::encode( $cli->apellidos).'</td>';
  echo '<td class="izq">'.html::encode( $cli->domFiscal).'</td>';
  echo '<td class="cen">';
  echo '<div class="acciones">';
  //-- echo 'Ver Modificar Eliminar';
  //if (tiene_permiso( 'clientes.ver')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Ver', 'icono'=>'ver.png',
      'activo'=>false, 'url'=>array('a'=>'clientes.ver', 'id'=>$cli->referencia, 'p'=>$pagina)));
  //if (tiene_permiso( 'clientes.editar')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Editar', 'icono'=>'editar.png',
      'activo'=>false, 'url'=>array('a'=>'clientes.editar', 'id'=>$cli->referencia, 'p'=>$pagina)));
  //if (tiene_permiso( 'clientes.borrar')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Borrar', 'icono'=>'borrar.png',
      'activo'=>false, 'url'=>array('a'=>'clientes.borrar', 'id'=>$cli->referencia, 'p'=>$pagina)));
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
vista::generarPieza( 'paginador', array( 'url'=>array('a'=>'clientes'), 'total'=>$total, 'pagina'=>$pagina, 'lineas'=>$lineas));
?>
  </td>
  <td class="cen">
<?php //Generar el boton para CREAR.
//if (tiene_permiso( 'clientes.crear')) {
  echo '<div class="acciones">';
  vista::generarPieza( 'boton_accion', array( 'texto'=>'Nuevo', 'icono'=>'crear.png',
    'activo'=>true, 'url'=>array('a'=>'clientes.crear', 'p'=>$pagina)));
  echo '</div>';
//}//if
?>
  </td>
</tr>
</tfoot>
</table>
</div>