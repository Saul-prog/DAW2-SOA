<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ContactForm;
use app\models\ArticuloPruebas;
use app\models\Pedidos;
use app\models\Clientes;
class PruebaController extends Controller
{
  
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //return 'Hola mundo';
       //return $this->render('index');
       return $this->renderContent('hola');
    }

    public function actionContacto(){
        //http://localhost/daw2/basic/web/index.php?r=prueba/contacto
        $modelo=new ContactForm();
        $lista=$modelo->attributes();
        $html='<pre>'.print_r($lista,true).'</pre>';
        $etiquetas=[];
        foreach($lista as $attr) $etiquetas[$attr] = $modelo->getAttributeLabel($attr);
        $html.='<pre>'.print_r($etiquetas,true).'</pre>';
        print_r($html);


    }

    public function actionArticulo(){
        $modelo=new ArticuloPruebas();
        $lista=$modelo->attributes();
        $html='<pre>'.print_r($lista,true).'</pre>';
        $modelo->precio=100;
        $modelo->iva=10;
        $modelo->validate();
        $html='<pre>Errores:'.print_r($modelo->getErrors(),true).'</pre>';
    }


    public function actionPedido(){
        $html='';
        $modelo=Pedidos::find()->limit(1)->one();
        $cliente=$modelo->cliente;
        //$query=$modelo->getLineas();
        //$lineas=$modelo->lineas;
        $html.='<pre>'.print_r($modelo->attributes,true).'</pre>';
        $html.='<pre>Clientes: '.print_r($cliente->attributes,true).'</pre>';
        $html.='<pre>Lineas: '.print_r(count($modelo->lineas),true).'</pre>';
        $html.='<pre>Precio total: '.print_r($modelo->ImporteTotal,true).'</pre>';
        //echo $html;
        return $this->renderContent($html);
    }


}
