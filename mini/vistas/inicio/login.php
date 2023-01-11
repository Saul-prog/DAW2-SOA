<?php
/*
  Formulario de acceso a la aplicacion
  Variables usadas:
    - $usuario --> clase "usuario" con los posibles datos de acceso.
*/
?>
    <div class="w3-card-4">
        <div class="w3-container w3-green">
            <h1>Acceso</h1>
            <h5>Introduzca los datos de acceso al sistema:</h5>
        </div>


        <form  class="w3-container" action="" method="post">
        <fieldset>
          <label for="usr" style="display:inline-block;width:10em;">Usuario:</label>
          <input class="w3-input" type="text" id="usr" name="usuario" size="10"
              value="" />
          <br/>
          <label for="pwd" style="display:inline-block;width:10em;">Contraseña:</label>
          <input class="w3-input" type="password" id="pwd" name="password" size="10" value=""/>
          <br/>
            <td colspan="2" class="cen">
                <?php if (!empty($error)) { ?><div class="w3-panel w3-red"><?php echo $error; ?></div><?php }//if ?>
            </td>
          <input class="w3-button w3-block" type="submit" value="Enviar" />

        </fieldset>
        </form>
    </div>
<?php


