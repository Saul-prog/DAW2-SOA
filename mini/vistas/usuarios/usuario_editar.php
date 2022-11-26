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
<h1>Editar Usuario</h1>
<form action="" method="post">
    <div class="hoja">
        <table>
            <?php //Generar el cuerpo de la tabla con el formulario de articulo.
            vista::generarParcial( 'usuario_formulario', array( 'modelo'=>$modelo, 'error'=>$error));
            ?>
            <tfoot>
            <tr>
                <td colspan="2" class="cen">
                    <?php if (!empty($error)) { ?><div class="mensaje"><?php echo $error; ?></div><?php }//if ?>
                    <div class="acciones">
                        <?php //Generar el pie de la tabla con las acciones.
                        //if (tiene_permiso( 'articulos.editar')) {
                        vista::generarPieza( 'boton_accion', array( 'texto'=>'Guardar', 'icono'=>'guardar.png',
                            'activo'=>false, 'url'=>array('a'=>'usuario.editar', 'id'=>$modelo->id, 'p'=>$pagina),
                            'submit'=>true));
                        //}//if "permiso"

                        //Generar el boton para VOLVER.
                        vista::generarPieza( 'boton_accion', array( 'texto'=>'Cancelar y Volver', 'icono'=>'volver.png',
                            'activo'=>true, 'url'=>array('a'=>'usuarios', 'p'=>$pagina)));
                        ?>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
</form>
</div>