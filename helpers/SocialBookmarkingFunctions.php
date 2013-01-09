<?php
/**
 * Simple Pages
 *
 * @copyright Copyright 2008-2013 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

function social_bookmarking_get_services() 
{
	$services = unserialize(get_option('social_bookmarking_services'));
	ksort($services);
	return $services;
}

function social_bookmarking_get_service_props($service)
{
    static $xml = null;
    if (!$xml) {
        $file = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'services.xml');
        $xml = new SimpleXMLElement($file);
    }
    foreach ($xml->site as $site) {
        if ($site->key != $service) continue;
        return $site;
    }
}