<?php
/**
 * 认证方法
 * 版本：PHP7
 * Date: 2018/3/21
 * Time: 17:08
 */

namespace common\components;


use yii\base\Exception;

class Security
{
    private $passwordHashCost = 13; //看电脑性能可适当增加

    /**
     * @return Security
     */
    public static function factory()
    {
        $class = __CLASS__;
        return new $class();
    }

    /**
     * 生成随机串
     * The string generated matches [A-Za-z0-9_-]+ and is transparent to URL-encoding.
     * @param int $length the length of the key in characters
     * @return string the generated random key
     * @throws Exception on failure.
     */
    public function generateRandomString(int $length = 32):string
    {
        if (!is_int($length)) {
            throw new Exception('First parameter ($length) must be an integer');
        }

        if ($length < 1) {
            throw new Exception('First parameter ($length) must be greater than 0');
        }

        $bytes = self::generateRandomKey($length);
        return substr(self::base64UrlEncode($bytes), 0, $length);
    }
    private static function base64UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }
    private static function generateRandomKey(int $length):string
    {
        if (!is_int($length)) {
            throw new Exception('First parameter ($length) must be an integer');
        }

        if ($length < 1) {
            throw new Exception('First parameter ($length) must be greater than 0');
        }

        // always use random_bytes() if it is available 。 PHP7支持
        if (function_exists('random_bytes')) {
            return random_bytes($length);
        } else {
            $bytes = '';
            while (strlen($bytes) < $length)
                $bytes .= chr(mt_rand(0, 255));
            return $bytes;
        }
    }

    /**
     * 生成密码
     * @param $password
     * @param null $cost
     * @return bool|string
     * @throws Exception
     */
    public function generatePasswordHash($password, $cost = null)
    {
        if ($cost === null) {
            $cost = $this->passwordHashCost;
        }

        // 版本大于 5.5
        if (function_exists('password_hash')) {
            /* @noinspection PhpUndefinedConstantInspection */
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
        } else {
            throw new Exception('请升级PHP版本到5.6及以上');
        }
    }

    /**
     * 验证密码
     * @param $password
     * @param $hash
     * @return bool
     */
    public function validatePassword($password, $hash)
    {
        if (!is_string($password) || $password === '') {
            throw new Exception('Password must be a string and cannot be empty.');
        }

        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $hash, $matches)
            || $matches[1] < 4
            || $matches[1] > 30
        ) {
            throw new Exception('Hash is invalid.');
        }

        if (function_exists('password_verify')) {
            return password_verify($password, $hash);
        } else {
            throw new Exception('请升级PHP版本到5.6及以上');
        }
    }
}