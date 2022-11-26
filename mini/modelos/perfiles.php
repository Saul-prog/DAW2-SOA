<?php
modelo::usar('sesion');
class perfil extends modeloDAO
{
const ROL_Invitado='Invitado';
const ROL_Cliente='Cliente';
const ROL_Administrador='Administrador';
const ROL_Empleado='Empleado';

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