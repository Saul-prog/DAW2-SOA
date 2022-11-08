<?php

class controlador_prueba extends controlador{
    public function accion_inicio(){
        echo "<p>Hola mundo</p>";
        vistas::generarParcial()
    }
}
?>