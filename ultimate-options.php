<?php
/*
    Plugin Name: Ultimate Options
    Plugin URI: http://ultimate-sa.com/
    Description: Ultimate Options.
    Version: 1.7.10
    Author: Ultimate Solutions
    Author URI: http://ultimate-sa.com/
    License: GPL2 or later
    Text Domain: uso
*/

if ( ! defined('ABSPATH') ) exit();

//Plugin Version
if ( ! defined( 'USO_VERSION' ) )

    define( 'USO_VERSION' , '1.7.10' );



/* USO Language Folder Loading */
function plugin_load_textdomain()
{
    load_plugin_textdomain('uso', false, basename(dirname(__FILE__)) . '/languages');
}
add_action('init', 'plugin_load_textdomain');


define( 'USO_NAME'  , plugin_basename( __FILE__ ) );
define( 'USO_PATH'  , plugin_dir_path( __FILE__ ) );
define( 'USO_URL'   , plugin_dir_url( __FILE__ ) );

if ( ! function_exists( 'uso_options_activate' ) ) {

    register_activation_hook( __FILE__, 'uso_options_activate' );
    function uso_options_activate()
    {
        uso_change_ultmart_theme_settings();
    }

}

/* Include Files */
include USO_PATH . 'uso-functions.php';
include USO_PATH . 'uso-assets.php';
if(is_admin() && (!wp_doing_ajax())) {
    include USO_PATH . 'uso-admin.php';
}
include USO_PATH . 'uso-frontend.php';


/* Add Settings Link */
if ( ! function_exists( 'uso_options_add_settings_links' ) ) {

    add_filter( 'plugin_action_links_' . USO_NAME, 'uso_options_add_settings_links' );
    function uso_options_add_settings_links ( $links )
    {
        $us_options_links = array(
            '<a href="admin.php?page=pj_ultimate_options">Settings</a>',
        );
        return array_merge( $links, $us_options_links );
    }

}

require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

if ( ! function_exists( 'uso_get_options_github_update' ) ) {
    //add_action('admin_init','uso_get_options_github_update');
    function uso_get_options_github_update()
    {

        // Update Plugin
        global $uso_dev_mode_status;

        $plugin_url = 'https://github.com/ultimate-eg/ultimate-options/';
        if ($uso_dev_mode_status === 'test')
            $plugin_url = 'https://github.com/ultimate-eg/ultimate-options-dev/';

        require 'plugin-update-checker/plugin-update-checker.php';
        $myUpdateChecker = PucFactory::buildUpdateChecker(
            $plugin_url,
            __FILE__,
            'pj-ultimate-options'
        );

        $myUpdateChecker->setAuthentication('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');
        $myUpdateChecker->setBranch('master');

    }
}