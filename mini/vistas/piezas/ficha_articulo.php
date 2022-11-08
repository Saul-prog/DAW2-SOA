<?php
//-----------------------------------------------------------------
//PIEZA para mostrar un ARTICULO en el CATALOGO
// Variables:
// $articulo -> modelo articulo a generar.
// $cesta    -> si generar el acceso a la cesta de la compra o no.
// $pagina   -> posible numero de pagina activa del catalogo.
//-----------------------------------------------------------------
if (!isset($pagina) || empty($pagina)) $pagina= 1;
if (!isset($cesta)) $cesta= true;
$fmtPrecio= number_format( $articulo->precio, 2, ',', '.');
if ($articulo->precio < 20.00) {
  $fmtPrecio= '<span class="precio-bajo">'.$fmtPrecio.'<span>';
}
?>
<div class="articulo">
  <div class="caja-sombra">
    <?php echo $articulo->referencia;?><br/>
    <?php echo htmlentities( $articulo->texto);?><br/>
  <div class="der">Precio: <?php echo $fmtPrecio;?>€</div>
    <?php if ($cesta) {
      $url= '?'.http_build_query( array('a'=>'catalogo.add', 'ref'=>$articulo->referencia, 'p'=>$pagina));
    echo '<a href="'.$url.'">';
    echo '<img src="recursos/cesta.png" title="Agregar a la cesta" alt="Agregar a la cesta" width="32px" height="auto"/>';
    echo '</a>';
  }// ?>
  </div>
</div>