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
$htmlCrear= vista::generarPieza( 'boton_accion', array(
        'texto'=>'Crear cuenta'
    , 'icono'=>'login.png'
    , 'activo'=>true
    , 'url'=>array('a'=>'inicio.registro')
        //, 'submit'=>true
    )
    , true
);
  if ($usuario === null) {
      echo 'Invitado';
      echo '<div class="w3-bar w3-black">'.$htmlCrear.$htmlLogin.'</div>';

  } else {
      if(strcmp($usuario->rol,'Invitado')==0){
        echo 'Invitado';

          echo '<div class="w3-bar w3-black">'.$htmlCrear .$htmlLogin.'</div>';
      }else{
          echo $usuario->nombre.'('.$usuario->rol.')';

          echo '<div class="w3-bar w3-black">'.$htmlLogout.'</div>';
      }

    //echo '<div class="acciones linea">'.$htmlLogin.$htmlLogout.'</div>';
  }
?>
</div>
<?php //Aunque la pieza "usuario" flote, forzar a que ocupe espacio. ?>
<div class="salto"></div>