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
modelo::usar('perfiles');
if(perfil::esPerfil('Administrador')){
    $opciones= array(
        array( 'titulo' => 'Inicio', 'url'=>'?a=inicio'),
        array( 'titulo' => 'Catálogo', 'url'=>'?a=catalogo'),
        array( 'titulo' => 'Ofertas', 'url'=>'?a=ofertas'),
        array( 'titulo' => 'Articulos', 'url'=>'?a=articulos'),
        array( 'titulo' => 'Clientes', 'url'=>'?a=clientes'),
        array( 'titulo' => 'Compra', 'url'=>'?a=compra'),
        array( 'titulo' => 'pedidos', 'url'=>'?a=pedidos'),
        array( 'titulo' => 'usuarios', 'url'=>'?a=usuarios'),
    );
}else if(perfil::esPerfil('Empleado')) {
    $opciones = array(
        array('titulo' => 'Inicio', 'url' => '?a=inicio'),
        array('titulo' => 'Catálogo', 'url' => '?a=catalogo'),
        array('titulo' => 'Ofertas', 'url' => '?a=ofertas'),
        array('titulo' => 'Articulos', 'url' => '?a=articulos'),
        array('titulo' => 'Clientes', 'url' => '?a=clientes'),
        array('titulo' => 'Compra', 'url' => '?a=compra'),
        array('titulo' => 'pedidos', 'url' => '?a=pedidos'),

    );/*---------*/
}






?>
<div class="menu">
    <ul><?php
        foreach ($opciones as $array) {
            echo "</li>";
            echo "<a href=".$array['url'].">".$array['titulo']."</a>";
            echo "</li>";

            }
        ?>
</ul>
</div>