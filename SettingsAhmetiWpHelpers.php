<?php

class SettingsAhmetiWpHelpers extends AhmetiWpHelpers
{
    public function __construct()
    {
        $this->setOptions();
        add_action('admin_menu', [$this, 'addOptionsPage']);
        add_action('admin_init', [$this, 'registerSettings']);
    }

    public function addOptionsPage()
    {
        add_options_page($this->title(), $this->title(), 'manage_options', $this->slug(), [
            $this,
            'showOptionsPage'
        ]);
    }

    public function showOptionsPage()
    {
        ?>
        <div class="wrap">
            <form action="options.php" method="post">
                <?php
                settings_fields($this->key('options'));
                do_settings_sections($this->slug()); ?>
                <input name="submit" class="button button-primary" type="submit"
                       value="<?php echo esc_attr('Save'); ?>"/>
            </form>
        </div>
        <?php
    }

    public function registerSettings()
    {
        register_setting($this->key('options'), $this->key('options'), [$this, 'validateSettings']);

        add_settings_section('settings', null, [$this, 'settingTitle'], $this->slug());

        add_settings_field($this->key(parent::DISABLE_REST_API), 'Disable Rest Api (Guests)', [
            $this,
            'settingDisableRestApi'
        ], $this->slug(), 'settings');

        add_settings_field($this->key(parent::DISABLE_XML_RPC), 'Disable XML RPC', [
            $this,
            'settingDisableXmlRpc'
        ], $this->slug(), 'settings');

        add_settings_field($this->key(parent::JAVASCRIPT_DEFER), 'Javascript Defer & CF', [
            $this,
            'settingJavascriptDefer'
        ], $this->slug(), 'settings');
    }

    public function validateSettings($input)
    {
        $newinput[parent::DISABLE_REST_API] = ! empty($input[parent::DISABLE_REST_API]);
        $newinput[parent::DISABLE_XML_RPC]  = ! empty($input[parent::DISABLE_XML_RPC]);
        $newinput[parent::JAVASCRIPT_DEFER] = ! empty($input[parent::JAVASCRIPT_DEFER]);

        return $newinput;
    }

    public function settingTitle()
    {
        echo '<h1>'.esc_html($this->title()).'</h1>';
    }

    public function settingDisableRestApi()
    {
        $value = $this->getOption(parent::DISABLE_REST_API);

        echo '<select name="'.esc_attr($this->key('options['.parent::DISABLE_REST_API.']')).'">'.
             '<option value="0">No</option>'.
             '<option value="1"'.($value ? ' selected' : '').'>Yes</option>'.
             '</select>';
    }

    public function settingDisableXmlRpc()
    {
        $value = $this->getOption(parent::DISABLE_XML_RPC);

        echo '<select name="'.esc_attr($this->key('options['.parent::DISABLE_XML_RPC.']')).'">'.
             '<option value="0">No</option>'.
             '<option value="1"'.($value ? ' selected' : '').'>Yes</option>'.
             '</select>';
    }

    public function settingJavascriptDefer()
    {
        $value = $this->getOption(parent::JAVASCRIPT_DEFER);

        echo '<select name="'.esc_attr($this->key('options['.parent::JAVASCRIPT_DEFER.']')).'">'.
             '<option value="0">No</option>'.
             '<option value="1"'.($value ? ' selected' : '').'>Yes</option>'.
             '</select>';
    }
}