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
 * Version:           1.0.0
 * Author:            Robertas Reiciunas
 * Author URI:        http://www.reiciunas.lt/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       a4sforms
 * Domain Path:       /languages/
 */

/*
A4s Forms is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
A4s Forms is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with A4s Forms. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die( 'No script kiddies please!' );
}

function a4sforms_setup_post_types() {
	register_post_type(
		'a4sforms',
		['public' => 'true']
	);
}
add_action('init', 'a4sforms_setup_post_types');

function a4sforms_install() {
	a4sforms_setup_post_types();
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'a4sforms_install');

function a4sforms_deactivation() {
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'a4sforms_deactivation');

if (!class_exists('A4sForms')) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-a4sforms.php';
	
}








