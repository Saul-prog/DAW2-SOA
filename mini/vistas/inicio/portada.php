<h1>PORTADA</h1>
Esta es la vista que se muestra en la acción predeterminada del controlador.<br/>
El fichero es &quot;<?php echo basename(__FILE__); ?>&quot;.<br/>
Ubicado físicamente en &quot;<?php echo dirname(__FILE__); ?>&quot;.<br/>
<?php
depurar( array( 
  'id_controlador' => aplicacion::$id_controlador,
  'id_accion' => aplicacion::$id_accion,
  'controlador' => aplicacion::$controlador,
  'dato' => $dato,
));

?>
<?php
echo '<pre>'; print_r( $_SESSION); echo '</pre>'; 

