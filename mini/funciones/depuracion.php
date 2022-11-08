<?php
//Un sistema basico de gestion de depuracion y logs.
//(c) DAW2 - EPSZ - Univ. Salamanca
class log
{
  //-------------------------------------------------------------------------
  //Atributo con el fichero donde se almacena los mensajes de depuracion
  //enviados al LOG.
  //Si no esta iniciado, se coge el nombre por defecto.
  protected static $fichero= null;
  
  //-------------------------------------------------------------------------
  //Atributo con el identificador del archivo de LOG abierto.
  //Si en "null" no se ha abierto, si es "false" se ha intentado abrir pero
  //ha dado fallo de apertura/creación.
  protected static $id_fichero= null;
  
  //-------------------------------------------------------------------------
  //Función para obtener el nombre del archivo de LOG.
  public static function filename()
  {
    if (empty(self::$fichero)) {
      //iniciar el nombre por defecto si no esta iniciado.
      self::$fichero= dirname(dirname(__FILE__)).'/configuraciones/depuracion.log';
    }//if
//echo '<h1>'.self::$fichero.'</h1>';
    return self::$fichero;
  }//filename
  
  //-------------------------------------------------------------------------
  //Limpiar el archivo de LOG eliminandolo del sistema de ficehros.
  //Devuelve verdadero ("true") si se ha eliminado correctamente.
  public static function limpiar()
  {
    self::cerrar();//Cerrar por si está abierto.
    $res= @unlink( self::filename());//Eliminar el archivo.
    self::$fichero= null;//Limpiar el nombre para la proxima apertura.
    return $res;
  }//limpiar
  
  //-------------------------------------------------------------------------
  //Abrir el archivo de LOG si no está ya (o hubo error la última vez).
  //El argumento "$truncar" indica si se debe abrir para escritura iniciando
  //el archivo desde cero ($truncar=true) o se debe abrir para añadir textos
  //al final ($truncar=false).
  //Devuelve verdadero ("true") si se ha abierto correctamente o estaba ya
  //abierto el archivo.
  public static function abrir( $truncar=false)
  {
    if ((self::$id_fichero === null) || (self::$id_fichero === false)) {
      self::$id_fichero= @fopen( self::filename(), ($truncar ? 'w+b' : 'a+b'));
    }//if
    return (self::$id_fichero !== false);
  }//abrir
  
  //-------------------------------------------------------------------------
  //Cerrar el fichero de LOG si está abierto.
  //No devuelve nada pues se asume que el cierre siempre limpia o pierde el 
  //identificador del archivo abierto previamente.
  public static function cerrar()
  {
    if ((self::$id_fichero !== null) && (self::$id_fichero !== false)) {
      @fclose( self::$id_fichero);
    }//if
    self::$id_fichero= null;
  }//cerrar
  
  //-------------------------------------------------------------------------
  //Enviar un mensaje al archivo de LOG, opcionalmente con una marca de 
  //tiempo por delante del mismo en el momento de la depuración.
  //El mensaje se envía al fichero tal cual se haya recibido, sin añadir ni
  //quitar caracteres, a excepción de la marca de tiempo que se agrega por
  //delante en caso de haberlo indicado.
  public static function mensaje( $msg, $timestamp=true)
  {
    if (self::abrir()) {
//echo '<h1>abierto</h1>';
      //Imprimir el mensaje con la marca de tiempo si se ha indicado...
      $tiempo= ($timestamp ? self::timestamp().' ' : '');
      @fwrite( self::$id_fichero, $tiempo.$msg);
      @fflush( self::$id_fichero);
    }//if
  }//mensaje
  
  //-------------------------------------------------------------------------
  //Enviar un mensaje al archivo de LOG acabado con los caracteres que marcan
  //el FIN DE LINEA (CR + LF) y opcionalmente con una marca de tiempo por 
  //delante del mismo en el momento de la depuración.
  public static function mensajeLin( $msg, $timestamp=true)
  {
    self::mensaje( $msg . "\r\n", $timestamp);
  }//mensajeLin
  
  //-------------------------------------------------------------------------
  //Obtener la marca de tiempo actual formateada, con indicador de milisegundos
  //o no, según se especifique en el parámetro "$miliseconds".
  public static function timestamp( $miliseconds=true)
  {
    $time= self::microtime();
    $res= date('Y-m-d H:i:s', $time);
    if ($miliseconds) $res.= sprintf( '.%03d', (int)(($time - (int)$time) * 1000));
    return $res;
  }//timestamp
  
  //-------------------------------------------------------------------------
  //Obtener el valor en coma flotante del tiempo del sistema en microsegundos.
  //-La parte entera son los segundos, y la parte decimal los microsegundos.
  public static function microtime()
  {
//echo 'microtime= ('.microtime().'), ('.microtime(true).')<br>';
    if (version_compare( phpversion(), '5.0.0') < 0) {
      list( $usec, $sec) = explode( ' ', microtime());
      return ((float)$sec + (float)$usec);
    } else {  
      return microtime( true);
    }//if
  }//microtime
  
}//class log

//---------------------------------------------------------------------------
//Depurar un array de datos con (clave => valor) como salida HTML.
function depurar( $variables= array())
{
  //echo '<hr/>GET: '; print_r( $_GET);
  //echo '<hr/>POST: '; print_r( $_POST);
  //echo '<hr/>SESSION: '; print_r( $_SESSION);
  if (!is_array( $variables)) $variables= array( '_'=>$variables);
  foreach( $variables as $k=>$v) {
    echo '<hr/>'.$k.': '; print_r( $v);
  }
}//depurar


