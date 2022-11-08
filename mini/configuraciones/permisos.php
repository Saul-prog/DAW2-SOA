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
  array('*', '*', '*', true),
);