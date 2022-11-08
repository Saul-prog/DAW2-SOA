<?php
//---------------------------------------------------------------------------
//Vista de BORRADO de pedidos...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "pedido" a visualizar o "null" si
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
<h1>Eliminar Pedido</h1>
<div class="hoja">
<table>
<?php //Generar el cuerpo de la tabla con la ficha de pedido.
vista::generarParcial( 'pedido_ficha', array( 'modelo'=>$modelo, 'error'=>$error));
?>
<tfoot>
<tr>
  <td colspan="2" class="cen">
  <div class="acciones">
<?php //Generar el pie de la tabla con las acciones.
if ($modelo !== null) {
//if (tiene_permiso( 'pedidos.borrar')) {
  vista::generarPieza( 'boton_accion', array( 'texto'=>'Confirmar Borrado', 'icono'=>false,
    'activo'=>false, 'url'=>array('a'=>'pedidos.borrar', 'id'=>$modelo->clavePrimaria(), 'ok'=>true, 'p'=>$pagina)));
//}//if "permiso"
}//if "hay modelo"
//Generar el boton para VOLVER.
vista::generarPieza( 'boton_accion', array( 'texto'=>'Volver', 'icono'=>'volver.png',
  'activo'=>true, 'url'=>array('a'=>'pedidos', 'p'=>$pagina)));
?>
  </div>
  </td>
</tr>
</tfoot>
</table>
</div>