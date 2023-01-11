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


?>

<h1>Buscar ubicaciónes</h1>
<form action="Geolocalizacion.php" method="post">
	<p>Pais <input type="text" name="Pais" /></p>
	<p>Dirección <input type="text" name="direccion" /></p>
	<p><input type="submit" /></p>
</form>



<?php  

$Pais = $_POST["Pais"];//almacenamos los datos del formulario


$direccion = str_replace(' ', '',$_POST["direccion"]); //almacenamos los datos del formulario

//almacenamos las cinsultas en el fichero de log con la fecha y la hora
fwrite($logFile, "\n".date("d/m/Y H:i:s")." busqueda de: País => ".$Pais.' Dirección => '.$direccion) or die("Error escribiendo en el archivo");fclose($logFile);

$url = utf8_encode('https://maps.googleapis.com/maps/api/geocode/json?address='.$Pais.'+'.$direccion.'&key=AIzaSyDAIIZFJ1YTUHN9dljcyxaDWuxqm3t57LE');

//print_r ($url);
//leemos la url mediante curl

  $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url); 
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
   curl_setopt($ch, CURLOPT_HEADER, 0); 
   $data = curl_exec($ch); 
   curl_close($ch); 

$file = fopen("archivo.json", "w");
fwrite($file, $data);
//echo $data;
//fwrite($file, file_get_contents($data));
//echo $data;

	$data_json= file_get_contents("archivo.json"); //abrimos el fichero temporal .json y lo alacenamos en una variable
	$info = json_decode($data_json, true);

foreach($info as $elemento){

        
$arrConnections = ($elemento);//almacenamos data para poder acceder en el siguiente foreach
 

//print_r ($elemento[0]["address_components"]);

foreach ($arrConnections as $elemento)
{
	
	$lat = ($elemento["geometry"]["location"]["lat"]);//almacenamos los datos que necesitamos para posicionarnos en el mapa
	$lng = ($elemento["geometry"]["location"]["lng"]);
	
//echo $lat;
//echo $lng;

}

}
?>

<div id="map"></div>
	 
<script type="text/javascript">
  function iniciarMap(){
	  
	   /* pasamos las coordenadas obtenidas del json para mostrar el mapa por pantalla */
    var coord = {lat:<?php echo $lat; ?>,lng:<?php echo $lng; ?>};
    var map = new google.maps.Map(document.getElementById('map'),{
      zoom: 10, /* Zoom del mapa  */
      center: coord  /* centrar en unas coordenadas concretas */
    });
    var marker = new google.maps.Marker({
      position: coord,
      map: map
    });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAIIZFJ1YTUHN9dljcyxaDWuxqm3t57LE&callback=iniciarMap"></script>
</body>
</html>