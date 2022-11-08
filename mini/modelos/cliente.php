<?php
class cliente extends modeloDAO
{
  //Atributos del objeto en la base de datos
  public $referencia; //Referencia unica del cliente, creada por el usuarioa su conveniencia
  public $cifnif;      //CIF o NIF del cliente
  public $nombre;      //Nombre del cliente o Nombre Comercial de la empresa
  public $apellidos;   //Apellidos del cliente o Razón Social de la empresa
  public $domFiscal;   //Domicilio Fiscal para Facturas
  public $domEnvio;    //Domicilio para los envíos de correo al cliente, si no se indica se usa el Fiscal
  public $notas;       //Notas internas para el Cliente
  public $email;       //Correo electronico del cliente y a la vez login de acceso al sistema
  public $password;    //Clave de acceso al sistema con espacio para un md5
  
  //-------------------------------------------------------------------------
  //Atributos a iniciar por heredar de "modeloDAO".
  //-------------------------------------------------------------------------
  protected $nombreTabla= 'clientes';
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
      'cifnif'    =>$this->cifnif,
      'nombre'    =>$this->nombre,
      'apellidos' =>$this->apellidos,
      'domFiscal' =>$this->domFiscal,
      'domEnvio'  =>$this->domEnvio,
      'notas'     =>$this->notas,
      'email'     =>$this->email,
      'password'  =>$this->password,
    );
	return basedatos::escaparArray( $datos);
  }//datosSQL
  
  //-------------------------------------------------------------------------
  //Obtener la orden SQL para listar los registros de "cliente" de la tabla, 
  //sin imponer limitaciones al número de filas resultantes, ya que la posible
  //paginación se añade posteriormente. 
  //Esta consulta está enfocada a la busqueda de registros para la sección de 
  //administración de clientes.
  // - $orden --> Se puede indicar el orden de los resultados tal cual se 
  // haría en la parte "ORDER BY" de la orden SQL, por defecto se ordena 
  // por "referencia".
  public static function sqlListar( $orden='')
  {
    if (empty($orden)) $orden= 'referencia ASC';
    //----------
    $sql= 'SELECT * FROM clientes ORDER BY '.$orden;
    return $sql;
  }//sqlListar

  //-------------------------------------------------------------------------
  //-------------------------------------------------------------------------
  
}//cliente