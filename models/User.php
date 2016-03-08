<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @property int $id
 * @property string $name
 * @property string $login
 * @property string $password_hash
 * @property string $email
 * @package app\models
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var string
     */
    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'name', 'password_hash', 'password'], 'string', 'max' => 128],
            ['email', 'email'],
            [['email', 'login'], 'required'],
            [['login', 'email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return sha1(
            implode('-', [
                $this->id,
                $this->login,
                $this->password_hash
            ])
        );
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Поиск пользователя по логину
     *
     * @param string $login
     * @return array|null|ActiveRecord
     */
    public static function findByLogin($login)
    {
        return self::find()->andWhere(['login' => $login])->one();
    }

    /**
     * Проверка пароля
     *
     * @param string $password
     * @return bool
     * @throws \yii\base\Exception
     */
    public function validatePassword($password)
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * @inheritDoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->password) {
                $this->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            return true;
        }

        return false;
    }
}
