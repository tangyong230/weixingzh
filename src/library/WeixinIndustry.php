<?php
/**
 * filename: WeixinIndustry.php.
 * author: china.php@qq.com
 * datetime: 2019/12/18
 */

namespace weixingzh\library;

use weixingzh\exception\WeixinException;

/**
 * 模板消息接口
 * Class WeixinIndustry
 */
class WeixinIndustry
{
    /*
     初如化数组格式，此三项必填
     [
        //获取所属行业url
        'get_industry'=>"https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=",
        //获取所有模板url
        'get_template'=>"https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=",
        //发送模板消息url
        'send_template_msg'=>"https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=",
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
        // TODO: Implement __clone() method.
    }

    /** 实例化
     * @param Curl $curl
     * @param array $config
     * @return null|WeixinIndustry
     */
    public static function getInstance(Curl $curl, array $config)
    {
        if (empty(self::$instance)) {
            self::$instance = new self($curl, $config);
        }
        return self::$instance;
    }

    /** 获取所属行业
     * @param $access_token
     * @return bool|mixed
     * @throws WeixinException
     */
    public static function getIndustry($access_token)
    {
        if (empty($access_token)) {
            return false;
        }
        $result = self::$curl->get(WeixinIndustry::$config['get_industry'] . $access_token);
        $result = json_decode($result, true);
        if (isset($result['primary_industry'])) {
            return $result;
        } else {
            throw new WeixinException(serialize($result));
        }
    }

    /** 获取所有模板
     * @param $access_token
     * @return bool|mixed
     * @throws WeixinException
     */
    public static function getTemplate($access_token)
    {
        if (empty($access_token)) {
            return false;
        }
        $result = self::$curl->get(WeixinIndustry::$config['get_template'] . $access_token);
        $result = json_decode($result, true);
        if (isset($result['template_list'])) {
            return $result;
        } else {
            throw new WeixinException(serialize($result));
        }
    }

    /** 发送模板消息
     * @param $access_token
     * @param string $data json字符串
     * @return bool|mixed
     * @throws WeixinException
     */
    public static function sendTemplateMessage($access_token, $data)
    {
        if (empty($access_token)) {
            return false;
        }
        $result = self::$curl->post(WeixinIndustry::$config['send_template_msg'] . $access_token, $data);
        $result = json_decode($result, true);
        if (isset($result['errcode']) && $result['errcode'] == 0) {
            return $result;
        } else {
            throw new WeixinException(serialize($result));
        }
    }
}