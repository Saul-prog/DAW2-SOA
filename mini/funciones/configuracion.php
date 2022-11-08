<?php
//Un sistema basico de gestion de configuraciones
//(c) DAW2 - EPSZ - Univ. Salamanca
class config
{
  //-------------------------------------------------------------------------
  //Atributo de control de configuracion cargada o no.
  protected static $cargada= false;
  
  //-------------------------------------------------------------------------
  //Atributo con el fichero donde se almacena la configuracion.
  //Si no esta iniciado, se coge el nombre por defecto.
  protected static $fichero= null;
  
  //-------------------------------------------------------------------------
  //Atributo con los datos de configuracion cargados en memoria, para que no
  //se tenga que leer el fichero continuamente en cada carga de la clase.
  protected static $datos= null;
  
  //-------------------------------------------------------------------------
  //Función para obtener el nombre del archivo de la configuración
  public static function filename()
  {
    if (empty(self::$fichero)) {
      //iniciar el nombre por defecto si no esta iniciado.
      self::$fichero= dirname(dirname(__FILE__))
          .'/configuraciones/aplicacion.php';
    }//if
    return self::$fichero;
  }//filename
  
  //-------------------------------------------------------------------------
  //Función para cargar los datos de configuración de la aplicacion.
  //Devuelve "true" si se ha cargado correctamente.
  public static function load( $reload=false)
  {
    $res= false;
    //Si no esta cargada la configuracion o se desea recargar...
    if (!self::$cargada || $reload) {
      $archivo= self::filename();
      if (is_readable($archivo)) {
        self::$datos= require( $archivo);
        if (!is_array(self::$datos)) self::$datos= array( self::$datos); 
        self::$cargada= true;
        $res= true;
      } else {
        error_grave('No es posible cargar la configuración de la aplicación.');
      }//if
    }//if
    return $res;
  }//load
  
  //-------------------------------------------------------------------------
  //Función para guardar los datos de configuración de la aplicacion en el
  //fichero.
  public static function save()
  {
    $res= false;
    if (self::$cargada) {
      $archivo= self::filename();
      if (is_writable($archivo) 
          || (!file_exists($archivo) && is_writable(dirname($archivo)))) {
        $datos= (empty(self::$datos) ? array() : self::$datos);
        file_put_contents( $archivo, 
          '<?php'."\r\n".
          '//Configuración del Sistema actualizada el '.date('Y-m-d H:i:s')."\r\n".
          'return '.var_export( $datos, true).';'."\r\n"
        );
        $res= true;
      } else {
        error_grave('No es posible guardar la configuración de la aplicación.');
      }//if
    }//if
    return $res;
  }//save

  
  //-------------------------------------------------------------------------
  //Limpiar la configuración de la aplicación para forzar a recargarla en 
  //caso de utilizarlos de nuevo, o simplemente para quitarla de memoria.
  //Este metodo NO ELIMINA LAS VARIABLES ALMACENADAS EN EL ARCHIVO.
  public static function clear()
  {
    self::$datos= null;
    self::$fichero= null;
    self::$cargada= false;
  }//clear
  
  //-------------------------------------------------------------------------
  //Obtener una variable de configuracion y si se encuentra obtener el valor
  //dado por defecto.
  public static function get( $variable, $defecto=null)
  {
//echo __METHOD__.'['.__LINE__.']'."<br/>";
    if (!self::$cargada) self::load();
    $res= $defecto;
    if (self::$cargada) {//si se ha cargado el archivo, se puede leer.
      if (isset(self::$datos[$variable])) $res= self::$datos[$variable];
      //Descomentar la siguiente linea si se quieren guardar los parametros
      //no creados manualmente que son por defecto y con algun valor...
      //--else if ($defecto !== null) self::set( $variable, $defecto);
      //...o descomentar la siguiente linea si se quieren guardar todos los
      //parametros no creados manualmente que son por defecto.
      else self::set( $variable, $defecto);
    }//if
    return $res;
  }//get

  //-------------------------------------------------------------------------
  //Establecer una variable de configuracion al valor dado. Si es necesario
  //se actualiza el archivo donde se almacena la configuración.
  public static function set( $variable, $valor)
  {
    if (!self::$cargada) self::load();//si se carga bien ya se ha marcado la carga.
    //Si no se ha cargado puede ser porque no exista el fichero inicialmente,
    //con lo que se inicia a una configuracion vacia.
    if (!self::$cargada) {
      self::$datos= array();
      self::$cargada= true;
    }//if
    self::$datos[$variable]= $valor;
    //Si se quiere hacer limpieza de variables nulas, descomentar la linea siguiente.
    //if ($valor === null) unset( self::$datos[$variable]);
    //Cada vez que hay un cambio se guarda en el archivo, con lo que se debe
    //procurar hacer pocas modificaciones en la configuración, ya que no es
    //el objetivo de un archivo de este tipo el estar modificándose cada poco.
    //De paso se devuelve el resultado de la grabación.
    return self::save();
  }//set
  
  //-------------------------------------------------------------------------
  //Obtener la lista de variables de configuracion de la aplicación.
  //Devuelve un array con los nombres de las variables almacenadas en el 
  //archivo de configuracion.
  public static function getVars()
  {
    if (!self::$cargada) self::load();
    $res= array();
    if (self::$cargada) {//si se ha cargado el archivo, se puede leer.
      $res= array_keys( self::$datos);
    }//if
    return $res;
  }//getVars
  
}//class config
