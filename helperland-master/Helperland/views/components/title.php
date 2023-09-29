<?php

	function title(){
		$title = 'Helperland';
		switch(pageUrl()){
			case '/' :
				$title = 'Helperland'; 
				break;
			case '/faqs' :
				$title = 'FAQs'; 
				break;
			case '/prices' :
				$title = 'Prices'; 
				break;
			case '/contact' :
				$title = 'Contact'; 
				break;
			case '/about' :
				$title = 'About'; 
				break;
			case '/service-provider/signup' :
				$title = 'Service Provider Signup'; 
				break;
			case '/customer/signup' :
				$title = 'Customer Signup'; 
				break;
			case '/book-now' :
				$title = 'Book Now'; 
				break;
			case '/guarantee' :
				$title = 'Our Gurantee'; 
				break;
			case '/customer/dashboard' :
				$title = 'Customer Dashboard'; 
				break;
			case '/service-provider/dashboard' :
				$title = 'Service-Provider Dashboard'; 
				break;
			case '/admin/dashboard' :
				$title = 'Admin Dashboard'; 
				break;
		}
		echo $title;
	}