<?php
//Un sistema basico de gestion de errores
//(c) DAW2 - EPSZ - Univ. Salamanca
function generar_error_html( $codigo, $clase, $mensaje)
{
  $protocolo= (isset($_SERVER['SERVER_PROTOCOL']) 
    ? $_SERVER['SERVER_PROTOCOL'] 
  : 'HTTP/1.0'
  );
  
  if (function_exists('generar_pagina_error')) {
    generar_pagina_error( $clase.'('.$codigo.'): '.$mensaje);
  } else {
    if (!headers_sent()) {
      header('Content-Type: text/html; charset=utf-8');
    }
    echo '<html>';
    echo '<head>';
    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" />';
    echo '<meta charset="UTF-8">';
    echo '</head>';
    echo '<body>';
    //echo $codigo.' '.$clase.', '.$mensaje;
    echo $clase.'('.$codigo.'): '.$mensaje;
    echo '</body>';
    echo '</html>';
  }
  exit();
}//generar_error_html

function error_grave( $mensaje)
{
  generar_error_html( 501, 'Error Grave', $mensaje);
}//error_grave


