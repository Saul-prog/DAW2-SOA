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
<tbody class="formulario">
<?php if ($modelo !== null) { ?>
  <tr><th>Ref.</th><td>
    <input type="text" name="cliente[referencia]" id="cliente_referencia" maxlength="10" 
           value="<?php echo html::encode( $modelo->referencia);?>"/>
  </td></tr>
  <tr><th>Cif/Nif</th><td>
    <input type="text" name="cliente[cifnif]" id="cliente_cifnif" maxlength="10" 
           value="<?php echo html::encode( $modelo->cifnif);?>"/>
  </td></tr>
  <tr><th>Nombre</th><td>
    <input type="text" name="cliente[nombre]" id="cliente_nombre" maxlength="250" 
           value="<?php echo html::encode( $modelo->nombre);?>"/>
  </td></tr>
  <tr><th>Apellidos</th><td>
    <input type="text" name="cliente[apellidos]" id="cliente_apellidos" maxlength="250" 
           value="<?php echo html::encode( $modelo->apellidos);?>"/>
  </td></tr>
  <tr><th>Dom. Fiscal</th><td>
    <input type="text" name="cliente[domFiscal]" id="cliente_domFiscal" maxlength="250" 
           value="<?php echo html::encode( $modelo->domFiscal);?>"/>
  </td></tr>
  <tr><th>Dom. Envio</th><td>
    <input type="text" name="cliente[domEnvio]" id="cliente_domEnvio" maxlength="250" 
           value="<?php echo html::encode( $modelo->domEnvio);?>"/>
  </td></tr>
  <tr><th>Notas</th><td>
    <input type="text" name="cliente[notas]" id="cliente_notas" maxlength="250" 
           value="<?php echo html::encode( $modelo->notas);?>"/>
  </td></tr>
  <tr><th>E-Mail</th><td>
    <input type="text" name="cliente[email]" id="cliente_email" maxlength="100" 
           value="<?php echo html::encode( $modelo->email);?>"/>
  </td></tr>
  <tr><th>Password</th><td>
    <input type="password" name="cliente[password]" id="cliente_password" maxlength="32" 
           value="<?php echo html::encode( $modelo->password);?>"/>
  </td></tr>
<?php } else { ?>
  <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>