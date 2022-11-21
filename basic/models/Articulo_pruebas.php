<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ArticuloPruebas extends \yii\db\ActiveRecord
{
    public static function tableName(){
        return 'articulos';
    }

    public function attributes(){
        $lista=parent::attributes();
        $lista[]='precioConIva';
        return $lista;
    }

    public function getPrecioConIva(){

        return $this->precio*$this->iva/100;
    }
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['referencia', 'texto'], 'required'],
            //
            [['precio','iva',] ,'default','value'=>0],
            [['precio','iva',] ,'double','integerOnly'=>false],

            [['notas'],'string'],
            [['referencia'],'string','max'=>10],
            [['texto'],'string','max'=>250],
            //message es lo que pone si no es único
            [['referencia'],'unique','message'=>'La referencia ya existe'],
            //
        ];
    }
}