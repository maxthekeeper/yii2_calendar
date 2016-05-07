<?php

namespace app\models\query;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Access]].
 *
 * @see \app\models\Access
 */
class AccessQuery extends ActiveQuery
{
    public function withDate($date)
    {
        return $this->andWhere(
            'date = :date',
            [
                ":date" => date('d.m.Y, $date')
            ]
        );
    }

    public function withGuest($guest)
    {
        return $this->andWhere(
            'user_guest = :guest',
            [
                ":guest" => $guest
            ]
        );
    }
    
    /**
     * @inheritdoc
     * @return \app\models\Access[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Access|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}