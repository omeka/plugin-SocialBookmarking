<div id="socialBookmarkingServiceSettings">
    <div class="field">
        <div class="two columns alpha">
            <?php echo get_view()->formLabel(SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION, __('Add to Items')); ?>
        </div>
        <div class="inputs five columns omega">
            <p class="explanation"><?php echo __(
                'Add social bookmarking links at the bottom of public item show pages.'
            ); ?></p>
            <?php echo get_view()->formCheckbox(
                SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION,
                true,
                array('checked' => (boolean) get_option(SocialBookmarkingPlugin::ADD_TO_OMEKA_ITEMS_OPTION))); ?>
        </div>
    </div>

    <div class="field">
        <div class="two columns alpha">
            <?php echo get_view()->formLabel(SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION, __('Add to Collections')); ?>
        </div>
        <div class="inputs five columns omega">
            <p class="explanation"><?php echo __(
                'Add social bookmarking links at the bottom of public collection show pages.'
            ); ?></p>
            <?php echo get_view()->formCheckbox(
                SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION,
                true,
                array('checked' => (boolean) get_option(SocialBookmarkingPlugin::ADD_TO_OMEKA_COLLECTIONS_OPTION))); ?>
        </div>
    </div>

    <div class="field">
        <fieldset>
        <div class="two columns alpha">
            <legend style="line-height: 1.5"><?php echo __('Services'); ?></legend>
        </div>

        <div class="inputs five columns omega">
            <p class="explanation"><?php echo __('Choose which social bookmarking services to show.'); ?></p>
            <?php
            $services = array('facebook' => __('Facebook'), 'twitter' => __('Twitter'), 'tumblr' => __('Tumblr'), 'email' => __('Email'));
            $serviceSettings = social_bookmarking_get_service_settings();
            foreach($services as $serviceCode => $serviceName):
                if (array_key_exists($serviceCode, $serviceSettings)) {
                    $value = $serviceSettings[$serviceCode];
                } else {
                    $value = false;
                }
            ?>
            <label>
            <?php echo get_view()->formCheckbox($serviceCode, true, array('checked'=>(boolean)$value)); ?>
            <?php echo html_escape($serviceName); ?>
            </label>
            <?php endforeach; ?>
        </div>
    </div>
</div>
