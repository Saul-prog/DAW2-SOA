<?php
modelo::usar('pedidolin');
modelo::usar('cliente');
class pedido extends modeloDAO
{
  //Atributos del objeto en la base de datos
  public $serie;  //Serie del Pedido como un texto o el año en curso
  public $numero; //Numero del pedido que debe ser unico dentro de la serie
  public $fecha; //Fecha del pedido en formato sql "AAAA-MM-DD"'
  public $refCli; //Cliente asociado al pedido'
  public $domEnvio; //Domicilio de envio del pedido, se propone el que tiene el cliente pero se puede modificar
  public $estado= 0; //Estado del Pedido: 0=Abierto/Pendiente, 1=Bloqueado/Preparacion, 2=Bloqueado/Enviado, 3=Cerrado/Recibido, 4=Cerrado/Anulado', ...
  public $notas; //Notas internas para el Pedido
  
  //-------------------------------------------------------------------------
  //Atributos adicionales para facilitar la gestión del pedido.
  //-------------------------------------------------------------------------
  protected $nombreTabla= 'pedidos';
  public $lineas= null; //Array con los modelos de datos de lineas del pedido.
  //Si es "null" no se ha cargado aun de la base de datos, o iniciado como 
  //nuevo.
  public $cliente= null; //Instancia del modelo cliente relacionado con el pedido.
  
  //-------------------------------------------------------------------------
  //Atributos a iniciar por heredar de "modeloDAO".
  //-------------------------------------------------------------------------
  protected $campoClave= array( 'serie'=>null, 'numero'=>null);
  //--protected $campoAutonumerico= null;
  
  //-------------------------------------------------------------------------
  //Metodos a implementar por heredar de "modelo".
  //-------------------------------------------------------------------------
  
  //-------------------------------------------------------------------------
  //Validar los datos antes de almacenarlos en la BD o cuando se quiera.
  //Debe devolver "verdadero" si se valida todo correctamente, sino "falso".
  /*-----Comentado mientras no se utilice
  public function validar()
  {
    return true;
  }//validar
  //-----*/
  
  //-------------------------------------------------------------------------
  //Metodos a implementar por heredar de "modeloDAO".
  //-------------------------------------------------------------------------
  
  //-------------------------------------------------------------------------
  //Devolver los datos necesarios para generar una orden SQL para INSERTAR
  //o ACTUALIZAR un registro en la base de datos para este modelo.
  protected function datosTabla( $insertar)
  {
    $fecha= strtotime( $this->fecha);
    $fecha= ($fecha === false) ? null : date( 'Y-m-d', $fecha);//dejar fecha nula si no es valida
    //--$fecha= date( 'Y-m-d', ($fecha === false) ? time() : $fecha);//dejar fecha actual si no es valida
    //----------
    //Al insertar se debe calcular el numero de pedido segun la serie indicada.
    if ($insertar && !is_numeric($this->numero)) {
      $this->numero= self::siguienteNumero( $this->serie);
    }//if
    //----------
    $datos= array(
      'serie'   =>$this->serie,
      'numero'  =>$this->numero,
      'fecha'   =>$fecha,
      'refCli'  =>$this->refCli,
      'domEnvio'=>$this->domEnvio,
      'estado'  =>$this->estado,
      'notas'   =>$this->notas,
    );
	return basedatos::escaparArray( $datos);
  }//datosTabla
  
  //-------------------------------------------------------------------------
  //Obtener la orden SQL para listar los registros de "pedidos" de la tabla, 
  //sin imponer limitaciones al número de filas resultantes, ya que la posible
  //paginación se añade posteriormente. 
  //Esta consulta está enfocada a la busqueda de registros para la sección de 
  //administración de pedidos o similar.
  // - $orden --> Se puede indicar el orden de los resultados tal cual se 
  // haría en la parte "ORDER BY" de la orden SQL, por defecto se ordena 
  // por "serie,numero".
  // - $refCli --> Opcional. Referencia del cliente para filtrar sus pedidos
  // concretos. Si no se indica, no se aplica el filtro, salen todos.
  public static function sqlListar( $orden='', $refCli=null)
  {
    if (empty($orden)) $orden= 'serie ASC, numero ASC';
    //----------
    $sql= 'SELECT * FROM pedidos '
      .(($refCli !== null) ? ' WHERE refCli="'.basedatos::escapar( $refCli).'"' : '')
      .' ORDER BY '.$orden;
    return $sql;
  }//sqlListar
  
  //-------------------------------------------------------------------------
  //Métodos de apoyo al pedido.
  //-------------------------------------------------------------------------
  
