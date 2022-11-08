<?php 
//Pieza de generación del "login" del usuario y algunos detalles más
$usuario= sesion::get('usuario');
?>
<div class="usuario">
<?php 
  $htmlLogout= vista::generarPieza( 'boton_accion', array(
        'texto'=>'Desconectar'
      , 'icono'=>'login.png'
      , 'activo'=>false
      , 'url'=>array('a'=>'inicio.logout')
      //, 'submit'=>true
      )
    , true
  );
  $htmlLogin= vista::generarPieza( 'boton_accion', array(
      'texto'=>'Conectar'
      , 'icono'=>'login.png'
      , 'activo'=>true
      , 'url'=>array('a'=>'inicio.login')
      //, 'submit'=>true
      )
    , true
  );
  if ($usuario !== null) {
    echo $usuario->nombre.'('.$usuario->rol.')';
    echo '&nbsp;';
    echo '<div class="acciones linea">'.$htmlLogout.'</div>';
  } else {
    echo 'Invitado';
    echo '&nbsp;';
    echo '<div class="acciones linea">'.$htmlLogin.'</div>';
    //echo '<div class="acciones linea">'.$htmlLogin.$htmlLogout.'</div>';
  }
?>
</div>
<?php //Aunque la pieza "usuario" flote, forzar a que ocupe espacio. ?>
<div class="salto"></div>