<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PedidoLinea]].
 *
 * @see PedidoLinea
 */
class PedidosLineaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PedidoLinea[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PedidoLinea|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
