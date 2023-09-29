<?php

namespace core;

use core\Response;

class Validation{

	// REGEX...
	const TextRegEx = '/^[A-Za-z]/';
	const EmailRegEx = '/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+(\.[a-zA-Z]{2,})+$/';
	const PhoneRegEx = '/^[0-9]{10}$/';
	const PasswordRegEx = '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/';
	const PostalCodeRegEx = '/^[0-9]{5,6}$/';

	// PASSWORD...
	private static $password = '';
	// ERROR ARRAY...
	private static $error = [];


	public static function check($body, $fields){
		// LOOP FOR ALL INPUT FIELDS...
		foreach($fields as $key => $validation){
			if(isset($body->$key)){ //REQUIRED OR REQUIRE VALIDATION DONE HERE...
				// STORE INPUT VALUE IN VARIABLE...
				$value = $body->$key; 
				// TEMP ARRAY [STORING ALL ERROR MESSAGE...]
				$temp[$key] = [];    
				// LOOP FOR ALL VALIDATION FOR SINGLE INPUT FIELDS...
				foreach($validation as $i){
					if($i=='password'){
						self::$password = $body->$key;
					}
					self::checkCriteria($key, $value, $i);
					if(isset(self::$error[$key])){
						array_push($temp[$key], self::$error[$key]);
						self::$error[$key] = null;
					}
				}
				if(count($temp[$key])==1){
					// ASSIGN STRING... [SINGLE ERROR MESSAGE]
					self::$error[$key] = $temp[$key][0];
				}
				else if(count($temp[$key])>1){
					// ASSIGN ARRAY...  [MULTIPULE ERROR MESSAGE]
					self::$error[$key] = $temp[$key];
				}
			}
			else if($validation[0]!='optional'){
				self::$error[$key] = 'Field is required!';
			}
		}
		// PASS RESPONSE ACCORDING TO VALIDATION...
		if(count(self::$error)>0){
			$res = new Response();
			$res->status(400)->json(['message'=>'Validation Error', 'errors'=>self::$error]);
			exit();
		}
	}


	public static function checkCriteria($key, $value, $i){
		if(str_contains($i, 'min:')){
			self::minValidation($key, $value, $i);
		}
		else if(str_contains($i, 'max:')){
			self::maxValidation($key, $value, $i);
		}
		else if(str_contains($i, 'length:')){
			self::lengthValidation($key, $value, $i);
		}
		else{
			switch($i){
				case 'text':
					self::textValidation($key, $value);
					break;
				case 'string':
					self::stringValidation($key, $value);
					break;
				case 'integer':
					self::integerValidation($key, $value);
					break;
				case 'number':
					self::integerValidation($key, $value);
					break;
				case 'array':
					self::arrayValidation($key, $value);
					break;
				case 'object':
					self::objectValidation($key, $value);
					break;
				case 'email':
					self::emailValidation($key, $value);
					break;
				case 'phone':
					self::phoneValidation($key, $value);
					break;
				case 'mobile':
					self::phoneValidation($key, $value);
					break;
				case 'password':
					self::passwordValidation($key, $value);
					break;
				case 'confirm-password':
					self::confirmPasswordValidation($key, $value);
					break;
				case 'postal-code':
					self::postalCodeValidation($key, $value);
					break;	
			}	
		}
	}

	// TEXT VALIDATION...
	public static function textValidation($key, $value){
		if(!preg_match(Validation::TextRegEx, $value)){
			self::$error[$key] = 'Only text allowed !';
			// [ ONLY A-Z]
		}
	}

	// STRING VALIDATION...
	public static function stringValidation($key, $value){
		if(!is_string($value)){
			self::$error[$key] = 'Not a valid string !';
		}
	}

	// INTEGER VALIDATION...
	public static function integerValidation($key, $value){
		if(!is_integer($value)){
			self::$error[$key] = 'Not a valid integer !';
		}	
	}

	// ARRAY VALIDATION...
	public static function arrayValidation($key, $value){
		if(!is_array($value)){
			self::$error[$key] = 'Not a valid array !';
		}	
	}

	// OBJECT VALIDATION...
	public static function objectValidation($key, $value){
		if(!is_object($value)){
			self::$error[$key] = 'Not a valid object !';
		}	
	}

	// MIN VALIDATION...
	public static function minValidation($key, $value, $i){
		if(str_contains($i, 'min:')){
			$min = (int) str_replace('min:', '', $i);
			if(strlen($value) < $min){
				self::$error[$key] = "Minimum {$min} character required !";
			}
		}
	}

	// MAX VALIDATION...
	public static function maxValidation($key, $value, $i){
		if(str_contains($i, 'max:')){
			$max = (int) str_replace('max:', '', $i);
			if(strlen($value) > $max){
				self::$error[$key] = "Maximum {$max} character allowed !";
			}
		}
	}

	// LENGTH VALIDATION...
	public static function lengthValidation($key, $value, $i){
		if(str_contains($i, 'length:')){
			$length = (int) str_replace('length:', '', $i);
			if(strlen($value) != $length){
				self::$error[$key] = "Field value length {$length} characters exact!";
			}
		}
	}

	// EMAIL VALIDATION...
	public static function emailValidation($key, $value){
		if(!preg_match(Validation::EmailRegEx, $value)){
			self::$error[$key] = "Email Address not in valid format !";
		}
	}

	// PHONE VALIDATION...
	public static function phoneValidation($key, $value){
		if(!preg_match(Validation::PhoneRegEx, $value)){
			self::$error[$key] = "Phone Number not in valid format !";
		}
	}

	// PASSWORD VALIDATION...
	public static function passwordValidation($key, $value){
		// STORE THE PASSWORD FOR VALIDATE CONFIRM PASSWORD...
		self::$password = $value;
		if(!preg_match(Validation::PasswordRegEx, $value)){
			self::$error[$key] = "Password not in valid format !";
		}
	}

	// CONFIRM-PASSWORD VALIDATION...
	public static function confirmPasswordValidation($key, $value){
		if(self::$password!=$value){
			self::$error[$key] = "Confirm Password & Password are not same !";
		}
	}

	// POSTAL-CODE VALIDATION...
	public static function postalCodeValidation($key, $value){
		if(!preg_match(Validation::PostalCodeRegEx, $value)){
			self::$error[$key] = "Postal Code have Minimum 5 or Maximum 6 digits only !";
		}
	}

	
}