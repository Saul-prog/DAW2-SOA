<?php
aplicacion::$modoPublico= true;
modelo::usar( 'articulo');
modelo::usar( 'Cesta');
modelo::usar( 'usuario');
modelo::usar( 'cliente');
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
        $id= (isset($_GET['ref']) ? $_GET['ref'] : null);
        $cesta= Cesta::instancia_de_sesion();
        $cesta->eliminar($id);
        $cesta->guardar_en_sesion();
        vista::redirigir( '', array('a'=>'compra.ver'));
    }

    public function accion_set(){
        $id= (isset($_POST['ref']) ? $_POST['ref'] : NULL);
        $cantidad=(isset($_POST['cantidad']) ? $_POST['cantidad'] : 1);
        if($cantidad>=1&&$id!==NULL){
            $cesta=Cesta::instancia_de_sesion();
            $cesta->set($id,$cantidad);
            $cesta->guardar_en_sesion();
        }
        vista::redirigir( '', array('a'=>'compra.ver'));
    }

    public function accion_compra(){

        $cesta= Cesta::instancia_de_sesion();
        $registros= $cesta->contenido();
        $lineas=$cesta->total_articulos();
        //var_dump($registros);
        $total=$cesta->total_unidades();//Se va a mostrar todo de una sin importar la cantidad
        //----------
        //Dar una respuesta
        //vista::$plantilla= 'publica.php';
        vista::generarPagina('compra_final',array(
            'pagina'=>1,
            'lineas'=>$total,
            'total'=>$total,
            'registros'=>$registros,
        ));


    }

    public function accion_confirmar(){
        $us=sesion::get('usuario');
        $id=$us->id;
        if($id===NULL){
            $sql='SELECT id,password FROM usuarios WHERE login = "'.$us->login.'"';
            $res=basedatos::obtenerUno($sql);
            $us->id=$res['id'];
            $us->password=$res['password'];
        }else{
            $sql='SELECT password FROM usuarios WHERE login = "'.$us->login.'"';
            $res=basedatos::obtenerUno($sql);
            $us->password=$res['password'];
        }

        $sqlcliente='SELECT * FROM clientes WHERE idUsuario = "'.$us->id.'"';
        $rescliente=basedatos::obtenerUno($sqlcliente);
        if($rescliente===null){
            if(isset($_POST['cliente'])){
                $datos=$_POST['cliente'];
                $cliente = new cliente;
                $sql='SELECT * FROM clientes WHERE referencia LIKE "REG%"';
                $num_clientes=basedatos::contar($sql);
                $num_clientes++;

                $cliente->referencia = sprintf('REG%06d',$num_clientes);
                $cliente->idUsuario  = $us->id;

                $cliente->nombre     =  $datos['nombre'];
                $cliente->apellidos  = $datos['apellidos'];
                $cliente->cifnif     =  $datos['cifnif'];
                $cliente->domFiscal  = $datos['domicilio_fiscal'];
                $cliente->domEnvio   = $datos['domicilio_envio'];
                $cliente->notas      = $datos['notas'];
                $cliente->email      = $us->login;
                $cliente->password   =$us->password;
                $us->password='';

                $cliente->guardar();
            }
            $us->password='';
            vista::generarPagina( 'rellenar_cliente', array(
                'registros'=>$cliente,
            ));

        }elseif($rescliente===false){
            $us->password='';
            var_dump($rescliente);
        }else{
            $us->password='';
            $cliente=new cliente;
            $cliente->llenar($rescliente);

            vista::generarPagina( 'cliente_datos', array(
            ));
        }
    }
    public function accion_pagar(){
        $us=sesion::get('usuario');
        $id=$us->id;

        $pagar=(isset($_GET['pago']) ? $_GET['pago'] : 0);

        if($pagar){
            //Se obtiene los datos del cliente para el pedido
            $sql='SELECT referencia,domEnvio FROM clientes WHERE idUsuario = "'.$us->id.'"';
            $rescliente=basedatos::obtenerUno($sql);
            //se crean los valores para pedido
            $referencia=$rescliente['referencia'];
            $domEnvio=$rescliente['domEnvio'];
            $anyo=date("Y");
            $fecha=date("Y-m-d");
            $estado=0;
            $numero=basedatos::contar('pedidos');
            $numero++;
            //agregar pedidolin----------------------------------------------------------------------------

        }else{
            vista::generarPagina( 'pago_cliente', array(

            ));
        }

    }
}