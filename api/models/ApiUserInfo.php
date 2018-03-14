<?php
/**
 * 公众号 用户信息处理类
 * Date: 2018/3/14
 * Time: 16:01
 */

namespace api\models;


use common\components\WechatCoreHelper;
use common\models\WechatUserInfo;

class ApiUserInfo
{
    /**
     * 更新用户信息 (订阅号内用户订阅时)
     * @param array $userInfo
     */
    public function updateUserInfo($userInfo){

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
                'headimgurl'    => empty($userInfo['headimgurl']) ? $userInfo['headimgurl'] : '' ,
                'subscribe_time'=> $userInfo['subscribe_time'],
                'unionid'   => $userInfo['unionid'],
                'remark'    => $userInfo['remark'],
                'groupid'   => $userInfo['groupid'],
                'u_state'   => WechatUserInfo::TYPE_WECHAT
            ];
            $user->attributes = $values;
            if ($user->save()){
                return $user->uid;
            }else{
                WechatCoreHelper::WechatLogRecord($userInfo, $userInfo['openid'], 'err');
                return false;
            }
        }else{
            //更新用户信息
            $uid  = (int)$user->uid;


            $count = ApiUserInfo::model()->updateByPk($uid,
                array(
                    'nickname'  => WechatCoreHelper::deleteNicknameEmoji($userInfo['nickname']),
                    'headimgurl'=> empty($userInfo['headimgurl']) ? $userInfo['headimgurl'] : 'http://cdn.joyup.tv/wechat/images/def.png',
                    'remark' 	=> $userInfo['remark'],
                    'city'		=> $userInfo['city'],
                    'u_state'	=> 1,
                    'add_time'	=>time()
                )
            );
            if ($count >0){
                return $uid;
            }else{
                WechatCoreHelper::wechatLog($userInfo,106,'err',new VrpengWechatLog() );
            }
        }
    }

    /**
     * 更新用户关注状态
     * @param string $openid
     * @return bool
     */
    public function updateSubscribeState($openid){
        //更新用户信息
        $count =VrpengUserInfo::model()->updateAll(array('u_state'=>0),
            'openid=:openid',array(':openid'=>$openid));
        if ($count >0){
            return true;
        }
        return FALSE;
    }

    /**
     * 检查用户信息是否存在
     */
    public function CheckUser(){

    }
}