<?php
//---------------------------------------------------------------------------
//Vista de CONSULTA de articulos...
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
<h1>Datos de envío</h1>
<div class="hoja">
    <table>
        <?php //Generar el cuerpo del cliente.?>
        <tbody class="ficha">
            <?php if ($cliente !== null) { ?>
        <tr><th>Nombre</th><td><?php echo html::encode( $cliente->nombre);?></td></tr>
        <tr><th>Apellido</th><td><?php echo html::encode( $cliente->apellidos);?></td></tr>
        <tr><th>NIF/CIF</th><td><?php echo html::encode( $cliente->cifnif);?></td></tr>
        <tr><th>Domicilio Fiscal</th><td><?php echo html::encode( $cliente->domFiscal);?></td></tr>
        <tr><th>Domicilio Envío</th><td><?php echo html::encode( $cliente->domEnvio);?></td></tr>
        <tr><th>email</th><td><?php echo html::encode( $cliente->email);?></td></tr>
            <?php } else { ?>
        <tr><th>Error</th><td><?php echo $error;?></td></tr>
        <?php }//if ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" class="cen">
                <div class="acciones">
                    <?php
                    //Generar el pie de la tabla con las acciones.
                    //if (tiene_permiso( 'articulos.editar')) {
                    vista::generarPieza( 'boton_accion', array( 'texto'=>'Confirmar y pagar', 'icono'=>'editar.png',
                        'activo'=>false, 'url'=>array('a'=>'compra.pagar',)));
                    //}//if "permiso"

                    //Generar el boton para VOLVER.
                    vista::generarPieza( 'boton_accion', array( 'texto'=>'Volver', 'icono'=>'volver.png',
                        'activo'=>true, 'url'=>array('a'=>'compra')));
                    ?>
                </div>
            </td>
        </tr>
        </tfoot>
    </table>
</div>