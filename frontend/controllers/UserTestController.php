<?php
/**
 * 简单测试
 * Date: 2018/3/22
 * Time: 14:47
 */

namespace frontend\controllers;


use common\models\WechatUser;
use frontend\models\LoginForm;
use yii\web\Controller;

class UserTestController extends Controller
{
    public $layout = 'main2';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!WechatUser::isGuest()){
            $this->goHome();
        }

        $model = new LoginForm();
        if ($model->)

        return $this->render('login',[
            'model' => $model
        ]);
    }

    public function actionSignup()
    {
        //判断是否已登录
        //判断是否提交数据
        //否则展示

    }

    public function actionLogout()
    {
        //判断是否已登录
        //判断是否提交数据
        //否则展示
    }

}