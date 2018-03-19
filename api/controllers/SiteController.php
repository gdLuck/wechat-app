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
        //$this->postObj = json_decode('{"ToUserName":"gh_70ba7ea19a28","FromUserName":"oAAqd1Jn_LfwowCsQzRT-nJ22AXI",
        //"CreateTime":"1521451832","MsgType":"event","Event":"subscribe","EventKey":{}}');
        //WechatCoreHelper::wechatLogRecord($this->postObj,'init-'.$this->postObj->Event, 'test');

        MsgEventManage::factory($this->postObj)->MsgManage();

        exit('success');
    }

}
