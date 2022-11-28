<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Clientes;

/**
 * ClientesSearch represents the model behind the search form of `app\models\Clientes`.
 */
class ClientesSearch extends Clientes
{
    public $nombreCompleto;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referencia', 'cifnif', 'nombre', 'apellidos', 'domFiscal', 'domEnvio', 'notas', 'email', 'password','nombreCompleto'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {



        $query = Clientes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'referencia', $this->referencia])
            ->andFilterWhere(['like', 'cifnif', $this->cifnif])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'domFiscal', $this->domFiscal])
            ->andFilterWhere(['like', 'domEnvio', $this->domEnvio])
            ->andFilterWhere(['like', 'notas', $this->notas])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password]);
        $query->andFilterWhere(['like', 'CONCAT(nombre, " ",apellidos)', $this->nombreCompleto]);
        //La de abajo puede provocar inyección sql
        //$query->andFilterWhere(['like', 'CONCAT(nombre, " ",apellidos)', '%'.$this->nombreCompleto.'%',false]);
        return $dataProvider;
    }
}
