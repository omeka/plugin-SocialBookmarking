<?php
/**
 * Social Bookmarking
 *
 * @copyright Copyright 2008-2013 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

function social_bookmarking_get_service_settings()
{
    return unserialize(get_option(SocialBookmarkingPlugin::SERVICE_SETTINGS_OPTION));
}

function social_bookmarking_set_service_settings($serviceSettings)
{
    set_option(SocialBookmarkingPlugin::SERVICE_SETTINGS_OPTION, serialize($serviceSettings));
}

function social_bookmarking_get_default_service_settings()
{
    $serviceSettings = array(
        'facebook' => 1,
        'twitter' => 1,
        'tumblr' => 1,
        'email' => 1,
    );
    return $serviceSettings;
}

function social_bookmarking_toolbar($url, $title, $description='')
{
    $services = social_bookmarking_get_service_settings();
    $html = '';

    $linkFormat = '<a href="%s?%s" class="socialbookmarking-link %s"><span class="icon" aria-hidden="true"></span>%s</a>';

    if (!empty($services['facebook'])) {
        $query = http_build_query(array('u' => $url), '', '&', PHP_QUERY_RFC3986);
        $html .= sprintf($linkFormat, 'https://www.facebook.com/sharer.php', html_escape($query), 'facebook', __('Facebook'));
    }
    if (!empty($services['twitter'])) {
        $query = http_build_query(array('url' => $url), '', '&', PHP_QUERY_RFC3986);
        $html .= sprintf($linkFormat, 'https://twitter.com/share', html_escape($query), 'twitter', __('Twitter'));
    }
    if (!empty($services['tumblr'])) {
        $query = http_build_query(array('url' => $url), '', '&', PHP_QUERY_RFC3986);
        $html .= sprintf($linkFormat, 'https://tumblr.com/share/link', html_escape($query), 'tumblr', __('Tumblr'));
    }
    if (!empty($services['email'])) {
        $query = http_build_query(array('subject' => $title, 'body' => $url), '', '&', PHP_QUERY_RFC3986);
        $html .= sprintf($linkFormat, 'mailto:', html_escape($query), 'email', __('Email'));
    }

    if ($html) {
        $html = '<div class="socialbookmarking-links">'. $html . '</div>';
    }

    return $html;
}
