<?php
//---------------------------------------------------------------------------
//Vista de FICHA de cliente que va embebida dentro de las vistas de 
//CONSULTA o BORRADO.
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "Cliente" a visualizar o "null" si
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
  <tr><th>Cif/Nif</th><td><?php echo html::encode( $modelo->cifnif);?></td></tr>
  <tr><th>Nombre</th><td><?php echo html::encode( $modelo->nombre);?></td></tr>
  <tr><th>Apellidos</th><td><?php echo html::encode( $modelo->apellidos);?></td></tr>
  <tr><th>Dom. Fiscal</th><td><?php echo html::encode( $modelo->domFiscal);?></td></tr>
  <tr><th>Dom. Envio</th><td><?php echo html::encode( $modelo->domEnvio);?></td></tr>
  <tr><th>Notas</th><td><?php echo html::encode( $modelo->notas);?></td></tr>
  <tr><th>E-Mail</th><td><?php echo html::encode( $modelo->email);?></td></tr>
  <tr><th>Password</th><td><?php echo html::encode( $modelo->password);?></td></tr>
<?php } else { ?>
  <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>