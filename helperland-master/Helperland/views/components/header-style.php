<?php

    $home_header_id = '';
    $home_header_style = '';
    $home_header_logo_style = '';
    $home_focus_btn = '';
    $active_link = ['contact' => '', 
                    'prices' => '', 
                    'guarantee' => '', 
                    'blog'=> ''];

    switch(pageUrl()){
        case '/':
            $home_header_id = 'home_navbar';
            $home_header_style = 'background-color:transparent;height:130px';
            $home_header_logo_style = 'width:175px; height:130px;';
            $home_focus_btn = 'transparent';
            break;
        case '/service-provider/signup':
            $home_header_id = 'home_navbar';
            $home_header_style = 'background-color:transparent;height:130px';
            $home_header_logo_style = 'width:175px; height:130px;';
            $home_focus_btn = 'transparent';
            break;			
        case '/prices':
            $active_link['prices'] = 'navbar_focus_btn transparent';
            break;
        case '/contact':
            $active_link['contact'] = 'navbar_focus_btn transparent';
            break;
        case '/blog':
            $active_link['blog'] = 'navbar_focus_btn transparent';
            break;
        case '/guarantee':
            $active_link['guarantee'] = 'navbar_focus_btn transparent';
            break;
    }
