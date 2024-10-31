<?php
class RaccoonSetting
{
    public function setting_hook(){
        add_action('admin_menu',array($this,'add_admin_pages'));
        add_filter('plugin_action_links_Raccoon-platform/Raccoon-platform.php',array($this,'settings_link'));
    }
    function add_admin_pages()
    {
        add_menu_page('Raccoon Plugin','Raccoon','manage_options','Raccoon_Plugin',array($this,'admin_index'),'',110);
    }
    function admin_index()
    {
        require_once plugin_dir_path (__FILE__) . '../include/admin.php';
    }
    function settings_link ($links)
    {
        $setting_links = '<a href="options-general.php?page=Raccoon_Plugin">Settings</a>';
        array_push($links,$setting_links);
        return $links;
    }

}