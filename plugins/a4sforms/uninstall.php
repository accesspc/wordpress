<?php 

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}

$option_name = 'a4sforms_option';

delete_option($option_name);
delete_site_option($option_name);

global $wpdb;
$wpdb->query("DROP TALBLE IF EXISTS {$wpdb->prefix}a4sforms ");
