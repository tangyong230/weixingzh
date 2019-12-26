# 微信公众号api封装
## 一 获取access_token
````
//必填配置
$tokenConfig =  [
    'appid'=>'',
    'secret'=>'',
    'accessTokenUrl'=> 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential'
];
//获取access_token
$accessToken = \weixingzh\library\WeixinToken::getInstance(new \weixingzh\library\Curl(),$tokenConfig)->getAccessToken();
````
## 二 模板消息接口
````
//必填配置
$industryConfig = [
    //获取所属行业url
    'get_industry'=>"https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=",
    //获取所有模板url
    'get_template'=>"https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=",
    //发送模板消息url
    'send_template_msg'=>"https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=",
];
//发送模板消息
$result = \weixingzh\library\WeixinIndustry::getInstance(new \weixingzh\library\Curl(),$industryConfig)->sendTemplateMessage($accessToken,$strData);
````
