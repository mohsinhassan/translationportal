<?php

namespace backend\models;
//use common\models\User;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $language_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{

    public $password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password', 'email', 'language_id', 'created_at', 'updated_at'], 'required'],
            [['language_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password', 'password_reset_token', 'email'], 'string', 'max' => 255],
            /*[['auth_key'], 'string', 'max' => 32],*/
            [['username'], 'unique'],
            [['email'], 'unique'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            /*[['password_reset_token'], 'unique'],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password' => Yii::t('app', 'Password'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'language_id' => Yii::t('app', 'Language ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return userQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new userQuery(get_called_class());
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        exit("here222");
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function signup()
    {
        /*if (!$this->validate()) {
            return null;
        }
        */
       //
        $user = new common/models/User();

        $user->username = $this->username;

        $user->email = $this->email;
        $hash = $user->setPassword("abc123");
        echo $hash;exit;

        $user->auth_key = Yii::$app->security->generateRandomString();
        //$this->generateAuthKey();
        //$user->password_hash = Yii::$app->security->generatePasswordHash("abcd123");
        //$user->password_hash = Yii::$app->security->generatePasswordHash();
        //echo $hash = Yii::$app->getSecurity()->generatePasswordHash("abcd123");exit;
        //echo "<pre>"; print_r($user);exit;
        //exit("here5");
        return $user->save() ? $user : null;
    }
}
