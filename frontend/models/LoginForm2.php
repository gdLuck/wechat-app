<?php
/**
 * Date: 2018/3/22
 * Time: 15:17
 */

namespace frontend\models;


use common\models\WechatUser;
use yii\base\Model;

class LoginForm2 extends Model
{
    public $username;
    public $password;
    public $rememberme = true;

    private $_user;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberme', 'boolean'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()){
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)){
                $this->addError($attribute, '账号或密码错误！');
            }
        }
    }

    public function login()
    {
        if ($this->validate()){
            return WechatUser::model()->login($this->getUser(), $this->rememberme);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === null){
            $this->_user = WechatUser::findByUsername($this->username);
        }
        return $this->_user;
    }

}