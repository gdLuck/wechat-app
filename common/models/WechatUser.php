<?php
/**
 * 新用户表 - 测试用
 */

namespace common\models;

use common\components\Security;
use common\components\UserIdentityInterface;
use Yii;

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
            [['username', 'auth_key', 'password_hash', 'phone', 'qq_id', 'created_at', 'update_at'], 'required'],
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
            [['phone'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
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
            'status' => '1 男 2女 0保密',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
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

    public function login(UserIdentityInterface $userModel, bool $rememberMe = false): bool
    {
        // TODO: Implement login() method.
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username'=> $username, 'status'=> self::STATUS_ACTIVE]);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id'=>$id, 'status'=> self::STATUS_ACTIVE]);
    }

}
