<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ContactForm;
use app\models\Articulo;
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
        $modelo=new Articulo();
        $lista=$modelo->attributes();
        $html='<pre>'.print_r($lista,true).'</pre>';
        print_r($lista);
    }
}
