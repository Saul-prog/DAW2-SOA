<?php
//---------------------------------------------------------------------------
//Vista de MODIFICACION de clientes...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "Cliente" a visualizar o "null" si
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
<h1>Editar Cliente</h1>
<form action="" method="post">
<div class="hoja">
<table>
<?php //Generar el cuerpo de la tabla con el formulario de cliente.
vista::generarParcial( 'cliente_formulario', array( 'modelo'=>$modelo, 'error'=>$error));
?>
<tfoot>
<tr>
  <td colspan="2" class="cen">
  <?php if (!empty($error)) { ?><div class="mensaje"><?php echo $error; ?></div><?php }//if ?>
  <div class="acciones">
<?php //Generar el pie de la tabla con las acciones.
//if (tiene_permiso( 'clientes.editar')) {
  vista::generarPieza( 'boton_accion', array( 'texto'=>'Guardar', 'icono'=>'guardar.png',
    'activo'=>false, 'url'=>array('a'=>'clientes.editar', 'id'=>$modelo->referencia, 'p'=>$pagina), 
    'submit'=>true));
//}//if "permiso"

//Generar el boton para VOLVER.
vista::generarPieza( 'boton_accion', array( 'texto'=>'Cancelar y Volver', 'icono'=>'volver.png',
  'activo'=>true, 'url'=>array('a'=>'clientes', 'p'=>$pagina)));
?>
  </div>
  </td>
</tr>
</tfoot>
</table>
</form>
</div>