<?php
namespace common\components;

/*
 * 微信回复发送消息类
*/
class WechatAutoAnswer
{
	public $setFlag = false;
	public $debug = false;

	private $fromUserName;
	private $toUserName;

    /**
     * @return WechatAutoAnswer
     */
	public static function factory()
    {
        $class = __CLASS__;
        return new $class();
    }

    /**
     * 定义各用户信息.
     * @param $fromUserName 发送方帐号（用户OpenID） 接收到的微信数据中的数据
     * @param $toUserName 开发者微信号  接收到的微信数据中的数据
     */
    public function __construct($fromUserName = FROM_USER_NAME, $toUserName = TO_USER_NAME)
    {
        $this->fromUserName = $fromUserName;
        $this->toUserName = $toUserName;
    }

    /**
	 * 回复文本消息
	 * @param array $newsData
	 * @return string
	 */
	public function MatchText($newsDate)
    {
		$createtime = time ();
		$funcflag = $this->setFlag ? 1 : 0;
		$textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		<FuncFlag>%s</FuncFlag>
		</xml>";
		return sprintf ( $textTpl, $this->fromUserName, $this->toUserName, $createtime, "text", $newsDate, $funcflag );
	}
	
	/**
	 * 回复图片消息
	 * @param array $newsData
	 * @return string
	 */
	public function MatchImage($newsDate)
    {
		$createtime = time ();
		$funcflag = $this->setFlag ? 1 : 0;
		$textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Image>
		<MediaId><![CDATA[%s]]></MediaId>
		</Image>
		<FuncFlag>%s</FuncFlag>
		</xml>";
		return sprintf ( $textTpl, $this->fromUserName, $this->toUserName, $createtime, "image", $newsDate, $funcflag );
	}
	
	/**
	 * 回复语音消息
	 * @param array $newsData
	 * @return string
	 */
	public function MatchVoice($newsData)
	{
		$createtime = time();
		$funcflag = $this->setFlag ? 1 : 0;
		$textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Voice>
		<MediaId><![CDATA[%s]]></MediaId>
		</Voice>
		<FuncFlag>%s</FuncFlag>
		</xml>";
		return sprintf($textTpl , $this->fromUserName, $this->toUserName, $createtime,"voice", $newsData['mediaId'] , $funcflag);
	}
	
	/**
	 * 回复视频消息
	 * @param array $newsData
	 * @return string
	 */
	public function MatchVideo($newsData)
	{
		$createtime = time();
		$funcflag = $this->setFlag ? 1 : 0;
		$textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Video>
		<MediaId><![CDATA[%s]]></MediaId>
		<Title><![CDATA[%s]]></Title>
		<Description><![CDATA[%s]]></Description>
		</Video>
		<FuncFlag>%s</FuncFlag>
		</xml>";
		return sprintf($textTpl , $this->fromUserName, $this->toUserName, $createtime,"video", $newsData['mediaid'] , $newsData['title'] , $newsData['description'] , $funcflag);
	}
	
	/**
	 * 回复图文消息
	 * @param array $newsData
	 * @return string
	 */
	public function MatchNews($newsData=array())
	{
		$createtime = time();
		$funcflag = $this->setFlag ? 1 : 0;
		$newTplHeader = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>{%s}</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<ArticleCount>%s</ArticleCount><Articles>";
		$newTplItem = "<item>
		<Title><![CDATA[%s]]></Title>
		<Description><![CDATA[%s]]></Description>
		<PicUrl><![CDATA[%s]]></PicUrl>
		<Url><![CDATA[%s]]></Url>
		</item>";
		$newTplFoot = "</Articles>
		<FuncFlag>%s</FuncFlag>
		</xml>";
		$content = '';
		$itemsCount = count($newsData['items']);
		$itemsCount = $itemsCount < 10 ? $itemsCount : 10;//微信公众平台图文回复的消息一次最多10条
		if ($itemsCount)
		{
			//for ($i=0; $i<10 ; $i++){
				foreach ($newsData['items'] as $key => $item)
				{
					$content .= sprintf($newTplItem,$item['title'],$item['description'],$item['picUrl'],$item['url'])."\r\n";//微信的信息数据
				}
			//}
		}
		$header = sprintf($newTplHeader, $this->fromUserName, $this->toUserName, $createtime,"news",$itemsCount);
		$footer = sprintf($newTplFoot,$funcflag);
		return $header . $content . $footer;
	}
	
	/**
	 * 回复音乐消息--待完善
	 * @param array $newsData
	 * @return string
	 */
	public function MatchMusic($newsData=array())
	{
		$createtime = time();
		$funcflag = $this->setFlag ? 1 : 0;
		$textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Music>
		<Title><![CDATA[%s]]></Title>
		<Description><![CDATA[%s]]></Description>
		<MusicUrl><![CDATA[%s]]></MusicUrl>
		<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
		</Music>
		<FuncFlag>%s</FuncFlag>
		</xml>";
		return sprintf($textTpl,$newsData['FromUserName'], $newsData['ToUserName'],$createtime,"music",$newsData['title'],$newsData['description'],$newsData['MusicUrl'],$newsData['HQMusicUrl'],$funcflag);
	}
	
	/**
	 * 回复
	 * @param string $msg
	 */
	public function Reply($msg)
    {
        /*if($this -> debug) {
            $this ->writeStr($msg."\n");
        }*/
		exit($msg);
	}
	
	/**
	 * 打印数据到本地
	 **/
	private function writeStr($str)
    {
		$date = date ( 'Y-m-d' );
		$open = fopen ( "/" . $date . "_log.txt", "a" );
		fwrite ( $open, $str );
		fclose ( $open );
	}

}