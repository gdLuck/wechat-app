<?php

namespace api\controllers;

use api\models\MsgEventManage;
use common\components\WechatCoreHelper;
use Yii;
use yii\base\Exception;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public $postObj;//接收微信请求数据

    /**
     * 接收后初始操作
     * @param \yii\base\Action $action
     * @return bool
     * @throws Exception
     */
    public function beforeAction($action)
    {
        try {
            //you must define TOKEN by yourself
            if (!defined("WECHAT_TOKEN")) {
                throw new Exception('TOKEN is not defined!');
            }

            $this->postObj = new \stdClass();
            //验证
            WechatCoreHelper::factory()->valid(WECHAT_TOKEN);

            $postStr = file_get_contents("php://input");

            /* 防xml注入 */
            libxml_disable_entity_loader(true);
            if (!empty ($postStr)) {
                $this->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

                if (empty ($this->postObj)) {
                    die ('poststr not null');
                } else {
                    define('FROM_USER_NAME', $this->postObj->FromUserName);//发送方帐号（用户OpenID） 接收到的数据
                    define('TO_USER_NAME', $this->postObj->ToUserName);//开发者微信号
                }
            } else {
                die ('');
            }
        } catch (Exception $e) {
            WechatCoreHelper::wechatLogRecord($e->getMessage(),'beforeAction');
            throw new Exception('500');
        }

        return true;
    }

    /**
     * 微信开发者模式入口
     * @return mixed
     */
    public function actionIndex()
    {
        //$this->postObj = json_decode('{"ToUserName":"gh_ccfabcebd005","FromUserName":"oG0C8wru6XsIL_YdOmV5TLR7-46w",
        //"CreateTime":"1464077641","MsgType":"text","Content":"11623","MsgId":"6288165587314314005"}');
        //WechatCoreHelper::wechatLogRecord($this->postObj,'init', 'test');

        MsgEventManage::factory($this->postObj)->MsgManage();

        exit('success');
    }

}
