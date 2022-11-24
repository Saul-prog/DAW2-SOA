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
        $pagina=1;
        $cesta= Cesta::instancia_de_sesion();
        $registros= $cesta->contenido();
        $total=$cesta->total_articulos();
        //var_dump($registros);
       // $lineas=$total=$cesta->total_articulos();//Se va a mostrar todo de una sin importar la cantidad
        //----------
        //Dar una respuesta
        //vista::$plantilla= 'publica.php';
        vista::generarPagina( 'compra', array(
            'pagina'=>$pagina,
            'lineas'=>$total,
            'total'=>$total,
            'registros'=>$registros,
        ));
    }//accion_ver

    public function accion_quitar()
    {
        $id= (isset($_GET['ref']) ? $_GET['ref'] : null);
        $cantidad=(isset($_GET['cantidad']) ? $_GET['cantidad'] : 1);

        $cesta= Cesta::instancia_de_sesion();

        $cesta->quitar( $id, $cantidad);
        $cesta->guardar_en_sesion();

        vista::redirigir( '', array('a'=>'compra.ver'));
    }

    public function accion_add()
    {
        $id= (isset($_GET['ref']) ? $_GET['ref'] : null);
        $oferta=(isset($_GET['oferta']) ? $_GET['oferta'] : 0);
        if($id!==NULL){
            $cesta= Cesta::instancia_de_sesion();
            $cesta->poner( $id, $oferta,1);
            $cesta->guardar_en_sesion();
        }
        vista::redirigir( '', array('a'=>'compra.ver'));
    }
    public function accion_clear(){
        $cesta= Cesta::instancia_de_sesion();
        $cesta->vaciar();
        $cesta->guardar_en_sesion();
        vista::redirigir( '', array('a'=>'compra.ver'));
    }
    public function accion_del(){
        $cesta= Cesta::instancia_de_sesion();
        $cesta->vaciar();
        $cesta->guardar_en_sesion();
        vista::redirigir( '', array('a'=>'compra.ver'));
    }

    public function accion_set(){
        $id= (isset($_POST['ref']) ? $_POST['ref'] : null);
        $cantidad=(isset($_POST['cantidad']) ? $_POST['cantidad'] : 1);
        var_dump($id);
        var_dump($cantidad);
        $cesta=Cesta::instancia_de_sesion();
        $cesta->set($id,$cantidad);
        $cesta->guardar_en_sesion();
        vista::redirigir( '', array('a'=>'compra.ver'));
    }

}