<?php
//Un sistema basico de gestion de sesiones
//(c) DAW2 - EPSZ - Univ. Salamanca
class sesion
{
  //-------------------------------------------------------------------------
  //Atributo de control de sesion iniciada o no.
  protected static $iniciada= false;
  
  //-------------------------------------------------------------------------
  //Iniciar el sistema de sesiones
  public static function start()
  {
    if (!self::$iniciada) {
      session_start();
      self::$iniciada= true;
    }//if
  }//start
  
  //-------------------------------------------------------------------------
  //Limpiar toda la informacion de la sesion e invalidarla completamente
  public static function clear()
  {
    if (self::$iniciada) {
      session_unset();
      //Si se usan COOKIES para el control del ID de sesion, eliminarlo tambien.
      if (ini_get("session.use_cookies")) {
        $params= session_get_cookie_params();
        setcookie( session_name(), '', time() - 42000,//tiempo caducado
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
        );
      }//if
      //Finalmente, destruir la sesión.
      session_destroy();
      //Y marcarla como no iniciada
      self::$iniciada= false;
    }//if
  }//clear
  
  //-------------------------------------------------------------------------
  //Obtener una variable de sesion
  public static function get( $variable, $defecto=null)
  {
    if (!self::$iniciada) self::start();
    $res= $defecto;
    if (isset($_SESSION[$variable])) $res= $_SESSION[$variable];
    //Descomentar la siguiente linea si se quieren guardar los 
    //parametros no creados manualmente que son por defecto.
    //--else if ($defecto !== null) self::set( $variable, $defecto);
    return $res;
  }//get

  //-------------------------------------------------------------------------
  //Establecer una variable de sesion
  public static function set( $variable, $valor)
  {
    if (!self::$iniciada) self::start();
    $_SESSION[$variable]= $valor;
    //Si se quiere hacer limpieza de variables nulas, descomentar la linea siguiente.
    if ($valor === null) unset( $_SESSION[$variable]);
  }//set

}//class sesion


