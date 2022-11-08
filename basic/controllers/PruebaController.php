<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

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

   
}
