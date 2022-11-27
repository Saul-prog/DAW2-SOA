<?php 
//Pieza de generación del "menu lateral", que aparece en la parte 
//izquierda por ejemplo.

// Ejemplo de menú en forma de array para poder implementar diferentes
// piezas que lo generen visualmente.
// Se puede hacer además que la opción tenga la clave "activa", por 
// ejemplo, para indicar que esa opción debe estar resaltada visualmente
// de alguna manera, pero si no se indica o se evalúa a "false" no se
// deberá resaltar.



$opciones= array(
  array( 'titulo' => 'Inicio', 'url'=>'?a=inicio'),
array( 'titulo' => 'Clientes', 'url'=>'?a=clientes', 'activo'=>true),
  array( 'titulo' => 'Articulos', 'url'=>'?a=articulos'),
    array( 'titulo' => 'Ofertas', 'url'=>'?a=ofertas'),
    array( 'titulo' => 'Catalogo', 'url'=>'?a=catalogo'),
    array( 'titulo' => 'Compra', 'url'=>'?a=compra'),
    array( 'titulo' => 'Usuarios', 'url'=>'?a=usuarios'),
  array( 'titulo' => 'Pedidos', 'url'=>'?a=pedidos')
);/*---------*/
?>

<div class="menu2">
    <ul>
    <?php
foreach ($opciones as $array) {

        ?><li><?php
        echo "<a href=".$array['url'].">".$array['titulo']."</a>";
        echo "</li>";

    
}

?>
</ul>
</div>
