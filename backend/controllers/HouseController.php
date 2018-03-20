<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\libs\house\Cat;
use backend\libs\house\Dog;
use backend\libs\house\Mouse;
use backend\libs\house\Person;

use yii\base\Event;

/**
 * Site controller
 */
class HouseController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return '';
    }

    public function actionEx1()
    {
        //事件处理器的类型
        $cat1 = new Cat();
        $mouse1 = new Mouse();
        $cat1->on(Cat::EVENT_CAT_EX1, [$mouse1, 'ex1'], '事件处理器的类型:对象方法' );
        $cat1->on(Cat::EVENT_CAT_EX1, 'ex1', '事件处理器的类型:全局函数' );
        $cat1->on(Cat::EVENT_CAT_EX1, ['backend\libs\house\Mouse','ex1'],'事件处理器的类型:静态类方法' );
        $cat1->on(Cat::EVENT_CAT_EX1, function($event){
            echo '匿名函数' . PHP_EOL;
            echo $event->data . PHP_EOL;
        }, '事件处理器的类型:匿名函数');
        $cat1->ex1();
    }

    public function actionEx2()
    {
        //猫叫触发了一些列的动作
        $cat1       = new Cat();
        $mouse1     = new Mouse();
        $dog1       = new Dog();
        $person1    = new Person();
        $cat1->on(Cat::EVENT_CAT_SHOUT, [$mouse1, 'run']); // 猫叫触发了老鼠跑
        $cat1->on(Cat::EVENT_CAT_SHOUT, [$dog1, 'look'] ); // 猫叫触发狗看
        $dog1->on(Dog::EVENT_DOG_LOOK , [$cat1, 'run']); // 狗看触发了猫跑
        $mouse1->on(Mouse::EVEN_MOUSE_RUN, [$person1, 'do']); // 老鼠跑触发了人扔鞋子
        $cat1->shout();
    }

    public function actionEx3()
    {
        // 5只猫触发事件
        $cat1       = new Cat();
        $cat2       = new Cat();
        $cat3       = new Cat();
        $cat4       = new Cat();
        $cat5       = new Cat();
        $mouse1     = new Mouse();

        $cat1->on(Cat::EVENT_CAT_EX1, [$mouse1, 'ex3'], '$cat1 事件处理器的类型:对象方法' );
        $cat2->on(Cat::EVENT_CAT_EX1, [$mouse1, 'ex3'], '$cat2 事件处理器的类型:对象方法' );
        $cat3->on(Cat::EVENT_CAT_EX1, [$mouse1, 'ex3'], '$cat3 事件处理器的类型:对象方法' );
        $cat4->on(Cat::EVENT_CAT_EX1, [$mouse1, 'ex3'], '$cat4 事件处理器的类型:对象方法' );
        $cat5->on(Cat::EVENT_CAT_EX1, [$mouse1, 'ex3'], '$cat5 事件处理器的类型:对象方法' );
        //$cat1->off(Cat::EVENT_CAT_EX1);

        $cat1->ex1();
        $cat2->ex1();
        $cat3->ex1();
        $cat4->ex1();
        $cat5->ex1();
    }

    public function actionEx4()
    {
        // 触发类级别的事件
        $cat1       = new Cat();
        $cat2       = new Cat();
        $cat3       = new Cat();
        $cat4       = new Cat();
        $cat5       = new Cat();
        $mouse1     = new Mouse();

        Event::on(Cat::className(), Cat::EVENT_CAT_EX1, [$mouse1,'ex1'],'5只猫触发类级别的事件');
       // Event::off(Cat::className(), Cat::EVENT_CAT_EX1, [$mouse1,'ex1']);
        $cat1->ex1();
        $cat2->ex1();
        $cat3->ex1();
        $cat4->ex1();
        $cat5->ex1();
    }

    public function actionEx5()
    {
        // 只触发了一次就终止了
        $bool = false ;
        $cat1       = new Cat();
        $mouse1     = new Mouse();
        $dog1       = new Dog();

        $cat1->on(Cat::EVENT_CAT_EX5, [$dog1, 'ex5'], 'dog ex5 !');
        $cat1->on(Cat::EVENT_CAT_EX5, [$mouse1, 'ex5'], 'cat ex5 !', $bool);

        $cat1->ex5();
    }

    public function actionEx6()
    {
        // 触发全局级别事件
        $person = new Person();
        Yii::$app->on('person.bar', function ($event) {
            echo get_class($event->sender);  // 显示 "app\components\Foo"
            echo PHP_EOL;
            echo '触发全局级别事件';
        });
        //Yii::$app->off('person.bar');
        $person->do3();
    }

    public function actionEx7()
    {
        // 事件处理顺序
        $bool = true; // false优先, true推后
        $cat1       = new Cat();
        $dog1       = new Dog();
        $mouse1     = new Mouse();
        $cat1->on(Cat::EVENT_CAT_SHOUT, [$mouse1, 'run']); // 猫叫触发了老鼠跑
        $cat1->on(Cat::EVENT_CAT_SHOUT, [$dog1, 'look'], null, $bool); // 猫叫触发狗看
        $cat1->shout();
    }

    public function actionEx8()
    {
        // 重载了 event 的事件
        $person = new Person();
        $person->on(Person::EVENT_PERSON_DO4, [$person, 'do4']);
        $person->pa();
    }
}
