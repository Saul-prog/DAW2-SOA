<?php
//-----------------------------------------------------------------
//PIEZA para mostrar una OFERTA de un Artículo en el CATALOGO
// Variables:
// $oferta -> modelo oferta a generar.
// $cesta    -> si generar el acceso a la cesta de la compra o no.
// $pagina   -> posible numero de pagina activa del catalogo.
//-----------------------------------------------------------------
if (!isset($pagina) || empty($pagina)) $pagina= 1;
if (!isset($cesta)) $cesta= true;
$fmtPrecio= number_format( $oferta->precio, 2, ',', '.');
if ($oferta->precio < 20.00) {
  $fmtPrecio= '<span class="precio-bajo">'.$fmtPrecio.'<span>';
}
?>
<div class="articulo">
  <div class="caja-sombra">
    <?php echo $oferta->articulo->referencia;?><br/>
    <?php //echo $oferta->$refART;?><br/>
    <?php echo htmlentities( $oferta->articulo->texto);?><br/>
  <div class="der">Precio: <?php echo $fmtPrecio;?>€</div>
    <?php if ($cesta) {
      $url= '?'.http_build_query( array('a'=>'catalogo.add', 'ref'=>$oferta->articulo->referencia, 'p'=>$pagina));
    echo '<a href="'.$url.'">';
    echo '<img src="recursos/cesta.png" title="Agregar a la cesta" alt="Agregar a la cesta" width="32px" height="auto"/>';
    echo '</a>';
  }// ?>
  </div>
</div>