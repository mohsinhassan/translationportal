<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "screenshots".
 *
 * @property integer $screenshot_id
 * @property integer $window_id
 * @property string $image
 * @property string $created_at
 */
class Screenshot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'screenshots';
    }
    public $tmp_image;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['window_id'], 'required'],
            [['window_id'], 'integer'],
            /*[['created_at','image','tmp_image'], 'safe'],*/
            [['image'], 'file', 'extensions'=>'jpg, gif, png', 'maxFiles'=>6],
            [['image'], 'string', 'max' => 250],
            [['image'], 'safe'],
            //[['tmp_image[]'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'screenshot_id' => Yii::t('app', 'Screenshot ID'),
            'window_id' => Yii::t('app', 'Screen Windows'),
            'image' => Yii::t('app', 'Image'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return ScreenshotsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScreenshotsQuery(get_called_class());
    }

    public function getWindow()
    {
        return $this->hasOne(ScreenWindow::className(), [ 'window_id' => 'window_id']);
    }
}
