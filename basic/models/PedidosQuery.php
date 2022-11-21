<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Pedidos]].
 *
 * @see Pedidos
 */
class PedidosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Pedidos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Pedidos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
