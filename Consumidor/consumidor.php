

<form name="opc"method="post"action="consumidor.php">

       <h1>Opciones para visualizar:</h1> 
       <select name="opciones" id="Provincia">
            <option value="OP1">Ocupación por sector</option>
            <option value="OP2">Puntos de recarga de vehículos eléctricos</option>
            <option value="OP3">Convocatoria de empleo público dadas dos fechas</option>
            <option value="OP4">Establecimientos farmacéuticos en Castilla y León</option>
            <option value="OP5">Tasa de mortalidad COVID-19 por zonas de salud</option>
        </select>
       <input type="submit"/>

</form>

<?php
/*
https://analisis.datosabiertos.jcyl.es/api/records/1.0/search/?dataset=puntos-de-recarga-del-vehiculo-electrico&q=&facet=nombre&facet=operador&facet=tipo
*/
$opc=isset($_POST["opciones"]) ? $_POST["opciones"] : "";
if(strcmp($opc,"OP1")==0){
?>
    <form name="formulario"method="post"action="consumidor.php">

        Provincia: 
        <select name="Provincia" id="Provincia">
                <option value="Total Nacional">Total Nacional</option>
                <option value="Albacete">Albacete</option>
                <option value="Alicante/Alacant">Alicante/Alacant</option>
                <option value="Almería">Almería</option>
                <option value="Araba/Álava">Araba/Álava"</option>
                <option value="Asturias">Asturias</option>
                <option value="Ávila">Ávila</option>
                <option value="Badajoz">Badajoz</option>
                <option value="Balears, Illes">Balears, Illes</option>
                <option value="Barcelona">Barcelona</option>
                <option value="Bizkaia">Bizkaia</option>
                <option value="Burgos">Burgos</option>
                <option value="Cáceres">Cáceres</option>
                <option value="Cádiz">Cádiz</option>
                <option value="Cantabria">Cantabria</option>
                <option value="Castellón/Castelló">Castellón/Castelló</option>
                <option value="Ciudad Real">Ciudad Real</option>
                <option value="Córdoba">Córdoba</option>
                <option value="Coruña, A">Coruña, A</option>
                <option value="Cuenca">Cuenca</option>
                <option value="Gipuzkoa">Gipuzkoa</option>
                <option value="Girona">Girona</option>
                <option value="Granada">Granada</option>
                <option value="Guadalajara">Guadalajara</option>
                <option value="Huelva">Huelva</option>
                <option value="Huesca">Huesca</option>
                <option value="Jaén">Jaén</option>
                <option value="León">León</option>
                <option value="Lleida">Lleida</option>
                <option value="Lugo">Lugo</option>
                <option value="Madrid">Madrid</option>
                <option value="Málaga">Málaga</option>
                <option value="Murcia">Murcia</option>
                <option value="Navarra">Navarra</option>
                <option value="Ourense">Ourense</option>
                <option value="Palencia">Palencia</option>
                <option value="Palmas, Las">Palmas, Las</option>
                <option value="Pontevedra">Pontevedra</option>
                <option value="Rioja, La">Rioja, La</option>
                <option value="Salamanca">Salamanca</option>
                <option value="Santa Cruz de Tenerife">Santa Cruz de Tenerife</option>
                <option value="Segovia">Segovia</option>
                <option value="Sevilla">Sevilla</option>
                <option value="Soria">Soria</option>
                <option value="Tarragona">Tarragona</option>
                <option value="Teruel">Teruel</option>
                <option value="Toledo">Toledo</option>
                <option value="Valencia/València">Valencia/València</option>
                <option value="Valladolid">Valladolid</option>
                <option value="Zamora">Zamora</option>
                <option value="Zaragoza">Zaragoza</option>
                <option value="Ceuta">Ceuta</option>
                <option value="Melilla">Melilla</option>
            </select>
        Año: 
        <select name="anyo" id="anyo">
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
            </select>
        <input type="submit"/>

    </form>

    <?php	
    //<input type="text"name="anyo"value="2020"> <input type="text"name="Provincia"value="Zamora">
    $datos=json_decode(file_get_contents('https://servicios.ine.es/wstempus/js/es/DATOS_TABLA/3995?tip=AM'));
    $provincia=isset($_POST["Provincia"]) ? $_POST["Provincia"] : "Total Nacional";
    $anyo=isset($_POST["anyo"]) ? $_POST["anyo"] : 2020;
    //Se comprueba que nos alga fuera de los añosa ceptados
    if($anyo<2008){
        $anyo=2008;
    }
    if($anyo>2022){
        $anyo=2022;
    }
    //if((strcmp("Albacete",$provincia)!=0)&&(strcmp("Albacete",$provincia)!=0)&&)
    echo '<p>Es la provincia:'.$provincia .'</p>';
    echo '<p>Es el año:'.$anyo .'</p>';
    //Comprobar $datos
    //var_dump($datos);

    foreach($datos as $dato){
        //var_dump($dato);
        foreach($dato->MetaData as $metadato){
            echo'<table>';
            if(strcmp($metadato->Nombre,$provincia)==0){

                echo '<tr>'. $dato->Nombre.'<tr/>';
                //echo '<p>'.$metadato->Nombre.'</p>';
                
                foreach($dato->Data as $data){
                    if($data->Anyo==$anyo){
                        echo '<tr>';
                        //obtener por trimestre el porcentaje deocupados por sector económico
                        echo '<td>Periodo '.$data->T3_Periodo.' del año '.$data->Anyo.' es '.$data->Valor.'%</td>';
                        echo '<tr/>';
                    } 
                }
            } 
        }
    }
}
?>

