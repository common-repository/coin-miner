<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
function coin_miner_plugin_page() {
	if (!current_user_can('administrator')){
	die();
}
	wp_enqueue_style('styleCss');
	wp_enqueue_script( 'cmAmazingScript');
	
	// CoinImp Vars
	$coin_imp_data = new CoinImpData;
	$ci_public_key = $coin_imp_data->getPublicKey();
	$ci_secret_key = $coin_imp_data->getSecretKey();
	$ci_miner_speed = $coin_imp_data->getMinerSpeed();
	$ci_disable_plugin = $coin_imp_data->getPluginStatus();
	$ci_mobile_disable = $coin_imp_data->getMobileStatus();
	$ci_delayed_miner_speed = $coin_imp_data->getDelayedMinerSpeed();
	$ci_delayed_miner_time = $coin_imp_data->getDelayedMinerTime();
	$ci_user_concent = $coin_imp_data->getUserConcent();

	// CoinHive Vars
	$coin_hive_data = new CoinHiveData;
	$ch_public_key = $coin_hive_data->getPublicKey();
	$ch_secret_key = $coin_hive_data->getSecretKey();
	$ch_miner_speed = $coin_hive_data->getMinerSpeed();
	$ch_disable_plugin = $coin_hive_data->getPluginStatus();
	$ch_mobile_disable = $coin_hive_data->getMobileStatus();
	$ch_user_concent = $coin_hive_data->getUserConcent();
	$ch_delayed_miner_speed = $coin_hive_data->getDelayedMinerSpeed();
	$ch_delayed_miner_time = $coin_hive_data->getDelayedMinerTime();
	
	$url = plugins_url( "", dirname(__FILE__) );
?>
<div class="ci-setting-wrap">
	<div class="tab" style="height: 70px;">
		<button class="tablinks" onclick="cm_openTab(event, 'Dashboard')">Dashboard</button>
		<button class="tablinks" onclick="cm_openTab(event, 'CoinHiveMiner')">Coin-Hive Miner</button>
		<button class="tablinks" onclick="cm_openTab(event, 'CoinImpMiner')">Coin-Imp Miner</button>
	</div>
	<div id="Dashboard" class="tabcontent active" style="display: block;">
		<table>
			<tr>
				<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Coin Hive Miner</th>
				<td style="font-size: 16px;"><?php if($ch_disable_plugin == "on") {echo "off";} else {echo "on";}?></td>
			</tr>
			<tr>
				<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Coin Imp Miner</th>
				<td style="font-size: 16px;"><?php if($ci_disable_plugin == "on") {echo "off";} else {echo "on";}?></td>
			</tr>
		</table>
		<div class="instructions-main" id="instructions">
			<h3>Signup Instructions</h3>
			<button onclick="cm_toggleInstructions('coin-hive-instructions')">Coin Hive Signup Instructions</button>
			<button onclick="cm_toggleInstructions('coin-imp-instructions')">Coin Imp Signup Instructions</button>
			
			<div id="coin-hive-instructions" class="coin-hive-instructions" style="display: none;">
				<div class="instructions" id="instructions-1">
					<div class="inst_title">1) Go to <a id="coinhivelink" href="https://coinhive.com">CoinHive.com</a> click signup</br>
						2) Fill in your email address and create a password.</div>
					<img class="inst_img" src="<?php echo esc_url($url); ?>/img/coin-hive-2.png">
				</div>
				<div class="instructions" id="instructions-2">
					<div class="inst_title">3) Verify your signup email</div>
					<img class="inst_img" src="<?php echo esc_url($url); ?>/img/coin-hive-3.png">
				</div>
				<div class="instructions" id="instructions-3">
					<div class="inst_title">4) Login to Coin-Hive</br>
						5) go to Setting -> Sites and API Keys</div>
					<img class="inst_img" src="<?php echo esc_url($url); ?>/img/coin-hive-4.png">
				</div>
				<div class="instructions" id="instructions-4">
					<div class="inst_title">6) Under your site fill in your website name</br>
						7) Copy your Public Site Key, and your Private Secret Key to the plugin setting</div>
					<img class="inst_img" src="<?php echo esc_url($url); ?>/img/coin-hive-5.png">
				</div>
			</div>
			
			<div id="coin-imp-instructions" class="coin-imp-instructions" style="display: none;">
				<div class="instructions" id="instructions-1">
					<div class="inst_title">1) Go to <a id="coinimplink" href="https://www.coinimp.com" onclick="cm_chchange(this)">Coinimp.com</a> click signup</br>
						2) Fill in your email address and create a password.</div>
					<img class="inst_img" src="<?php echo esc_url($url); ?>/img/coin-imp-1.png">
				</div>
				<div class="instructions" id="instructions-2">
					<div class="inst_title">3) Login to CoinImp</br>
						4) Go to Dashboard</div>
					<img class="inst_img" src="<?php echo esc_url($url); ?>/img/coin-imp-2.png">
				</div>
				<div class="instructions" id="instructions-3">
					<div class="inst_title">5) Add new site</div>
					<img class="inst_img" src="<?php echo esc_url($url); ?>/img/coin-imp-3.png">
				</div>
				<div class="instructions" id="instructions-4">
					<div class="inst_title">6) Click on "Generate Site Code for Background Mining</div>
					<img class="inst_img" src="<?php echo esc_url($url); ?>/img/coin-imp-4.png">
				</div>
				<div class="instructions" id="instructions-5">
					<div class="inst_title">7) Copy The Value from the '' (see image) - this is your private Secret Key - go to plugin setting and paste it</div>
					<img class="inst_img" src="<?php echo esc_url($url); ?>/img/coin-imp-5.png">
				</div>
			</div>
		</div>
	</div>
	
	<div id="CoinHiveMiner" class="tabcontent">
		<form action="options.php" method="post">
			<?php
				settings_fields( 'coin-miner-options' );
				do_settings_sections( 'coin-miner-options' );
			?>	
			<table>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Your Coin Public Key</th>
					<td><input type="text" name="ch_public_key" class="cm-itext" value="<?php echo esc_textarea($ch_public_key); ?>" size="50" /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Your Coin-Hive Secret Key</th>
					<td><input type="text" placeholder="2lhVMLr0sfIAU6jOScbilzRyf63Tlw2i" class="cm-itext" name="ch_secret_key" size="50" value="<?php echo esc_textarea($ch_secret_key); ?>"></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Miner Speed (1 for max, 0 for none)</th>
					<td><input placeholder="0.3" type="text" class="cm-itext" name="ch_miner_speed" value="<?php echo esc_textarea($ch_miner_speed); ?>" /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Delayed Minor Speed (1 for max, 0 for none)</th>
					<td><input placeholder="0.3" type="text" class="cm-itext" name="ch_delayed_miner_speed" value="<?php echo esc_textarea($ch_delayed_miner_speed); ?>" /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Delayed Miner Time (Start mining at higher speed after X minute)</th>
					<td><input placeholder="0.3" type="text" class="cm-itext" name="ch_delayed_miner_time" value="<?php echo esc_textarea($ch_delayed_miner_time); ?>" /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Mobile Miner Disabled</th>
					<td><input type="checkbox" name="ch_mobile_disable" <?php if($ch_mobile_disable == "on") {echo "checked='checked'";} ?> /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Miner Disabled</th>
					<td><input type="checkbox" name="ch_disable" <?php if($ch_disable_plugin == "on") {echo "checked='checked'";} ?> /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">User Consent Needed</th>
					<td><input type="checkbox" name="ch_user_concent_needed" <?php if($ch_user_concent == "on") {echo "checked='checked'";} ?> /></td>
				</tr>
				<tr>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</form>
	</div>

	<div id="CoinImpMiner" class="tabcontent active">
		<form action="options.php" method="post">
			<?php
				settings_fields( 'coin-miner-options-ci' );
				do_settings_sections( 'coin-miner-options-ci' );
			?>
			<table id="mytable">
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Your Coin-Imp secret-key</th>
					<td><input type="text" class="cm-itext" id="ci_secret_key" name="ci_secret_key" value="<?php echo esc_textarea($ci_secret_key) ?>" size="50" /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Miner Speed <span>(1 for min, 0 for max)</span></th>
					<td><input placeholder="0.3" type="text" class="cm-itext" name="ci_miner_speed" value="<?php echo esc_textarea($ci_miner_speed); ?>" /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Delayed Minor Speed (1 for max, 0 for none)</th>
					<td><input placeholder="0.3" type="text" class="cm-itext" name="ci_delayed_miner_speed" value="<?php echo esc_textarea($ci_delayed_miner_speed); ?>" /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Delayed Miner Time (Start mining at higher speed after X minute)</th>
					<td><input placeholder="0.3" type="text" class="cm-itext" name="ci_delayed_miner_time" value="<?php echo esc_textarea($ci_delayed_miner_time); ?>" /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Mobile Miner Disabled</th>
					<td><input type="checkbox" name="ci_mobile_disable" <?php if($ci_mobile_disable == "on") {echo "checked='checked'";} ?> /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">Miner Disabled</th>
					<td><input type="checkbox" name="ci_disable" <?php if($ci_disable_plugin == "on") {echo "checked='checked'";} ?> /></td>
				</tr>
				<tr>
					<th class="cm-title" style="font-size: 20px; text-align: left; padding-right: 33px; height: 65px;">User Consent Needed</th>
					<td><input type="checkbox" name="ci_user_concent_needed" <?php if($ci_user_concent == "on") {echo "checked='checked'";} ?> /></td>
				</tr>
				<tr>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php
}