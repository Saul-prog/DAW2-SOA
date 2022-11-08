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
    /*
        if(strcmp($dato->MetaData->Nombre,$provincia)==0){
            echo '<p>'.$dato->MetaData->Nombre.'</p>';
        }
    */
}





/*
foreach ($datos as $key => $value) {

        
        foreach ($value['MetaData'] as $key2 => $value2){
            echo '<p>Nombre '.$key2.'=>'.$value2['Nombre'];
            if(strcmp($value2['Nombre'],$provincia)==0){
                echo '<p>Nombre '.$key2.'=>'.$value2['Nombre'];
                foreach ($value['Data'] as $key3 => $value3){
                    if($anyo==(int)$value3['Anyo']){
                        echo '<p>Periodo '.$value3['T3_Periodo'].' Año: '.$value3['Anyo'].' Porcentaje: '.$value3['Valor'].'</p>';
                    }
                }
            }
        }
}
*/