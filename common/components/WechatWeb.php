<?php
namespace common\components;

/**
 * 微信服务号网页授权核心类
 */
class WechatWeb
{
    //高级功能-》开发者模式-》获取
    private $appId;
    private $appSecret;
    private $coreHelper;
    
    public function __construct($appId = WECHAT_APPID, $token = WECHAT_TOKEN) {
        $this->appId = $appId;
        $this->appSecret = $token;
    	$this->coreHelper = new WechatCoreHelper();
    }
    
    /**
     * 获取微信授权链接
     * @param string $redirect_uri 跳转地址
     * @param mixed $state 参数
     * @return array
     */
    public function getAuthorizeUrl($redirect_uri = '', $state = 2)
    {
        $redirect_uri = urlencode($redirect_uri);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appId&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";
    }
    
    /**
     * 获取网页授权token
     * @param string $code 通过get_authorize_url获取到的code
     * @return array
     */
    public function getAccessToken($code = '')
    {
	    $cfg['ssl'] = true;
		//$token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=authorization_code&appid={$this->app_id}&secret={$this->app_secret}&code={$code}";
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appId}&secret={$this->appSecret}&code={$code}&grant_type=authorization_code";
	    $token_data = $this->coreHelper->curl_get_contents($token_url, $cfg);
		return json_decode($token_data,true);
    }
    
    /**
     * 获取授权后的微信用户信息
     * @param string $access_token
     * @param string $open_id
     * @return array
     */
    public function getWebUserInfo($access_token = '', $open_id = '')
    {
    	$cfg['ssl'] = true;
    
    	// $info_url="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid=o_GlPs2n92tGyDixORcu1GoJLad8";
    	$info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$open_id&lang=zh_CN";
    	$info_data =  $this->coreHelper->curl_get_contents($info_url, $cfg);
    
    	return json_decode($info_data,true);
    	
    	return FALSE;
    }

    /**
     * 获取授权后的微信上面的图片
     * @param string $access_token
     * @param string $open_id
     */
    public function getMediaInfo($access_token = '', $media_id = '')
    {
	   $cfg['ssl'] = true;
      
	   $info_url="https://api.weixin.qq.com/cgi-bin/media/get?access_token={$access_token}&media_id={$media_id}";
	   //$info_url="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid=o_GlPs2n92tGyDixORcu1GoJLad8";
       // $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid=o_GlPs2n92tGyDixORcu1GoJLad8&lang=zh_CN";
       $info_data = $this->coreHelper->curl_get_contents($info_url, $cfg);
       return $info_data;
    }

}
 