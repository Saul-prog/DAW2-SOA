<?php
modelo::usar( 'pedido');
modelo::usar( 'pedidolin');
class controlador_pedidos extends controlador
{
  public $accion_defecto= 'admin';
  
  //-------------------------------------------------------------------------
  //Obtener un ID de pedido como representacion de cadena para los errores.
  protected static function cadena_id( $id, $devolver=true)
  {
    if (is_array($id)) $res= implode( '/', $id);
    else $res= (string)$id;
    if (!$devolver) echo $res;
    else return $res;
  }//cadena_id
  
  //-------------------------------------------------------------------------
  //Accion para ADMINISTRAR/LISTAR pedidos
  public function accion_admin()
  {
    //----------
    //Extraer Datos para ejecucion con la pagina que se está viendo.
    $pagina= (isset($_GET['p']) ? (int)$_GET['p'] : 0);
    if ($pagina < 1) $pagina= 1;//se empieza en la primera pagina como mucho.
    $lineas= config::get('pagina.lineas', 10);
    if ($lineas < 1) $lineas= 1;//como minimo se obtiene 1 elemento por pagina.
    //----------
    //Ejecutar accion
    $sql= pedido::sqlListar();
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
  //Accion para CREAR un pedido
  public function accion_crear()
  {
    $bien= false;
    $error= '';
    $modelo= new pedido;
    //----------
    $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
    //----------
    //Si hay datos del formulario pedido, se intenta crear nuevo...
    if (isset($_POST['pedido'])) {
      //Copiar los datos del formulario...
      $modelo->llenar( $_POST['pedido']);
      //Intentar guardar validando antes el modelo...
      $bien= $modelo->guardar();
      if ($bien) $error= 'El pedido se ha guardado correctamente.';
      else $error= 'No se ha podido guardar el pedido nuevo. '.basedatos::$error;
    }//if
    //----------
    //Dar una respuesta segun el resultado del proceso.
    if ($bien) {
      //vista::redirigir( array('pedidos.editar'), array('id'=>$modelo->referencia, 'p'=>$pagina));
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
  }//accion_crear
  
  //-------------------------------------------------------------------------
  //Accion para EDITAR un pedido
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
      $error= 'No se ha indicado el pedido a editar.';
    } else {
      $modelo= new pedido;
      if (!$modelo->cargar( $id)) {
        $error= 'No se puede cargar el pedido ('.$this->cadena_id($id,true).') para editar.';
        $modelo= null;
      }//if
    }//if
    //----------
    //Si hay modelo cargado, y datos del formulario, se intenta copiar/guardar.
    if (($modelo !== null) && isset($_POST['pedido'])) {
      //Copiar los datos del formulario...
      $modelo->llenar( $_POST['pedido']);
      //Intentar guardar validando antes el modelo...
      $bien= $modelo->guardar();
      if ($bien) $error= 'El pedido se ha guardado correctamente.';
      else $error= 'No se ha podido guardar el pedido ('.$this->cadena_id($id,true).'). '.basedatos::$error;
    }//if
    //----------
    //Dar una respuesta segun el resultado del proceso.
    //--if ($bien) {
    //--  vista::redirigir( array('pedidos'), array('p'=>$pagina));
    //--} else {
      vista::generarPagina( 'editar', array( 
        'modelo'=>$modelo,
        'error'=>$error,
        'pagina'=>$pagina,
      ));
    //--}//if
  }//accion_editar
  
