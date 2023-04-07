<?php

class JavascriptDeferAhmetiWpHelpers
{
    public function __construct()
    {
        add_filter('script_loader_tag', function ($tag, $handle, $src) {

            if (is_admin() || strpos($tag, '.js') === false) {
                return $tag;
            }

            if (strpos($tag, 'jquery.min.js')) {
                parse_str(parse_url($src, PHP_URL_QUERY), $params);
                if (isset($params['ver'])) {
                    $cfSrc = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/'.$params['ver'].'/jquery.min.js';
                    $tag   = str_replace($src, $cfSrc, $tag);
                }
            }

            if (strpos($tag, 'jquery-migrate.min.js')) {
                parse_str(parse_url($src, PHP_URL_QUERY), $params);
                if (isset($params['ver'])) {
                    $cfSrc = 'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/'.$params['ver'].'/jquery-migrate.min.js';
                    $tag   = str_replace($src, $cfSrc, $tag);
                }
            }

            if (strpos($tag, 'underscore.min.js')) {
                parse_str(parse_url($src, PHP_URL_QUERY), $params);
                if (isset($params['ver'])) {
                    $cfSrc = 'https://cdnjs.cloudflare.com/ajax/libs/underscore.js/'.$params['ver'].'/underscore-min.js';
                    $tag   = str_replace($src, $cfSrc, $tag);
                }
            }

            if (strpos($tag, ' defer') !== false) {
                return $tag;
            }

            return str_replace(' src', ' defer src', $tag);

        }, PHP_INT_MAX, 3);
    }
}