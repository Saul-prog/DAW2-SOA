<?php
modelo::usar('sesion');
class perfil extends modeloDAO
{
const ROL_Invitado=0;
const ROL_Cliente=1;
const ROL_Administrador=2;

//define('Roles',array('ROL_Invitado','ROL_Cliente','ROL_Administrador'));
public static function esUsuarioPerfil($usuario,$perfil){
    if(strcmp($usuario[rol],$perfil)==0){
        return true;
    }
    return false;

}
public static function esPerfil($perfil){
    $usuario=sesion::get('usuario');
    if(esUsuarioPerfil($usuario,$perfil)){
        return true;
    }
    return false;
}


}//perfil