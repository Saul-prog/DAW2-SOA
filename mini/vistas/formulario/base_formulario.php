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
    <tr><th>Nombre</th><td>
            <input type="text" name="usuario[nombre]" id="nombre_usuario" maxlength="10"
                   value="<?php echo html::encode( $modelo->nombre_usuario);?>"/>
        </td></tr>
    <tr><th>Correo electrónico</th><td>
            <input type="text" name="usuario[email]" id="email" maxlength="250"
                   value="<?php echo html::encode( $modelo->email);?>"/>
        </td></tr>
    <tr><th>Contraseña</th><td>
            <input type="text" name="usuario[password]" id="password" maxlength="8"
                   value="<?php echo sprintf( '%0.2f', $modelo->password);?>"/>
        </td></tr>
<?php } else { ?>
    <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>