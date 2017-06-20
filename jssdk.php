<?php 
$url = $_GET['url']; 
class JSSDK { 
	private $appId; 
	private $appSecret; 
	private $url; 
	public function __construct($appId, $appSecret,$url) { 
		$this->appId = $appId; 
		$this->appSecret = $appSecret; 
		$this->url = $url; 
 	} 
	 public function getSignPackage() { 
		$jsapiTicket = $this->getJsApiTicket(); 
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
		$url =$this->url; 
		$timestamp = time(); 
		$nonceStr = $this->createNonceStr(); 
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url"; 
		$signature = sha1($string); 
		$signPackage = array( 
		  "appId"  => $this->appId, 
		  "nonceStr" => $nonceStr, 
		  "timestamp" => $timestamp, 
		  "url"  => $url, 
		  "signature" => $signature, 
		  "rawString" => $string
		); 
		return $signPackage; 
	 } 
	private function createNonceStr($length = 16) { 
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
		$str = ""; 
		for ($i = 0; $i < $length; $i++) { 
		 $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1); 
		} 
		return $str; 
	} 
	private function getJsApiTicket() { 
		 $data = json_decode(file_get_contents("jsapi_ticket.json")); 
		 if ($data->expire_time < time()) { 
		  $accessToken = $this->getAccessToken(); 
		  $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken"; 
		  $res = json_decode($this->httpGet($url)); 
		  $ticket = $res->ticket; 
		  if ($ticket) { 
		  $data->expire_time = time() + 7000; 
		  $data->jsapi_ticket = $ticket; 
		  $fp = fopen("jsapi_ticket.json", "w"); 
		  fwrite($fp, json_encode($data)); 
		  fclose($fp); 
		  } 
		 } else { 
		  $ticket = $data->jsapi_ticket; 
		 } 
		 return $ticket; 
	} 
	private function getAccessToken() { 
		 $data = json_decode(file_get_contents("access_token.json")); 
		 if ($data->expire_time < time()) { 
		  $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret"; 
		  $res = json_decode($this->httpGet($url)); 
		  $access_token = $res->access_token; 
		  if ($access_token) { 
		  $data->expire_time = time() + 7000; 
		  $data->access_token = $access_token; 
		  $fp = fopen("access_token.json", "w"); 
		  fwrite($fp, json_encode($data)); 
		  fclose($fp); 
		  } 
		 } else { 
		  $access_token = $data->access_token; 
		 } 
		 return $access_token; 
	} 
	private function httpGet($url) { 
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_TIMEOUT, 500); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		$res = curl_exec($curl); 
		curl_close($curl); 
		return $res; 
	} 
} 

$jssdk = new JSSDK("wx697d085a65340b93", "90c6a359583ca3a75101498af33a824b",$url);//按照自己的公众号填写 
$signPackage = $jssdk->GetSignPackage(); 
$tmp=json_encode(array ('appId'=>$signPackage["appId"],'timestamp'=>$signPackage["timestamp"],'nonceStr'=>$signPackage["nonceStr"],'signature'=>$signPackage["signature"],'url'=>$signPackage["url"])); 
$callback = $_GET['callback']; 
echo $callback.'('.$tmp.')'; 
exit; 
?>