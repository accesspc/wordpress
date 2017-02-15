<?php

/**
 * @link              http://www.reiciunas.lt
 * @since             1.0.0
 * @package           A4s-Forms
 *
 * @wordpress-plugin
 * Plugin Name:       A4s Forms
 * Plugin URI:        http://www.reiciunas.lt/plugins/a4s-forms
 * Description:       Forms
 * Version:           1.0.1
 * Author:            Robertas Reiciunas
 * Author URI:        http://www.reiciunas.lt/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       a4sforms
 * Domain Path:       /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-a4sforms-activator.php
 */
function activate_a4sforms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-a4sforms-activator.php';
	A4sForms_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_a4sforms' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-a4sforms-deactivator.php
 */
function deactivate_a4sforms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-a4sforms-deactivator.php';
	A4sForms_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_a4sforms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-a4sforms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_a4sforms() {

	$plugin = new A4sForms();
	$plugin->run();

}
run_a4sforms();
