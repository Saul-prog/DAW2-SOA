<?php
modelo::usar( 'cliente');
class controlador_clientes extends controlador
{
  public $accion_defecto= 'admin';
  
  //-------------------------------------------------------------------------
  public function accion_admin()
  {
    //----------
    //Extraer Datos para ejecucion con la pagina que se está viendo.
    $pagina= (isset($_GET['p']) ? (int)$_GET['p'] : 0);
    if ($pagina < 1) $pagina= 1;//se empieza en la primera pagina como mucho.
    $lineas= config::get('pagina.lineas', 10);
    //$lineas= 5;//Probar con menos lineas
    if ($lineas < 1) $lineas= 1;//como minimo se obtiene 1 elemento por pagina.
    //----------
    //Ejecutar accion
    $sql= cliente::sqlListar();
    $total= basedatos::contar( $sql);
    $registros= basedatos::obtenerTodos( $sql, $pagina-1, $lineas);
    //----------
    //Dar una respuesta
    vista::generarPagina( 'admin', array( 
      'pagina'=>$pagina,
      'lineas'=>$lineas,
      'total'=>$total,
      'registros'=>$registros,
    ));
  }//accion_admin
  
  //-------------------------------------------------------------------------
  //Accion para CREAR un cliente
  public function accion_crear()
  {
    $bien= false;
    $error= '';
    $modelo= new cliente;
    //----------
    $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
    //----------
    //Si hay datos del formulario cliente, se intenta crear nuevo...
    if (isset($_POST['cliente'])) {
      //Copiar los datos del formulario...
      $modelo->llenar( $_POST['cliente']);
      //Intentar guardar validando antes el modelo...
      $bien= $modelo->guardar();
      if ($bien) $error= 'El cliente se ha guardado correctamente.';
      else $error= 'No se ha podido guardar el cliente nuevo.';
    }//if
    //----------
    //Dar una respuesta segun el resultado del proceso.
    if ($bien) {
      //vista::redirigir( array('clientes.editar'), array('id'=>$modelo->referencia, 'p'=>$pagina));
      vista::generarPagina( 'editar', array( 
        'modelo'=>$modelo,
        'error'=>$error,
        'pagina'=>$pagina,
      ));
    } else {
      vista::generarPagina( 'crear', array( 
        'modelo'=>$modelo,
        'error'=>$error,
        'pagina'=>$pagina,        
      ));
    }//if
    //-----*/
  }//accion_crear
  
