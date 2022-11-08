<?php
/**
 * Creador: Saúl Otero García
 * Versión: 02/11/2022
 */
//recibimos datos en formato json {"usuario":"federico", "password":"notiene"}
$datos=json_decode(file_get_contents('php://input'),TRUE);


    $con =  mysqli_connect('localhost', 'root', '', 'soa');
    //Conexión con base de datos
    if ($con) $con->set_charset( 'UTF8');
    if ($con->connect_error) {
        printf("Falló la conexión: %s\n", $con->connect_error);
        exit();
    }
    /***/

    $usuario=$datos['usuario'];
    $contrasena=md5($datos['contrasena']);
    $peticion=$con->prepare("SELECT token FROM cliente WHERE usuario LIKE ? and contrasena LIKE ?");
    $peticion->bind_param("ss",$usuario,$contrasena);
    if($peticion->execute()){
        $rs= $peticion->get_result();

        if($rs)
        {
            $fila= $rs->fetch_assoc();
        }
    }

    if($fila['token']==NULL){
        //Toma de datos
        $contrasena=md5($datos['contrasena']);
        //Insercción de datos en la petición
        $token=bin2hex(random_bytes((10 - (10 % 2)) / 2));
        $peticion=$con->prepare("UPDATE cliente SET token = ? WHERE usuario LIKE ?");
        $peticion->bind_param("ss",$token,$usuario);
        $peticion->execute();
    }else{
        //Si existe el token se
        $token=$fila['token'];
    }
    //Se devuelve el token
    $datos['token']=$token;
    echo json_encode($datos);    
    /*
    *Comprobación de token y usuario
    */
    
    $peticion=$con->prepare("SELECT token FROM cliente WHERE usuario LIKE ?");
    $peticion->bind_param("s",$usuario);
    if($peticion->execute()){
        $rs= $peticion->get_result();

        if($rs)
        {
            $fila= $rs->fetch_assoc();
            if(strcmp($token,$fila['token'])){
                echo '<p>Error en el token</p>';
                printf('<p>El token calculato %s, el token de la base %s</p>',$token,$fila['token']);
            }
        }
    }


    /**
     * Se elimian el token
     */
    $peticion=$con->prepare("UPDATE cliente SET token = NULL WHERE usuario LIKE ?");
    $peticion->bind_param("s",$usuario);
    if(!$peticion->execute()){
     

                echo '<p>Error al poner en null el token</p>';
                printf("Falló la conexión: %s\n", $con->connect_error);
    }


?>
