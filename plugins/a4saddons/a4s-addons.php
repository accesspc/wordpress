<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.reiciunas.lt
 * @since             1.1.0
 * @package           A4s-Addons
 *
 * @wordpress-plugin
 * Plugin Name:       A4s Addons
 * Plugin URI:        http://www.reiciunas.lt/plugins/a4s-addons
 * Description:       A pack of widgets and other stuff
 * Version:           1.4.0
 * Author:            Robertas Reiciunas
 * Author URI:        http://www.reiciunas.lt/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       a4s-addons
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die( 'No script kiddies please!' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-a4s-addons-activator.php
 */
function activate_a4s_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-a4s-addons-activator.php';
	a4s_addons_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-a4s-addons-deactivator.php
 */
function deactivate_a4s_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-a4s-addons-deactivator.php';
	a4s_addons_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_a4s_addons' );
register_deactivation_hook( __FILE__, 'deactivate_a4s_addons' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-a4s-addons.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_a4s_addons() {
	
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	
	$plugin_data = array();
	if ( is_admin() && function_exists('get_plugin_data') ) {
		$plugin_data = get_plugin_data( __FILE__ );
	}
	
	$plugin = new a4s_addons($plugin_data);
	$plugin->run();

}
run_a4s_addons();
