<?php
/**
 * Date: 2018/3/16
 * Time: 14:46
 */

namespace api\models;


use common\models\WechatKeyword;

class ApiWecahtKeyword extends WechatKeyword
{
    /**
     * 匹配用户关键字（完全匹配）
     */
    public function KeywordMatch($keyword)
    {
        $result = self::find()->where(['keyword'=> $keyword])->limit(1)->one();
        $data = [];
        if (!empty($result)){
            $data['kid'] 	 	= $result[0]['kid'];
            $data['keyword'] 	= $result[0]['keyword'];
            $data['vfID']	 	= $result[0]['vf_id'];
            $data['content'] 	= $result[0]['content'];
            $data['type'] 	 	= $result[0]['type'];
        }

        return $data;
    }

    /**
     * 图文内容
     */
    public function KeywordNewsFodder()
    {

    }
}