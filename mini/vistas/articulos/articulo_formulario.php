<?php
//---------------------------------------------------------------------------
//Vista de FICHA de articulo que va embebida dentro de las vistas de 
//CONSULTA o BORRADO.
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "Articulo" a visualizar o "null" si
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
    <input type="text" name="articulo[referencia]" id="articulo_referencia" maxlength="10" 
           value="<?php echo html::encode( $modelo->referencia);?>"/>
  </td></tr>
  <tr><th>Descripción</th><td>
    <input type="text" name="articulo[texto]" id="articulo_texto" maxlength="250" 
           value="<?php echo html::encode( $modelo->texto);?>"/>
  </td></tr>
  <tr><th>Precio</th><td>
    <input type="text" name="articulo[precio]" id="articulo_precio" maxlength="8" 
           value="<?php echo sprintf( '%0.2f', $modelo->precio);?>"/>
  </td></tr>
  <tr><th>%IVA</th><td>
    <input type="text" name="articulo[iva]" id="articulo_iva" maxlength="5" 
           value="<?php echo sprintf( '%0.2f', $modelo->iva);?>"/>
  </td></tr>
  <tr><th>Notas</th><td>
	<textarea name="articulo[notas]" id="articulo_notas" maxlength="1000" rows="5" cols="45"><?php echo html::encode( $modelo->notas);?></textarea>
  </td></tr>
<?php } else { ?>
  <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>