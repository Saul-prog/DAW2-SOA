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
  <title>Prueba: <?php /*echo pagina::$titulo;*/?></title>
</head>
<body class="pagina">
  <div class="cabecera">
  <strong>Plantilla Pública:</strong> ...lo que sea de una cabecera...
  <?php vista::generarPieza('usuario'); ?>
  </div>
  <div class="cuerpo">
    <div class="menu-sup">
    ...parte publica...lo que sea de un menu superior
    <?php //vista::generarPieza('menu_portal'); ?>
    </div>
    <div class="contenido">
      <?php echo $contenido; ?>
    </div>
    <div class="salto"></div>
  </div>
  <div class="pie salto">
    &copy; Desarrollo de Aplicaciones Web II - EPSZ - Univ. Salamanca
  </div>
  
  
  <?php //Depurar sesion
    echo '<pre>';
    print_r( $_SESSION);
    echo '</pre>';
  ?>
</body>
</html>