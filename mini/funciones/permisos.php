<?php
//Un sistema basico de gestion de permisos
//(c) DAW2 - EPSZ - Univ. Salamanca

function puede_ejecutar( $usuario, $controlador, $accion)
{
  //Preparar la lista de permisos
  static $_permisos= null;
  if (!is_array($_permisos)) {
    $_permisos= require( 
		dirname(dirname(__FILE__))
		.'/configuraciones/permisos.php'
	);
  }//if
  
  //Preparar el rol del usuario recibido (o no)
  $rol= 'Invitado';
  if ($usuario instanceof usuario) {
    if (isset($usuario->rol)) $rol= $usuario->rol;
  } else {
    //No se puede comprobar si tiene o no permisos ese usuario,
	//así que, considerarlo "Invitado" por defecto.
  }//if
	  
  //Comprobar la existencia de (rol,controlador,accion)
  //en la lista de permisos.
  // --> (rol, controlador, accion, permitir)
  // --> (rol, controlador, *, permitir)
  // --> (rol, *, *, permitir)
  // --> ('*', controlador, *, permitir)
  // --> ('*', *, *, permitir o denegar)
  $permitir= false;
  foreach( $_permisos as $permiso) {
	$r= ($permiso[0]=='*') || (strcasecmp( $rol, $permiso[0])==0);
	$c= ($permiso[1]=='*') || (strcasecmp( $controlador, $permiso[1])==0);
	$a= ($permiso[2]=='*') || (strcasecmp( $accion, $permiso[2])==0);
	if ($r && $c && $a) {
	  $permitir= $permiso[3];
	  break;
	}//if
  }//foreach
  
  return $permitir;
}



class usuario
{

  public $rol= 'Invitado';
  public $nombre= 'Invitado';
  public $login= null;
  public $password= null;


    public function comprobar()
    {
        $sql='SELECT nombre,perfil FROM usuarios WHERE login = "'.$this->login.'" AND password ="'.$this->password.'"';
        $datos = basedatos::obtenerUno($sql);
        if($datos){
            $this->nombre=$datos['nombre'];
            $this->rol=$datos['perfil'];

            if($this->poner_fecha()){

                return true;
            }else{

                return false;

            }
        }
        return false;
    }

    public function poner_fecha(){
        //Se formatea la fecha en datetime de mysql
        $ultima_fecha=date("Y-m-d H:i:s");
        $sql='UPDATE usuarios SET ultima_fecha = "'.$ultima_fecha.'" WHERE login = "'.$this->login.'" AND password ="'.$this->password.'"';
        $datos = basedatos::ejecutarSQL($sql);
        if($datos===false){

            return false;
        }else{
            var_dump($this);
            return true;
        }
    }


}//class usuario
