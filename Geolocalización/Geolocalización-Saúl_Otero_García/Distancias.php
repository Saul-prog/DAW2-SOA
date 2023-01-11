<?php//Saúl Otero García 39462243Q
//Version 05/12/2022
$key="AIzaSyDH_z5rL8m8AXr67aGW5Al_H7-G-3ZN9NQ";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dsitancias usando API de Google maps</title>
	
</head>
<body>

<?php
error_reporting(0);//Se limpian los errores
$fd=fopen("registro.log", "a");



?>
<h1>Calcular distancias</h1>
<form action="Distancias.php" method="get">
	<p>Dirección Origen  <input type="text" name="origen" /></p>
	<p>Dirección Destino <input type="text" name="destino" /></p>
    <p>Opciones 
        <select name="opc" id="opc">
            <option value="driving">Coche</option>
            <option value="walking">Andando</option>
            <option value="bicycling">Bicicleta</option>
        </select>
    </p>
	<input type="submit">
</form>
<?php
//Se comprueban los valores
$origen= (isset($_GET['origen']) ? $_GET['origen'] : null);
$destino= (isset($_GET['destino']) ? $_GET['destino'] : null);
$opc= (isset($_GET['opc']) ? $_GET['opc'] : null);

if($origen==null || $destino==null || $opc==null ){
    echo '<h2>Ha de indicar un inicio, un destino y la forma de ir de A a B</h2>';

}else{
    $mod=0;
    $transporte='';
    if(strcmp($opc,'driving')==0){
        $transporte='coche';
    }
    if(strcmp($opc,'walking')==0){
        $transporte='andando';
        $mod=1;
    }
    if(strcmp($opc,'bicycling')==0){
        $transporte='bicicleta';
    }
   
    //Se eliminan los espacios en blanco
    $origenS = str_replace(' ', '',$origen);
    $destinoS = str_replace(' ', '',$destino);
   
    //Se crea el registo y se cierra Se vatria en mensaje en si se usa transporte o es andando
    if($mod){
        fwrite($fd, "\n".date("d/m/Y H:i:s")." : Desde ".$origenS."\t Hasta ".$destinoS."\t".$transporte);
    }else{
        fwrite($fd, "\n".date("d/m/Y H:i:s")." : Desde ".$origenS."\t Hasta ".$destinoS."\t en ".$transporte);
    }

  
    //Se genera la url
    $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.$origenS.'&destinations='.$destinoS.'&mode='.$opc.'&key=AIzaSyDH_z5rL8m8AXr67aGW5Al_H7-G-3ZN9NQ';

    $datos=json_decode(file_get_contents($url) );
    
    
    
    foreach($datos as $rows){  
        if(is_object($rows[0])){
            
            $duracion=$rows[0]->elements[0]->duration->text;
            $distancia=$rows[0]->elements[0]->distance->text;
            
        }
    }
    echo '<h3>La distancia es de '.$distancia.'</h3><br>';
    if($mod){
        echo '<h3>Desde '.$origen." hasta ".$destino." ".$transporte;
    }else{
        echo '<h3>Desde '.$origen." hasta ".$destino." en ".$transporte;
    }
    
    echo ' se tarda '.$duracion."</h3>";
    fwrite($fd, "\tLa distancia es:".$distancia." y se tarda".$duracion );
    fclose($fd);
}
?>

</body>
</html>

