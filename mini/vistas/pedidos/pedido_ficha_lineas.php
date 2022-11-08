<?php
//---------------------------------------------------------------------------
//Vista de FICHA de lineas de pedido que va embebida dentro de las vistas de 
//CONSULTA o BORRADO.
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelos --> Array de instancias con las "lineas de pedido" a visualizar.
//    $pedido --> Instancia con un modelo "pedido" al que pertenecen las 
//                lineas o "null" si hubo error de carga.
//---------------------------------------------------------------------------
/*-----*X/
echo '<pre>';
depurar( array( 
  'id_controlador' => aplicacion::$id_controlador,
  'id_accion' => aplicacion::$id_accion,
  'modelos' => $modelos,
  'pedido' => $pedido,
));
echo '</pre>';
return;
//-----*/
?>
<div class="hoja interior">
<table>
<thead>
<tr>
  <th colspan="7">Detalle de Líneas de Artículos del Pedido</th>
</tr>
<tr>
  <th>Linea</th>
  <th>Articulo</th>
  <th>Descripción</th>
  <th>Cantidad</th>
  <th>Precio</th>
  <th>%IVA</th>
  <th>Importe</th>
</tr>
</thead>
<tbody>
<?php //Generar las lineas recibidas del pedido.
if (count($modelos) == 0) {
  echo '<tr class="par">';
  echo '<td colspan="7" class="cen">No hay lineas en el pedido.</td>';
  echo '</tr>';
} else {
  //Para acumular los diferentes importes base y cuotas de iva para el total final.
  $sumas=array();
  foreach($modelos as $indice => $modelo) {
    echo '<tr class="'.(($indice % 2 == 0) ? 'par' : 'impar').'">';
    
    //Columna "LINEA"= orden + titulo(serie,numero,idLinea)
    echo '<td class="cen" title="'.html::encode( sprintf( '%s/%06d [%d]', $modelo->serie, $modelo->numero, $modelo->idLinea)).'">'.html::encode( sprintf( '%d', $modelo->orden)).'</td>';
    //Columna ARTICULO
    $articulo= $modelo->refArt;
    if ($articulo === null) {
      $articulo= '...';
    } else if (!$modelo->cargarArticulo()) {
      $articulo= '*'.$articulo;//indicar una referencia que no existe en la bd.
    }//if
    echo '<td class="cen">'.html::encode( $articulo).'</td>';
    //Columna DESCRIPCION
    echo '<td class="izq">'.html::encode( $modelo->texto).'</td>';
    //Columna CANTIDAD
    echo '<td class="der">'.sprintf( '%d', $modelo->cantidad).'</td>';
    //Columna PRECIO
    echo '<td class="der">'.sprintf( '%0.2f', $modelo->precio).'</td>';
    //Columna %IVA
    echo '<td class="der">'.sprintf( '%0.2f', $modelo->iva).'</td>';
    //Columna IMPORTE
    echo '<td class="der">'.sprintf( '%0.2f', $modelo->importeBase).'</td>';

    echo '</tr>';
    //----------
    //Acumular las bases y cuotas de iva...
    if (!isset($sumas[$modelo->iva])) {
      $sumas[$modelo->iva]= array( 'base'=>0.0, 'iva'=>0.0);
    }//if
    $sumas[$modelo->iva]['base']+= $modelo->importeBase;
    $sumas[$modelo->iva]['iva']+= $modelo->cuotaIva;
  }//foreach
}//if
?>
</tbody>
<?php /*-----*/ 
if (count($modelos) > 0) {
?>
<tfoot>
<tr>
  <td colspan="3">
    &nbsp;
  </td>
  <td colspan="4">
<?php //Generar el pie de la tabla con la informacion de las bases e ivas y el total
vista::generarParcial( 'pedido_ficha_totales', array( 'sumas'=>$sumas, 'pedido'=>$pedido));
?>
  </td>
</tr>
</tfoot>
<?php 
}//if
//-----*/?>
</table>
</div>
