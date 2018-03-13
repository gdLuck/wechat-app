<?php
namespace common\components;

/**
 * 微信内容处理返回类
 */
abstract class SendAbstraction implements SendInterface
{
	public $answer;
	
	public function __construct(){
		$this->answer = WechatAutoAnswer::factory();
	}
	
	/**
	 * 发送文本回复
	 * @param string $contentStr 要发送的信息
	 */
	public function sendText($contentStr)
	{
		//$contentStr = str_replace('\n', "\r\n", $contentStr);
		$reply = $this->answer->MatchText ( $contentStr );
		$this->answer->Reply ( $reply );
	}
	
	/**
	 * 发送图文回复
	 * @param array $data 要发送的信息
	 */
    public function sendNews($data){
		$reply = $this->answer->MatchNews( $data );
		$this->answer->Reply ( $reply );
	}
}