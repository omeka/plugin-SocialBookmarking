<?php

define('SOCIAL_BOOKMARKING_VERSION', 0.2);

add_plugin_hook('install', 'social_bookmarking_install');
add_plugin_hook('uninstall', 'social_bookmarking_uninstall');
add_plugin_hook('config', 'social_bookmarking_config');
add_plugin_hook('config_form', 'social_bookmarking_config_form');
add_plugin_hook('public_append_to_items_show', 'social_bookmarking_append_to_item');

function social_bookmarking_install() 
{
	$social_bookmarking_services = array(
	'delicious' 		=> 	true,
	'digg' 				=> 	true,
	'furl' 				=> 	true,
	'blinklist'			=>	false,
	'reddit'			=> 	true,
	'feed_me'			=>	false,
	'technorati'		=>	true,
	'yahoo'				=>	true,
	'newsvine'			=>	true,
	'socializer'		=>	false,
	'magnolia'			=>	false,
	'stumbleupon'		=>	false,
	'google'			=>	false,
	'rawsugar'			=>	false,
	'squidoo'			=>	false,
	'blinkbits'			=>	false,
	'netvouz'			=>	false,
	'rojo'				=>	false,
	'blogmarks'			=>	false,
	'simpy'				=>	false,
	'comments'			=>	false,
	'scuttle'			=>	false,
	'bloglines'			=>	false,
	'tailrank'			=>	false,
	'scoopeo'			=>	false,
	'blogmemes'			=>	false,
	'blogspherenews'	=>	false,
	'blogsvine'			=>	false,
	'mixx'				=>	false,
	'netscape'			=>	false,
	'ask'				=>	false,
	'linkagogo'			=>	false,
	'delirious'			=>	false,
	'socialdust'		=>	false,
	'live'				=>	false,
	'slashdot'			=>	false,
	'sphinn'			=>	false,
	'facebook'			=>	false,
	'myspace'			=>	false,
	'connotea'			=>	false,
	'misterwong'		=>	false,
	'barrapunto'		=>	false,
	'twitter'			=>	false,
	'indianpad'			=>	false,
	'bluedot'			=>	false,
	'segnalo'			=>	false,
	'oknotizie'			=>	false,
	'diggita'			=>	false,
	'seotribu'			=>	false,
	'upnews'			=>	false,
	'wikio'				=>	false,
	'notizieflash'		=>	false,
	'kipapa'			=>	false,
	'fai_informazione'	=>	false,
	'bookmark_it'		=>	false,
	'ziczac'			=>	false,
	'plim'				=>	false,
	'technotizie'		=>	false,
	'diggitsport'		=>	false,
	'sbr'				=>	false
	);
	
	set_option('social_bookmarking_version', SOCIAL_BOOKMARKING_VERSION);
	set_option('social_bookmarking_services', serialize($social_bookmarking_services));	
}

function social_bookmarking_uninstall()
{
	delete_option('social_bookmarking_version');
	delete_option('social_bookmarking_services');
}

function social_bookmarking_config() 
{
	$social_bookmarking_services = social_bookmarking_get_services();
	
	unset($_POST['install_plugin']);
		
	$foo = serialize($_POST);
	
	set_option('social_bookmarking_services', $foo);

}

function social_bookmarking_config_form() 
{
    include 'config_form.php';
}

function social_bookmarking_append_to_item()
{
    $item = get_current_item();
    
echo '<h2>Social Bookmarking</h2>';
$social_bookmarking_services = social_bookmarking_get_services();
	foreach($social_bookmarking_services as $service => $value) {
		if ($value == false) continue;
		$site = social_bookmarking_get_service_props($service);
		$target_href = str_replace('{title}', item('Dublin Core', 'Title'), $site->url);
		$target_href = str_replace('{link}', abs_uri('items/show/'.item('ID')), $target_href);
		
		$image = img($site->img);
		
        $target_url = '<a class="social_img" href="'.$target_href.'" title="'.$site['name'].'"><img src="'.$image.'" /></a>';
        echo $target_url;
	}
}

function social_bookmarking_get_services() 
{
	$services = unserialize(get_option('social_bookmarking_services'));
	return $services;
}

function social_bookmarking_get_service_props($service)
{
    $file = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'services.xml');
    $xml = new SimpleXMLElement($file);
    foreach ($xml->site as $site) {
        if ($site->key != $service) continue;
        return $site;
    }
}