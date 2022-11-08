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
<h1>Crear Articulo</h1>
<form action="" method="post">
<div class="hoja">
<table>
<?php //Generar el cuerpo de la tabla con el formulario de articulo.
vista::generarParcial( 'articulo_formulario', array( 'modelo'=>$modelo, 'error'=>$error));
?>
<tfoot>
<tr>
  <td colspan="2" class="cen">
  <?php if (!empty($error)) { ?><div class="mensaje"><?php echo $error; ?></div><?php }//if ?>
  <div class="acciones">
<?php //Generar el pie de la tabla con las acciones.
//if (tiene_permiso( 'articulos.crear')) {
  vista::generarPieza( 'boton_accion', array( 'texto'=>'Crear Nuevo', 'icono'=>'guardar.png',
    'activo'=>false, 'url'=>array('a'=>'articulos.crear', 'p'=>$pagina), 
    'submit'=>true));
//}//if "permiso"

//Generar el boton para VOLVER.
vista::generarPieza( 'boton_accion', array( 'texto'=>'Cancelar y Volver', 'icono'=>'volver.png',
  'activo'=>true, 'url'=>array('a'=>'articulos', 'p'=>$pagina)));
?>
  </div>
  </td>
</tr>
</tfoot>
</table>
</form>
</div>