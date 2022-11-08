<?php
//-----------------------------------------------------------------
/**
 * Clase que implementa una Cesta de la compra.
 *
 * ----------------------------------------------------------------
 * Funciones
 *  - Llevar conjunto de articulos con sus cantidades
 *  - Añadir articulo a la cesta con cantidad 1 o N unidades.
 *  - Quitar articulo de la cesta por completo o quitar N unidades.
 *  - Vaciar cesta.
 *  - Obtener lista de articulos "en bruto" (Id.Articulo, Cantidad)
 *  - Obtener el número de articulos diferentes en la cesta.
 *  - Obtener el número total de articulos en la cesta.
 *  
 *  - Obtener la instancia de la sesion.
 *  - Guardar la instancia en la sesion.
 *  
 *  + Obtener lista de articulos "preparada" :
 *   (Id.Articulo, Descripcion, Cantidad, Precio, Iva%, Importe)
 *  + Obtener resumen de totales de la cesta:
 *   (Iva%, Suma Base, Cuota Iva, Importe Tipo Iva%)
 *   (Suma Bases, Suma Cuotas Iva, Importe Total)
 *  + Establecer el "cliente" relacionado.
 *  + Obtener el "cliente" relacionado.
 * ----------------------------------------------------------------
*/
class Cesta
{
  //Datos de articulos en la cesta.
  //1. Array con elementos array('id'=>xxx, 'cantidad'=>xxx)
  //2. Array con elementos ('id' => cantidad)
  //3. Array con elementos ('id' => array(cantidad, Articulo))
  //*** La implementacion actual sigue la idea 2.
  protected $datos= array();
  
  
  //Añadir articulo a la cesta con cantidad 1 o N unidades.
  public function poner( $id, $cantidad=1)
  {
    //1. Decidir si sumar o insertar dato.
    if (isset( $this->datos[$id]))
      $this->datos[$id]+= $cantidad;
    else
      $this->datos[$id]= $cantidad;
    
    //2. Insertar dato vacio primero.
    //if (!isset( $this->datos[$id])) $this->datos[$id]= 0;
    //$this->datos[$id]+= $cantidad;
    
  }//poner
  
  //Quitar articulo de la cesta por completo o quitar N unidades.
  public function quitar( $id, $cantidad=1)
  {
    //$this->poner( $id, -$cantidad);
    if (isset( $this->datos[$id])) {
      $this->datos[$id]-= $cantidad;
      if ($this->datos[$id] <= 0) unset( $this->datos[$id]);
    }
  }//quitar
  
  //Vaciar cesta.
  public function vaciar()
  {
    $this->datos= array();
    //--$this->datos= [];
  }//vaciar
  
  //Obtener lista de articulos "en bruto" (Id.Articulo, Cantidad)
  public function contenido()
  {
    return $this->datos;
  }//contenido
  
  //Obtener el número de articulos diferentes en la cesta.
  public function total_articulos()
  {
    return count( $this->datos);
  }//total_articulos
  
  //Obtener el número total de articulos en la cesta.
  public function total_unidades()
  {
    /*
    $total= 0;
    foreach( $this->datos as $cantidad) $total+= $cantidad;
    return $total;
    */
    
    /*
    $total= 0;
    $cantidad= reset( $this->datos);
    while ($cantidad !== false) {
      $total+= $cantidad;
      $cantidad= next( $this->datos);
    }
    */
    
    return array_sum( $this->datos);
  }//total_unidades
  
  
  //---------------------------------------------------------------
  //Obtener / Establecer la cesta en la sesion activa.
  //---------------------------------------------------------------
  
  //Variable a usar para la cesta en sesion.
  protected $variable_sesion= 'cesta';
  
  //Cargar la instancia de la sesion.
  public function cargar_de_sesion()
  {
    //Cargar datos de la sesion.
    $datos= sesion::get( $this->variable_sesion, null);
    //Recuperar los datos de la clase importados de la sesion.
    if (!is_array( $datos)) $datos= array();
    $this->datos= $datos;
  }//cargar_de_sesion
  
  //Guardar la instancia en la sesion.
  public function guardar_en_sesion()
  {
    //Montar el array de datos a exportar a la sesion.
    $datos= $this->datos;
    //Guardar datos en la sesion.
    sesion::set( $this->variable_sesion, $datos);
  }//guardar_en_sesion
  
  //Obtener una nueva instancia cargada de la sesion.
  public static function instancia_de_sesion()
  {
    $cesta= new Cesta();
    $cesta->cargar_de_sesion();
    return $cesta;
  }//instancia_de_sesion
  
}//class Cesta



