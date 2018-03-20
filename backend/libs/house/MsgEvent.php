<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/7
 * Time: 18:07
 */

namespace backend\libs\house;
use yii\base\Event;

class MsgEvent extends Event{
    //下面的这三个参数需要在触发事件时传递
    public $dateTime;   // 微博发出的时间
    public $author;     // 微博的作者
    public $content;    // 微博的内容
    public $shoes ;
}