<?php namespace PhpFanatic\clarifAI\Api;

abstract class AbstractBaseApi implements AuthInterface
{
	private $clientid = null;
	private $clientsecret = null;
	private $endpoint = 'https://api.clarifai.com';
	private $version = 'v2';
	private $apiurl = null;
	private $access = ['token'=>null, 'token_time'=>null, 'token_expires'=>null];
	private $model = [
			'General'=>'general-v1.3', 
			'Adult'=>'nsfw-v1.0', 
			'Weddings'=>'weddings-v1.0', 
			'Travel'=>'travel-v1.0', 
			'Food'=>'food-items-v1.0'];

	public function __construct($clientid, $clientsecret) {
		$this->SetClientId($clientid);
		$this->SetClientSecret($clientsecret);
		$this->SetApiUrl();
		$this->GenerateToken();
	}
	
	public function SetClientId($clientid) {
		$this->clientid = $clientid;
	}

	public function SetClientSecret($clientsecret) {
		$this->clientsecret = $clientsecret;
	}
	
	public function SetEndPoint($endpoint) {
		$this->endpoint = $endpoint;
	}
	
	public function SetVersion($version) {
		$this->version = $version;
	}
	
	public function SetApiUrl() {
		$this->apiurl = $this->endpoint . '/' . $this->version;
	}
		
	public function GenerateToken() {
		$this->access['token'] = '';
		$this->access['token_time'] = '';
		$this->access['token_expires'] = '';
	}
	
	public function IsTokenValid() {
		if(!isset($this->access['token'])) {
			return false;
		}
	
		if((date('U') - $this->access['token_time']) < $this->access['token_expires']) {
			return false;
		}
		
		return true;
	}
	
	public function SendPost($data, $service='inputs') {		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_URL, $this->apiurl . '/' . $service);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, array(
				'Content-Type: application/json', 
				'Content-Length: ' . strlen($data),
				'Authorization: Bearer '.$this->access['token']));
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
	
	public function SendGet($data, $service='inputs') {
		$auth = 'Authorization: Bearer '.$this->access['token'];
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, array('Content-Type: application/json', $auth));
		curl_setopt($ch, CURLOPT_URL, $this->apiurl . '/' . $service);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
		$result = curl_exec($ch);
		curl_close($ch);
	
		return $result;
	}
}