  //-------------------------------------------------------------------------
  //Accion para CONSULTAR un pedido
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
      $error= 'No se ha indicado el pedido a consultar.';
    } else {
      $modelo= new pedido;
      if (!$modelo->cargar( $id)) {
        $error= 'No se puede cargar el pedido ('.$this->cadena_id($id,true).') para consultar.';
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
  //Accion para ELIMINAR un pedido
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
      $error= 'No se ha indicado el pedido a editar.';
    } else {
      $modelo= new pedido;
      if (!$modelo->cargar( $id)) {
        $error= 'No se puede cargar el pedido ('.$this->cadena_id($id,true).') para editar.';
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
      if ($bien) $error= 'El pedido se ha eliminado correctamente.';
      else $error= 'No se ha podido eliminar el pedido ('.$this->cadena_id($id,true).') '.basedatos::$error;
    }//if
    //----------
    //Dar una respuesta segun el resultado del proceso.
    if ($bien) {
      vista::redirigir( array('pedidos'), array('p'=>$pagina));
    } else {
      vista::generarPagina( 'borrar', array(
        'modelo'=>$modelo,
        'error'=>$error,
        'pagina'=>$pagina,
      ));
    }//if
  }//accion_borrar
  
  //-------------------------------------------------------------------------
  //Accion para CREAR modelos de pedido de ejemplo.
  //Eliminar o comentar cuando no se use.
  /*-----*/
  public function accion_creardemo()
  {
    $bien= false;
    //----------
    //Simular la creacion de varios pedidos...
    for ($i= 1; ($i <= 25); $i++) {
      $modelo= new pedido;//nueva instancia de pedido para crear en la bd.
      $modelo->serie= date('Y');//año actual
      $modelo->numero= $i;
      $modelo->fecha= date('Y-m-d');//fecha actual
      $modelo->refCli= 'ZA000002';//uno que puede existir o no, pero bueno.
      $modelo->domEnvio= 'domicilio de envio del pedido "'.$modelo->serie.'/'.sprintf('%05d',$modelo->numero).'".';
      $modelo->estado= rand(0,count(pedido::listaEstados())-1);//uno de los posibles valores de estado.
      $modelo->notas= null;//sprintf( 'notas %06d', $i);
      //Añadir varias lineas a este pedido, aunque aún no exista en la BD.
      $modelo->lineas= array();
      $linTotal= rand(1,25);//Numero de lineas a generar en el pedido.
      for ($lin= 1; ($lin <= $linTotal); $lin++) {
        $linea= new pedidolin;//Nueva instancia de linea de pedido para crearla.
        //--$linea->idLinea= ...;//Es AUTONUMERICO con lo que se rellena solo al insertarlo en la BD.
        $linea->serie= $modelo->serie;
        $linea->numero= $modelo->numero;
        $linea->orden= $lin;
        $linea->refArt= sprintf( 'ART%06d', rand(1,40));//generar un codigo de articulo que puede que no exista (25 si, 15 no).
        if ($linea->cargarArticulo()) {
echo '<pre>'.print_r($linea->articulo,true).'</pre>';
          //Si se carga bien, se coge el texto.
          $linea->texto= $linea->articulo->texto;
          $linea->precio= $linea->articulo->precio;
          $linea->iva= $linea->articulo->iva;
        } else {
          //Si no se carga bien, se genera como una linea libre 
          //y se elimina la referencia.
          $linea->texto= 'Linea libre para el articulo "'.$linea->refArt.'"';
          $linea->refArt= null;
          $linea->precio= rand( 5, 10000) / 100;
          $linea->iva= 21.00;
        }//if
        $linea->cantidad= rand( 1, 100);
        $linea->importeBase= 9753.10; //Comprobar que se recalcula antes de almacenar en la BD.
        $linea->cuotaIva= 123.45; //Comprobar que se recalcula antes de almacenar en la BD.
        //Añadir la linea manualmente a la lista de lineas del pedido.
        $linea->pedido= &$this;//Referencia al pedido asociado.
        $modelo->lineas[]= $linea;
      }//for
      //Guardar el modelo y sus lineas asociadas.
      $modelo->guardar();
    }//for
    //--echo 'voy a redirigir la pagina...'; flush();//probar a generar contenido HTML antes de redirigir.
    //vista::redirigir( array('pedidos','admin'));
    echo '<hr/>';
    echo 'Fin';
    echo '<hr/>';
  }//accion_creardemo
  
}//class controlador_pedidos
