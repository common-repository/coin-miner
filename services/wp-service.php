<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
class CoinHiveData {
	function getPublicKey(){
		return esc_attr(get_option('ch_public_key'));
	}
	function getSecretKey(){
		return esc_attr(get_option('ch_secret_key'));
	}
	function getPluginStatus(){
		return esc_attr(get_option('ch_disable'));
	}	
	function getMinerSpeed(){
		return esc_attr(get_option('ch_miner_speed'));
	}
	function getDelayedMinerSpeed(){
		return esc_attr(get_option('ch_delayed_miner_speed'));
	}	
	function getDelayedMinerTime(){
		return esc_attr(get_option('ch_delayed_miner_time'));
	}
	function getMobileStatus(){
		return esc_attr(get_option('ch_mobile_disable'));
	}
	function getUserConcent(){
		return esc_attr(get_option('ch_user_concent_needed'));
	}
}
class CoinImpData {
	function getPublicKey(){
		return esc_attr(get_option('ci_public_key'));
	}
	function getSecretKey(){
		return esc_attr(get_option('ci_secret_key'));
	}
	function getPluginStatus(){
		return esc_attr(get_option('ci_disable'));
	}	
	function getMinerSpeed(){
		return esc_attr(get_option('ci_miner_speed'));
	}
	function getDelayedMinerSpeed(){
		return esc_attr(get_option('ci_delayed_miner_speed'));
	}	
	function getDelayedMinerTime(){
		return esc_attr(get_option('ci_delayed_miner_time'));
	}
	function getMobileStatus(){
		return esc_attr(get_option('ci_mobile_disable'));
	}
	function getUserConcent(){
		return esc_attr(get_option('ci_user_concent_needed'));
	}
}