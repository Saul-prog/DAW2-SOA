<?php
//---------------------------------------------------------------------------
//Vista de MODIFICACION de articulos...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "articulo" a visualizar o "null" si
//                hubo error de carga.
//    $error  --> Mensaje de error o cadena vacia si no hubo.
//    $pagina --> numero de pagina que se esta obteniendo.
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
<h1>Datos del cliente</h1>
<form action="" method="post">
    <div class="hoja">
        <table>
            <?php //Generar el cuerpo de la tabla con el formulario de articulo.
            ?>
            <tbody class="formulario">

                <tr><th>Nombre</th><td>
                        <input type="text" name="cliente[nombre]" id=cliente_nombre" maxlength="50"
                               value=""/>
                    </td></tr>
                <tr><th>Apellido</th><td>
                        <input type="text" name="cliente[apellidos]" id="cliente_apellido" maxlength="50"
                               value=""/>
                    </td></tr>
                <tr><th>CIF/NIF</th><td>
                        <input type="text" name="cliente[cifnif]" id="domicilio_fiscal" maxlength="10"
                               value=""/>
                    </td></tr>
                <tr><th>Domicilio fiscal</th><td>
                        <input type="text" name="cliente[domicilio_fiscal]" id="domicilio_fiscal" maxlength="250"
                               value=""/>
                    </td></tr>
                <tr><th>Domicilio de Envío</th><td>
                    <input type="text" name="cliente[domicilio_envio]" id="domicilio_de_envio" maxlength="250"
                           value=""/>
                </td></tr>
                <tr><th>Notas</th><td>
                    <input type="text" name="cliente[notas]" id="notas" maxlength="250"
                           value=""/>
                </td></tr>

            </tbody>
            ?>
            <tfoot>
            <tr>
                <td colspan="2" class="cen">
                    <?php if (!empty($error)) { ?><div class="mensaje"><?php echo $error; ?></div><?php }//if ?>
                    <div class="acciones">
                        <?php //Generar el pie de la tabla con las acciones.
                        //if (tiene_permiso( 'articulos.editar')) {
                        vista::generarPieza( 'boton_accion', array( 'texto'=>'Guardar', 'icono'=>'guardar.png',
                            'activo'=>false, 'url'=>array('a'=>'compra.confirmar', 'p'=>0),
                            'submit'=>true));
                        //}//if "permiso"

                        //Generar el boton para VOLVER.
                        vista::generarPieza( 'boton_accion', array( 'texto'=>'Cancelar y Volver', 'icono'=>'volver.png',
                            'activo'=>true, 'url'=>array('a'=>'compra.ver', 'p'=>0)));
                        ?>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
</form>
</div>