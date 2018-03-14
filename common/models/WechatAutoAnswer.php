<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%auto_answer}}".
 *
 * @property int $id
 * @property string $content
 * @property int $type 1 关注  2 错误关键字回复
 * @property int $addtime
 */
class WechatAutoAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auto_answer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['addtime'], 'required'],
            [['addtime'], 'integer'],
            [['content'], 'string', 'max' => 200],
            [['type'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'type' => '1 关注  2 错误关键字回复',
            'addtime' => 'Addtime',
        ];
    }
}
