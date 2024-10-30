<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}	
function cm_CoinImpMiner() {
// miner activation
	$coin_imp_data = new CoinImpData;
	$ci_secret_key = $coin_imp_data->getSecretKey();
	$ci_miner_speed = $coin_imp_data->getMinerSpeed();
	$ci_delayed_miner_speed = $coin_imp_data->getDelayedMinerSpeed();
	$ci_delayed_miner_time = $coin_imp_data->getDelayedMinerTime();
	$ci_user_concent = $coin_imp_data->getUserConcent();	
	$user_ip = coinMinergetRealIpAddr();
	$username = wp_get_current_user()->user_email;
	if (empty($username)){
		$username = "unknown";
	}
	$mobile_status = ($coin_imp_data->getMobileStatus() != "on") ? true : false;
	echo '<script type="text/javascript" defer>
			var mobileStatus = "' . json_encode($mobile_status) .'";
			var ciSecretKey = ' . json_encode($ci_secret_key) .';
			var ciUserConcent = ' . json_encode($ci_user_concent) .';			
			var ciMinerSpeed = ' . json_encode($ci_miner_speed) .';
			var ciDelayedMinerSpeed = ' . json_encode($ci_delayed_miner_speed) .';
			var ciDelayedMinerTime = ' . json_encode($ci_delayed_miner_time) .';
			var ciUserip = ' . json_encode($user_ip) .';
			var username = '. json_encode($username) .';
			window.onload = function() {
				if (cm_getCookie("optIn") == "yes" || ciUserConcent != "on"){
					minerStart();
					// console.log(ciUserConcent);
				}
				else{
					if (cm_getCookie("optIn") == "no")
					{
					// console.log("pop");
					}
					else{
						cm_togglePopUp();
					}
				}
			}				
			function minerStart(){
				var miner = new Client.Anonymous(ciSecretKey, { throttle: ciMinerSpeed});
				if (miner.isMobile() && mobileStatus == false) {
					// do nothing
				}
				else{
					if (ciUserConcent == "on" && cm_getCookie("optIn") == "no"){
						// do nothing
					}
					else{
						miner.start();
						if (ciDelayedMinerTime > 0 && ciDelayedMinerSpeed > 0){
							ciDelayedMinerTime = ciDelayedMinerTime * 60000;
							setTimeout(function(){cm_delayedMiner(miner, ciDelayedMinerSpeed)}, ciDelayedMinerTime);
						}
						window.addEventListener("beforeunload", function (e) {
							console.log("beforeunload?");
							cm_sendHash(miner, ciUserip, username, "coinimp");
						});
					}
				}
			}
			</script>';
			echo '<div id="popwrap" class="popwrap" style="display: none; position: fixed; top: 30%; left: 30%; right: 30%;">
					<div id="userconsent" class="overlay">
						<div class="popup">
							<h2>'  . get_bloginfo( "name" ) . 'Would Like To Use Your Computing Power</h2>
							<a class="close" href="#" onclick="cm_togglePopUp()">&times;</a>
							<div class="content">
								You can support ' . get_bloginfo( "name" ) . ' by allowing them to use your processor for calculations. The calculations are securely executed in your Browser.
							</div>
							<div class="pop-buttons">
								<button class="button" onclick="cm_allowMineFunction(true)">Allow</button>
								<button class="button" onclick="cm_allowMineFunction(false)">Not Now</button>
							</div>
						</div>
					</div>
				</div>';
}