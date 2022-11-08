<?php
//---------------------------------------------------------------------------
//Vista de FICHA de los totales de pedido que va embebida dentro de las 
//vistas de CONSULTA o BORRADO.
//---------------------------------------------------------------------------
// Datos que recibe:
//    $sumas --> Array de datos con clave el tipo de iva y valor un array con
//               la base y el iva calculado. Si no viene dado, se intenta
//               calcular del modelo "pedido" recibido.
//    $pedido --> Instancia con un modelo "pedido" al que pertenecen las 
//                lineas o "null" si hubo error de carga.
//---------------------------------------------------------------------------
/*-----*X/
echo '<pre>';
depurar( array( 
  'id_controlador' => aplicacion::$id_controlador,
  'id_accion' => aplicacion::$id_accion,
  'sumas' => $sumas,
  //'pedido' => $pedido,
));
echo '</pre>';
return;
//-----*/
//---------------------------------------------------------------------------
if (!isset($sumas)) {
  $sumas= array();
  //Si hay pedido, lo suyo es recorrer sus lineas acumulando las bases y 
  //cuotas de iva en funcion de su tipo.
  //...
}//if
//Ordenar el array de sumas por la clave (tipo de iva) en orden ascendente.
ksort( $sumas);
?>
<table>
<thead>
<tr>
    <th colspan="4">Resumen Bases</th>
</tr>
<tr>
  <th>%IVA</th>
  <th>Base</th>
  <th>Cuota</th>
  <th>Importe</th>
</tr>
</thead>
<tbody>
<?php //Generar las lineas recibidas con las sumas.
//Para acumular el total de cada base y cuota para el total final.
$total=array( 'base'=>0.0, 'iva'=>0.0);
$indice= 0;
foreach($sumas as $tipoIva => $importe) {
  echo '<tr class="'.(($indice % 2 == 0) ? 'par' : 'impar').'">';
  //----------
  //Columna %IVA
  echo '<td class="der">'.sprintf( '%0.2f', $tipoIva).'</td>';
  //Columna "BASE"
  echo '<td class="der">'.sprintf( '%0.2f', $importe['base']).'</td>';
  //Columna CUOTA
  echo '<td class="der">'.sprintf( '%0.2f', $importe['iva']).'</td>';
  //Columna IMPORTE PARCIAL
  echo '<td class="der">'.sprintf( '%0.2f', $importe['base']+$importe['iva']).'</td>';
  //----------
  echo '</tr>';
  //----------
  //Acumular las bases y cuotas de iva...
  $total['base']+= $importe['base'];
  $total['iva']+= $importe['iva'];
  $indice++;
}//foreach
?>
</tbody>
<tfoot class="totales">
<tr>
  <th class="der">Totales</th>
  <th class="der"><?php echo sprintf( '%0.2f', $total['base']); ?></th>
  <th class="der"><?php echo sprintf( '%0.2f', $total['iva']); ?></th>
  <th class="der"><?php echo sprintf( '%0.2f', $total['base'] + $total['iva']); ?></th>
</tr>
</tfoot>
</table>
