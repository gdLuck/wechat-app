<?php
/**
 * 微信内容处理返回类
 * @author gtb
 */
class WechatSend
{
	protected $autoAnswer;
	
	public function __construct(){
		$this->autoAnswer = new WechatAutoAnswer();
	}
	
	/**
	 * 发送文本回复
	 * @param string $contentStr 要发送的信息
	 */
	protected function _sendText($contentStr)
	{
		//$contentStr = str_replace('\n', "\r\n", $contentStr);
		$reply = $this->autoAnswer->MatchText ( $contentStr );
		$this->autoAnswer->Reply ( $reply );
	}
	
	/**
	 * 发送图文回复
	 * @param array $data 要发送的信息
	 */
	protected function _sendNews($data){
		$reply = $this->autoAnswer->MatchNews( $data );
		$this->autoAnswer->Reply ( $reply );
	}
}