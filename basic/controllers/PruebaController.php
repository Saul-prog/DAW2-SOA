<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ContactForm;
use app\models\ArticuloPruebas;
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
}
