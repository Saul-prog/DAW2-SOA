<?php

class perfil
{
const ROL_Invitado='Invitado';
const ROL_Cliente='Cliente';
const ROL_Administrador='Administrador';
const ROL_Empleado='Empleado';

public static function esUsuarioPerfil($usuario,$perfil){
    if(strcmp($usuario->rol,$perfil)==0){
        return true;
    }
    return false;

}
public static function esPerfil($perfil){
    $usuario=sesion::get('usuario');
    if($usuario===NULL){
        $usuario=new usuario();
        sesion::set('usuario',$usuario);
    }
    if(perfil::esUsuarioPerfil($usuario,$perfil)){
        return true;
    }
    return false;
}


}//perfil