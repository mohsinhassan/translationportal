<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ScreenWindow]].
 *
 * @see ScreenWindow
 */
class ScreenWindowQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ScreenWindow[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ScreenWindow|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
