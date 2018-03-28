<?php
/**
 * 新用户表 - 测试用
 */

namespace common\models;

use common\components\Security;
use common\components\UserIdentityInterface;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $nickname
 * @property string $auth_key 随机值，加密密钥用
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $phone
 * @property string $email
 * @property string $qq_id 绑定的QQ授权ID
 * @property int $status 用户状态
 * @property int $created_at
 * @property int $update_at
 */
class WechatUser extends \yii\db\ActiveRecord implements UserIdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @return WechatUser
     */
    public static function model()
    {
        $class = __CLASS__;
        return new $class();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash'], 'required'],
            [['created_at', 'update_at'], 'integer'],
            [['username'], 'string', 'max' => 12],
            [['nickname'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'qq_id'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
            [['status'], 'string', 'max' => 4],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'nickname' => 'Nickname',
            'auth_key' => '随机值，加密密钥用',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'phone' => 'Phone',
            'email' => 'Email',
            'qq_id' => '绑定的QQ授权ID',
            'status' => '0 禁止  10 活动用户',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['update_at', 'created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_at']
                ]
            ]
        ];
    }

    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->getPrimaryKey();
    }

    public function getAuthkey()
    {
        // TODO: Implement getAuthkey() method.
        return $this->auth_key;
    }

    public function setPassword($password)
    {
        // TODO: Implement setPassword() method.
        $this->password_hash = Security::factory()->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        // TODO: Implement validatePassword() method.
        return Security::factory()->validatePassword($password, $this->password_hash);
    }

    public function generateAuthKey()
    {
        // TODO: Implement generateAuthKey() method.
        $this->auth_key = Security::factory()->generateRandomString();
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return $this->getAuthkey() === $authKey;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username'=> $username, 'status'=> self::STATUS_ACTIVE]);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id'=>$id, 'status'=> self::STATUS_ACTIVE]);
    }

    /**
     * 设置登录信息
     * @param UserIdentityInterface $userModel
     * @param bool $rememberMe
     * @return bool
     */
    public function login(UserIdentityInterface $userModel, bool $rememberMe = false): bool
    {
        // TODO: Implement login() method.
        $session = yii::$app->session;

        //设置用户登录 信息
        $id = $userModel->getId();
        $ip = Yii::$app->getRequest()->getUserIP();
        $loginInfo = [
            'id' => $id,
            'ip' => $ip,
            'username' => $userModel->username,
            'time' => time()
        ];
        $session->set('loginInfo', json_encode($loginInfo));

        return !self::isGuest();
    }

    public static function getIdentity()
    {
        static $loginAccount = null;
        if ($loginAccount != null && ($loginAccount->time + 3600 > time() ) ){
            return $loginAccount;
        }
        $session = Yii::$app->getSession();
        return $loginAccount = $session->getIsActive() ? json_decode($session->get('loginInfo')) : null;
    }

    public static function isGuest()
    {
        return self::getIdentity() === null;
    }

    public static function logout()
    {
        Yii::$app->getSession()->destroy();
    }
}
