<?php
//---------------------------------------------------------------------------
//Plantilla principal de la aplicación en modo PUBLICO.
//---------------------------------------------------------------------------
//Las acciones previas a generar el HTML de la plantilla que sean comunes,
//es mejor ponerlas en "principal.php" si se carga siempre el mismo y se
//diferencia por "aplicacion::$modoPublico", sino se ponen aqui o para que
//sean únicas, se incluyen desde aquí con algún "include(...)".

?><!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf8"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="recursos/principal.css" media="screen" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <title>Prueba: <?php /*echo pagina::$titulo;*/?></title>
</head>
<body class="pagina">
  <div class="w3-container w3-teal">
      <h1>POSEIDAW2</h1>
  <?php vista::generarPieza('usuario'); ?>
  </div>
  <div class="cuerpo">
    
    
    <?php vista::generarPieza('menu_portal'); ?>
 
    <div class="contenido">
      <?php echo $contenido; ?>
    </div>
    <div class="salto"></div>
  </div>
  <div class="w3-container w3-teal">

      <p> &copy; Desarrollo de Aplicaciones Web II - EPSZ - Univ. Salamanca - Saúl Otero García
      </p>
  </div>

</body>
</html>