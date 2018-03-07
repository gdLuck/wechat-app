<?php
/**
 * 微信公众号通用核心业务类
 */
namespace common\components;

use yii;
use yii\base\Exception;

class WechatCoreHelper
{
    /**
     * @return WechatCoreHelper
     */
    public static function factory()
    {
        $class = __CLASS__;
        return new $class();
    }

    /**
     * 验证来源是否有效
     * @param string $token   后台绑定TOKEN
     * @param int $first 0默认  1首次 是否首次验证
     * @return
     */
    public function valid($token,$first =FIRST_TIME)
    {
        $echostr = yii::$app->request->get('echostr');

        if ($first == 1){
            if($this->checkSignature($token)){//首次验证使用
                die($echostr);
            }
        }else{
            if(!$this->checkSignature($token)){
                die('TOKEN ERROR!');//签名错误
            }
        }
        return true;
    }

	/**
	 * 微信加密验证算法
	 * @param string $token 微信平台生成的密钥
	 * @return bool
	 */
	private function checkSignature($token)
	{
		// you must define TOKEN by yourself
		if (empty($token)) {
			throw new Exception('TOKEN is not defined!');
		}
		$signature = yii::$app->request->get('signature','');
		$timestamp = yii::$app->request->get('timestamp',0);
		$nonce 	   = yii::$app->request->get('nonce');

		$tmpArr = array($token, $timestamp, $nonce);
		
		// use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
	
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 从数据库取得用户授权信息  用户ID方法 (共用)
	 * @param int $userid
	 */
//	public function getWebUserInfoToUid($userid){
//
//		$data = array();
//		$userInfo = UserInfo::model()->findAllByPk($userid);
//		if (empty($userInfo)){
//			return $data;
//		}else{
//			$data['u_id']		= $userInfo[0]['u_id'];
//			$data['nickname'] 	= $userInfo[0]['nickname'];
//			$data['headimgurl'] = $userInfo[0]['headimgurl'];
//		}
//
//		return $data;
//	}
	
	/**
	 * 日志信息记录 
	 * @param string $log 日志信息
	 * @param string $fromUserName 用户Openid
	 * @param string $toUserName 开发者ID 
	 * @param mixed $table  0 主错误表    其他(表实例)
	 */
//	public static function wechatLog($log='',$fromUserName='err',$toUserName='err',$talbe = 0){
//		if ($talbe){
//			$model = $talbe;
//		}else{
//			$model = new WechatLog();
//		}
//
//		$model->log = json_encode($log);
//		$model->tousername = $toUserName;
//		$model->fromusername = $fromUserName;
//		$model->add_time   = time();
//		if ($model->save()){
//			return true;
//		}else{
//			return false;
//		}
//	}

	/**
	 * 微信用户昵称处理 替换emoji表情
	 * @param string $nickname 用户昵称
     * @param string $replace 替换值 小于5位
	 * @return string 
	 */
	public static function replaceNicknameEmoji($nickname, $replace = ''){

	    if(!is_string($replace) && mb_strlen($replace) >= 5){
            $replace = '';
        }

		$tmpStr = json_encode($nickname);
		$result = preg_replace("/(\\\u[ed][0-9a-f]{3})/i", $replace, $tmpStr);
		$result = json_decode($result,true);
		return $result;
	}
	
	/**
	 * 取得返回文件
	 * @param string $durl
	 * @param array() $cfg  是否HTTPS  是否POST  array('ssl'=>true,'post'=> array() )POST 一维
	 * @return mixed
	 */
	public function curlGetContents($durl ,$cfg ){
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $durl);
		if( isset($cfg['post']) ){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $cfg['post']);//多维数组时需加 http_build_query($cfg['post'])
		}
		if($cfg['ssl'])
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//禁用SSL检查  开启HTTPS模式
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		}
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);//当根据Location:重定向时，自动设置header中的Referer:信息。
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);//最大请求时间
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);//返回数据流  否则直接输出
		
		$result = curl_exec($ch);
		if (curl_errno($ch))
		{
			return curl_error($ch);
		}
		curl_close($ch);
		return $result;
	}
}
