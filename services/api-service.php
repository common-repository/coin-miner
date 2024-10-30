<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
class CoinHiveApiService
{
	const API_URL = 'https://api.coinhive.com';
	//private $secret = null;
	public function __construct($secret) {
		if (strlen($secret) !== 32) {
			// die();
			throw new Exception('CoinHive - Invalid Secret');
		}
		$this->secret = $secret;
	}
  
	function get($path, $data = []) {
		$data['secret'] = $this->secret;
		$url = self::API_URL.$path.'?'.http_build_query($data);
		$response = file_get_contents($url);
		return json_decode($response);
	}
	
	function post($path, $data = []) {
		$data['secret'] = $this->secret;
		$context = stream_context_create([
			'http' => [
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			]
		]);
		$url = SELF::API_URL.$path;
		$response = file_get_contents($url, false, $context);
		return json_decode($response);
	}	
}
class CoinImpApiService
{
/* <script src="https://www.webassembly.stream/M5ii.js"></script>
<script>
    var miner = new Client.Anonymous('bb29c8460738ace25bb86cdefd48788bc324cbef0f45a16092cf8e32efc91f2d', {
        throttle: 0.3
    });
    miner.start(); // IF_EXCLUSIVE_TAB ?
</script>
 */
 }
