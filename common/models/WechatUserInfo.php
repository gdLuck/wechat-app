<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_info}}".
 *
 * @property int $uid
 * @property int $subscribe
 * @property string $openid
 * @property string $nickname
 * @property int $sex 0保密 1男 2女
 * @property string $city
 * @property string $country
 * @property string $province
 * @property string $headimgurl
 * @property int $subscribe_time
 * @property string $unionid
 * @property string $remark
 * @property int $groupid
 * @property int $t_id
 * @property int $u_state 0 未关注 1已关注
 * @property int $created_at
 * @property int $updated_at
 */
class WechatUserInfo extends \yii\db\ActiveRecord
{
    const STATE_SUBSCRIBE = 1; //订阅
    const STATE_UNSUBSCRIBE = 0; //取消订阅

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subscribe', 'openid', 'nickname', 'city', 'country', 'province', 'headimgurl', 'subscribe_time', 'unionid', 'remark', 'groupid', 't_id', 'u_state', 'created_at', 'updated_at'], 'required'],
            [['subscribe', 'subscribe_time', 'groupid', 't_id', 'u_state', 'created_at', 'updated_at'], 'integer'],
            [['openid', 'unionid'], 'string', 'max' => 100],
            [['nickname'], 'string', 'max' => 40],
            [['sex'], 'string', 'max' => 4],
            [['city', 'country', 'province', 'remark'], 'string', 'max' => 20],
            [['headimgurl'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'subscribe' => 'Subscribe',
            'openid' => 'Openid',
            'nickname' => 'Nickname',
            'sex' => '0保密 1男 2女',
            'city' => 'City',
            'country' => 'Country',
            'province' => 'Province',
            'headimgurl' => 'Headimgurl',
            'subscribe_time' => 'Subscribe Time',
            'unionid' => 'Unionid',
            'remark' => 'Remark',
            'groupid' => 'Groupid',
            't_id' => 'T ID',
            'u_state' => '0 未关注 1已关注',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
}
