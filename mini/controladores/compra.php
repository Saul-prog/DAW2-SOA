<?php
aplicacion::$modoPublico= true;
modelo::usar( 'articulo');
modelo::usar( 'Cesta');

class controlador_compra extends controlador
{
    public $accion_defecto = 'ver';

    //-------------------------------------------------------------------------
    //Accion para VER cesta de la compra
    public function accion_ver()
    {
        //----------
        //Ejecutar accio
        $cesta= Cesta::instancia_de_sesion();
        $registros= $cesta->contenido();
        $total=$cesta->total_articulos();
        //var_dump($registros);
       // $lineas=$total=$cesta->total_articulos();//Se va a mostrar todo de una sin importar la cantidad
        //----------
        //Dar una respuesta
        //vista::$plantilla= 'publica.php';
        vista::generarPagina( 'compra', array(
            'pagina'=>1,
            'lineas'=>1,
            'total'=>$total,
            'registros'=>$registros,
        ));
    }//accion_ver

}