<?php
/**
 * TEXT 消息处理
 * Date: 2018/3/15
 * Time: 15:48
 */

namespace api\models;

use api\components\ManageInterface;
use common\components\SendAbstraction;

class TextManage extends SendAbstraction implements ManageInterface
{
    public $userContent;

    public function result()
    {
        // TODO: Implement result() method.
    }
}