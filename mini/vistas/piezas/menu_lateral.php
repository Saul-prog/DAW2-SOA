<?php 
//Pieza de generación del "menu lateral", que aparece en la parte 
//izquierda por ejemplo.

/*-----*x/
// Ejemplo de menú en forma de array para poder implementar diferentes
// piezas que lo generen visualmente.
// Se puede hacer además que la opción tenga la clave "activa", por 
// ejemplo, para indicar que esa opción debe estar resaltada visualmente
// de alguna manera, pero si no se indica o se evalúa a "false" no se
// deberá resaltar.
$opciones= array(
  array( 'titulo' => 'Inicio', 'url'=>'?a=inicio')
  array( 'titulo' => 'Clientes', 'url'=>'?a=clientes', 'activo'=>true)
  array( 'titulo' => 'Articulos', 'url'=>'?a=articulos')
  array( 'titulo' => 'Pedidos', 'url'=>'?a=pedidos')
  ,array(...)
);
//-----*/
?>
<div class="menu">
<ul>
<li><a href="?a=inicio">Inicio</a></li>
<li><a href="?a=clientes">Clientes</a></li>
<li><a href="?a=articulos">Articulos</a></li>
<li><a href="?a=pedidos">Pedidos</a></li>
</ul>
</div>