<?php
modelo::usar('ofertas');
modelo::usar('articulo');
class ofertas extends modeloDAO
{
  //Atributos del objeto en la base de datos
  public $idOferta;  //Identificador de la linea de oferta.
  public $refArt; //Referencia al articulo relacionado.
  public $precio= 0.0; //Precio del articulo con 2 decimales, no deberia ser negativo.
  public $activa= true; //Si la oferta esta activa o no.
  public $notas; //Notas internas para la Oferta.
  
  //-------------------------------------------------------------------------
  //Atributos adicionales para facilitar la gestión de la oferta.
  //-------------------------------------------------------------------------
  public $articulo= null; //Instancia del modelo articulo relacionado con la oferta.
  
  //-------------------------------------------------------------------------
  //Atributos a iniciar por heredar de "modeloDAO".
  //-------------------------------------------------------------------------
  protected $nombreTabla= 'ofertas';
  protected $campoClave= array( 'idOferta'=>null);
  protected $campoAutonumerico= 'idOferta';//Campo AUTO_INCREMENT
  
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
    //Adaptar valores antes de enviar a la BD.
    $precio= (float)str_replace( ',', '.', $this->precio);//asegurar numero en "sql-ingles"
    $activa= $this->activa ? 1 : 0;
    
    $datos= array(
      'idOferta'=>$this->idOferta,
      'refArt'  =>$this->refArt,
      'precio'  =>$precio,
      'activa'  =>$activa,
      'notas'   =>$this->notas,
    );
    return basedatos::escaparArray( $datos);
  }//datosTabla
  
  //-------------------------------------------------------------------------
  //Obtener la orden SQL para listar los registros de "ofertas" de la tabla, 
  //sin imponer limitaciones al número de filas resultantes, ya que la posible
  //paginación se añade posteriormente. 
  //Esta consulta está enfocada a la busqueda de registros para la sección de 
  //administración de ofertas, independientemente de si estan activas o no.
  // - $orden --> Se puede indicar el orden de los resultados tal cual se 
  // haría en la parte "ORDER BY" de la orden SQL, por defecto se ordena 
  // por "refArt".
  public static function sqlListar( $orden='')
  {
    if (empty($orden)) $orden= 'refArt ASC';
    //----------
    $sql= 'SELECT * FROM ofertas ORDER BY '.$orden;
    return $sql;
  }//sqlListar
  
  public static function sqlListarActivas( $orden='')
  {
    if (empty($orden)) $orden= 'refArt ASC';
    //----------
    $sql= 'SELECT * FROM ofertas WHERE activa ORDER BY '.$orden;
    return $sql;
  }//sqlListarActivas
  
  //-------------------------------------------------------------------------
  //Métodos de apoyo a la oferta.
  //-------------------------------------------------------------------------
  
  //-------------------------------------------------------------------------
  //Cargar la oferta con el modelo de datos del articulo que tiene asociado.
  public function cargarArticulo()
  {
    //Si el articulo no esta cargado, o si lo esta, hay referencia en la oferta
    //y las referencias no coinciden entre si, se intenta cargar.
    if (($this->articulo === null) || 
          (($this->articulo !== null) && !empty($this->refArt) 
              && ($this->articulo->referencia != $this->refArt))) {
      //Crear la instancia nueva y cargarla, y si falla, dejarla nula.
      $this->articulo= new articulo;
      if (!$this->articulo->cargar( $this->refArt)) $this->articulo= null;
    }//if
    return ($this->articulo !== null);
  }//cargarArticulo
  
  //-------------------------------------------------------------------------
  //Sobreescribir el metodo de la clase base para implementar lacargaautomatica de la relacion con "articulo"
  public function carga($filtroIDs){
    $res=parent::cargar($filtroIDs);
    //if($res) $res=$this->$cargaArticulo();//Si no va bien se devuelve
    if($res) $this->$cargaArticulo();

    return $res;
  }
  
  //-------------------------------------------------------------------------
  //-------------------------------------------------------------------------

}//oferta