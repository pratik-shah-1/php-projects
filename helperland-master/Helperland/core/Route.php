<?php

namespace core;

use core\Request;
use core\Response;

class Route{

	public static $browser_url = '/';
	public static $route_url = '/';
	public static $params_key = [];
	public static $params_value = [];
	public static $req;
	public static $res;
	public static $method = 'GET';

	// ----------CLEAN_URL------------
	public static function cleanUrl($url){
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = strtolower($url);
		$url = rtrim($url, '/');
		if(str_contains($url, LOCAL_PATH)){
			$url = str_replace(LOCAL_PATH, '', $url);
		}
		$url = $url==""? '/' : $url;
		return $url;
	}

	// ----------SPLIT_URL------------
	public static function splitUrl($route_arr){

		self::$route_url = self::cleanUrl($route_arr);
		self::$browser_url = self::cleanUrl($_SERVER['REQUEST_URI']);
		self::$params_key = explode('/', self::$route_url);
		self::$params_value = explode('/', self::$browser_url);

		/**
		 * SET ROUTE_URL AS PARAMS_KEY
		 * SET BROWSER_URL AS PARAMS_VALUE
		 * WHEN ROUTE MATCH THEN ONLY CREATE REQ, RES OBJECT
		 */
		
		if(self::$route_url==self::$browser_url){
			pageUrl(self::$browser_url);
			self::$req = new Request();
			self::$res = new Response();	
			return true;
		}
		else if(str_contains(self::$route_url, ':')){
			pageUrl(self::$browser_url);
			if(count(self::$params_key) == count(self::$params_value)){
				for($i=0; $i<count(self::$params_key); $i++){
					if(!str_contains(self::$params_key[$i], ':')){
						if(self::$params_key[$i] != self::$params_value[$i]){
							return false;
						}
					}
				}
				self::$req = new Request([self::$params_key, self::$params_value]);
				self::$res = new Response();		
				return true;
			}
		}
		else if(str_contains(self::$browser_url, '?')){
			self::$res = new Response();		
			self::$res->status(400)->json(['error'=>'Query String URL Not Supported!']);
			exit();
		}
		else if(self::$route_url!==self::$browser_url && self::$route_url=='/*'){
			pageUrl('/*');	
			self::$req = new Request();
			self::$res = new Response();	
			return true;
		}

	}

	// ----------SET-METHOD------------
	public static function setMethod(){
		self::$method = $_SERVER['REQUEST_METHOD'];
		return self::$method;
	}

	// ----------GET------------
	public static function get($route_arr, $callback1, $callback2=false){
		if(self::setMethod() == 'GET'){
			self::run($route_arr, $callback1, $callback2);
		}
	}

	// ----------POST------------
	public static function post($route_arr, $callback1, $callback2=false){
		if(self::setMethod() == 'POST'){
			self::run($route_arr, $callback1, $callback2);
		}
	}

	// ----------PATCH------------
	public static function patch($route_arr, $callback1, $callback2=false){
		if(self::setMethod() == 'PATCH'){
			self::run($route_arr, $callback1, $callback2);
		}
	}

	// ----------PUT------------
	public static function put($route_arr, $callback1, $callback2=false){
		if(self::setMethod() == 'PUT'){
			self::run($route_arr, $callback1, $callback2);
		}
	}
	
	// ----------DELETE------------
	public static function delete($route_arr, $callback1, $callback2=false){
		if(self::setMethod() == 'DELETE'){
			self::run($route_arr, $callback1, $callback2);
		}
	}

	// ----------RUN METHOD (CALL A CONTROLLER & MIDDLEWARE)------------
	public static function run($route_arr, $callback1, $callback2){
		if(self::splitUrl($route_arr)){
			if($callback2!=false){
				$middleware = $callback1;
				$controller = $callback2;
				if(call_user_func($middleware)){
					call_user_func_array($controller, [self::$req, self::$res]);
					exit();
				}
			}
			else{
				$controller = $callback1;
				call_user_func_array($controller, [self::$req, self::$res]);
				exit();
			}
		}
	}

}