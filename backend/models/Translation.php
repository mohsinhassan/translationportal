<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "translation".
 *
 * @property string $translation_id
 * @property string $label_id
 * @property string $translation
 * @property integer $is_approved
 * @property string $language_id
 * @property string $created_by
 * @property string $created_at
 *
 * @property SystemLabel $label
 * @property Language $language
 */
class Translation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label_id', 'translation', 'language_id', 'created_by'], 'required'],
            [['label_id', 'is_approved', 'language_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['translation'], 'string', 'max' => 255],
            [['label_id'], 'exist', 'skipOnError' => true, 'targetClass' => SystemLabel::className(), 'targetAttribute' => ['label_id' => 'label_id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'language_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'translation_id' => Yii::t('app', 'Translation ID'),
            'label_id' => Yii::t('app', 'Label ID'),
            'translation' => Yii::t('app', 'Translation'),
            'is_approved' => Yii::t('app', 'Is Approved'),
            'language_id' => Yii::t('app', 'Language ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    // function for getting is_approved value for 0, 1
    public function getIsApproved($value)
    {
        if($value){
            return "Active";
        }
        return "In-Active";
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabel()
    {
        return $this->hasOne(SystemLabel::className(), ['label_id' => 'label_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['language_id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
