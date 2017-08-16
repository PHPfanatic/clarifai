<?php namespace PhpFanatic\clarifAI\Api;

/**
 * Base API functionality for clarifAI.  This abstract class is a bit heavy, but handles all of the communication
 * between the extended client class and clarifAI.
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/clarifai
 * @version  1.2.2
 */

abstract class AbstractBaseApi implements AuthInterface
{
	private $clientid = null;
	private $clientsecret = null;
	private $clientversion = '1.2.2';
	private $endpoint = 'https://api.clarifai.com';
	private $version = 'v2';
	private $apiurl = null;
	
	public $access = ['token'=>null, 'token_time'=>null, 'token_expires'=>null];
	
	/**
	 * Initial ImageClient setup.
	 * @param string $clientid
	 * @param string $clientsecret
	 */
	public function __construct($clientid, $clientsecret) {
		$this->SetClientId($clientid);
		$this->SetClientSecret($clientsecret);
		$this->SetApiUrl();
	}
	
	/**
	 * Set client id
	 * {@inheritDoc}
	 * @see \PhpFanatic\clarifAI\Api\AuthInterface::SetClientId()
	 */
	public function SetClientId($clientid) {
		$this->clientid = $clientid;
	}

	/**
	 * Set client secret
	 * {@inheritDoc}
	 * @see \PhpFanatic\clarifAI\Api\AuthInterface::SetClientSecret()
	 */
	public function SetClientSecret($clientsecret) {
		$this->clientsecret = $clientsecret;
	}
	
	/**
	 * Place holder for future setting of client version.
	 * @param string $clientversion
	 */
	public function GetClientVersion() {
		return $this->clientversion;
	}
	
	/**
	 * Returns the custom agent header.  This was a ClarifAI request to better help them debug client inquiries.
	 * @return string
	 */
	public function GetClientAgent() {
		return 'Clarifai PHP (https://github.com/PHPfanatic/clarifai);'.$this->GetClientVersion().';'.phpversion();
	}
	
	/**
	 * Sets a new endpoint url.  Calling this method also updates the Api url.
	 * @example $client->SetEndPoint('http://api.clarifai.com');
	 * @param string $endpoint
	 */
	public function SetEndPoint($endpoint) {
		$this->endpoint = $endpoint;
		$this->SetApiUrl();
	}
	
	/**
	 * Sets a new clarifAI version to work with.  Calling this method also updates the Api url.
	 * @example $client->SetVersion('v2');
	 * @param string $version
	 */
	public function SetVersion($version) {
		$this->version = $version;
		$this->SetApiUrl();
	}
	
	/**
	 *	Sets the api url.
	 */
	private function SetApiUrl() {
		$this->apiurl = $this->endpoint . '/' . $this->version;
	}
		
	/**
	 * Validate if a OAUTH token is set and if it is valid.
	 * {@inheritDoc}
	 * @see \PhpFanatic\clarifAI\Api\AuthInterface::IsTokenValid()
	 * @return bool
	 */
	public function IsTokenValid() {
		if(!isset($this->access['token'])) {
			return false;
		}
	
		if(((int) date('U') - $this->access['token_time']) < $this->access['token_expires']) {
			return false;
		}
	
		return true;
	}
	
	/**
	 * Generate OAUTH token and set the access variable as needed.
	 * {@inheritDoc}
	 * @see \PhpFanatic\clarifAI\Api\AuthInterface::GenerateToken()
	 * @return bool
	 */
	public function GenerateToken() {
		$ch = curl_init();
		
		$header = array();
		$header[] = 'Content-type: application/json';
		$header[] = $this->GetClientAgent();
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_USERPWD, $this->clientid . ":" . $this->clientsecret);
		curl_setopt($ch, CURLOPT_URL, $this->apiurl . '/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$result = json_decode(curl_exec($ch), true);	
		curl_close($ch);
		
		if($result['status']['code'] == '10000') {
			$this->access['token'] = $result['access_token'];
			$this->access['token_time'] = (int)date('U');
			$this->access['token_expires'] = $result['expires_in'];
		}
		else {
			return false;
		}
		
		return true;
	}

	/**
	 * Send a POST request to clarifAI API.
	 * @param string $data json inputs string.
	 * @param string $service appended to the apiurl when making the API call.
	 * @return string
	 */
	public function SendPost($data, $service) { 
		$ch = curl_init();
		
		$header = array();
		$header[] = 'Content-type: application/json';
		$header[] = 'Authorization: Bearer ' . $this->access['token'];
		$header[] = $this->GetClientAgent();
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $this->apiurl . '/' . $service);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
	
	/**
	 * Send a Delete request to clarifAI API.
	 * @param string $data json inputs string.
	 * @param string $service appended to the apiurl when making the API call.
	 * @return string
	 */
	public function SendDelete($data, $service) {
		$ch = curl_init();
	
		$header = array();
		$header[] = 'Content-type: application/json';
		$header[] = 'Authorization: Bearer ' . $this->access['token'];
		$header[] = $this->GetClientAgent();
	
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $this->apiurl . '/' . $service);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
		$result = curl_exec($ch);
		curl_close($ch);
	
		return $result;
	}
	
	/**
	 * Send a PATCH request to clarifAI API.
	 * @param string $data json inputs string.
	 * @param string $service appended to the apiurl when making the API call.
	 * @return string
	 */
	public function SendPatch($data, $service='inputs') {
		$ch = curl_init();
	
		$header = array();
		$header[] = 'Content-type: application/json';
		$header[] = 'Authorization: Bearer ' . $this->access['token'];
		$header[] = $this->GetClientAgent();
	
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $this->apiurl . '/' . $service);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
		$result = curl_exec($ch);
		curl_close($ch);
	
		return $result;
	}
	
	/**
	 * Send a GET request to clarifAI API.
	 * @param array $data
	 * @param string $service
	 * @return mixed
	 */
	public function SendGet($data=array(), $service='inputs') {
		$ch = curl_init();
		
		$data = implode('/', array_filter($data));
		
		$header = array();
		$header[] = 'Content-type: application/json';
		$header[] = 'Authorization: Bearer ' . $this->access['token'];
		$header[] = $this->GetClientAgent();
		
		if($data === '') {
			$url = $this->apiurl . '/' . $service;
		} else {
			$url = $this->apiurl . '/' . $service . '/' . $data;
		}
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($ch);
		curl_close($ch);
	
		return $result;
	}
}