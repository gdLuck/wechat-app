<?php
/**
 * Date: 2018/3/15
 * Time: 17:09
 */

namespace api\models;

use api\components\ManageInterface;
use common\components\{SendAbstraction,WechatCoreHelper};
use common\models\WechatAutoAnswer;

class SubscribeManage extends SendAbstraction implements ManageInterface
{
    /**
     * 订阅处理
     */
    public function result()
    {
        // TODO: Implement result() method.
        $wechatUserInfo = WechatCoreHelper::factory()->getWechatUserInfo(FROM_USER_NAME);
        if (isset($wechatUserInfo['openid'])){
            //测试用
            WechatCoreHelper::wechatLogRecord($wechatUserInfo,FROM_USER_NAME,'subscribe update info');
            //更新用户信息
            ApiWechatUserInfo::model()->updateUserInfo($wechatUserInfo);
        }else{
            WechatCoreHelper::wechatLogRecord($wechatUserInfo,FROM_USER_NAME,'userInfo err');
        }
        $this->sendSubscribeContent();
    }

    /**
     * 取消订阅
     */
    public function unsubscribe()
    {
        ApiWechatUserInfo::model()->updateSubscribeState(FROM_USER_NAME);
    }


    //回复订阅信息
    private function sendSubscribeContent()
    {
        $answer = WechatAutoAnswer::find()->select('content')
            ->where(['type'=> WechatAutoAnswer::STATE_SUBSCRIBE])
            ->orderBy('addtime DESC')->limit(1)
            ->one();

        $this->sendText($answer->content);
    }
}