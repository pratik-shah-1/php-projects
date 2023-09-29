<?php

	$pageUrl = '/';

	// ----------STORE & RETURN CURRENT URL----------
	function pageUrl($url=false){
		global $pageUrl;
		if($url!=false){
			$pageUrl = $url;
		}
		else{
			return $pageUrl;
		}
	}

	// ----------ANCHOR TAG----------
	function url($path){
		$path = trim($path, '/');
		return BASE_URL.'/'.$path;
	}

	// ----------PUBLIC FOLDER as ASSETS----------
	function assets($path){
		$path = ltrim($path, '/');
		return BASE_URL.'/'.$path.'?'.time();
		//APPEND TIME END OF FILE, BECAUSE FILE NOT REFLECTING AFTER CHANGING IN IT
	}

	// ----------COMPONENTS----------
	function component($parameter1, $parameter2=false){

		if($parameter2!=false){
			// WE CAN CHANGE THE COMPONENT PATH IN VIEWS Directory...
			$path = $parameter1;
			$name = $parameter2;
			$path = trim($path, '/');
			$name = trim($name, '/');
			$component_path = __DIR__.'/../views/'.$path.'/'.$name.'.php';
			if(file_exists($component_path)){
				require_once $component_path;							
			}
		}
		else{
			// BY DEFAULT ALL COMPOENTS LOADED FROM VIEWS/COMPONENTS/...
			$name = $parameter1;
			$name = trim($name, '/');
			$component_path = __DIR__.'/../views/components/'.$name.'.php';
			if(file_exists($component_path)){
				require_once $component_path;							
			}
		}
	}

	// ----------SESSION FUNCTION----------
	function session($key, $value=false){
		if($value!=false){
			$_SESSION[$key] = $value;
		}
		else if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}
		else{
			return false;
		}
	}

	// ----------FLASH SESSION----------
	function flashSession($key, $value=false){
		if($value!=false){
			$_SESSION[$key] = $value;
		}
		else if(isset($_SESSION[$key])){
			$sessionVal = $_SESSION[$key];
			unset($_SESSION[$key]);
			return $sessionVal;
		}
		else{
			return false;
		}
	}

	// ----------COOKIE----------
	function cookie($key, $value=false, $time=false){
		if($value!=false){
			// 5 DAYS TIME...
			if($time==false){
				$time = time()+(60*60*24*5);
			}
			setcookie($key, $value, $time, '/', '', true, true);
		}
		else if(isset($_COOKIE[$key])){
			return $_COOKIE[$key];
		}
		else{
			return false;
		}
	}

	// ----------CSRF_TOKEN----------
	function csrfToken(){
		$token = bin2hex(random_bytes(16));
		setcookie('X-CSRF-TOKEN', $token, time()+(60*60*24*0.5), '/', '', false, false);
		$_SESSION['X-CSRF-TOKEN'] = $token;
		return $token;		
		/**
		 * For Getting $_COOKIE value we need to refresh the page
		 * setcookie('KEY','VALUE') & $_COOKIE['KEY'] both are not working on same page.
		 * $_COOKIE['KEY'] NOT REFLECTED IMIDIATLY THAT'S WHY WE USE $_SESSION['KEY']
		 */
	}


