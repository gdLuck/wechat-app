<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/8
 * Time: 10:42
 */

namespace backend\libs\house;

use yii\base\Model;

class Person extends  Model
{
    const EVENT_TEST='event_test';
    const EVENT_PERSON_DO4 = "do4" ;
    
    public function do1($event)
    {
        //print_r($event);
        echo 'I am man , thowing now !'.PHP_EOL;
    }

    public function do3()
    {
        \Yii::$app->trigger('person.bar', new MsgEvent(['sender' => $this]));
    }

    public function do4($event)
    {
        echo 'time: ' . $event->dateTime . ' ,author: ' . $event->author . ' ,content: ' . $event->content . ' ,shoes:' . $event->shoes;
    }

    public function pa()
    {
        $MsgEvent = new MsgEvent();
        $MsgEvent->dateTime = time();
        $MsgEvent->author = 'bingcool';
        $MsgEvent->content = 'hello,everyone';
        $MsgEvent->shoes = 'this is shoes';
        $this->trigger(self::EVENT_PERSON_DO4, $MsgEvent);
    }
}