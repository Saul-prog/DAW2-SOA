<?php
//El archivo de funciones carga lo necesario para el sistema.
//errores, configuracion, depuracion, sesiones, permisos, urls, 
//controladores, vistas, modelos, ...
require_once( 'funciones/funciones.php');

aplicacion::ejecutar();


//--> https://localhost/mini/configuraciones/aplicacion.php

//---------------------------------------------------------------------------
exit();
//---------------------------------------------------------------------------
$usuario= false;
if (isset($_SESSION['u'])) $usuario= $_SESSION['u'];

$accion= false;
if (isset($_GET['a'])) $accion= $_GET['a'];

$accionDefecto= 'inicio';
if (empty($accion)) $accion= $accionDefecto;


//http://localhost/daw2/mini/?a=clientes
//http://localhost/daw2/mini/index.php?a=clientes
//http://localhost/daw2/mini/

//http://localhost/daw2/mini/clientes

//http://localhost/daw2/mini/?a=clientes.crear
//http://localhost/daw2/mini/clientes.crear
//http://localhost/daw2/mini/c.c
//http://localhost/daw2/mini/clic
//http://localhost/daw2/mini/clir
//http://localhost/daw2/mini/cliu
//http://localhost/daw2/mini/clid
//http://localhost/daw2/mini/clif




//http://localhost/daw2/mini/?a=articulos

//control de accesos por accion...
$permisos= array(
  'clientes'=>'alguien',
  'articulos'=>'alguien',
  'facturas'=>'contable',
  //'catalogo'=>,
);


if (isset($permisos[$accion]) 
  && puede_ejecutar($usuario, $permisos[$accion])) {
    
  if (is_readable('controladores/'.$accion.'.php')) {
    require('controladores/'.$accion.'.php');
  } else {
    require('controladores/'.$accionDefecto.'.php');
    //echo 'acceso no valido a accion de "'.$accion.'"';
  }

} else {
  if (is_readable('controladores/'.$accion.'.php')) {
    require('controladores/'.$accion.'.php');
  } else {
    require('controladores/'.$accionDefecto.'.php');
    //echo 'acceso no valido a accion PUBLICA de "'.$accion.'"';
  }	
}


/*depurar( array( 
  'GET'=>$_GET, 
  'POST'=>$_POST, 
  'SESSION'=>$_SESSION
));*/