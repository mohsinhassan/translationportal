<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "system_labels".
 *
 * @property string $label_id
 * @property integer $window_id
 * @property string $access_key_android
 * @property string $access_key_ios
 * @property string $label
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Translation[] $translations
 */
class SystemLabel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_labels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['window_id','label'], 'required'],
            [['window_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['access_key_android', 'access_key_ios', 'label'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'label_id' => Yii::t('app', 'Label ID'),
            'window_id' => Yii::t('app', 'Window'),
            'access_key_android' => Yii::t('app', 'Access Key Android'),
            'access_key_ios' => Yii::t('app', 'Access Key Ios'),
            'label' => Yii::t('app', 'Label'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['label_id' => 'label_id']);
    }
    public function getWindow()
    {
        return $this->hasOne(ScreenWindow::className(), [ 'window_id' => 'window_id']);
    }
}
