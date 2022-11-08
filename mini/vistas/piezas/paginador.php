<?php 
//Pieza de generación de un "paginador" como una lista de enlaces a la 
//aplicación con los parametros de la URL recibidos, y algunos detalles más.
//---------------------------------------------------------------------------
// Datos:
// - $url --> es un array con (clave => valor) con la lista de parametros que
// se van a incluir en las URLs que se generen en el paginador, lo normal es
// que se reciban los parametros para acceder al controlador y accion actuales,
// pero si no se reciben se toman todos los del array $_GET actual.
// - $pagina es el numero de pagina actual, siendo la referencia para la lista
// de enlaces que se van a generar.
// - $enlaces es el numero de enlaces a generar. El minimo es de 2 y el 
// maximo es 25, pero se recomienda usar valores entre 5 y 10. Si no se indica
// o es un valor nulo, falso o cero, se toma por defecto 5.
// - $total es el numero de resultados totales si no se paginaran. Si no se 
// indica, es "false" o negativo, no se informa del total ni tampoco se pueden
//  calcular el número máximo de páginas. Si es cero si se informa/calcula.
// - $lineas es el numero de resultados por pagina. Si no se indica, es 
// "false" o cero, no se pueden calcular el número máximo de páginas.
//---------------------------------------------------------------------------
if (!isset($url)) $url= null;
if (!is_array($url)) $url= $_GET;
//----------
if (!isset($pagina)) $pagina= 1;
if ($pagina < 1) $pagina= 1;
//----------
if (!isset($enlaces) || empty($enlaces)) $enlaces= 5;
if ($enlaces < 3) $enlaces= 2;
if ($enlaces > 25) $enlaces= 25;
//----------
if (!isset($total) || ($total === false)) $total= -1;
//----------
if (!isset($lineas) || ($lineas === false)) $lineas= 0;
//----------
$paginas= -1;
if (($total >= 0) && ($lineas > 0)) {
  $paginas= (int)(($total + $lineas - 1) / $lineas);
}//if
//----------
?>
<div class="paginador">
<ul>
<?php //Informar del total de resultados.
if ($total >= 0) {
  echo '<li><span>';
  //--echo '[enlaces= '.$enlaces.']';//depurar
  if ($total == 0) {
    echo 'No nay resultados.'; 
  } else {
    echo $total.' resultado'.(($total==1) ? '' : 's');
    if ($paginas >= 0) {
      echo ', página '.$pagina.' de '.$paginas;
    }//if
    echo '.';
  }//if
  echo '</span></li>';
}//if

//Calcular los límites del número de enlaces a mostrar...
$pagina--;//Tener la pagina relativa al 0.
$medio= (int)($enlaces / 2);
$inicio= max( 0, $pagina - $medio);
$fin= $inicio + $enlaces - 1;
//Si se conoce el total de paginas, limitar por arriba
if (($paginas >= 0) && ($fin >= $paginas)) {
  $fin= $paginas - 1;
  $inicio= max( 0, $fin - $enlaces + 1);
}//if
//Tener los valores de pagina relativos al 1.
$inicio++; $fin++; $pagina++;
//Generar los enlaces si hay más de una página resultante...
if ($paginas > 1) {
  echo '<li><span>';
  echo 'Ir a página:';
  echo '</span></li>';
  for($url['p']= $inicio; ($url['p'] <= $fin); $url['p']++) {
    echo '<li>';
    echo '<a href="?'.http_build_query( $url, 'arg').'"'.(($url['p']==$pagina) ? ' class="actual"' : '').'>';
    echo $url['p'];
    echo '</a>';
    echo '</li>';
  }//for
  /*-----*X/
  //Generar la información sobre el total de paginas.
  if ($paginas >= 2) {
    echo '<li><span>';
    echo ' de '.$paginas;
    echo '</span></li>';
  }//if
  //-----*/
}//if
?>
<div class="salto"></div>
</ul>
</div>