  //-------------------------------------------------------------------------
  //Obtener el siguiente número de pedido según la serie indicada y los datos
  //que se encuentren en la BD.
  //El sistema es simple y puede tener problemas si hay mucha concurrencia
  //de peticiones de inserción de pedidos simultánea, ya que al ejecutarse
  //en paralelo las peticiones, puede darse el mismo número de pedido varias
  //veces mientras no se guarde en la base de datos.
  public static function siguienteNumero( $serie)
  {
    $res= 0;
    $sql= 'SELECT MAX(numero) AS ultimo FROM pedidos WHERE serie="'.$serie.'"';
    $registro= basedatos::obtenerUno( $sql);
    //Si no hay error, se coge el valor maximo devuelto, sino se queda en
    //CERO asumiendo que no hay SERIE y debe empezar en 1.
    if (($registro !== false) && ($registro !== null)) {
      $res= $registro['ultimo'];
    }//if
//echo 'ultimo de '.$serie.'= '.($res+1).'...';
    return $res+1;
  }//siguienteNumero
  
  //-------------------------------------------------------------------------
  //Obtener la lista de estados posibles para el pedido.
  public static function listaEstados()
  {
    $res= array(
      0=>'Abierto/Pendiente', 
      1=>'Bloqueado/Preparacion',
      2=>'Bloqueado/Enviado',
      3=>'Bloqueado/Recibido',
      4=>'Cerrado/Aceptado',
      5=>'Cerrado/Devuelto',
      6=>'Cerrado/Anulado',
    );
    return $res;
  }//listaEstados
  
  //-------------------------------------------------------------------------
  //Obtener el nombre de un posible estado segun si identificador clave.
  public static function textoEstado( $id)
  {
    $lista= self::listaEstados();
    $res= (isset($lista[$id]) ? $lista[$id] : '<Estado_Pedido_'.$id.'>');
    return $res;
  }//textoEstado
  
  //-------------------------------------------------------------------------
  //Métodos de manipulacion de lineas de pedido.
  //-------------------------------------------------------------------------
  
  //-------------------------------------------------------------------------
  //Obtener el SQL para leer las lineas de pedido del pedido actual del modelo.
  //*** Este metodo deberia ir en el modelo "pedidolin", pues similar al 
  //"pedidolin::sqlListar(...)".
  protected function sqlLineasPedido()
  {
    /*-----
    $sql= 'SELECT * FROM pedidoslin'
        .' WHERE ('
          .'(serie="'.basedatos::escapar( $this->serie).'")'
          .' AND '
          .'(numero="'.basedatos::escapar( $this->numero).'")'
        .') ORDEN BY orden ASC';
    return $sql;
    -----*/
    return pedidolin::sqlListar( 'serie,numero,orden', $this->serie, $this->numero);
  }//sqlLineasPedido
  
  //-------------------------------------------------------------------------
  //Aprovechar la herencia de "modeloDAO" a la hora de llenar el pedido desde
  //un array de datos para llenar los datos de lineas relacionadas con el 
  //pedido si vienen dadas.
  public function llenar( $datos)
  {
    parent::llenar( $datos);
    //Usar el llenado de la clase padre y como "lineas" o "cliente" son
    //atributos publicos de la clase, si vienen dentro del array "$datos"
    //se van a copiar tal cual, con lo que hay que hacer un repaso de sus
    //contenidos para asegurar que son modelos de datos y no otra cosa.
    //----------
    //Si los datos vienen de la base de datos no aparece "lineas" o "cliente",
    //con lo que el proceso siguiente no se realiza.
    //Ignorar el atributo "lineas" que no sea array.
    if (!is_array($this->lineas)) $this->lineas= null;
    if (is_array($this->lineas)) {
      //Repasar las lineas creando los modelos asociados.
      foreach( $this->lineas as $i => $regLinea) {
        //Si ya es un objeto, no se toca.
        if (!is_object($regLinea)) {
          $linea= new pedidolin;
          //Si hay ID de linea, se intenta coger de la BD la linea original.
          if (isset($regLinea['idLinea'])) $linea->cargar( $regLinea['idLinea']);
          //Si se coge de la BD, ya esta el modelo con los datos originales, 
          //pero pueden haberse modificado, con lo que se llenan igualmente
          //con los datos que vienen dados.
          $linea->llenar( $regLinea);
          $this->lineas[$i]= $linea;
        }//if
      }//foreach
    }//if
    //Ignorar el atributo "cliente" que no sea array u objeto.
    if (!is_array($this->cliente) && !is_object($this->cliente)) $this->cliente= null;
    //Si "cliente" ya es un objeto, no se toca.
    if (is_array($this->cliente)) {
      $cliente= new cliente;
      //Si hay ID de cliente, se intenta coger de la BD el original.
      if (isset($this->cliente['referencia'])) $cliente->cargar( $this->cliente['referencia']);
      //Si se coge de la BD, ya esta el modelo con los datos originales, 
      //pero pueden haberse modificado, con lo que se llenan igualmente
      //con los datos que vienen dados, aunque luego no se utilicen.
      $cliente->llenar( $this->cliente);
      $this->cliente= $cliente;
    }//if
  }//llenar
  
