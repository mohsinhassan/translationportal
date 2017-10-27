<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Screenshot]].
 *
 * @see Screenshot
 */
class ScreenshotsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Screenshot[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Screenshot|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
