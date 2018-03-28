<?php
/**
 * 测试
 * Date: 2018/3/28
 * Time: 10:54
 */

namespace frontend\models;


use common\models\WechatUser;
use yii\base\Model;

class SignupForm2 extends Model
{
    public $username;
    public $password;
    public $email;

    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['username', 'email'], 'trim'],
            ['username', 'unique', 'targetClass' => '\common\models\WechatUser', 'message' => '用户名已存在！'],
            ['username', 'string', 'min' => 5, 'max' => 20],
            ['password', 'string', 'min' => 6, 'max' => 12],
            ['email', 'unique', 'targetClass' => '\common\models\WecahtUser', 'message' => '邮箱已被注册'],
            ['email', 'email'],
            ['email', 'string', 'max' => 100]
        ];
    }

    public function signup()
    {
        $user = new WechatUser();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $user->save() ? $user : null;
    }

}