<?php
namespace common\components;

use yii\caching\MemCache;
use yii\caching\FileCache;

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
     * 设定缓存路径
     * @param string $directory
     * @return FileCache|MemCache
     */
    public static function cache($directory='') {
        /** @var FileCache|MemCache $cache */
        $cache = \Yii::$app->cache;
        if (in_array(get_class($cache),['common\components\Cache','yii\redis\Cache'])) {
            //memcache
            $cache->keyPrefix = $directory;
            return $cache;
        } else {
            //文件缓存
            $cachePath = \Yii::getAlias('@cache');
            $path =  $cachePath. DS . $directory;
            if (!is_dir($path))
                self::createDir($directory,$cachePath);
            $cache->cachePath = \Yii::getAlias('@cache') . DS . $directory;
            return $cache;
        }
    }

    /**
     * 创建目录
     * 可以递归创建，默认是以当前网站根目录下创建
     * 第二个参数指定，就以第二参数目录下创建
     * @param string $path      要创建的目录
     * @param string $webroot   要创建目录的根目录
     * @return boolean
     */
    public static function createDir($path, $webroot = null) {
        $path = preg_replace('/\/+|\\+/', DS, $path);
        $dirs = explode(DS, $path);
        if (!is_dir($webroot))
            $webroot = \Yii::getAlias("@webroot");
        foreach ($dirs as $element) {
            $webroot .= DS . $element;
            if (!is_dir($webroot)) {
                if (!mkdir($webroot, 0777))
                    return false;
                else
                    chmod($webroot, 0777);
            }
        }
        return true;
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
