<?php
return array(
  //array(rol, controlador, accion, permitir),
  //array('Invitado', 'inicio', 'inicio', true),
  
  //array('Invitado', 'inicio', 'logout', false),
  //array('Invitado', 'inicio', '*', true),
  
  //Permitir acceso al catalogo a todo el mundo.
  //array('*', 'catalogo', '*', true),
  
  //array('Cliente', 'catalogo', '*', true),
  //array('Cliente', 'pedidos', '*', true),
	
  
  //Si no se encuentra coincidencia, PERMITIR TODO al Administrador
  //array('Administrador', '*', '*', true),
  
  //Si no se encuentra coincidencia, PROHIBIR TODO al TODOS
  //array('*', '*', '*', false),
  //Si no se encuentra coincidencia, PERMITIR TODO al TODOS
    array('Administrador','*','*',true),
    //Clientes
    array('Cliente', 'catalogo', '*', true),
    array('Cliente', 'ofertas', '*', true),
    array('Cliente', 'inicio', '*', true),
    array('Cliente', 'compra', '*', true),
    //Empleados
    array('Empleado', 'usuarios', '*', false),
    array('Empleado', '*', '*', true),
    //Invitado
    array('Invitado', 'catalogo', '*', true),
    array('Invitado', 'ofertas', '*', true),
    array('Invitado', 'inicio', '*', true),

    array('Invitado', 'compra', 'ver', true),


);