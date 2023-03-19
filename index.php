<?php

/**
 * Plugin Name
 *
 * @package           AhmetiWpHelpers
 * @author            Ahmet Imamoglu
 * @license           MIT
 *
 * @wordpress-plugin
 * Plugin Name:       Ahmeti WP Helpers
 * Plugin URI:        https://ahmeti.com.tr/
 * Description:       Ahmet WP Helpers
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.1
 * Author:            Ahmet Imamoglu
 * Author URI:        https://ahmeti.com.tr/
 */

if ( ! defined('ABSPATH')) {
    exit();
}

class AhmetiWpHelpers
{
    const DISABLE_REST_API = 'disable_rest_api';

    private $title = 'Ahmeti WP Helpers';
    private $slug = 'ahmeti-wp-helpers';
    private $key = 'ahmeti_wp_helpers';
    private $options = null;

    public function init()
    {
        $this->setOptions();

        if (is_admin()) {
            require_once(__DIR__.DIRECTORY_SEPARATOR.'SettingsAhmetiWpHelpers.php');
            new SettingsAhmetiWpHelpers();
        }

        $helperDir = __DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR;

        if (isset($this->options[self::DISABLE_REST_API]) && $this->options[self::DISABLE_REST_API]) {
            require_once($helperDir.'DisableRestApiAhmetiWpHelpers.php');
            new DisableRestApiAhmetiWpHelpers();
        }
    }

    public function title()
    {
        return $this->title;
    }

    public function slug($text = null)
    {
        return $this->slug.(empty($text) ? '' : '_'.$text);
    }

    public function key($text = null)
    {
        return $this->key.(empty($text) ? '' : '_'.$text);
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