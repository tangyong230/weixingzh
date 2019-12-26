<?php
namespace weixingzh\library;
class Curl{
	
	protected static function init($url, $cookie, $headers = []) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		if( $cookie ) {
			is_array($cookie) && $cookie = implode(';', $cookie);
			
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		
		if( !empty($headers) ) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		
		
		if(preg_match("#^https#", $url)) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		}
		
		return $ch;
	}
	
	protected static function exec($ch) {
		$res = curl_exec($ch);
		curl_close($ch);
		
		return $res;
	}
	

    /**
     * @param $url
     * @param null $cookie
     * @param array $headers
     * @return bool|mixed
     */
	public static function get($url, $cookie = null, $headers = []) {
		try{
			$ch = self::init($url, $cookie, $headers);
			$res = self::exec($ch);
		} catch(\Exception $e) {
			$res = false;
		}
		
		return $res;
	}

    /**
     * @param $url
     * @param $data
     * @param null $cookie
     * @param array $headers
     * @return bool|mixed
     */
	public static function post($url, $data, $cookie = null, $headers = []) {
		try{
			$ch = self::init($url, $cookie, $headers);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? http_build_query($data) : $data);
			$res = self::exec($ch);
		} catch(\Exception $e) {
			$res = false;
		}
		
		return $res;
	}
}