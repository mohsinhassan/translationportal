<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "screen_windows".
 *
 * @property integer $window_id
 * @property string $window_name
 * @property string $type_id
 * @property string $created_at
 */
class ScreenWindow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'screen_windows';
    }
//    public $tmp_image;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'integer'],
            [['type_id','window_name'], 'required'],
            [['window_name'], 'string', 'max' => 50],
            [['type_id','window_name'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'window_id' => Yii::t('app', 'Window ID'),
            'window_name' => Yii::t('app', 'Window Name'),
            'type_id' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
            /*'image' => Yii::t('app', 'Image'),*/
        ];
    }

    /**
     * @inheritdoc
     * @return ScreenWindowQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScreenWindowQuery(get_called_class());
    }

    public function getScreenshot()
    {
        return $this->hasMany(Screenshot::className(), ['window_id' => 'window_id' ]);
    }

    public function getTypes()
    {
        return $this->hasOne(Types::className(), [ 'type_id' => 'type_id']);
    }
}
