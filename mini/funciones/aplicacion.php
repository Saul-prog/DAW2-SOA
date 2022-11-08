<?php
//Un sistema basico de gestion de aplicación (flujo de ejecución)
//(c) DAW2 - EPSZ - Univ. Salamanca
class aplicacion
{

  public static $modoPublico= false;
  
  //-------------------------------------------------------------------------
  //Atributo con la ruta relativa a "index.php" donde se almacenan los 
  //controladores de la aplicacion.
  public static $rutaControladores= 'controladores';
  
  //-------------------------------------------------------------------------
  //Atributos con la configuración del parametro de URL ($_GET) que indica 
  //el controlador/accion a ejecutar por la petición en curso, y el separador
  //utilizado entre controlador y accion dentro de el.
  public static $parametroAccion= 'a';
  public static $separadorAccion= '.';
  
  //-------------------------------------------------------------------------
  //Atributo con el controlador actual que se debe ejecutar o ya se esta 
  //ejecutando en la aplicación según los datos de la petición.
  public static $id_controlador= null;//nombre identificador del controlador.
  public static $controlador= null;//instancia del controlador.
  
  //-------------------------------------------------------------------------
  //Atributo con la accion actual que se debe ejecutar o ya se esta
  //ejecutando en la aplicación según los datos de la petición.
  public static $id_accion= null;
  
  //-------------------------------------------------------------------------
  //Metodo para extraer la información del controlador/accion que se ha pedido
  //ejecutar, y realizar las acciones correspondientes para ello.
  public static function ejecutar()
  {
    $ejecutar= '';
    if (isset($_GET[self::$parametroAccion])) $ejecutar= trim( $_GET[self::$parametroAccion]);
    
    $ejecutar= (empty($ejecutar) ? array() : explode( self::$separadorAccion, $ejecutar));
    self::$id_accion= (isset($ejecutar[1]) ? trim($ejecutar[1]) : '');
//echo __METHOD__.'['.__LINE__.']'."<br/>";    
    self::$id_controlador= (isset($ejecutar[0]) 
        ? trim($ejecutar[0]) 
        : config::get('aplicacion.controlador.defecto',''));
	//En este pundo se conocen los IDs de controlador y de accion, con lo que se
	//puede realizar el posible mapeo de URLs si hubiera alguna equivalencia.
	//La idea seria convertir los IDs de controlador y de accion recibidos en 
	//otros IDs para apuntar a otros de forma mas amigable o con nombre largos
	//que nos interesa "ocultar".
    //--mapear_controlador_accion();
//depurar( array( 'ejecutar', $ejecutar));
//echo __METHOD__.'['.__LINE__.']'."<br/>";
    if (empty(self::$id_controlador)) {
      error_grave( 'No es posible ejecutar la petición,'
          .' no hay controlador predefinido.');
    } else {
      self::$id_controlador= strtolower( self::$id_controlador);
      $archivo= self::$rutaControladores.'/'.self::$id_controlador.'.php';
      if (!is_readable($archivo)) {
        error_grave( 'No es posible ejecutar la petición,'
            .' no existe el archivo para el controlador'
            .' "'.self::$id_controlador.'".'); 
      } else {
        $clase_control= 'controlador_'.self::$id_controlador;
        require_once( $archivo);
        if (!class_exists( $clase_control, false)) {
          error_grave( 'No es posible ejecutar la petición,'
              .' no existe la clase para el controlador'
              .' "'.self::$id_controlador.'".');
        } else {
          self::$controlador= new $clase_control;
          if (self::$controlador === null) {
            error_grave( 'No es posible ejecutar la petición,'
              .' no se ha creado la instancia de control'
              .' "'.self::$id_controlador.'".');
          } else {
            if (empty(self::$id_accion)) self::$id_accion= self::$controlador->accion_defecto;
            if (empty(self::$id_accion)) {
              error_grave( 'No es posible ejecutar la petición,'
                  .' no hay accion predefinida para el controlador'
                  .' "'.self::$id_controlador.'".');
            } else {
              $metodo= 'accion_'.self::$id_accion;
              if (!method_exists( self::$controlador, $metodo)) {
                error_grave( 'No es posible ejecutar la petición,'
                    .' no existe el metodo para la accion'
                    .' "'.self::$id_accion.'", en el controlador'
                    .' "'.self::$id_controlador.'".');
              } else if (!puede_ejecutar( sesion::get('usuario')
						, self::$id_controlador, self::$id_accion)) {
                error_grave( 'No es posible ejecutar la petición,'
                    .' no tiene permisos suficientes para la accion'
                    .' "'.self::$id_accion.'", en el controlador'
                    .' "'.self::$id_controlador.'".');
              } else {
				//$objeto->accion_crear();
				//self::$controlador->$metodo();
                call_user_func( array( self::$controlador, $metodo));
              }//if
            }//if
          }//if
        }//if
      }//if
    }//if
  }//ejecutar
  
  //-------------------------------------------------------------------------
  //Indicador de activación del modo de generación de URLs en la aplicación.
  //Si está activo (a "true"), las URLs se generan con formato "PATH" o ruta y
  //se deberá tener activo en el servidor web el módulo de reescritura de
  //URLs y haber configurado en el archivo ".htaccess" las conversiones.
  //Si no está activo (a "false"), las URLs se generan con formato "GET" o 
  //"QUERY" con los parametros habituales.
  public static $modo_url_path= false;
  
  //-------------------------------------------------------------------------
  //Generar una URL relativa o absoluta a cualquier accion o recurso de 
  //la aplicacion.
/*
  public static function url_aplicacion( $parametros=null, $absoluta=false)
  {
    //Si no es valido el array de parametros, se deja vacio.
    if (!is_array($parametros)) $parametros= array();
    
    $url= '';
    if (self::$modo_url_path) {
      //Modo "PATH" activo.
      
    } else {
      //Modo "QUERY" activo.
      $url= '?'.http_build_query( $parametros, 'arg[', );
    }//if
    
    
    $url= '?'.http_build_query( array('a'=>'catalogo.add', 'ref'=>$articulo->referencia, 'p'=>$pagina));
    
    if ($absoluta) {
    }
    
    
      
    
  }//url_aplicacion
  
  public static function url_recurso()
*/
  
  
  //-------------------------------------------------------------------------
  
  //-------------------------------------------------------------------------
  //-------------------------------------------------------------------------

}//class aplicacion