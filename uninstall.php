<?php 
/**
 * Trigger this on Plugin uninstall
 *
 * @package coin-hibe
 */
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
$option_name = 'coin-miner-options';
$ci_option_name = 'coin-miner-options-ci';
 
delete_option($option_name);
delete_option($ci_option_name);

// for site options in Multisite
// delete_site_option($option_name);
 
// drop a custom database table
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "coin_imp");
$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "coin_hive");
