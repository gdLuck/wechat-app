<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/8
 * Time: 10:30
 */

namespace backend\libs\house;

use yii\base\Component;

class Dog extends Component
{
    const EVENT_DOG_LOOK = 'look';
    public function look()
    {
        echo "i am dog , looking now !".PHP_EOL;
        $this->trigger(self::EVENT_DOG_LOOK);
    }

    public function ex5($event)
    {
        echo $event->data .PHP_EOL;
    }

}