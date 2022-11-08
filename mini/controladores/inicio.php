<?php
//aplicacion::$modoPublico= true;

class controlador_inicio extends controlador
{

  //-------------------------------------------------------------------------
  public function accion_inicio()
  {
    //Extraer Datos para ejecucion


    //Ejecutar accion


    //Dar una respuesta

    /*depurar( array(
      'accion'=>$accion,
      'usuario'=>$usuario
    ));*/

    //--generar_vista( 'portada' /*, array con argumentos para la vista */);
    //vista::generarPagina( 'portada' /*, array con argumentos para la vista */);
    vista::generarPagina( 'portada', array( 'dato'=>'un dato'));
  }//accion_inicio

  //-------------------------------------------------------------------------
  public function accion_login()
  {
    //Extraer Datos para ejecucion
    $valido= false;
    $bloqueado= false;
    $usuario= new usuario();
    if (isset($_POST['usuario'])) $usuario->login= $_POST['usuario'];
    if (isset($_POST['password'])) $usuario->password= $_POST['password'];
    
    //Ejecutar accion
    
    //Comprobar Usuario y contraseña validos
    //SIMULARLO!!!
    if (($usuario->login == 'admin')
        && ($usuario->password == 'admin')) {
      $valido= true;
      $usuario->rol= 'Administrador';
      $usuario->nombre= 'Tú mismo';
      //aplicacion::$modoPublico= false;
    } else if (($usuario->login == 'cliente') 
      && ($usuario->password == 'cliente')) {
      $valido= true;
      $usuario->rol= 'Cliente';
      $usuario->nombre= 'Cliente Prueba';
    } else {
      //No es valido...
    }//if
    
    //LOGIN si es valido o Control de bloqueo si no es valido.
    $veces= 0;
    if ($valido) {
      $usuario->password= '';
      sesion::set('usuario', $usuario);
      sesion::set('usuario.veces', null);
    } else {
      $veces= 1 + sesion::get('usuario.veces', 0);
      $bloqueado= ($veces > 4);
      sesion::set('usuario.veces', $veces);
    }//if
//sesion::set('usuario.veces', null);

    //Dar una respuesta
    if ($valido) {
      vista::redirigir( array( 'inicio'));
    } else if ($bloqueado) {
      generar_pagina_error( 
          'El acceso a la aplicación está bloqueado por haber fallado'
        . ' más de '.$veces.' veces. '
      );
    } else {
      vista::generarPagina( 'login', array( 'usuario'=>$usuario));
    }
  }//accion_login
  

  //-------------------------------------------------------------------------
  public function accion_logout()
  {
    //Extraer Datos para ejecucion
    
    //Ejecutar accion
    sesion::clear();
    
    //Dar una respuesta
    vista::redirigir( array( 'inicio'));
    
  }//accion_logout
  

}//class controlador_inicio
