<?php

namespace common\models;

use Yii;

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
 * @property int $u_state
 */
class WechatUserInfo extends \yii\db\ActiveRecord
{
    /**
     * @return WechatUserInfo
     */
    public static function model()
    {
        $class = __CLASS__;
        return new $class();
    }

    const TYPE_WECHAT = 1; //来源微信公众号
    const TYPE_WEB = 2;

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
            [['subscribe', 'openid', 'nickname', 'city', 'country', 'province', 'headimgurl', 'subscribe_time', 'unionid', 'remark', 'groupid', 't_id', 'u_state'], 'required'],
            [['subscribe', 'subscribe_time', 'groupid', 't_id', 'u_state'], 'integer'],
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
            'u_state' => 'U State',
        ];
    }
}
