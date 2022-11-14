<?php

namespace app\models;
use Yii;

class Articulo extends \yii\db\ActiveRecord
{
    public static function tableName(){
        return 'articulos';
    }

    public public attributes(){
        $lista=parent::attributes();
        $lista[]='precioConIva';
        return $lista;
    }
    public protected getPrecioConIva(){
        $lista=parent::attributes();
        $lista[]='precioConIva';
        return $this->precio*$this->iva/100;
    }
}