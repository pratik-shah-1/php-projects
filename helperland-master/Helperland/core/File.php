<?php

namespace core;


class File{

	public static function upload($file, $path){		

		$path = trim($path, '/');

		$uploadPath = STORAGE_PATH.$path;

		$fileName = strtolower(time().date('ymd').$file['name']);	

		if(!file_exists($uploadPath)){
			// CREATE A UPLOAD PATH DIRECTORY...
			mkdir($uploadPath, 0777, true);
		}

		$source = $file['tmp_name'];
		$destination = $uploadPath.'/'.$fileName;

		if(move_uploaded_file($source, $destination)){
			return $path.'/'.$fileName;
		}

	}

}