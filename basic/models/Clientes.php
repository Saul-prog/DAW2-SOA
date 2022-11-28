<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clientes".
 *
 * @property string $referencia Referencia unica del cliente, creada por el usuarioa su conveniencia
 * @property string $cifnif
 * @property string $nombre Nombre del cliente o Nombre Comercial de la empresa
 * @property string $apellidos Apellidos del cliente o Razón Social de la empresa
 * @property string $domFiscal Domicilio Fiscal para Facturas
 * @property string|null $domEnvio Domicilio para los envíos de correo al cliente, si no se indica se usa el Fiscal
 * @property string|null $notas Notas internas para el Cliente
 * @property string $email Correo electronico del cliente y a la vez login de acceso al sistema
 * @property string $password Clave de acceso al sistema con espacio para un md5
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referencia', 'cifnif', 'nombre', 'apellidos', 'domFiscal', 'email', 'password'], 'required'],
            [['notas'], 'string'],
            [['referencia', 'cifnif'], 'string', 'max' => 10],
            [['nombre', 'apellidos', 'domFiscal', 'domEnvio'], 'string', 'max' => 250],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 32],
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
            'cifnif' => Yii::t('app', 'Cifnif'),
            'nombre' => Yii::t('app', 'Nombre'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'domFiscal' => Yii::t('app', 'Dom Fiscal'),
            'domEnvio' => Yii::t('app', 'Dom Envio'),
            'notas' => Yii::t('app', 'Notas'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),

            //Etiqueta de atributos virtuales
            'nombreCompleto' =>'Nombre y apellidos',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ClientesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientesQuery(get_called_class());
    }

    //atributo virtual pedidos dentro de cliente
    public function getPedidos(){
        //yii\db\ActiveQuery    Nombre de la tablaOrigen, Lo que relaciona las tablas [keyOrigen=>keyDestino,....]
        return  $this->hasMany(Pedidos::class,['refCli'=>'referencia'])->inverseOf('cliente');
    }
    protected $_numPedidos=null;
    public function getNumPedidos(){
        //Muy lento, buscar otra función
        //return  count($this->pedidos);
        if($this->_numPedidos===null){
            $this->_numPedidos=$this->getPedidos()->count();
        }
        return $this->_numPedidos;
    }

    /**
     * Atributo virtual para el nombre completo
     * @return Nombre completo
     */

    public function getNombreCompleto(){
        //v1
        return $this->nombre.' '.$this->apellidos;
        //v2
        //return $this->nombre.', '.$this->apellidos;
    }


}
