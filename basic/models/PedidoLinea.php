<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedidoslin".
 *
 * @property int $idLinea Identificador de la linea del pedido para facilitar los accesos
 * @property string $serie Serie del pedido al que pertenece la linea
 * @property int $numero Numero del pedido al que pertenece la linea
 * @property int $orden Orden de la linea dentro del pedido, se deberia poder cambiar una linea de posicion en el orden
 * @property string|null $refArt Articulo asociado a la linea o "NULO" si es linea de texto libre
 * @property string $texto Texto copiado del articulo o el texto libre que se haya introducido
 * @property int $cantidad Cantidad de unidades, puede ser negativo para devoluciones
 * @property float $precio Precio del articulo con 2 decimales, copiado inicialmente del articulo pero modificable, no deberia ser negativo
 * @property float $iva Tipo de IVA del articulo en porcentaje, copiado inicialmente del articulo
 * @property float $importeBase Importe precalculado de la Cantidad * Precio, para facilitar su tratamiento
 * @property float $cuotaIva Importe precalculado del importeBase * iva / 100, para facilitar su tratamiento
 */
class PedidoLinea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedidoslin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['serie', 'numero', 'orden', 'texto', 'cantidad', 'precio', 'iva', 'importeBase', 'cuotaIva'], 'required'],
            [['numero', 'orden', 'cantidad'], 'integer'],
            [['texto'], 'string'],
            [['precio', 'iva', 'importeBase', 'cuotaIva'], 'number'],
            [['serie'], 'string', 'max' => 4],
            [['refArt'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idLinea' => Yii::t('app', 'Id Linea'),
            'serie' => Yii::t('app', 'Serie'),
            'numero' => Yii::t('app', 'Numero'),
            'orden' => Yii::t('app', 'Orden'),
            'refArt' => Yii::t('app', 'Ref Art'),
            'texto' => Yii::t('app', 'Texto'),
            'cantidad' => Yii::t('app', 'Cantidad'),
            'precio' => Yii::t('app', 'Precio'),
            'iva' => Yii::t('app', 'Iva'),
            'importeBase' => Yii::t('app', 'Importe Base'),
            'cuotaIva' => Yii::t('app', 'Cuota Iva'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PedidosLineaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PedidosLineaQuery(get_called_class());
    }
}
