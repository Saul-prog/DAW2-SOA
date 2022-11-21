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
<?php if ($registro !== null) { ?>
    <tr><th>Ref.</th><td><?php echo html::encode( $registro);?></td></tr>
    <tr><th>Precio</th><td><?php echo sprintf( 'Precio');?></td></tr>
    <tr><th>%IVA</th><td><?php echo sprintf( 'IVA');?></td></tr>
    <tr><th>Cantidad</th><td><?php echo html::encode( $registro['cantidad']);?></td></tr>
    <tr><th>Precio</th><td><?php echo html::encode( 'Precio Final');?></td></tr>
<?php } ?>
</tbody>