<?php
//aplicacion::$modoPublico= true;
modelo::usar( 'usuario');

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
    $usuario= new usuario;
    $usuario->login= (isset($_POST['usuario']) ? $_POST['usuario'] : NULL);
    $usuario->password= (isset($_POST['password']) ? $_POST['password'] : NULL);
    //Ejecutar accion
    //Comprobar Usuario y contraseña validos
    //Si son validos se aprovecha el accso a la base de datos y se rellena
      if($usuario!==NULL){

          if ($usuario->comprobar()) {
              $valido= true;

          } else {



              //vista::generarPagina('asd');
          }//if
      }


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


    //--------------------------------------------------------------------------
    public function accion_registro(){
        $bien= false;
        $error= '';
        $usuario= new usuarioAcceso;
        $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
        $vuelta= (isset($_GET['vuelta']) ? $_GET['vuelta'] : 'no_vuelta');
        if (isset($_POST['usuarioAcceso'])) {
            //Copiar los datos del formulario...
            $datos=$_POST['usuarioAcceso'];
            $usuario->nombre=$datos['nombre'];
            $usuario->password=$datos['password'];
            $usuario->login=$datos['login'];
            $usuario->perfil=$datos['perfil'];
            $usuario->ultima_fecha=$datos['ultima_fecha'];
            //Intentar guardar validando antes el modelo...
            $bien= $usuario->guardar();
            if ($bien) $error= 'El usuario se ha guardado correctamente.';
            else $error= 'No se ha podido guardar el usuario nuevo.';
        }//if
        if ($bien) {
            //se crea un nuevo usuario para tener en la sesión
            //No se obtiene el id porque no es necesario hacer una consulta a la base de datos en este momento
            $us=new usuario;
            $us->nombre=$usuario->nombre;
            $us->rol=$usuario->perfil;
            $us->login=$usuario->login;
            sesion::set('usuario', $us);
            sesion::set('usuario.veces', null);
            $vuelta= (isset($_GET['vuelta']) ? $_GET['vuelta'] : 'no_vuelta');

            if(strcmp('vuelta_compra',$vuelta)!==0){
                vista::redirigir( '', array('a'=>'inicio','p'=>$pagina));
            }
            vista::redirigir( '', array('a'=>'compra.ver','p'=>$pagina));

        } else {
            vista::generarPagina( 'formularios_registro', array(
                'modelo'=>$usuario,
                'error'=>$error,
                'pagina'=>$pagina,
                'vuelta'=>$vuelta,
            ));
        }//if

    }//controlador_registro


    public function accion_cliente(){
        $bien= false;
        $error= '';
        $usuario= new usuarioAcceso;
        $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
        $vuelta= (isset($_GET['vuelta']) ? $_GET['vuelta'] : 'no_vuelta');
        if (isset($_POST['usuarioAcceso'])) {
            //Copiar los datos del formulario...
            $datos=$_POST['usuarioAcceso'];
            $usuario->nombre=$datos['nombre'];
            $usuario->password=$datos['password'];
            $usuario->login=$datos['login'];
            $usuario->perfil=$datos['perfil'];
            $usuario->ultima_fecha=$datos['ultima_fecha'];
            //Intentar guardar validando antes el modelo...
            $bien= $usuario->guardar();
            if ($bien) $error= 'El usuario se ha guardado correctamente.';
            else $error= 'No se ha podido guardar el usuario nuevo.';
        }//if
        if ($bien) {
            //se crea un nuevo usuario para tener en la sesión
            //No se obtiene el id porque no es necesario hacer una consulta a la base de datos en este momento
            $us=new usuario;
            $us->nombre=$usuario->nombre;
            $us->rol=$usuario->perfil;
            $us->login=$usuario->login;
            sesion::set('usuario', $us);
            sesion::set('usuario.veces', null);
            $vuelta= (isset($_GET['vuelta']) ? $_GET['vuelta'] : 'no_vuelta');

            if(strcmp('vuelta_compra',$vuelta)!==0){
                vista::redirigir( '', array('a'=>'inicio','p'=>$pagina));
            }
            vista::redirigir( '', array('a'=>'compra.ver','p'=>$pagina));

        } else {
            vista::generarPagina( 'formularios_registro', array(
                'modelo'=>$usuario,
                'error'=>$error,
                'pagina'=>$pagina,
                'vuelta'=>$vuelta,
            ));
        }//if
    }
}//class controlador_inicio




