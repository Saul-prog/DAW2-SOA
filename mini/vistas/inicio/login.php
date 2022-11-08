<?php
/*
  Formulario de acceso a la aplicacion
  Variables usadas:
    - $usuario --> clase "usuario" con los posibles datos de acceso.
*/
?>

<h1>Acceso</h1>
Introduzca los datos de acceso al sistema:<br/>
<form action="" method="post">
<fieldset>
  <label for="usr" style="display:inline-block;width:10em;">Usuario:</label>
  <input type="text" id="usr" name="usuario" size="10" 
      value="<?php echo $usuario->login;?>" />
  <br/>
  <label for="pwd" style="display:inline-block;width:10em;">Contraseña:</label>
  <input type="password" id="pwd" name="password" size="10" value=""/>
  <br/>
  <input type="submit" value="Enviar" />
</fieldset>
</form>
<?php
echo '<pre>'; print_r( $_SESSION); echo '</pre>'; 

