<?php
/**
 * filename: WeixinFriends.php.
 * author: china.php@qq.com
 * datetime: 2019/12/18
 */

namespace weixingzh\library;


use weixingzh\exception\WeixinException;

class WeixinFriends
{

    /*
         [
            //获取所属行业url
            'get_friends'=>"https://api.weixin.qq.com/cgi-bin/user/get?access_token=%s&next_openid=%s",
         ]
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
    }

    /** 实例化
     * @param Curl $curl
     * @param array $config
     * @return null|WeixinFriends
     */
    public static function getInstance(Curl $curl, array $config)
    {
        if (empty(self::$instance)) {
            self::$instance = new self($curl, $config);
        }
        return self::$instance;
    }

    /** 获取关注粉丝列表
     * @param $access_token
     * @param null $next_openid
     * @return bool|mixed
     * @throws WeixinException
     */
    public static function getFriendsList($access_token, $next_openid = null)
    {
        if (empty($access_token)) {
            return false;
        }
        $result = self::$curl->get(sprintf(self::$config['get_friends'], $access_token, $next_openid));
        $result = json_decode($result, true);
        if (isset($result['total'])) {
            return $result;
        } else {
            throw new WeixinException(serialize($result));
        }
    }

}