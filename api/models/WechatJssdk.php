<?php
/**
 * 测试公众号
 */

namespace api\models;


use common\components\Helper;
use common\components\Jssdk;

class WechatJssdk extends Jssdk
{
    /**
     * @param string $appid
     * @param string $appSecret
     * @return WechatJssdk
     */
    public static function factory($appid = WECHAT_APPID, $appSecret = WECHAT_TOKEN)
    {
        $class = __CLASS__;
        return new $class($appid, $appSecret);
    }

    public function __construct($appid = WECHAT_APPID, $appSecret = WECHAT_TOKEN)
    {
        parent::__construct($appid, $appSecret);
    }

    public function getAccessToken()
    {
        // TODO: Implement getAccessToken() method.
        // access_token 应该全局存储与更新，可只用缓存
        $access_token = Helper::cache('wechat')->get('accessToken');
        if (!$access_token) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                Helper::cache('wechat')->set('accessToken', $access_token ,7000);
            } else {
                //记录错误日志
            }
        }

        return $access_token;
    }
}