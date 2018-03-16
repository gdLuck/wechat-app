<?php
/**
 * 公众号 用户信息处理类
 * Date: 2018/3/14
 * Time: 16:01
 */

namespace api\models;

use common\components\WechatCoreHelper;
use common\models\WechatUserInfo;

class ApiWechatUserInfo
{
    /**
     * @return ApiWechatUserInfo
     */
    public static function model()
    {
        $class = __CLASS__;
        return new $class();
    }

    /**
     * 更新用户信息 (订阅号内用户订阅时)
     * @param array $userInfo
     */
    public function updateUserInfo(array ...$userInfo):bool
    {

        $user = WechatUserInfo::find()->where(['openid'=> $userInfo['openid']])
            ->limit(1)->one();

        if (!$user){
            //新增用户信息
            $values = [
                'subscribe' => $userInfo['subscribe'],
                'openid'    => $userInfo['openid'],
                'nickname'  => WechatCoreHelper::replaceNicknameEmoji($userInfo['nickname']),
                'sex'       => $userInfo['sex'],
                'city'      => $userInfo['city'],
                'country'   => $userInfo['country'],
                'province'  => $userInfo['province'],
                'headimgurl'    => $userInfo['headimgurl'] ?? '' , // 7新特性
                'subscribe_time'=> $userInfo['subscribe_time'],
                'unionid'   => $userInfo['unionid'],
                'remark'    => $userInfo['remark'],
                'groupid'   => $userInfo['groupid'],
                'u_state'   => WechatUserInfo::STATE_SUBSCRIBE
            ];
            $user->attributes = $values;
            if ($user->save()){
                return true;
            }else{
                WechatCoreHelper::wechatLogRecord($userInfo, $userInfo['openid'], 'err');
                return false;
            }
        }else{
            //更新用户信息
            $user->nickname     = WechatCoreHelper::replaceNicknameEmoji($userInfo['nickname']);
            $user->headimgurl   = empty($userInfo['headimgurl']) ? $userInfo['headimgurl'] : '';
            $user->remark       = $userInfo['remark'];
            $user->city         = $userInfo['city'];
            $user->u_state      = WechatUserInfo::STATE_UNSUBSCRIBE;
            if ($user->save()){
                return true;
            }else{
                WechatCoreHelper::wechatLogRecord($userInfo,106,'err' );
                return false;
            }
        }
    }

    /**
     * 更新用户关注状态
     * @param string $openid
     * @return bool
     */
    public function updateSubscribeState($openid)
    {
        //更新用户信息
        $model = WechatUserInfo::find()->where('openid=:openid',[':openid'=>$openid])
            ->limit(1)->one();
        $model->u_state = 0;
        if ($model->save()){
            return true;
        }
        return FALSE;
    }

    /**
     * 检查用户信息是否存在
     */
    public function CheckUser()
    {

    }
}