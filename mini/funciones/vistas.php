<?php
//Un sistema basico de gestion de vistas
//(c) DAW2 - EPSZ - Univ. Salamanca
class vista
{
  //-------------------------------------------------------------------------
  //Atributo con la ruta relativa a "index.php" donde se almacenan las vistas
  //de la aplicacion.
  public static $rutaVistas= 'vistas';
  
  //-------------------------------------------------------------------------
  //Atributo con la ruta relativa a la carpeta de vistas donde se almacenan
  //las piezas -trozos de vista- de la aplicacion.
  public static $rutaPiezas= 'piezas';
  
  //-------------------------------------------------------------------------
  //Atributo con la ruta relativa a la carpeta de vistas donde se almacenan
  //las plantillas -diseños de pagina- de la aplicacion.
  public static $rutaPlantillas= '.';
  
  //-------------------------------------------------------------------------
  //Atributo con el archivo de plantilla principal de las paginas de la
  //aplicacion.
  public static $plantilla= 'principal.php';
  
  //-------------------------------------------------------------------------
  //Generar una vista y mezclar su contenido resultante con la plantilla 
  //principal de la pagina configurada en la aplicacion.
  public static function generarPagina( $vista=null, $parametros=array())
  {
    $contenido= '';
	if ($vista !== null) {
	  $contenido= self::generarParcial( $vista, $parametros, true);
	} else if (isset( $parametros['contenido'])) {
	  $contenido= $parametros['contenido'];
	}
    require( self::$rutaVistas.'/'.self::$rutaPlantillas.'/'.self::$plantilla);
  }//generarPagina
  
  //-------------------------------------------------------------------------
  //Generar la vista de una pieza, a la que se le envian los parametros 
  //indicados como variables, y devolviendo el resultado como una cadena o
  //enviandolo como salida HTML directamente.
  public static function generarPieza( $pieza, $parametros=array(), $devolver= false)
  {
    return self::generarArchivo( self::$rutaVistas.'/'.self::$rutaPiezas.'/'.$pieza.'.php', $parametros, $devolver);
  }//generarPieza
  
  //-------------------------------------------------------------------------
  //Generar una vista de forma parcial, a la que se le envian los parametros 
  //indicados como variables, y devolviendo el resultado como una cadena o
  //enviandolo como salida HTML directamente segun el argumento "$devolver".
  //Si la vista contiene el separador de directorio "/", no se utiliza el
  //nombre del controlador actualmente en ejecución como nombre de subcarpeta
  //donde encontrar la vista dentro de la carpeta global de vistas, sino que 
  //se usa como ruta relativa desde la carpeta global de vistas.
  public static function generarParcial( $vista, $parametros=array(), $devolver= false)
  {
    $archivo= self::$rutaVistas;
    $pos= strpos( $vista, '/');
    if ($pos === false) {
      $archivo.= '/'.aplicacion::$id_controlador.'/';
    } else if ($pos == 0) {
      $archivo.= '';
    } else {
      $archivo.= '/';
    }//if
    $archivo.= $vista.'.php';
    return self::generarArchivo( $archivo, $parametros, $devolver);
  }//generarParcial
  
  //-------------------------------------------------------------------------
  //Generar el archivo de vista indicado inyectando los parametros como 
  //variables locales, y devolviendo la cadena con el HTML generado.
  protected static function generarArchivo( $_x_archivo, $_x_parametros, $_x_devolver=false)
  {
    if ($_x_devolver) ob_start();
    if (is_readable($_x_archivo)) {
      //Preparar los parametros como variables locales antes de ejecutar
      //el archivo de la vista. Descomentar la linea "extract" que interese
      //segun se deseen extraer solo parametros con nombre de variable
      //valido (primera linea), o todos, pero poniendo un prefijo de variable
      //en los nombres de indice que no sean validos o numericos (segunda 
      //linea) quedando como "$indice_N"...
      extract( $_x_parametros);
      //--extract( $parametros, EXTR_OVERWRITE || EXTR_PREFIX_INVALID, 'indice_');
      //Ejecutar la vista cargando el archivo PHP calculado.
      require( $_x_archivo);
    } else {
      error_grave( 'vista no disponible ('.$_x_archivo.').');
    }//if
    if ($_x_devolver) {
      $res= ob_get_clean();
      return $res;
    }//if
  }//generarArchivo
  
  //-------------------------------------------------------------------------
  //Enviar la orden de redirección al navegador web para que realize a otra 
  //peticion a la URL generada.
  // - $url --> cadena con la URL donde saltar, o cadena vacia si se desea
  // saltar a la misma pagina de llamada, o array con cadenas que indican
  // el controlador, accion para generar la URL de la aplicación.
  // - $datorUrl --> array de (clave => valor) con los argumentos adicionales
  // que debe llevar la URL donde saltar.
  public static function redirigir( $url='', $datosUrl=array())
  {
    if (is_array($url)) {
      $datosUrl[aplicacion::$parametroAccion]= implode( aplicacion::$separadorAccion, $url);
      $url= '';
    }//if
    if (count($datosUrl) > 0) {
      $url.= '?'.http_build_query( $datosUrl, 'arg');
    }//if
    //La salida se genera dependiendo de si ya hay salida HTML generada o no.
    if (headers_sent()) {
      echo '<script>';
      echo 'document.location='.json_encode($url).';';
      echo '</script>';
    } else {
      header('Location: '.$url, true, 302);
    }//if
  }//redirigir
  
}//class vista

//---------------------------------------------------------------------------
//Funciones de apoyo, que no son necesarias si se actualizan los lugares donde se usan.
function generar_pagina_error( $mensaje, $parametros=array())
{
  $old= vista::$plantilla;
  vista::$plantilla= 'error.php';
  $parametros['contenido']= $mensaje;
  vista::generarPagina( null, $parametros);
  vista::$plantilla= $old;
}//generar_pagina_error


//---------------------------------------------------------------------------
//Clase con funciones de apoyo a la generación de código HTML.
class html
{
  //---------------------------------------------------------------------------
  //Funcion de apoyo para incluir en HTML una cadena de caracteres de forma 
  //segura, en el juego de caracteres UTF8.
  public static function encode( $cadena)
  {
    return htmlspecialchars( $cadena, ENT_COMPAT, 'UTF-8');
  }//encode

}//class html


