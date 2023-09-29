<?php

    // DATE AND TIME...
    date_default_timezone_set('Asia/Kolkata'); 

    // CHANGE THE SESSION PATH...
    if(!file_exists(SESSION_PATH)){
        mkdir(SESSION_PATH, 0777, true);
    }

    ini_set('session.save_path', SESSION_PATH);
	session_start();
