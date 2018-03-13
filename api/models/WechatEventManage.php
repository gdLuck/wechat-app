<?php

namespace api\models;

use yii\base\Exception;

/**
 * 微信消息处理
 */
class WechatEventManage
{
    public $postObj; //接收到的微信请求数据

    /**
     * @return WechatEventManage
     */
    public static function factory($postObj)
    {
        $class = __CLASS__;
        return new $class($postObj);
    }

    public function __construct($postObj)
    {
        $this->postObj = $postObj;
    }

    /**
     * 消息处理
     * @throws Exception
     */
    public function MsgManage()
    {
        try {
            switch ($this->postObj->MsgType) {
                case 'text'://文本信息
                    break;
                case 'image'://图片信息
                    break;
                case 'location': //地理信息
                    break;
                case 'event':
                    $this->EventManage();
                    break;
                default:
                    exit('');
                    break;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 事件处理
     * @throws Exception
     */
    public function EventManage()
    {
        try {
            switch ($this->postObj->Event) {
                case 'subscribe'://用户关注
                    break;
                case 'unsubscribe':  //取消关注
                    break;
                case 'CLICK'://自定义菜单推送
                    break;
                default:
                    exit('');
                    break;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}