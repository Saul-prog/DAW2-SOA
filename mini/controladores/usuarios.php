<?php
modelo::usar( 'usuario');
class controlador_usuarios extends controlador
{

    public $accion_defecto= 'administrar';

    public function accion_crear(){
        $bien= false;
        $error= '';
        $modelo= new usuarioAcceso;
        //----------
        $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
        //----------
        //Si hay datos del formulario articulo, se intenta crear nuevo...
        if (isset($_POST['usuarioAcceso'])) {
            //Copiar los datos del formulario...
            $modelo->llenar( $_POST['usuarioAcceso']);
            //Intentar guardar validando antes el modelo...
            $bien= $modelo->guardar();
            if ($bien) $error= 'El Usuario se ha guardado correctamente.';
            else $error= 'No se ha podido guardar el usuario nuevo.';
        }//if
        //----------
        //Dar una respuesta segun el resultado del proceso.
        if ($bien) {
            //vista::redirigir( array('articulos.editar'), array('id'=>$modelo->referencia, 'p'=>$pagina));
            vista::generarPagina( 'usuarios_editar', array(
                'modelo'=>$modelo,
                'error'=>$error,
                'pagina'=>$pagina,
            ));
        } else {
            vista::generarPagina( 'usuarios_crear', array(
                'modelo'=>$modelo,
                'error'=>$error,
                'pagina'=>$pagina,
            ));
        }//if
        //-----*/
    }

    public function accion_ver(){

    }

    public function accion_editar(){

    }

    public function accion_borrar(){

    }

    public function accion_administrar(){
        //----------
        //Extraer Datos para ejecucion con la pagina que se está viendo.
        $pagina= (isset($_GET['p']) ? (int)$_GET['p'] : 0);
        if ($pagina < 1) $pagina= 1;//se empieza en la primera pagina como mucho.
        $lineas= config::get('pagina.lineas', 10);
        if ($lineas < 1) $lineas= 1;//como minimo se obtiene 1 elemento por pagina.
        //----------
        //Ejecutar accion
        $sql= usuarioAcceso::sqlListar();
        $total= basedatos::contar( $sql);
        $registros= basedatos::obtenerTodos( $sql, $pagina-1, $lineas);
        //----------
        //Dar una respuesta
        vista::generarPagina( 'usuarios_admin', array(
            'pagina'=>$pagina,
            'lineas'=>$lineas,
            'total'=>$total,
            'registros'=>$registros,
        ));
    }
}
