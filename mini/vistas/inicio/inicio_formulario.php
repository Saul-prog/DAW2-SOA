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
            <input type="text" name="usuarioAcceso[nombre]" id="usuario_referencia" maxlength="50"
                   value="<?php echo html::encode( $modelo->nombre);?>"/>
        </td></tr>
    <tr><th>Email</th><td>
            <input type="email" name="usuarioAcceso[login]" id="usuario_login" maxlength="32"
                   value="<?php echo html::encode( $modelo->login);?>"/>
        </td></tr>
    <tr><th>Contraseña</th><td>
            <input type="password" name="usuarioAcceso[password]" id="usuario_password" maxlength="32"
                   value="<?php echo html::encode(  $modelo->password);?>"/>
        </td></tr>

            <input type="hidden" name="usuarioAcceso[perfil]" id="usuario_perfil" maxlength="32"
                   value="Cliente"/>


            <?php
            $modelo->ultima_fecha=date("Y-m-d H:i:s");

            ?>
            <input type="hidden" name="usuarioAcceso[ultima_fecha]" id="usuario_ultima_fecha" maxlength="32"
                   value="<?php echo html::encode($modelo->ultima_fecha);?>"/>

<?php } else { ?>
    <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>