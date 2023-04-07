<?php

/**
 * Plugin Name:       Ahmeti WP Helpers
 * Plugin URI:        https://ahmeti.com.tr/ahmeti-wp-helpers
 * Description:       Performance focused, and you can activate some helpers easily.
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.1
 * Author:            Ahmet Imamoglu
 * Author URI:        https://ahmeti.com.tr/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ahmeti-wp-helpers
 */

if ( ! defined('ABSPATH')) {
    exit();
}

class AhmetiWpHelpers
{
    const TITLE = 'Ahmeti WP Helpers';
    const SLUG = 'ahmeti-wp-helpers';
    const KEY = 'ahmeti_wp_helpers';

    const DISABLE_REST_API = 'disable_rest_api';
    const DISABLE_XML_RPC = 'disable_xml_rpc';
    const JAVASCRIPT_DEFER = 'javascript_defer';

    private $options = null;

    public function init()
    {
        $this->setOptions();

        if (is_admin()) {
            require_once __DIR__.DIRECTORY_SEPARATOR.'SettingsAhmetiWpHelpers.php';
            new SettingsAhmetiWpHelpers();
        }

        $helpersDir = __DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR;

        if (isset($this->options[self::DISABLE_REST_API]) && $this->options[self::DISABLE_REST_API]) {
            require_once $helpersDir.'DisableRestApiAhmetiWpHelpers.php';
            new DisableRestApiAhmetiWpHelpers();
        }

        if (isset($this->options[self::DISABLE_XML_RPC]) && $this->options[self::DISABLE_XML_RPC]) {
            require_once $helpersDir.'DisableXmlRpcAhmetiWpHelpers.php';
            new DisableXmlRpcAhmetiWpHelpers();
        }

        if (isset($this->options[self::JAVASCRIPT_DEFER]) && $this->options[self::JAVASCRIPT_DEFER]) {
            require_once $helpersDir.'JavascriptDeferAhmetiWpHelpers.php';
            new JavascriptDeferAhmetiWpHelpers();
        }
    }

    public function title()
    {
        return self::TITLE;
    }

    public function slug($text = null)
    {
        return self::SLUG.(empty($text) ? '' : '_'.$text);
    }

    public function key($text = null)
    {
        return self::KEY.(empty($text) ? '' : '_'.$text);
    }

    protected function setOptions()
    {
        $this->options = get_option($this->key('options'));
    }

    public function getOption($key)
    {
        return $this->options[$key] ?? null;
    }
}

(new AhmetiWpHelpers)->init();