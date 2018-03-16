<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%keyword}}".
 *
 * @property int $kid
 * @property string $keyword
 * @property int $vf_id
 * @property string $content
 * @property int $type
 * @property string $remark
 * @property int $add_time
 */
class WechatKeyword extends \yii\db\ActiveRecord
{
    const TYPE_TEXT = 1; //文本回复
    const TYPE_NEWS = 2; //图文回复

    private static $_models = array();            // class name => model

    /**
     * 静态调用子类方法
     * Returns the static model of the specified request class.
     * @param string $className request class name.
     * @return WechatKeyword  request model instance.
     */
    public static function model($className = __CLASS__)
    {
        if (isset(self::$_models[$className]))
            return self::$_models[$className];
        else {
            $model = self::$_models[$className] = new $className(null);
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%keyword}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keyword', 'type', 'add_time'], 'required'],
            [['vf_id', 'add_time'], 'integer'],
            [['keyword'], 'string', 'max' => 20],
            [['content'], 'string', 'max' => 200],
            [['type'], 'string', 'max' => 4],
            [['remark'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kid' => 'Kid',
            'keyword' => 'Keyword',
            'vf_id' => 'Vf ID',
            'content' => 'Content',
            'type' => 'Type',
            'remark' => 'Remark',
            'add_time' => 'Add Time',
        ];
    }
}
