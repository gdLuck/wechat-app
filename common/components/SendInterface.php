<?php
/**
 * 消息发送接口定义
 */

namespace common\components;


interface SendInterface
{
    public function sendText($contentStr);
    public function sendNews($data);
    //...
}