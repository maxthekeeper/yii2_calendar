<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Модель User
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property string $password write-only password
 * @property string $salt
 * @property string $access_token
 * @property string $create_date
 */

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Константы
     */
    const MIN_LENGTH_PASS = 6;

    /**
     * Имя таблицы
     *
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'name', 'surname', 'password'], 'required'],
            [['password'], 'string', 'min' => self::MIN_LENGTH_PASS],
            [['username'], 'email'],
            [['username', 'access_token'], 'unique'],
        ];
    }

    /**
     * Атрибуты
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app','Логин'),
            'name' => Yii::t('app', 'Имя'),
            'surname' => Yii::t('app', 'Фамилия'),
            'password' => Yii::t('app', 'Пароль'),
            'salt' => Yii::t('app', 'Соль'),
            'access_token' => Yii::t('app', 'Токен'),
            'create_date' => Yii::t('app', 'Дата регистрации'),
        ];
    }

    public function getCalendar()
    {
        return $this->hasMany(Calendar::className(), ['creator' => 'id']);
    }

    public function getAccessUserOwner()
    {
        return $this->hasMany(Access::className(), ['user_owner' => 'id']);
    }

    public function getAccessUserGuest()
    {
        return $this->hasMany(Access::className(), ['user_guest' => 'id']);
    }

    /**
     * Обработчик события
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->getIsNewRecord() && !empty($this->password))
            {
                $this->salt = $this->saltGenerator();
            }
            if (!empty($this->password))
            {
                $this->password = $this->passWithSalt($this->password, $this->salt);
            }
            else
            {
                unset($this->password);
            }
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Генерируем соль
     *
     * @return string
     */
    public function saltGenerator()
    {
        return hash("sha512", uniqid('salt_', true));
    }

    /**
     * Возвращаем пароль с солью
     *
     * @param $password
     * @param $salt
     * @return string
     */
    public function passWithSalt($password, $salt)
    {
        return hash("sha512", $password . $salt);
    }

    /**
     * Найти пользователя по ID
     *
     * @param string|integer $id - ID пользователя, которого ищем
     * @return IdentityInterface|null - объект пользователя, которому принадлежит ID
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Найти пользователя по токену
     *
     * @param string $token
     * @return IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Найти пользователя по логину
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Поолучить ID
     *
     * @return string|integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Получить токен
     *
     * @return string $access_token
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * Проверить токен
     *
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Проверить пароль
     *
     * @param string $password - пароль для валидации
     * @return bool - правильный ли пароль для текущего пользователя
     */
    public function validatePassword($password)
    {
        return $this->password === $this->passWithSalt($password, $this->salt);
    }

    /**
     * Генерируем пароль с солью
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $this->passWithSalt($password, $this->saltGenerator());
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }
}
