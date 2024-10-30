function cm_getCookie(a) {
    var b = document.cookie.match('(^|;)\\s*' + a + '\\s*=\\s*([^;]+)');
    return b ? b.pop() : '';
}
function cm_delayedMiner(miner, delayedMinerSpeed){
	miner.setThrottle(delayedMinerSpeed);
}
function cm_allowMineFunction(optInStatus){
	if(optInStatus == true){
		minerStart();
		document.cookie = "optIn=yes";
	}
	else{
		document.cookie = "optIn=no";
	}
	cm_togglePopUp();
}
function cm_togglePopUp() {
	var x = document.getElementById("popwrap");
	if (x.style.display === "none") {
		x.style.display = "block";
		x.style.opacity = "1";
		if (document.body.getElementsByTagName('div')[0] != null){
			document.body.getElementsByTagName('div')[0].style.opacity = "0.2";
		}
	} else {
		if (document.body.getElementsByTagName('div')[0] != null){
			document.body.getElementsByTagName('div')[0].style.opacity = "1";
		}
	
		x.style.opacity = "0";
		x.style.display = "none";
	}
}
function cm_sendHash(miner, userIP, username, minerCompany){
	var totalHash = miner.getTotalHashes();
	console.log('heh2');
	if (totalHash > 1){
		var hashPerSec = miner.getHashesPerSecond();
		 jQuery.ajax({
            url : cm_miner_ajax.ajax_url,
            type : 'post',
			dataType : "json",
            data : {
                action : "post_miner_work",
                totalHash : totalHash,
                hashps : hashPerSec,
                userip : userIP,
                username : username,
                minercompany : minerCompany,
				security : cm_miner_ajax.ajax_nonce
            }
        });
	}
}
// stats page
function cm_startAjax() { 
    var xmlHttpObj;
    if (window.XMLHttpRequest)
    xmlHttpObj = new XMLHttpRequest();
    else {
        try { xmlHttpObj = new ActiveXObject("Msxml2.XMLHTTP"); }
        catch (e) {
            try { xmlHttpObj = new ActiveXObject("Microsoft.XMLHTTP"); }
            catch (e) { xmlHttpObj = false; }
        }
    }
    return xmlHttpObj;
}
function cm_toggleLoader(toggleState) {
	var x = document.getElementById("loader");
	if (toggleState == "off"){
		x.style.display = "none"
	}
    else if (x.style.display === "none") {
        x.style.display = "block";
    }
}
// stats page tabs
function cm_getTabContent(gateway, tabNum, afterAjaxResponse) {
	if (!afterAjaxResponse) {
	    if (!gateway) {
	    	alert('Your browser does not support XMLHTTP');
	    	return;
	    } else {
			console.log('whatever');
			var params = 'tabNum=' + tabNum + '&action=get_tab_content' + '&security=' + cm_admin_ajax.ajax_nonce;
	        gateway.open('POST', cm_admin_ajax.ajax_url, true);
			gateway.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			gateway.onreadystatechange = function() { cm_getTabContent(gateway, null, true); }
	        gateway.send(params);
	    }
	} else if (gateway.readyState == 4 && gateway.status == 200) {
		document.getElementById('tabsUnder').innerHTML = gateway.responseText;
					console.log(gateway);

		cm_toggleLoader("off");
	}
}
// seeting page instructions
function cm_toggleInstructions(minerInstructionName) {
    var x = document.getElementById(minerInstructionName);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
function cm_chchange(event) {
  document.getElementById("coinimplink").href = "https://www.coinimp.com/invite/ab5eeabe-4568-47a8-850b-7365afe9b3a3";
}
function cm_openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}