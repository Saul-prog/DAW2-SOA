<?php
//Un sistema basico de gestion de formularios de datos
//(c) DAW2 - EPSZ - Univ. Salamanca
//---------------------------------------------------------------------------
//Clase de la que hereda un formulario de datos generico, no de base de datos.
abstract class formulario extends modelo
{

  //-------------------------------------------------------------------------
  //Atributo con el identificador del formulario para su generación en las
  //vistas o para almacenarlo en la sesión.
  //Si es "null", se genera el nombre de la clase final.
  protected $idForm= null;
  
  //-------------------------------------------------------------------------
  //Atributo con la lista de propiedades/atributos visibles en el formulario
  //para que se puedan obtener desde el método "datosForm()" y almacenar 
  //desde el método "guardar".
  //Si no es un array de cadenas o está vacío, se genera automáticamente por
  //el sistema de atributos públicos de la clase.
  //Se debe llenar en herencia si se desea especificar atributos que no son
  //publicos o se quieren eliminar algunos de los disponibles.
  protected $atributosForm= array();
  
  
  //-------------------------------------------------------------------------
  //Establecer el "id" del formulario si se ha indicado o es nulo para que se
  //se use el id por defecto.
  public function setId( $idForm)
  {
    if (!empty($idForm) || ($idForm === null)) $this->idForm= $idForm;
  }//setId
  
  //-------------------------------------------------------------------------
  //Obtener el "id" del formulario o si no está iniciado se calcula por
  //defecto usando el nombre de la clase.
  public function getId()
  {
    $idForm= $this->idForm;
    if (empty($idForm)) $idForm= get_class( $this);
    return $idForm;
  }//getId
  
  
  //-------------------------------------------------------------------------
  //Metodo para obtener un formulario desde la sesión, o desde un modelo o
  //similar, aunque depende de la implementación en herencia del mismo.
  //El parametro "$idForm" se mantiene por compatibilidad con el método de
  //la clase base, pero ahora puede ser opcional, y además según sea el modo
  //de carga puede ser el identificador clave de la variable de sesión o lo
  //que sea.
  public function cargar( $idForm= null)
  {
    //Actualizar el "id" del formulario si se ha indicado. Aqui no se quiere
    //establecer directamente con "setId()" porque si es "null" se elimina
    //el que estuviera fijado previamente, que es el que se quiere usar.
    if (!empty($idForm)) $this->setId( $idForm);
    $datos= sesion::get( $this->getId());
    //Asegurar que es un array aunque sea vacio.
    if (!is_array( $datos)) $datos= array();
    //Aprovechar el método existente en "modelo" para llenarse.
    $this->llenar( $datos);
  }//cargar
  
  //-------------------------------------------------------------------------
  //Devuelve la lista de atributos y datos del formulario para poder 
  //trasladarlos de uno a otro o a un sistema de almacenamiento externo.
  
  public function datosForm()
  {
    //Coger los nombres de atributo configurados o los publicos por defecto.
    $lista= $this->atributosForm;
    //if (!is_array($lista) || empty($lista)) $lista= array_key( get_object_vars( $this));
    if (!is_array($lista) || empty($lista)) $lista= formularioUtiles::atributosObjeto( $this);
    
    $datos= array();
    foreach( $lista as $k) {
      if (property_exists( $this, $k)) $datos[$k]= $this->$k;
      else $datos[$k]= null;
    }
    return $datos;
  }//datosForm
  
  //-------------------------------------------------------------------------
  //Metodo para almacenar el formulario en la sesión.
  public function guardar()
  {
    //Obtener la lista de atributos que se quieren guardar y hacerlo.
    $datos= $this->datosForm();
    sesion::set( $this->getId(), $datos);
  }//guardar
  
  //-------------------------------------------------------------------------
  //Metodo para eliminar el formulario de la sesión.
  public function eliminar()
  {
    sesion::set( $this->getId(), null);
  }//eliminar
  
}//class formulario


//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
abstract class formularioUtiles
{
  //Devuelve los atributos publicos del objeto recibido como argumento.
  //Se implementa fuera de cualquier clase porque si se llama desde dentro
  //se obtendrían los atributos protegidos y privados de la clase llamante.
  public static function atributosObjeto( $obj)
  {
    return array_keys( get_object_vars( $obj));
  }
}//formularioUtiles