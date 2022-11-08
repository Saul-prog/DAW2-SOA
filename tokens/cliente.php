<?php
/**
 * Creador: Saúl Otero García
 * Versión: 02/11/2022
 */
//enviamos datos en formato json {"usuario":"UsuarioSaul","contraseña":"clave123","token"="0"}

    //Se abre el fichero
	$fp=fopen("datos.txt","r");
	//Se lee liena a línea
	
		$linea = fgets($fp);
	
	fclose($fp);
	$decolin=json_decode($linea);
	

	//Se manda al servidor
	$handle = curl_init("http://localhost/daw2/tokens/servidor.php");
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($decolin));
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	$response=curl_exec($handle);
	curl_close($handle);

//Se muestra la respuesta
echo $response;
//Se abre para sobreescribir
$fp=fopen("datos.txt","w");
fwrite($fp, $response);
	/***/
fclose($fp);
?>
