<?php 
//Pieza de generación del "menu lateral", que aparece en la parte 
//izquierda por ejemplo.

// Ejemplo de menú en forma de array para poder implementar diferentes
// piezas que lo generen visualmente.
// Se puede hacer además que la opción tenga la clave "activa", por 
// ejemplo, para indicar que esa opción debe estar resaltada visualmente
// de alguna manera, pero si no se indica o se evalúa a "false" no se
// deberá resaltar.
modelo::usar('perfiles');

if(perfil::esPerfil('Cliente')){
    $opciones= array(
        array( 'titulo' => 'Inicio', 'url'=>'?a=inicio'),
        array( 'titulo' => 'Catálogo', 'url'=>'?a=catalogo'),
        array( 'titulo' => 'Ofertas', 'url'=>'?a=ofertas'),
        array( 'titulo' => 'Compra', 'url'=>'?a=compra'),
    );/*---------*/
}else if(perfil::esPerfil('Invitado')){
    $opciones= array(
        array( 'titulo' => 'Inicio', 'url'=>'?a=inicio'),
        array( 'titulo' => 'Catálogo', 'url'=>'?a=catalogo'),
        array( 'titulo' => 'Ofertas', 'url'=>'?a=ofertas'),

    );/*---------*/
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
}else if(perfil::esPerfil('Administrador')) {
    $opciones = array(
        array( 'titulo' => 'Inicio', 'url'=>'?a=inicio'),
        array( 'titulo' => 'Catálogo', 'url'=>'?a=catalogo'),
        array( 'titulo' => 'Ofertas', 'url'=>'?a=ofertas'),
        array( 'titulo' => 'Articulos', 'url'=>'?a=articulos'),
        array( 'titulo' => 'Clientes', 'url'=>'?a=clientes'),
        array( 'titulo' => 'Compra', 'url'=>'?a=compra'),
        array( 'titulo' => 'pedidos', 'url'=>'?a=pedidos'),
        array( 'titulo' => 'usuarios', 'url'=>'?a=usuarios'),

    );/*---------*/
}else{
    $opciones= array(
        array( 'titulo' => 'Inicio', 'url'=>'?a=inicio'),
        array( 'titulo' => 'Catálogo', 'url'=>'?a=catalogo'),
        array( 'titulo' => 'Ofertas', 'url'=>'?a=ofertas'),
        );
}

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
