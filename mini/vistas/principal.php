<?php
//---------------------------------------------------------------------------
//Plantilla principal de la aplicación
//---------------------------------------------------------------------------

//Forzar la codificacion de caracteres en cualquier navegador, por si acaso
//no coge bien los "meta" indicados en la cabecera "head" del HTML final.
if (!headers_sent()) header( 'Content-Type: text/html; charset=utf-8', true);

$usuario= sesion::get('usuario');
$rol= (($usuario !== null) ? $usuario->rol : 'Invitado');
$publico= aplicacion::$modoPublico || ($rol == 'Invitado') || ($rol == 'Cliente');
//Se puede forzar a modo privado si es administrador po ejemplo.
//if ($rol == 'Administrador') $publico= false;
if ($publico) {
  include( 'publica.php');
} else {
  include( 'privada.php');
}