  //-------------------------------------------------------------------------
  //Aprovechar la herencia de "modeloDAO" a la hora de cargar el pedido de la
  //base de datos para cargar los datos relacionados con el pedido como el
  //cliente asociado y las lineas de pedido que tiene asociadas.
  public function cargar( $filtroIDs)
  {
    //Ejecutar la carga de la clase padre para obtener el pedido de la bd.
    $res= parent::cargar( $filtroIDs);
    //Si ha ido bien la carga, se puede hacer la carga de sus lineas y del 
    //cliente. No importa si estas cargas fallan. 
    if ($res) {
      $this->cargarLineas();
      $this->cargarCliente();
    }//if
    return $res;
  }//cargar
  
  //-------------------------------------------------------------------------
  //Cargar el pedido con los modelos de datos de lineas de pedido que tiene
  //asociadas.
  public function cargarLineas()
  {
    $res= true;
    $this->lineas= array();
    $sql= $this->sqlLineasPedido();
    if ($sql !== null) {
      $registros= basedatos::obtenerTodos( $sql);
      if ($registros !== false) {
        foreach($registros as $registro) {
          $linea= new pedidolin;
          //Importante indicar el llenado del modelo con datos que vienen de la BD.
          $linea->cargarRegistro( $registro);
          $linea->pedido= &$this;//Referencia al modelo del pedido al que pertenece.
          $this->lineas[]= $linea;
        }//foreach
        $res= true;
      }//if
    }//if
    return $res;
  }//cargarLineas
  
  //-------------------------------------------------------------------------
  //Cargar el pedido con el modelo de datos del cliente que tiene asociado.
  public function cargarCliente()
  {
    //Si el cliente no esta cargado, o si lo esta, hay referencia en el pedido
    //y las referencias no coinciden entre si, se intenta cargar.
    if (($this->cliente === null) || 
          (($this->cliente !== null) && !empty($this->refCli) 
              && ($this->cliente->referencia != $this->refCli))) {
      //Crear la instancia nueva y cargarla, y si falla, dejarla nula.
      $this->cliente= new cliente;
      if (!$this->cliente->cargar( $this->refCli)) $this->cliente= null;
    }//if
    return ($this->cliente !== null);
  }//cargarCliente
  
  //-------------------------------------------------------------------------
  //Aprovechar la herencia de "modeloDAO" a la hora de guardar el pedido de la
  //base de datos para guardar las lineas de pedido que tiene asociadas.
  public function guardar( $validar=true)
  {
    //Ejecutar la grabacion de la clase padre para que exista/actualice el 
    //pedido en la bd.
    $res= parent::guardar( $validar);
    //Al guardar el pedido puede que cambie su clave primaria por haber sido 
    //modificada, en ese caso las lineas asociadas deben llevar la clave nueva,
    //con lo que al almacenarlas se debe establecer la serie y numero actual
    //del pedido, y de paso reordenar el número de orden de la linea.
    if ($res) {
      if ($this->lineas !== null) {
        $orden= 0; $fallos= 0;
        foreach($this->lineas as $linea) {
          $orden++;
          $linea->serie= $this->serie;
          $linea->numero= $this->numero;
          $linea->orden= $orden;
          $linea->pedido= &$this;//Referencia al modelo del pedido al que pertenece.
          if (!$linea->guardar()) $fallos++;
          //Descomentar la linea siguiente si no se quiere continuar la 
          //grabacion de lineas si hay algún fallo en una de ellas.
          //--if ($fallos > 0) break;//Salir si hay fallo de grabación.
        }//foreach
        $res= ($fallos == 0);//si no hay fallos, ha guardado bien.
      }//if
    }//if
    return $res;
  }//guardar
  
  //-------------------------------------------------------------------------
  //Aprovechar la herencia de "modeloDAO" a la hora de eliminar el pedido de 
  //la base de datos para eliminar las lineas de pedido que tiene asociadas.
  public function eliminar()
  {
    $eraNuevo= $this->esNuevo();
    $res= parent::eliminar();
    //Al eliminar el pedido, se deben eliminar las lineas asociadas ya que
    //su existencia depende de la existencia del propio pedido.
    if ($res && !$eraNuevo) {
      if ($this->lineas !== null) {
        //Si tiene lineas cargadas, eliminarlas una a una.
        $fallos= 0;
        foreach($this->lineas as $linea) {
          if (!$linea->eliminar()) $fallos++;
          //Descomentar la linea siguiente si no se quiere continuar la 
          //eliminacion de lineas si hay algún fallo en una de ellas.
          //--if ($fallos > 0) break;//Salir si hay fallo de eliminacion.
        }//foreach
        $res= ($fallos == 0);//si no hay fallos, ha eliminado bien.
      } else {
        //Si no tiene lineas cargadas, eliminarlas con una SQL directa.
        //Se aprovecha la orden de borrado de la propia clase cambiando el
        //nombre de la tabla afectada.
        $sql= str_replace( 'pedidos', 'pedidoslin', $this->sqlEliminar());
        $res= basedatos::ejecutarSQL( $sql);
        //El resultado puede ser "false" u "objeto" si no ha ido bien.
        if ($res !== true) $res= false;
      }//if
    }//if
    return $res;
  }//eliminar
  
  
  //-------------------------------------------------------------------------
  //-------------------------------------------------------------------------
  
}//pedido