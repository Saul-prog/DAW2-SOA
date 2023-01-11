<?php
class usuarioAcceso extends modeloDAO
{
//Atributos del objeto en la base de datos
public $id;         //Identificador de usuario
public $nombre;     //Nombre del usuario para msotrar
/*    No se si ponerlo por seguridad*/
public $login;     //login par ainiciar sesion
public $password;  //Clave apra iniciar sesión
/**/
public $perfil;      //Palabra clave del perfil de usuario
public $ultima_fecha; //Ultima fecha de conexión
//-------------------------------------------------------------------------
//Atributos a iniciar por heredar de "modeloDAO".
//-------------------------------------------------------------------------
protected $nombreTabla= 'usuarios';
protected $campoClave= array( 'id'=>null);

    protected function datosTabla( $insertar)
    {
        $datos= array(
            'id'=>$this->id,
            'nombre'     =>$this->nombre,
            'login'    =>$this->login,
            'password'    =>$this->password,
            'perfil'    =>$this->perfil,
            'ultima_fecha'    =>$this->ultima_fecha,
        );
        return basedatos::escaparArray( $datos);
    }//datosTabla


public function comprobar()
{
    $sql='SELECT * FROM usuarios WHERE login = "'.$this->login.'" AND password ="'.$this->password.'"';
    $datos = basedatos::obtenerUno($sql);
    if($datos){
        $this->rellenar($datos);
        $this->poner_fecha();
    }
}
public function yaExiste(){
    $sql='SELECT * FROM usuarios WHERE login = "'.$this->login.'"';
    $datos = basedatos::obtenerUno($sql);
    if($datos===null){
        return true;
    }
    return false;
}

public function rellenar($datos){
    $this->id=$datos['id'];
    $this->nombre=$datos['nombre'];
    $this->perfil=$datos['perfil'];
}

public function poner_fecha(){
    $sql='UPDATE usuarios SET ultima_fecha = WHERE login = "'.$this->login.'" AND password ="'.$this->password.'"';
}

    public function llenar( $datos)
    {
        if (is_array( $datos)) {
            //Una forma rapida de copiar valores por clave del array a atributos
            //del objeto, pero que sin controlar el tipo de acceso del atributo
            //(publico, protegido, privado).
            foreach( $datos as $k => $v) {
                if (property_exists( $this, $k)) $this->$k= $v;
                //Aqui se puede hacer algo si la propiedad no existe, pero no importa.
            }//foreach
        }//if
    }//llenar


    public static function sqlListar( $orden='')
    {
        if (empty($orden)) $orden= 'id ASC';
        //----------
        $sql= 'SELECT * FROM usuarios ORDER BY '.$orden;
        return $sql;
    }//sqlListar



}