<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://codeixer.com
 * @since             1.0.0
 * @package           Wc_Mmqty
 *
 * @wordpress-plugin
 * Plugin Name:       CI WooCommerce Minimum Maximum Quantity & Step Control 
 * Plugin URI:        http://codeixer.com/wcmmqty
 * Description:       This plugin allow you to setup limits for your shop products 
 * Version:           1.0.0
 * Author:            codeixer
 * Author URI:        http://codeixer.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-mmqty
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

define( 'WC_MMQTY_VERSION', '1.0.0' );
define( 'WC_MMQTY_INC', plugin_dir_path( __FILE__ ) . 'inc/');
define( 'WC_MMQTY_ROOT', plugin_dir_path( __FILE__ ) .'');



//---------------------------------------------------------------------
// Add setting API
//---------------------------------------------------------------------

require_once plugin_dir_path(__FILE__) . '/inc/class.settings-api.php';

//---------------------------------------------------------------------
// Plugin Options
//---------------------------------------------------------------------

require_once plugin_dir_path(__FILE__) . '/inc/options.php';

new wcmmqty_Settings_API();

function wc_mmqty_option( $option, $section = 'wcmmqty_settings', $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}


class WC_MMQTY{

	function __construct() {
		
		add_action('plugins_loaded',array($this,'load_plugin_code'));
    add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) ); 
   
		
    }

   


    function load_plugin_code(){

    require_once WC_MMQTY_INC . 'wc-mmqty-public.php';
    require_once WC_MMQTY_INC . 'wc-mmqty-admin.php';

    }
    

    function load_textdomain() {
		load_plugin_textdomain( 'wc-mmqty', false, plugin_dir_url( __FILE__ ) . "/languages" );
	}
}

new WC_MMQTY();
