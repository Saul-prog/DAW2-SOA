<?php
//---------------------------------------------------------------------------
//Vista de CREACION de articulos...
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
<div class="w3-card-4">
    <div class="w3-container w3-green">
        <h1>Crear cuenta</h1>

    </div>

<form action="" method="post" class="w3-container">

        <table >
            <?php //Generar el cuerpo de la tabla con el formulario de usuario.
            vista::generarParcial( 'inicio_formulario', array( 'modelo'=>$modelo, 'error'=>$error));
            ?>
            <tfoot>
            <tr>
                <td colspan="2" class="cen">
                    <?php if (!empty($error)) { ?><div class="w3-panel w3-red"><?php echo $error; ?></div><?php }//if ?>
                    <div class="acciones">
                        <?php //Generar el pie de la tabla con las acciones.

                        vista::generarPieza( 'boton_accion', array( 'texto'=>'Crear Nuevo', 'icono'=>'guardar.png',
                            'activo'=>false, 'url'=>array('a'=>'inicio.registro', 'p'=>$pagina,'vuelta'=>$vuelta),
                            'submit'=>true));


                        //Generar el boton para VOLVER.
                        vista::generarPieza( 'boton_accion', array( 'texto'=>'Cancelar y Volver', 'icono'=>'volver.png',
                            'activo'=>true, 'url'=>array('a'=>'inicio', 'p'=>$pagina)));
                        ?>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>

</form>
</div>
