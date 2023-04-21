<div id="socialBookmarkingServiceSettings">
    <div class="field">
        <div class="two columns alpha">
            <?php echo get_view()->formLabel(SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION, 'Add to Items'); ?>
        </div>
        <div class="inputs five columns omega">
            <?php echo get_view()->formCheckbox(
                SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION,
                true,
                array('checked' => (boolean) get_option(SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION))); ?>
            <p class="explanation"><?php echo __(
                'If checked, this plugin will add a social bookmarking toolbar at the bottom of every public item show page.'
            ); ?></p>
        </div>
    </div>

    <div class="field">
        <div class="two columns alpha">
            <?php echo get_view()->formLabel(SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION, 'Add to Collections'); ?>
        </div>
        <div class="inputs five columns omega">
            <?php echo get_view()->formCheckbox(
                SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION,
                true,
                array('checked' => (boolean) get_option(SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION))); ?>
            <p class="explanation"><?php echo __(
                'If checked, this plugin will add a social bookmarking toolbar at the bottom of every public collection show page.'
            ); ?></p>
        </div>
    </div>

    <div class="field">
        <div class="two columns alpha">
            <p><?php echo __('Choose which social bookmarking services you would like to use on your site.'); ?></p>
        </div>

        <div class="inputs five columns omega">
        <ul style="list-style-type:none" class="details">
        <?php
            $services = array('facebook' => __('Facebook'), 'twitter' => __('Twitter'), 'tumblr' => __('Tumblr'), 'pinterest_share' => __('Pinterest'), 'email' => __('Email'));
            $serviceSettings = social_bookmarking_get_service_settings();
            foreach($services as $serviceCode => $serviceName):
                if (array_key_exists($serviceCode, $serviceSettings)) {
                    $value = $serviceSettings[$serviceCode];
                } else {
                    $value = false;
                }
        ?>
            <li>
            <label>
            <?php echo get_view()->formCheckbox($serviceCode, true, array('checked'=>(boolean)$value)); ?>
            <?php echo html_escape($serviceName); ?>
            </label>
            </li>
        <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
