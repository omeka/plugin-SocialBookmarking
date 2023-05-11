<?php
/**
 * Social Bookmarking
 *
 * @copyright Copyright 2008-2013 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */


require_once dirname(__FILE__) . '/helpers/SocialBookmarkingFunctions.php';

/**
 * Social Bookmarking plugin.
 */
class SocialBookmarkingPlugin extends Omeka_Plugin_AbstractPlugin
{
    const SERVICE_SETTINGS_OPTION = 'social_bookmarking_services';
    const ADD_TO_OMEKA_ITEMS_OPTION = 'social_bookmarking_add_to_omeka_items';
    const ADD_TO_OMEKA_COLLECTIONS_OPTION = 'social_bookmarking_add_to_omeka_collections';

    /**
     * @var array Hooks for the plugin.
     */
    protected $_hooks = array(
        'install',
        'uninstall',
        'upgrade',
        'initialize',
        'config_form',
        'config',
        'public_head',
        'public_items_show',
        'public_collections_show'
    );

    /**
     * @var array Options and their default values.
     */
    protected $_options = array(
        'social_bookmarking_services' => '',
        'social_bookmarking_add_to_omeka_items' => '1',
        'social_bookmarking_add_to_omeka_collections' => '1',
    );

    /**
     * Install the plugin.
     */
    public function hookInstall()
    {
        $this->_options['social_bookmarking_services'] = serialize(social_bookmarking_get_default_service_settings());
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
        if (version_compare($args['old_version'], '2.1', '<')) {
            $booleanFilter = new Omeka_Filter_Boolean;
            $newServiceSettings = social_bookmarking_get_default_service_settings();
            $oldServiceSettings = social_bookmarking_get_service_settings();
            foreach($newServiceSettings as $serviceCode => $value) {
                if (array_key_exists($serviceCode, $oldServiceSettings)) {
                    $newServiceSettings[$serviceCode] = $booleanFilter->filter($oldServiceSettings[$serviceCode]);
                }
            }
            social_bookmarking_set_service_settings($newServiceSettings);
        }
    }

    /**
     * Add the translations.
     */
    public function hookInitialize()
    {
        add_translation_source(dirname(__FILE__) . '/languages');
    }

    public function hookPublicHead()
    {
        queue_css_file('iconfonts');
        queue_css_file('social-bookmarking');
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
    public function hookConfig($args)
    {
        $post = $args['post'];
        unset($post['install_plugin']);

        set_option(SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION, $post[SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION]);
        unset($post[SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION]);

        set_option(SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION, $post[SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION]);
        unset($post[SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION]);

        $serviceSettings = social_bookmarking_get_service_settings();
        $booleanFilter = new Omeka_Filter_Boolean;
        foreach($post as $key => $value) {
            if (array_key_exists($key, $serviceSettings)) {
                $serviceSettings[$key] = $booleanFilter->filter($value);
            }
        }
        social_bookmarking_set_service_settings($serviceSettings);
    }

    public function hookPublicItemsShow()
    {
        if (get_option(SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION) == '1') {
            $item = get_current_record('item');
            $url = record_url($item, 'show', true);
            $title = strip_formatting(metadata($item, array('Dublin Core', 'Title'), array('no_escape' => true)));
            $description = strip_formatting(metadata($item, array('Dublin Core', 'Description'), array('no_escape' => true)));
            echo social_bookmarking_toolbar($url, $title, $description);
        }
    }

    public function hookPublicCollectionsShow()
    {
        if (get_option(SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION) == '1') {
            $collection = get_current_record('collection');
            $url = record_url($collection, 'show', true);
            $title = strip_formatting(metadata($collection, array('Dublin Core', 'Title'), array('no_escape' => true)));
            $description = strip_formatting(metadata($collection, array('Dublin Core', 'Description'), array('no_escape' => true)));
            echo social_bookmarking_toolbar($url, $title, $description);
        }
    }
}
