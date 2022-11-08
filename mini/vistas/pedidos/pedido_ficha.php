<?php
//---------------------------------------------------------------------------
//Vista de FICHA de pedido que va embebida dentro de las vistas de 
//CONSULTA o BORRADO.
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "pedido" a visualizar o "null" si
//                hubo error de carga.
//    $error  --> Mensaje de error o cadena vacia si no hubo.
//---------------------------------------------------------------------------
/*-----*X/
echo '<pre>';
depurar( array( 
  'id_controlador' => aplicacion::$id_controlador,
  'id_accion' => aplicacion::$id_accion,
  'modelo' => $modelo,
  'error' => $error,
));
echo '</pre>';
return;
//-----*/

?>
<tbody class="ficha">
<?php if ($modelo !== null) { 
  //-------------------------------------------------------------------------
  $serieNumero= sprintf( '%s/%06d', $modelo->serie, $modelo->numero);
  $fecha= strtotime( $modelo->fecha); 
  $fecha= (($fecha === false) ? '' : date( 'd-m-Y', $fecha));
  $cliente= $modelo->refCli;
  if ($modelo->cargarCliente()) $cliente.= ' - '.$modelo->cliente->apellidos.', '.$modelo->cliente->nombre;
  $estado= $modelo->estado.' - '.pedido::textoEstado( $modelo->estado);

?>
  <tr><th>Serie/Numero</th><td><?php echo html::encode( $serieNumero);?></td></tr>
  <tr><th>Fecha</th><td><?php echo html::encode( $fecha);?></td></tr>
  <tr><th>Cliente</th><td><?php echo html::encode( $cliente);?></td></tr>
  <tr><th>Dom. Envio</th><td><?php echo html::encode( $modelo->domEnvio);?></td></tr>
  <tr><th>Estado</th><td><?php echo html::encode( $estado);?></td></tr>
  <tr><th>Notas</th><td><?php echo html::encode( $modelo->notas);?></td></tr>
  <tr><td colspan="2"><?php
    vista::generarParcial( 'pedido_ficha_lineas', array( 'modelos'=>$modelo->lineas, 'pedido'=>$modelo)); 
  ?></td></tr>
<?php } else { ?>
  <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>