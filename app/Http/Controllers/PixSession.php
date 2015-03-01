<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Cookie;
use Carbon\Carbon;

class PixSession {
	
	const pix_user = 'hesanomy@sina.com';
	const pix_pass = 'qwer1234';
	const login_token = 'device_token';
	const login_token_value = 'yes';
	
	public static function getRequestsSession(){
		$session = new \Requests_Session('http://www.pixiv.net');
		$session->options['cookies'] = PixSession::getCookieJar();
		if (!PixSession::isLogedin($session)) PixSession::login($session);
		return $session;
	}
	
	public static function saveRequestsSession(\Requests_Session $session){
		PixSession::saveCookieJar($session->options['cookies']);
	}
	
	protected static function isLogedin(\Requests_Session $session){
		$array = $session->options['cookies']->getIterator()->getArrayCopy();
		if (array_key_exists(PixSession::login_token, $array) ) {
			$expires = $array['device_token']->attributes->offsetGet('expires');
			$time = Carbon::createFromFormat('l, d-M-Y H:i:s T', $expires)->subMinutes(60);
			$now = Carbon::now();
			if ($now->gt($time)){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			return false;
		}
	}
	
	protected static function getCookieJar(){
		$cookiesArray = [];
		$cookiesModel = Cookie::all();
		$cookiesModelArray = $cookiesModel->toArray();
		foreach ($cookiesModelArray as $_cookie){
			$attr = new \Requests_Utility_CaseInsensitiveDictionary();
			$attr->offsetSet('expires', $_cookie['expires']);
			$attr->offsetSet('max-age', $_cookie['max-age']);
			$attr->offsetSet('path', $_cookie['path']);
			$attr->offsetSet('domain', $_cookie['domain']);
			$cookiesArray[$_cookie['name']] = new \Requests_Cookie($_cookie['name'], $_cookie['value'], $attr);
		}
		return new \Requests_Cookie_Jar($cookiesArray);
	}
	
	protected static function saveCookieJar(\Requests_Cookie_Jar $jar){
		foreach ($jar->getIterator()->getArrayCopy() as $key => $value){
			$cookie = Cookie::firstOrNew(['name' => $value->name]);
			$cookie->value = $value->value;
			$attr = $value->attributes;
			$cookie->expires = $attr->offsetGet('expires');
			$cookie->setAttribute('max-age', $attr->offsetGet('max-age'));
			$cookie->path = $attr->offsetGet('path');
			$cookie->domain = $attr->offsetGet('domain');
			$cookie->save();
		}
	}
	
	protected static function login(\Requests_Session $session){
		set_time_limit(0);
		$session->options['follow_redirects'] = false;
		$response = $session->post('/login.php', [], [
			'mode' => 'login',
            'pixiv_id' => PixSession::pix_user,
            'pass' => PixSession::pix_pass,
            'mode' => 'login',
            'skip' => 1
		]);
		$session->options['follow_redirects'] = true;
		PixSession::saveRequestsSession($session);
		set_time_limit(30);
	}

}
