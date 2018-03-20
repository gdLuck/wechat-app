<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/7
 * Time: 12:43
 */

namespace backend\libs\house;
use yii\base\Component;

class Cat extends Component
{
    const EVENT_CAT_SHOUT = 'miao' ;
    const EVENT_CAT_EX1 = 'ex1' ;
    const EVENT_CAT_EX5 = 'ex5' ;

    public function shout()
    {
        echo "miao miao miao ".PHP_EOL;
        $this->trigger(self::EVENT_CAT_SHOUT);
    }

    public function run()
    {
        echo "i am cat, running now !".PHP_EOL;
    }

    public function ex1()
    {
        $this->trigger(self::EVENT_CAT_EX1);
    }

    public function ex5()
    {
        $this->trigger(self::EVENT_CAT_EX5);
    }
}