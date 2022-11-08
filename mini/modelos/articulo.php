<?php
class articulo extends modeloDAO
{
  //Atributos del objeto en la base de datos
  public $referencia; //Referencia unica del articulo, creada por el usuario a su conveniencia
  public $texto;      //Texto descriptivo del articulo  
  public $precio;     //Precio del articulo con 2 decimales
  public $iva;        //Tipo de IVA del articulo en porcentaje
  public $notas;      //Notas internas para el Articulo
  
  //-------------------------------------------------------------------------
  //Atributos a iniciar por heredar de "modeloDAO".
  //-------------------------------------------------------------------------
  protected $nombreTabla= 'articulos';
  protected $campoClave= array( 'referencia'=>null);
  //--protected $campoAutonumerico= null;//
  
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
    $datos= array(
      'referencia'=>$this->referencia,
      'texto'     =>$this->texto,
      'precio'    =>str_replace( ',', '.', $this->precio),//asegurar numero en "sql-ingles"
      'iva'       =>str_replace( ',', '.', $this->iva),//asegurar numero en "sql-ingles"
      'notas'     =>$this->notas,
    );
	return basedatos::escaparArray( $datos);
  }//datosTabla
  
  //-------------------------------------------------------------------------
  //Obtener la orden SQL para listar los registros de "articulos" de la tabla, 
  //sin imponer limitaciones al número de filas resultantes, ya que la posible
  //paginación se añade posteriormente. 
  //Esta consulta está enfocada a la busqueda de registros para la sección de 
  //administración de articulos.
  // - $orden --> Se puede indicar el orden de los resultados tal cual se 
  // haría en la parte "ORDER BY" de la orden SQL, por defecto se ordena 
  // por "referencia".
  public static function sqlListar( $orden='')
  {
    if (empty($orden)) $orden= 'referencia ASC';
    //----------
    $sql= 'SELECT * FROM articulos ORDER BY '.$orden;
    return $sql;
  }//sqlListar
  
  
  //-------------------------------------------------------------------------
  //-------------------------------------------------------------------------
  
}//articulo