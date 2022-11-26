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
    <tr><th>Nombre.</th><td><?php echo html::encode( $modelo->nombre);?></td></tr>
    <tr><th>Login</th><td><?php echo html::encode( $modelo->login);?></td></tr>
    <tr><th>Contraseña</th><td><?php echo html::encode( $modelo->password);?></td></tr>
    <tr><th>Perfil</th><td><?php echo html::encode( $modelo->perfil);?></td></tr>
    <tr><th>última fecha</th><td><?php echo html::encode( $modelo->ultima_fecha);?></td></tr>
<?php } else { ?>
    <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>