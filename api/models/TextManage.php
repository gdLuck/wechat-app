<?php
/**
 * TEXT 消息处理
 * Date: 2018/3/15
 * Time: 15:48
 */

namespace api\models;

use api\components\ManageInterface;
use common\components\SendAbstraction;
use common\models\WechatKeyword;

class TextManage extends SendAbstraction implements ManageInterface
{
    public $userContent;

    public function result()
    {
        // TODO: Implement result() method.
        if (!empty ( $this->userContent ) ) {
            $this->userContent = (string)$this->userContent;//清除对象数组结构

            $data  = ApiWecahtKeyword::model()->KeywordMatch($this->userContent);
            if (empty($data)){
                $data['type']	 = 1;
                $data['content'] = '查询失败，无相关内容！';
            }
            if (WechatKeyword::TYPE_NEWS == $data['type'] ){
                //图文回复, 数据由后台批量导入并关联
                $newsFodder =  ApiWecahtKeyword::model()->KeywordNewsFodder($data['vfID']);
                if(empty($newsFodder)){
                    $this->sendText('出错啦！试试其他关键字吧');
                }
                $this->sendNews($newsFodder);
            }else{
                //文本回复
                $contentStr = $data['content'];
                $this->sendText($contentStr);
            }

        }else{
            echo '';
        }
        echo '';
    }

}