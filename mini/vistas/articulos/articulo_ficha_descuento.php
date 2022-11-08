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
<tbody class="ficha">
<?php if ($modelo !== null) { ?>
  <tr><th>Ref.</th><td><?php echo html::encode( $modelo->referencia);?></td></tr>
  <tr><th>Descripción</th><td><?php echo html::encode( $modelo->texto);?></td></tr>
  <tr><th>Precio</th><td><?php echo sprintf( '%0.2f', $modelo->precio);?></td></tr>
  <?php if($modelo->$descuento!=NULL){?>
  <tr><th>Descuento</th><td><?php echo sprintf( '%0.2f', $modelo->descuento);?></td></tr>
  <?php }?>
  <tr><th>%IVA</th><td><?php echo sprintf( '%0.2f', $modelo->iva);?></td></tr>
  <tr><th>Notas</th><td><?php echo html::encode( $modelo->notas);?></td></tr>
  <?php } else { ?>
  <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>