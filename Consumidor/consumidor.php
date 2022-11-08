<form name="formulario"method="get"action="consumidor.php">

       Provincia: <input type="text"name="Provincia"value="Zamora">
       Año: <input type="text"name="anyo"value="2020">
       <input type="submit"/>

</form>

<?php	
$datos=json_decode(file_get_contents('https://servicios.ine.es/wstempus/js/es/DATOS_TABLA/3995?tip=AM'));
$provincia=isset($_GET["Provincia"]) ? $_GET["Provincia"] : "Total Nacional";
$anyo=isset($_GET["anyo"]) ? $_GET["anyo"] : 2020;
echo '<p>Es la provincia:'.$provincia .'</p>';
echo '<p>Es el año:'.$anyo .'</p>';
//Comprobar $datos
//var_dump($datos);
foreach($datos as $dato){
    //var_dump($dato);
    foreach($dato->MetaData as $metadato){
        if(strcmp($metadato->Nombre,$provincia)==0){
            echo $dato->Nombre.'<br>';
            //echo '<p>'.$metadato->Nombre.'</p>';
            foreach($dato->Data as $data){
                if($data->Anyo==$anyo){
                    //obtener por trimestre el porcentaje deocupados por sector económico
                    echo '<p>Periodo '.$data->T3_Periodo.' año '.$data->Anyo.' es '.$data->Valor.'%</p>';
                    echo '<br>';
                } 
            }
        } 
    }
}
?>

