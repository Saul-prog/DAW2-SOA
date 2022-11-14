

<form name="opc"method="get"action="consumidor.php">

       <h1>Opciones para visualizar:</h1> 
       <select name="opciones" id="opciones">
            <option value="OP1">Ocupación por sector</option>
            <option value="OP2">Puntos de recarga de vehículos eléctricos</option>
            <option value="OP3">Convocatoria de empleo público dadas dos fechas</option>
            <option value="OP4">Establecimientos farmacéuticos en Castilla y León</option>
            <option value="OP5">Tasa de mortalidad COVID-19 por zonas de salud</option>
        </select>
       <input type="submit"/>

</form>

<?php
/**
 * Apartado Ocupación por sector
 * https://servicios.ine.es/wstempus/js/es/DATOS_TABLA/3995?tip=AM
 */
$opc=isset($_GET["opciones"]) ? $_GET["opciones"] : "OP1";
if(strcmp($opc,"OP1")==0){
?>
    <form name="formulario"method="post"action="consumidor.php?opciones=OP1">

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
/*
* Apartado Puntos de recarga
* https://analisis.datosabiertos.jcyl.es/api/records/1.0/search/?dataset=puntos-de-recarga-del-vehiculo-electrico&q=&facet=nombre&facet=operador&facet=tipo
*/
if(strcmp($opc,"OP2")==0){
    $datos1=json_decode(file_get_contents('https://analisis.datosabiertos.jcyl.es/api/records/1.0/search/?dataset=puntos-de-recarga-del-vehiculo-electrico&q=&facet=nombre&facet=operador&facet=tipo    '));
    echo '<table border="1">';
    echo '<tr>';
    echo '<td>Nombre</td>';
    echo '<td>Dirección</td>';
    echo '<td>Operador</td>';
    echo '<td>Número de conectores</td>';
    echo '<td>Tipo de conector</td>';
    echo '<td>DMS(grados y minutos decimales) (N,W)</td>';
    echo '<td>DD(grados decimales)(N,W)</td>';
    echo '</tr>';
    foreach($datos1->records as $recarga){
        echo '<tr>';
        echo '<td>'.$recarga->fields->nombre.'</td>';
        echo '<td>'.$recarga->fields->direccion.'</td>';
        echo '<td>'.$recarga->fields->operador.'</td>';
        echo '<td>'.$recarga->fields->no.'</td>';
        echo '<td>'.$recarga->fields->tipo.'</td>';
        echo '<td>'.$recarga->geometry->coordinates[0].' N<br>'.$recarga->geometry->coordinates[1].' W</td>';
        echo '<td>'.$recarga->fields->dd[0].' N<br>'.$recarga->fields->dd[1].' W</td>';
        echo '</tr>';
        
    }
    echo '</table>';
}

/*
* Convocatoria de empleo público dadas dos fechas
* https://analisis.datosabiertos.jcyl.es/api/records/1.0/search/?dataset=convocatorias-de-empleo-publico&q=&sort=fechafinalizacion&facet=tipo&facet=organismo_gestor&facet=fechabocyl
*/
if(strcmp($opc,"OP3")==0){
    ?>
    <form name="formulario"method="post"action="consumidor.php?opciones=OP3">

    Fecha Inicio      
            <input type="date" id="start" name="inicial"
                value="2006-09-25"
                min="2006-09-25" max="2022-12-12">
    Fecha Fin
            <input type="date" id="start" name="final"
                value="2022-12-12"
                min="2006-09-25" max="2022-12-12">
            <input type="submit"/>
    </form>
        <?php
    $datos=json_decode(file_get_contents('https://analisis.datosabiertos.jcyl.es/api/records/1.0/search/?dataset=convocatorias-de-empleo-publico&q=&sort=fechafinalizacion&facet=tipo&facet=organismo_gestor&facet=fechabocyl'));
    $inicio=isset($_POST["inicial"]) ? $_POST["inicial"] : "2022-12-12";
    $fin=isset($_POST["final"]) ? $_POST["final"] : "2022-12-12";
    echo '<p>Es el año inicio:'.$inicio .'</p>';
    echo '<p>Es el año fin:'.$fin .'</p>';
   
    echo '<table border="1">';
    echo '<tr>';
    echo '<td>Titulo</td>';
    echo '<td>Clasificador</td>';
    echo '<td>Tipo</td>';
    echo '<td>Organismo Gestor</td>';
    echo '<td>Número de plazas</td>';
    echo '<td>Requerimientos necesarios</td>';
    echo '<td>Municipio</td>';
    echo '<td>Fecha inicio</td>';
    echo '<td>Fecha Finalización</td>';
    echo '</tr>';
    foreach($datos->records as $conv){
        
        if($conv->fields->fecha_de_inicio>$inicio&&$conv->fields->fecha_de_inicio<$fin){
        echo '<tr>';
        echo '<td>'.$conv->fields->titulo.'</td>';
        echo '<td>'.$conv->fields->clasificador.'</td>';
        echo '<td>'.$conv->fields->tipo.'</td>';
        $organismo=isset($conv->fields->organismo_gestor) ? $conv->fields->organismo_gestor : "";
        echo '<td>'.$organismo.'</td>';
        $plazas=isset($conv->fields->numeroplazas) ? $conv->fields->numeroplazas : "";
        echo '<td>'.$plazas.'</td>';
        $requisitos=isset($conv->fields->requisitos_necesarios) ? $conv->fields->requisitos_necesarios : "";
        echo '<td>'.$requisitos.'</td>';
        $municipio=isset($conv->fields->municipio) ? $conv->fields->municipio : "";
        echo '<td>'.$municipio.'</td>';
        echo '<td>'.$conv->fields->fecha_de_inicio.'</td>';
        echo '<td>'.$conv->fields->fechafinalizacion.'</td>';
        echo '</tr>';
        }
        
        
    }
    echo '</table>';
}

/*
* Registro de establecimientos farmacéuticos de Castilla y León
* https://analisis.datosabiertos.jcyl.es/api/records/1.0/search/?dataset=registro-de-establecimientos-farmaceuticos-de-castilla-y-leon&q=&facet=nombre_comercial&facet=provincia&facet=localidad&facet=municipio
*/
if(strcmp($opc,"OP4")==0){
    
    $datos=json_decode(file_get_contents('https://analisis.datosabiertos.jcyl.es/api/records/1.0/search/?dataset=registro-de-establecimientos-farmaceuticos-de-castilla-y-leon&q=&facet=nombre_comercial&facet=provincia&facet=localidad&facet=municipio'));
    
   
    echo '<table border="1">';
    echo '<tr>';
    echo '<td>Nombre Comercial</td>';
    echo '<td>Calle</td>';
    echo '<td>Número</td>';
    echo '<td>Teléfono</td>';
    echo '<td>Códgio postal</td>';
    echo '<td>Número de registro</td>';
    echo '<td>Localidad</td>';
    echo '<td>Municipio</td>';
    echo '</tr>';
    foreach($datos->records as $farmacias){
        
       
        echo '<tr>';
        echo '<td>'.$farmacias->fields->nombre_comercial.'</td>';
        echo '<td>'.$farmacias->fields->calle.'</td>';
        echo '<td>'.$farmacias->fields->numero.'</td>';
        echo '<td>'.$farmacias->fields->telefono.'</td>';
        echo '<td>'.$farmacias->fields->codigo_postal.'</td>';
        echo '<td>'.$farmacias->fields->num_reg.'</td>';
        echo '<td>'.$farmacias->fields->localidad.'</td>';
        echo '<td>'.$farmacias->fields->municipio.'</td>';
        echo '</tr>';
        
        
    }
    echo '</table>';
}