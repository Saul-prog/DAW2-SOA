<?php 
//Pieza de generación de un "boton de accion" como un enlace a la aplicación 
//con los parametros de la URL recibidos, y algunos detalles más.
//---------------------------------------------------------------------------
// Datos:
// - $texto --> Es el texto a mostrar en el enlace generado para la acción.
// Si se indica un icono, el texto se usa como titulo y texto alternativo.
// - $icono --> Es el nombre del recurso de icono a usar como imagen para el
// enlace generado. Si no se indica, es falso o no se encuentra, no se genera
// el codigo para la imagen, y se muestra el texto indicado.
// - $url --> Es una cadena con la URL final a usar en el enlace, o un array 
// con (clave => valor) con la lista de parametros que se van a incluir en la
// URL generada para el enlace del boton. Lo normal es que se reciban los 
// parametros para acceder al controlador y accion deseados, o la cadena con
// un enlace externo o similar, o se pueden incluir, por ejemplo, parametros 
// que sirvan para recordar la página donde se estaba previamente para usarlo
// al volver a la típica vista de administración cuando se haya terminado la 
// ejecución de la acción indicada por la URL.
// - $activo --> Indicador de si el boton debe llevar la clase "activo" o no.
// Si no se indica o es nulo o falso no se establece.
// - $submit --> Indicador de si el boton debe ejecutar la accion "submit" 
// sobre el formulario al que pertenece o no. Si es así, se genera el javascript
// necesario para ello.
//---------------------------------------------------------------------------
if (!isset($texto)) $texto= '';
if (!isset($icono)) $icono= false;
if (!isset($url)) $url= array();
if (!isset($activo)) $activo= false;
if (!isset($submit)) $submit= false;
//--<div class="boton-accion">
?>
<?php //Generar el enlace segun exista icono o no, ...
if (is_array($url)) $url= '?'.http_build_query( $url, 'arg');
if (is_string( $icono) && is_readable( dirname(__FILE__).'/../../recursos/'.$icono)) {
  $icono= '<img src="recursos/'.$icono.'" title="'.$texto.'" alt="'.$texto.'" />';
} else {
  $icono= false;
}//if
echo '<a href="'.$url.'"'.($activo ? ' class="activo"':'')
  .($submit ? 'onclick="document.forms[0].action=this.href;document.forms[0].submit();return false;"' : '')
  .'>';
if ($icono !== false) echo $icono;
else echo $texto;
echo '</a>';
//--</div>
?>
