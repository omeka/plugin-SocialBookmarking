<?php
/**
 * Social Bookmarking
 *
 * @copyright Copyright 2008-2013 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

define('SOCIAL_BOOKMARKING_VERSION', get_plugin_ini('SocialBookmarking', 'version'));

require_once dirname(__FILE__) . '/helpers/SocialBookmarkingFunctions.php';

/**
 * Social Bookmarking plugin.
 */
class SocialBookmarkingPlugin extends Omeka_Plugin_AbstractPlugin
{	
    /**
     * @var array Hooks for the plugin.
     */
    protected $_hooks = array('install', 
							  'uninstall', 
							  'upgrade',
							  'initialize',
							  'config_form',
							  'config',
							  'public_items_show');

    /**
     * @var array Options and their default values.
     */
    protected $_options = array(
        'social_bookmarking_version' => SOCIAL_BOOKMARKING_VERSION,
		'social_bookmarking_services' => '',
    );

    /**
     * Install the plugin.
     */
    public function hookInstall()
    {
		$socialBookmarkingServices = array(
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
		'stumbleupon'		=>	false,
		'google'			=>	true,
		'squidoo'			=>	false,
		'netvouz'			=>	false,
		'blogmarks'			=>	false,
		'comments'			=>	false,
		'bloglines'			=>	false,
		'scoopeo'			=>	false,
		'blogmemes'			=>	false,
		'blogspherenews'	=>	false,
		'blogsvine'			=>	false,
		'mixx'				=>	false,
		'netscape'			=>	false,
		'ask'				=>	false,
		'linkagogo'			=>	false,
		'socialdust'		=>	false,
		'live'				=>	false,
		'slashdot'			=>	false,
		'sphinn'			=>	false,
		'facebook'			=>	true,
		'myspace'			=>	false,
		'connotea'			=>	false,
		'misterwong'		=>	false,
		'barrapunto'		=>	false,
		'twitter'			=>	false,
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
		'diggitsport'		=>	false
		);
		
		$this->_options['social_bookmarking_services'] =  serialize($socialBookmarkingServices);

        $this->_installOptions();
    }

    /**
     * Uninstall the plugin.
     */
    public function hookUninstall()
    {
        $this->_uninstallOptions();
    }

    /**
     * Upgrade the plugin.
     *
     * @param array $args contains: 'old_version' and 'new_version'
     */
    public function hookUpgrade($args)
    {
        $oldVersion = $args['old_version'];
        $newVersion = $args['new_version'];
	    if (version_compare($oldVersion, '1.0.1', '<=')) {
	        $servicesToRemove = array(
	                            'blinkbits', 
	                            'bluedot',
	                            'delirious',
	                            'healthranker',
	                            'indianpad',
	                            'leonaut',
	                            'magnolia', 
	                            'rawsugar',
	                            'rojo',
	                            'scuttle',
	                            'simpy',
	                            'tailrank'
	                            );

	        $currentServices = social_bookmarking_get_services();
	        foreach ($servicesToRemove as $remove) {
	            unset($currentServices[$remove]);
	        }
	        $newServices = serialize($currentServices);
	        set_option('social_bookmarking_services', $newServices);
	    }
    }

    /**
     * Add the translations.
     */
    public function hookInitialize()
    {
        add_translation_source(dirname(__FILE__) . '/languages');
    }

    /**
     * Display the plugin config form.
     */
    public function hookConfigForm()
    {
        require dirname(__FILE__) . '/config_form.php';
    }

    /**
     * Set the options from the config form input.
     */
    public function hookConfig()
    {
		$socialBookmarkingServices = social_bookmarking_get_services();
		unset($_POST['install_plugin']);
		$foo = serialize($_POST);
		set_option('social_bookmarking_services', $foo);
    }

	public function hookPublicItemsShow()
	{		
		$item = get_current_record('item');
	    echo '<h2>' . __('Social Bookmarking') . '</h2>';
	    $socialBookmarkingServices = social_bookmarking_get_services();		
		foreach ($socialBookmarkingServices as $service => $value) {
			if ($value == false) continue;
			$site = social_bookmarking_get_service_props($service);
			$targetHref = str_replace('{title}', urlencode(strip_formatting(metadata($item, array('Dublin Core', 'Title')))), $site->url);
			$targetHref = str_replace('{link}', record_url($item, 'show', true), $targetHref);
			$image = img($site->img);
	        $serviceIcon = '<a class="social-img" href="'.$targetHref.'" title="'.$site['name'].'"><img src="'.$image.'" /></a>';
	        echo $serviceIcon;
		}
	}
}