  //-------------------------------------------------------------------------
  //Accion para EDITAR un cliente
  public function accion_editar()
  {
    $bien= false;
    $error= '';
    $modelo= null;
    //----------
    $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
    //----------
    //Coger el dato clave para cargar el modelo a editar...
    $id= (isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null));
    if ($id === null) {
      $error= 'No se ha indicado el cliente a editar.';
    } else {
      $modelo= new cliente;
      if (!$modelo->cargar( $id)) {
        $error= 'No se puede cargar el cliente ('.$id.') para editar.';
        $modelo= null;
      }//if
    }//if
    //----------
    //Si hay modelo cargado, y datos del formulario, se intenta copiar/guardar.
    if (($modelo !== null) && isset($_POST['cliente'])) {
      //Copiar los datos del formulario...
      $modelo->llenar( $_POST['cliente']);
      //Intentar guardar validando antes el modelo...
      $bien= $modelo->guardar();
      if ($bien) $error= 'El cliente se ha guardado correctamente.';
      else $error= 'No se ha podido guardar el cliente ('.$id.').';
    }//if
    //----------
    //Dar una respuesta segun el resultado del proceso.
    //--if ($bien) {
    //--  vista::redirigir( array('clientes'), array('p'=>$pagina));
    //--} else {
      vista::generarPagina( 'editar', array( 
        'modelo'=>$modelo,
        'error'=>$error,
        'pagina'=>$pagina,
      ));
    //--}//if
    //-----*/
  }//accion_editar
  
  //-------------------------------------------------------------------------
  //Accion para CONSULTAR un cliente
  public function accion_ver()
  {
    $bien= false;
    $error= '';
    $modelo= null;
    //----------
    $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
    //----------
    //Coger el dato clave para cargar el modelo a editar...
    $id= (isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null));
    if ($id === null) {
      $error= 'No se ha indicado el cliente a consultar.';
    } else {
      $modelo= new cliente;
      if (!$modelo->cargar( $id)) {
        $error= 'No se puede cargar el cliente ('.$id.') para consultar.';
        $modelo= null;
      }//if
    }//if
    //----------
    //Dar una respuesta segun el resultado del proceso.
    vista::generarPagina( 'ver', array(
      'modelo'=>$modelo,
      'error'=>$error,
      'pagina'=>$pagina,
    ));
  }//accion_ver
  
  //-------------------------------------------------------------------------
  //Accion para ELIMINAR un cliente
  public function accion_borrar()
  {
    $bien= false;
    $error= '';
    $modelo= null;
    //----------
    $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
    //----------
    //Coger el dato clave para cargar el modelo a editar...
    $id= (isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null));
    if ($id === null) {
      $error= 'No se ha indicado el cliente a editar.';
    } else {
      $modelo= new cliente;
      if (!$modelo->cargar( $id)) {
        $error= 'No se puede cargar el cliente ('.$id.') para editar.';
        $modelo= null;
      }//if
    }//if
    //----------
    $confirmado= (boolean)(isset($_GET['ok']) ? $_GET['ok'] : (isset($_POST['ok']) ? $_POST['ok'] : 0));
    //----------
    //Si hay modelo cargado, y datos del formulario, se intenta eliminar.
    if (($modelo !== null) && $confirmado) {
      //Intentar eliminar el modelo...
      $bien= $modelo->eliminar();
      if ($bien) $error= 'El cliente se ha eliminado correctamente.';
      else $error= 'No se ha podido eliminar el cliente ('.$id.').';
    }//if
    //----------
    //Dar una respuesta segun el resultado del proceso.
    if ($bien) {
      vista::redirigir( array('clientes'), array('p'=>$pagina));
    } else {
      vista::generarPagina( 'borrar', array(
        'modelo'=>$modelo,
        'error'=>$error,
        'pagina'=>$pagina,
      ));
    }//if
  }//accion_borrar
  
  //-------------------------------------------------------------------------
  //Accion para CREAR modelos de cliente de ejemplo.
  //Eliminar o comentar cuando no se use.
  /*-----*/
  public function accion_creardemo()
  {
    $bien= false;
    $modelo= new cliente;
    //----------
    //Simular la creacion de varios clientes...
    //INSERT INTO `clientes`
    // (`referencia`, `cifnif`, `nombre`, `apellidos`, `domFiscal`, `domEnvio`, `notas`, `email`, `password`)
    // VALUES
    // ('ZA000003', 'asdoiu', 'oiuoiu', 'oiuoiuoiu', 'oiuoiuoiu', '', NULL, 'email', 'clave')
    for ($i= 1; ($i <= 25); $i++) {
      $modelo->referencia= sprintf( 'ZA%06d', $i);
      $modelo->cifnif= sprintf( 'ID%06d', $i);
      $modelo->nombre= sprintf( 'nombre %06d', $i);
      $modelo->apellidos= sprintf( 'apellido %06d', $i);
      $modelo->domFiscal= sprintf( 'domicilio fiscal %06d', $i);
      $modelo->domEnvio= null;//sprintf( 'domicilio envio %06d', $i);
      $modelo->notas= null;//sprintf( 'notas %06d', $i);
      $modelo->email= sprintf( 'cliente%d@correo.es', $i);
      $modelo->password= sprintf( 'cliente%d', $i);
      $modelo->guardar();
      //crear nueva instancia para que se inserte el siguiente.
      $modelo= new cliente;
    }//for
    //--echo 'voy a redirigir la pagina...'; flush();//probar a generar contenido HTML antes de redirigir.
    vista::redirigir( array('clientes','admin'));
  }//accion_creardemo
  
  //-------------------------------------------------------------------------
  //Accion para EDITAR un modelo de cliente de ejemplo.
  public function accion_editardemo()
  {
    $bien= false;
    //----------
    //Simular la modificacion de los datos de cliente... En concreto la clave primaria...
    $modelo= new cliente;
    $id1= 'ZA000001';
    $id2= 'VA000001';
    $bien= $modelo->cargar( $id1);
    if (!$bien) {
      $id3= $id1;
      $id1= $id2;
      $id2= $id3;
      $bien= $modelo->cargar( $id1);
    }//if
    if ($bien) {
      depurar( array( 
        'modelo.cargado'=> print_r( $modelo,true)
      ));
      $modelo->referencia= $id2;
      if ($modelo->guardar()) {
        $info= 'Modelo actualizado correctamente.';
      } else {
        $info= 'Modelo no actualizado.';
      }//if
      depurar( array( 
        'info'=>$info,
        'modelo.guardado'=> print_r( $modelo,true)
      ));
    } else {
      echo 'No se ha podido cargar ninguna de las pruebas.';
    }//if
  }//accion_editardemo
  
  //-------------------------------------------------------------------------
  //Accion para ELIMINAR un modelo de cliente de ejemplo.
  public function accion_borrardemo()
  {
    $bien= false;
    //----------
    //Simular la eliminacion de los datos de cliente... En concreto la clave primaria...
    $modelo= new cliente;
    $borrado= sesion::get( 'cliente.borrado', null);
    if ($borrado !== null) {
      $modelo= $borrado;
      $bien= $modelo->guardar();
      if ($bien) {
        depurar( array( 
          'modelo.sesion.guardado' => print_r( $modelo, true)
        ));
        //Quitar de sesion el cliente borrado para la proxima vez...
        sesion::set( 'cliente.borrado', null);
      } else {
        echo 'No se ha podido guardar el cliente de la sesion.';
      }//if
    } else {
      $bien= $modelo->cargar( 'ZA000005');
      if ($bien) {
        depurar( array( 
          'modelo.cargado' => print_r( $modelo, true)
        ));
        if ($modelo->eliminar()) {
          depurar( array( 
            'modelo.borrado' => print_r( $modelo, true)
          ));
          //Guardar en sesion el cliente borrado para la proxima vez...
          sesion::set( 'cliente.borrado', $modelo);
        } else {
          echo 'No se ha podido eliminar el cliente de la BD.';
        }//if
      } else {
        echo 'No se ha podido cargar el cliente de la BD.';
      }//if
    }//if
  }//accion_borrardemo
  
}//class controlador_clientes
