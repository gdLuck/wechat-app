<?php
namespace common\components;

/**
 * 通用方法
 */
class Helper
{
    /**
     * @return Helper
     */
	public static function factory()
    {
		$className = __CLASS__;
		return new $className ();
	}

    /**
     * 加密密码
     * 加密表达式： $password = md5( md5(md5($password_text) . $solid_key) . substr(md5($regtime . $solid_key),8,16) )
     *
     * @param string $password	经过单次md5后的密码串
     * @param string $regtime	用户注册时间
     * @return string
     */
    public static function encryptPassword($password, $regtime)
    {
        $solid_key = Yii::app()->params['password_key'];
        $twice = md5($password . $solid_key);
        $rand_salt = substr(md5($regtime . $solid_key), 8, 16);
        $thrice = md5($twice . $rand_salt);
        return $thrice;
    }

    /**
     * 生成唯一ID
     * @return string
     */
    public static function createUuid()
    {
        $str = md5(uniqid(mt_rand() , true));
        $uuid = substr($str, 8, 16);
        return $uuid;
    }

    /**
     * 生成唯一的随机串
     * @return string
     */
    public static function createSeqid()
    {
        list($usec, $sec) = explode(" ", microtime());
        $str = ((float)$usec + (float)$sec);
        $seqid = $str . rand(1000, 9999);
        return md5($seqid);
    }

    /**
     * 过滤空格
     * @return string
     */
    public static function spaceFilter($str)
    {
        if (!$str || !is_string($str)){
            return $str;
        }
        return preg_replace("/[\s\n\r\t]/", '', $str);
    }

    /**
     * 取得链接文件源码
     * @param string $durl
     * @return mixed
     */
    public static function curl_file_get_contents($durl){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $durl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);//最大请求时间
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
        curl_setopt($ch, CURLOPT_REFERER,'http://www.vrpeng.com/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//返回数据流
        $r = curl_exec($ch);

        curl_close($ch);
        return $r;
    }

}
