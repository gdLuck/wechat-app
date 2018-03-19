<?php
/**
 * Date: 2018/3/16
 * Time: 14:46
 */

namespace api\models;

use common\models\WechatKeyword;

class ApiWecahtKeyword
{

    /**
     * @return ApiWecahtKeyword
     */
    public static function model()
    {
        $class = __CLASS__;
        return new $class();
    }

    /**
     * 匹配用户关键字（完全匹配）
     */
    public function KeywordMatch($keyword)
    {
        $result = WechatKeyword::find()->where(['keyword'=> $keyword])->limit(1)->one();

        $data = [];
        if (!empty($result)){
            $data['kid'] 	 	= $result->kid;
            $data['keyword'] 	= $result->keyword;
            $data['vfID']	 	= $result->vf_id;
            $data['content'] 	= $result->content;
            $data['type'] 	 	= $result->type;
        }

        return $data;
    }

    /**
     * 图文内容
     * @param int 素材ID
     */
    public function KeywordNewsFodder($vfid):array
    {
        return [];
    }
}