<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articulos".
 *
 * @property string $referencia Referencia unica del articulo, creada por el usuarioa su conveniencia
 * @property string $texto Texto descriptivo del articulo
 * @property float $precio Precio del articulo con 2 decimales
 * @property float $iva Tipo de IVA del articulo en porcentaje
 * @property string|null $notas Notas internas para el Articulo
 */
class Articulo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articulos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referencia', 'texto', 'precio', 'iva'], 'required'],
            [['precio', 'iva'], 'number'],
            [['notas'], 'string'],
            [['referencia'], 'string', 'max' => 10],
            [['texto'], 'string', 'max' => 250],
            [['referencia'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'referencia' => Yii::t('app', 'Referencia'),
            'texto' => Yii::t('app', 'Texto'),
            'precio' => Yii::t('app', 'Precio'),
            'iva' => Yii::t('app', 'Iva'),
            'notas' => Yii::t('app', 'Notas'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ArticulosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticulosQuery(get_called_class());
    }
}
