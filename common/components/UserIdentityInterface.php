<?php
/**
 * 用户认证接口
 * Date: 2018/3/21
 * Time: 15:42
 */

namespace common\components;

interface UserIdentityInterface
{
    //取得用户ID
    public function getId();
    //设置密码
    public function setPassword($password);
    //验证密码
    public function validatePassword($password);
    //生成密码重置TOKEN //余下可选
    //验证密码重置TOKEN
    //移除密码重置TOKEN
    //生成authKey
    public function generateAuthKey();
    //验证authKey
    public function validateAuthKey($authKey);
    //取得authKey
    public function getAuthkey();
    //登录-登录信息设置
    public function login(UserIdentityInterface $userModel, bool $rememberMe = false):bool ;
}