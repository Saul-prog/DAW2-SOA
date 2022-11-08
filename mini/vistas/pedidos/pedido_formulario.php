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
<tbody class="formulario">
<?php if ($modelo !== null) { 
  //Calcular algunos datos previamente para darles un mejor formato...
  $serie= empty($modelo->serie) ? date('Y') : $modelo->serie;
  $numero= ($modelo->esNuevo() || empty($modelo->numero)) ? '...' : $modelo->numero;
  $fecha= strtotime( $modelo->fecha);
  $fecha= ($fecha === false) ? $modelo->fecha : date( 'd-m-Y', $fecha);//dejar fecha "incorrecta" si no es valida
  //--$fecha= date( 'Y-m-d', ($fecha === false) ? time() : $fecha);//dejar fecha actual si no es valida
  //$fecha= ($fecha === false) ? '' : date( 'd-m-Y', $fecha);
  $modelo->cargarCliente();
  $cliente= ($modelo->cliente === null) 
      ? 'Indicar Referencia del Cliente.' 
      : $modelo->cliente->apellidos.', '.$modelo->cliente->nombre;
  $domEnvio= '';
  if (!empty($modelo->domEnvio)) {
    $domEnvio= $modelo->domEnvio;
  } else if (($modelo->cliente !== null) && !empty($modelo->cliente->domEnvio)) {
    $domEnvio= $modelo->cliente->domEnvio;
  }//if
  $estados= $modelo->listaEstados();
?>
  <tr><th>Serie</th><td>
    <input type="text" name="pedido[serie]" id="pedido_serie" maxlength="4" size="15"
           value="<?php echo html::encode( $serie);?>"/>
  </td></tr>
  <tr><th>Número</th><td>
    <input type="text" name="pedido[numero]" id="pedido_numero" maxlength="6" size="15"
           readonly="readonly"
           value="<?php echo html::encode( $numero);?>"/>
  </td></tr>
  <tr><th>Fecha</th><td>
    <input type="text" name="pedido[fecha]" id="pedido_fecha" maxlength="10" size="15"
           value="<?php echo html::encode( $fecha);?>"/>
  </td></tr>
  <tr><th>Cliente</th><td>
    <input type="text" name="pedido[refCli]" id="pedido_refCli" maxlength="10" size="15"
           value="<?php echo html::encode( $modelo->refCli);?>"/>
    <div class="info"><?php echo $cliente; ?></div>
  </td></tr>
  <tr><th>Dom. Envio</th><td>
    <input type="text" name="pedido[domEnvio]" id="pedido_domEnvio" maxlength="250"
           value="<?php echo html::encode( $domEnvio);?>"/>
  </td></tr>
  <tr><th>Estado</th><td>
    <select type="text" name="pedido[estado]" id="pedido_estado" size="1"
           value="<?php echo html::encode( $domEnvio);?>">
    <?php foreach( $estados as $valor => $etiqueta) {
      echo '<option value="'.html::encode( $valor).'"'
          .(($modelo->estado== $valor) ? ' selected' : '')
          .'>'.html::encode( $etiqueta).'</option>';
    }//foreach ?>
    </select>
  </td></tr>
  <tr><th>Notas</th><td>
  <textarea name="pedido[notas]" id="pedido_notas" maxlength="1000" rows="5" cols="45"><?php echo html::encode( $modelo->notas);?></textarea>
  </td></tr>
  <tr><td colspan="2"><?php 
    vista::generarParcial( 'pedido_ficha_lineas', array( 'modelos'=>$modelo->lineas, 'pedido'=>$modelo)); 
  ?></td></tr>
<?php } else { ?>
  <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>