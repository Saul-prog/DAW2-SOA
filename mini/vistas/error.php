<?php
//---------------------------------------------------------------------------
//Plantilla principal de la aplicación cuando hay algún ERROR
//---------------------------------------------------------------------------

//Por ahora se genera la misma que la "plantilla" porque está preparada 
//para ello, pero antes se activa el "modo público" si no está ya activo
//y no hay un "usuario conectado".

if (!aplicacion::$modoPublico && (sesion::get('usuario') === null)) {
  aplicacion::$modoPublico= true;
}
require( 'principal.php');