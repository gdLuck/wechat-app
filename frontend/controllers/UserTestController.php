<?php
/**
 * 简单测试
 * Date: 2018/3/22
 * Time: 14:47
 */

namespace frontend\controllers;

use frontend\models\SignupForm2;
use yii;
use common\models\WechatUser;
use frontend\models\LoginForm2;
use yii\web\Controller;

class UserTestController extends Controller
{
    public $layout = 'main2';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => yii\filters\AccessControl::class,
                'only' => ['logout', 'singup'],
                'rules' => [
                    [
                        'actions' => 'logout',
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => 'signup',
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        //判断是否已登录
        if (!WechatUser::isGuest()) {
            return $this->goHome();
        }

        $model = new LoginForm2();
        if ($model->load(yii::$app->request->post()) && $model->login()) {
            $this->goBack();
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    public function actionSignup()
    {
        $model = new SignupForm2();
        //判断是否提交数据
        if ($model->load(yii::$app->request->post())){
            if ($user = $model->signup()){
                if (WechatUser::model()->login($user)){//设置用户登录信息
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        WechatUser::logout();
        return $this->goHome();
    }

}