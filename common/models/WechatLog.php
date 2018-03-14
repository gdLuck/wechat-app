<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property int $logid
 * @property string $log
 * @property string $to_user_name
 * @property string $from_user_name
 * @property int $type 来源 1公众号
 * @property int $add_time
 */
class WechatLog extends \yii\db\ActiveRecord
{
    /**
     * @return WechatLog
     */
    public static function model()
    {
        $class = __CLASS__;
        return new $class();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log'], 'string'],
            [['add_time'], 'integer'],
            [['to_user_name', 'from_user_name'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'logid' => 'Logid',
            'log' => 'Log',
            'to_user_name' => 'To User Name',
            'from_user_name' => 'From User Name',
            'type' => '来源 1公众号',
            'add_time' => 'Add Time',
        ];
    }
}
