<?php
/**
 * filename: WeixinToken.php.
 * author: china.php@qq.com
 * datetime: 2019/12/18
 */

namespace weixingzh\library;

use weixingzh\exception\WeixinException;

/** 获取token
 * Class WeixinToken
 */
class WeixinToken
{
    /*
      初如化数组格式，此三项必填,顺序不能变
         [
            'appid'=>'wx1d8664674d0a15eb',
            'secret'=>'e4fb5f39ce89c9d68c0b1c9700a6c678',
            'accessTokenUrl'=> 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential'
         ];
    */

    private static $config = [];

    private static $instance = null;
    private static $curl = null;

    private function __construct($curl, $config)
    {
        self::$curl = $curl;
        self::$config = $config;
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /** 实例化
     * @param Curl $curl
     * @param array $config
     * @return null|WeixinToken
     */
    public static function getInstance(Curl $curl, array $config)
    {
        if (empty(self::$instance)) {
            self::$instance = new self($curl, $config);
        }
        return self::$instance;
    }

    /** 获取access_token
     * @return mixed
     * @throws WeixinException
     */
    public static function getAccessToken()
    {
        if (!isset(self::$config['appid']) || !isset(self::$config['secret']) || !isset(self::$config['accessTokenUrl'])) {
            throw new WeixinException("获取微信access_token配置有误！");
        }
        $querString = array_slice(self::$config, 0, 2);
        $result = self::$curl->get(self::$config['accessTokenUrl'] . "&" . http_build_query($querString));
        $result = json_decode($result, true);
        if (isset($result['access_token'])) {
            return $result['access_token'];
        } else {
            throw new WeixinException(serialize($result));
        }
    }
}