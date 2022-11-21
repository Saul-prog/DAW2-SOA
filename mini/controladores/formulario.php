<?php
modelo::usar( 'formularios');
class controlador_formulario extends controlador
{
    public $accion_defecto= 'ver';


    //-------------------------------------------------------------------------
    //Accion para CREAR un articulo
    public function accion_crear()
    {
        $bien= false;
        $error= '';
        $modelo= new formulario;
        //----------
        $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
        //----------

        if (isset($_POST['formulario'])) {
            //Copiar los datos del formulario...
            $modelo->llenar( $_POST['formulario']);
            $bien= $modelo->guardar();
            if ($bien) $error= 'El usuario se ha guardado correctamente.';
            else $error= 'No se ha podido guardar el usuario nuevo.';
        }//if
        //----------
        //se genera el formulario
        if ($bien) {
            //vista::redirigir( array('articulos.editar'), array('id'=>$modelo->referencia, 'p'=>$pagina));
            vista::generarPagina( 'editar_usuario', array(
                'modelo'=>$modelo,
                'error'=>$error,
                'pagina'=>$pagina,
            ));
        } else {
            vista::generarPagina( 'crear_usuario', array(
                'modelo'=>$modelo,
                'error'=>$error,
                'pagina'=>$pagina,
            ));
        }

        //-----*/
    }//accion_crear

    //-------------------------------------------------------------------------
    //Accion para EDITAR un articulo
    /******x/
    public function accion_editar()
    {
        $bien= false;
        $error= '';
        $modelo= null;
        //----------
        $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
        //----------
        //Coger el dato clave para cargar el modelo a editar...
        $id= (isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null));
        if ($id === null) {
            $error= 'No se ha indicado el articulo a editar.';
        } else {
            $modelo= new articulo;
            if (!$modelo->cargar( $id)) {
                $error= 'No se puede cargar el articulo ('.$id.') para editar.';
                $modelo= null;
            }//if
        }//if
        //----------
        //Si hay modelo cargado, y datos del formulario, se intenta copiar/guardar.
        if (($modelo !== null) && isset($_POST['articulo'])) {
            //Copiar los datos del formulario...
            $modelo->llenar( $_POST['articulo']);
            //Intentar guardar validando antes el modelo...
            $bien= $modelo->guardar();
            if ($bien) $error= 'El articulo se ha guardado correctamente.';
            else $error= 'No se ha podido guardar el articulo ('.$id.').';
        }//if
        //----------
        //Dar una respuesta segun el resultado del proceso.
        //--if ($bien) {
        //--  vista::redirigir( array('articulos'), array('p'=>$pagina));
        //--} else {
        vista::generarPagina( 'editar', array(
            'modelo'=>$modelo,
            'error'=>$error,
            'pagina'=>$pagina,
        ));
        //--}//if
        //-----/
    }//accion_editar
    /**********/
    //-------------------------------------------------------------------------
    //Accion para CONSULTAR un articulo
    public function accion_ver()
    {
        $bien= false;
        $error= '';
        $modelo= null;
        //----------
        $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
        //----------
        //Coger el dato clave para cargar el modelo a editar...
        $idFrom= (isset($_GET['idForm']) ? $_GET['idFrom'] : (isset($_POST['idFrom']) ? $_POST['idFrom'] : null));
        if ($idFrom === null) {
            $error= 'No se ha indicado usuario a consultar.';
        } else {
            $modelo= new formulario;
            if (!$modelo->cargar( $idFrom)) {
                $error= 'No se puede cargar el articulo ('.$idFrom.') para consultar.';
                $modelo= null;
            }//if
        }//if
        //----------
        //Dar una respuesta segun el resultado del proceso.
        vista::generarPagina( 'ver_formulario', array(
            'modelo'=>$modelo,
            'error'=>$error,
            'pagina'=>$pagina,
        ));
    }//accion_ver

    //-------------------------------------------------------------------------
    //Accion para ELIMINAR un articulo
    public function accion_borrar()
    {
        $bien= false;
        $error= '';
        $modelo= null;
        //----------
        $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
        //----------
        //Coger el dato clave para cargar el modelo a editar...
        $idFrom= (isset($_GET['idFrom']) ? $_GET['idFrom'] : (isset($_POST['idFrom']) ? $_POST['idFrom'] : null));
        if ($idFrom === null) {
            $error= 'No se ha indicado el articulo a editar.';
        } else {
            $modelo= new articulo;
            if (!$modelo->cargar( $idFrom)) {
                $error= 'No se puede cargar el articulo ('.$idFrom.') para editar.';
                $modelo= null;
            }//if
        }//if
        //----------
        $confirmado= (boolean)(isset($_GET['ok']) ? $_GET['ok'] : (isset($_POST['ok']) ? $_POST['ok'] : 0));
        //----------
        //Si hay modelo cargado, y datos del formulario, se intenta eliminar.
        if (($modelo !== null) && $confirmado) {
            //Intentar eliminar el modelo...
            $bien= $modelo->eliminar();
            if ($bien) $error= 'El articulo se ha eliminado correctamente.';
            else $error= 'No se ha podido eliminar el articulo ('.$idFrom.').';
        }//if
        //----------
        //Dar una respuesta segun el resultado del proceso.
        if ($bien) {
            vista::redirigir( array('formulario'), array('p'=>$pagina));
        } else {
            vista::generarPagina( 'borrar', array(
                'modelo'=>$modelo,
                'error'=>$error,
                'pagina'=>$pagina,
            ));
        }//if
    }//accion_borrar

    //-------------------------------------------------------------------------
    //Accion para CREAR modelos de articulo de ejemplo.
    //Eliminar o comentar cuando no se use.
    /*-----*x/
    public function accion_creardemo()
    {
        $bien= false;
        $modelo= new articulo;
        //----------
        //Simular la creacion de varios articulos...
        //INSERT INTO `articulos`
        // (`referencia`, `texto`, `precio`, `iva`, `notas`)
        // VALUES
        // ('A000034', 'asdoiu', 12.90, 21.00, NULL)
        for ($i= 1; ($i <= 25); $i++) {
            $modelo->referencia= sprintf( 'ART%06d', $i);
            $modelo->texto= sprintf( 'texto %06d', $i);
            $modelo->precio= sprintf( '%8.2f', $i*rand(100,1500)/100);
            $modelo->iva= sprintf( '%5.2f', ((int)($i/2) == 0) ? 21.00 : 10.00);
            $modelo->notas= null;//sprintf( 'notas %06d', $i);
            $modelo->guardar();
            //crear nueva instancia para que se inserte el siguiente.
            $modelo= new articulo;
        }//for
        //--echo 'voy a redirigir la pagina...'; flush();//probar a generar contenido HTML antes de redirigir.
        vista::redirigir( array('articulos','admin'));
    }//accion_creardemo
    /****/
}//class controlador_articulos