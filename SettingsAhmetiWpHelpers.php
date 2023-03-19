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
                       value="<?php esc_attr_e('Save'); ?>"/>
            </form>
        </div>
        <?php
    }

    public function registerSettings()
    {
        register_setting($this->key('options'), $this->key('options'), [$this, 'validateSettings']);
        add_settings_section('settings', null, [$this, 'settingTitle'], $this->slug());

        add_settings_field($this->key('disable_api'), 'Disable Api', [
            $this,
            'settingDisableApi'
        ], $this->slug(), 'settings');
    }

    public function validateSettings($input)
    {
        $newinput['disable_api'] = $input['disable_api'] == 1 ? true : false;

        return $newinput;
    }

    public function settingTitle()
    {
        echo '<h1>'.$this->title().'</h1>';
    }

    public function settingDisableApi()
    {
        $value = $this->getOption('disable_api');

        echo '<select name="'.$this->key('options[disable_api]').'">'.
             '<option value="0">No</option>'.
             '<option value="1"'.($value ? ' selected' : '').'>Yes</option>'.
             '</select>';
    }
}