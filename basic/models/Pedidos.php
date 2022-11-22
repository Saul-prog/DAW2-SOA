<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedidos".
 *
 * @property string $serie Serie del Pedido como un texto o el año en curso
 * @property int $numero Numero del pedido que debe ser unico dentro de la serie
 * @property string $fecha Fecha del pedido en formato sql "AAAA-MM-DD"
 * @property string $refCli Cliente asociado al pedido
 * @property string $domEnvio Domicilio de envio del pedido, se propone el que tiene el cliente pero se puede modificar
 * @property int $estado Estado del Pedido: 0=Abierto/Pendiente, 1=Bloqueado/Preparacion, 2=Bloqueado/Enviado, 3=Cerrado/Recibido, 4=Cerrado/Anulado
 * @property string|null $notas Notas internas para el Pedido
 */
class Pedidos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedidos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['serie', 'numero', 'fecha', 'refCli', 'domEnvio'], 'required'],
            [['numero', 'estado'], 'integer'],
            [['fecha'], 'safe'],
            [['notas'], 'string'],
            [['serie'], 'string', 'max' => 4],
            [['refCli'], 'string', 'max' => 10],
            [['domEnvio'], 'string', 'max' => 250],
            [['serie', 'numero'], 'unique', 'targetAttribute' => ['serie', 'numero']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'serie' => Yii::t('app', 'Serie'),
            'numero' => Yii::t('app', 'Numero'),
            'fecha' => Yii::t('app', 'Fecha'),
            'refCli' => Yii::t('app', 'Ref Cli'),
            'domEnvio' => Yii::t('app', 'Dom Envio'),
            'estado' => Yii::t('app', 'Estado'),
            'notas' => Yii::t('app', 'Notas'),
        ];
    }

    //Atributo virtual "lineas"
    public function getLineas(){
        //yii\db\ActiveQuery    Nombre de la tablaOrigen, Lo que relaciona las tablas [keyOrigen=>keyDestino,....]
        return  $this->hasMany(PedidoLinea::class,['serie'=>'serie','numero'=>'numero']);
    }

    public function getCliente(){
        //yii\db\ActiveQuery    Nombre de la tablaOrigen, Lo que relaciona las tablas [keyOrigen=>keyDestino,....]
        return  $this->hasOne(Clientes::class,['referencia'=>'refCli'])->inverseOf('pedidos');
    }

    public function getImporteTotal(){
        $total=0;
        foreach ($this->lineas as $linea){
            $total+=$linea->ImporteTotal;
        }
        return $total;
    }
    /**
     * {@inheritdoc}
     * @return PedidosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PedidosQuery(get_called_class());
    }
}
