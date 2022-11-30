<?php
modelo::usar( 'compra');
modelo::usar('perfiles');
//---------------------------------------------------------------------------
//Vista de cesta de la compra...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $registros --> array con los registros de la tabla de compra.
//    $total --> número de registros totales de la tabla de compra.
//    $pagina --> numero de pagina que se esta obteniendo.
//    $lineas --> numero de lineas visibles por pagina.
//---------------------------------------------------------------------------
/*-----
depurar( array(
  'id_controlador' => aplicacion::$id_controlador,
  'id_accion' => aplicacion::$id_accion,
  'pagina' => $pagina,
  'lineas' => $lineas,
  'total' => $total,
  'registros' => $registros,
));
//-----*/


//echo $local;
?>
    <h1>Cesta de la compra</h1>
    <div class="hoja">
<?php //Generar los registros obtenidos de la compra.
if (is_array($registros)) {
    $cantidad_final=0;
    $pagina=1;
    $precio_final=0;
    foreach($registros as $indice => $datos) {
        $modelo=new articulo;

        echo '<br>';
        $modelo->rellenar($indice,$datos['oferta']);
        //var_dump($modelo);
        //Opcion 1: Siguiendo el framework
        vista::generarParcial( 'ficha_compra_mod', array( 'articulo'=>$modelo,'datos'=>$datos, 'pagina'=>$pagina));
        ?>

        <?php

        //Opcion 2: incluir a mano.
        //include( 'ficha_oferta.php');

        //Opcion 3: aqui a mano.
        //echo '<div>'; print_r( $modelo); echo '</div>';


        $cantidad_final= $cantidad_final+($datos['cantidad']);
        $precio_final+=$datos['cantidad']*$modelo->precio;
    }//foreach
        echo '<div> <H2>Cantidad total: '.$cantidad_final.' Unidades</H2>';
        echo '<div> <H2>Precio total: '.$precio_final.'€</H2>';
    if($cantidad_final>0) {
        if(perfil::esPerfil('Invitado')){
            vista::generarPieza('boton_accion', array('texto' => 'Vaciar', 'icono' => 'delete.png',
                'activo' => false, 'url' => array('a' => 'compra.clear'),
                'submit' => true));
            $vuelta='vuelta_compra';
            $url= '?'.http_build_query( array('a'=>'inicio.registro', 'p'=>$pagina, 'vuelta'=>$vuelta));
            echo '<a href="'.$url.'" <H1>Crear Cuenta</H1></a>';

        }else{
            vista::generarPieza('boton_accion', array('texto' => 'Vaciar', 'icono' => 'delete.png',
                'activo' => false, 'url' => array('a' => 'compra.clear'),
                'submit' => true));
            echo '<div><H1>Comprar</H1>';
            vista::generarPieza('boton_accion', array('texto' => 'Comprar', 'icono' => 'cart.png',
                'activo' => false, 'url' => array('a' => 'compra.compra'),
                'submit' => true));
            echo '<div>';
        }
    }
} else {
    echo 'No hay datos.';
}