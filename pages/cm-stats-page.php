<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}	

function coin_miner_admin_page_init() {
wp_enqueue_style('styleCss');
wp_enqueue_script( 'cmAmazingScript');
?>

<script>
	window.onload = function() {
		console.log('muhahaha0');
		gateway = cm_startAjax();
		console.log('muhahaha1');
		cm_getTabContent(gateway, 1, null);
		console.log('muhahaha2');
		var tabsHouser = document.getElementById('tab');
		var tabs = tabsHouser.getElementsByTagName('button');
		tabsHouser.onclick = function(e) {
			var clickedElement = e ? e.target : window.event.srcElement;
			if (clickedElement.id.match(/^tab\d{1}$/)) {
				cm_toggleLoader(null);
				var clickedTabNum = clickedElement.id.substr(clickedElement.id.length-1, 1);
				for(var k=0; k<tabs.length; k++) tabs[k].className = '';
				clickedElement.className = 'on';
				cm_getTabContent(gateway, clickedTabNum, null);
			}
		}
	}
</script>
    <div class="wrap">
	
		<div class="tab" id="tab" style="height: 70px;">
		  <button id="tab1" class="tablinks on" onclick="">CoinImp Dashboard</button>
		  <button id="tab2" class="tablinks" onclick="">CoinImp Miners by user</button>
		  <button id="tab3" class="tablinks" onclick="">CoinImp Miners by Date</button>
		  <button id="tab4" class="tablinks" onclick="">CoinHive Dashboard</button>
		  <button id="tab5" class="tablinks" onclick="">CoinHive Miners by user</button>
		  <button id="tab6" class="tablinks" onclick="">CoinHive Miners by Date</button>
		</div>
		<div id="loader" class="loader"></div>

		<div id="tabsUnder">
		<?php // get content with js ?>
		</div>
	</div>
<?php
}