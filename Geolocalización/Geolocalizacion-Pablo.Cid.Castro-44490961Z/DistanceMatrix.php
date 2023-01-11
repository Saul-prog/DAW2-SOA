<!DOCTYPE html>
<html>
<head>
	<title>Maps</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
    
<?php
//Pablo Cid Castro 44490961Z

error_reporting(0); //no muestre errores
$logFile = fopen("FicheroLog.log", 'a') or die("Error creando archivo");//creamos el fichero que utilizaremos como log
//formulario para almacenar dirección origen y distino

?>

<h1>Calcular distancias</h1>
<form action="DistanceMatrix.php" method="post">
	<p>Dirección Origen  => <input type="text" name="direccion1" /></p>
	<p>Dirección Destino => <input type="text" name="direccion2" /></p>

	<input type="submit" value="Coche" name="Coche">
	<input type="submit" value="Andando" name="Andando">
	<input type="submit" value="Bicicleta" name="Bicicleta">
</form>


<?php  



$medio = "";//variable global para almacenar recultado de los botones

if (isset($_POST["Coche"])){
	
	$medio = "driving";//si es coche se traduce al formato admitido
	
	
}elseif(isset($_POST["Andando"])){
	
		$medio = "walking";//si es andando se traduce al formato admitido
	
}
elseif(isset($_POST["Bicicleta"])){
	
		$medio = "bicycling";//si es en bicicleta se traduce al formato admitido
	
}
else{
	
	echo "DEBE PULSAR UN MEDIO DE TRANSPORTE";//mensaje de error 
	
}

//alamcenamos las dos direcciones
$direccion1 = str_replace(' ', '',$_POST["direccion1"]); //borramos los espacios en blanco que no están admitidos(str_replace)
$direccion2 = str_replace(' ', '',$_POST["direccion2"]); 

fwrite($logFile, "\n".date("d/m/Y H:i:s")." busqueda de: dirección origen => ".$direccion1.' Dirección destino => '.$direccion2.' Método de transporte =>'.$medio) or die("Error escribiendo en el archivo");fclose($logFile);

//url donde optendremos los datos con dirección origen dentino, modo de transporte y api
$url = utf8_encode('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.$direccion1.'&destinations='.$direccion2.'&mode='.$medio.'&key=AIzaSyDAIIZFJ1YTUHN9dljcyxaDWuxqm3t57LE');

//print_r ($url);
//leemos la url mediante curl
  $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url); 
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
   curl_setopt($ch, CURLOPT_HEADER, 0); 
   $data = curl_exec($ch); 
   curl_close($ch); 

//creamos y almacenamos en un fichero los datos obtenidos en un json
$file = fopen("archivo.json", "w");
fwrite($file, $data);

//echo $data;
//leemos el fichero para obtener los datos
	$data_json= file_get_contents("archivo.json");
	$info = json_decode($data_json, true);

foreach($info as $elemento){//almacenamos en $elemento el contenido del primer array

        
$arrConnections = ($elemento);//almacenamos data para poder acceder en el siguiente foreach
 

//print_r ($arrConnections);

foreach ($arrConnections as $elemento)//dentro del primer array accedemos a elements
{
	
	$arrConnections = ($elemento["elements"]);//almacenamos data para poder acceder en el siguiente foreach
	
foreach ($arrConnections as $elemento)//mostramos los datos que nos interesan
{
	//mostramos los datos en forma de tabla
	?>
	
	</br>


 <table border="1">
  <tr>
   <td>Distancia:  </td>
   <td>
    <?php echo ($elemento["distance"]["text"]); ?>
   </td>
  </tr>
  <tr>
   <td>Operador:  </td>
   <td>
    <?php echo ($elemento["duration"]["text"]); ?>
   </td>
  </tr>
  
  </tr>
   </tr>
   </td>
  </tr>
 </table><br />

<?php
}
}
}
?>
    <style type="text/css">
      
table {
  table-layout: fixed;
  width: 100%;
  border-collapse: collapse;
  border: 3px solid purple;
  font-size: 30px;
}

thead th:nth-child(1) {
  width: 30%;
}

thead th:nth-child(2) {
  width: 20%;
}

thead th:nth-child(3) {
  width: 15%;
}

thead th:nth-child(4) {
  width: 35%;
}

th, td {
  padding: 20px;
}
      
      </style>

<div id="map"></div> 

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAIIZFJ1YTUHN9dljcyxaDWuxqm3t57LE&callback=iniciarMap"></script>
</body>
</html>