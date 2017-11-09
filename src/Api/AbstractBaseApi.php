<?php namespace PhpFanatic\clarifAI\Api;

/**
 * Base API functionality for clarifAI.  This abstract class is a bit heavy, but handles all of the communication
 * between the extended client class and clarifAI.
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/clarifai
 * @version  2.0.1
 */

abstract class AbstractBaseApi implements AuthInterface
{
	public $apikey = null;
	private $clientversion = '2.0.1';
	private $endpoint = 'https://api.clarifai.com';
	private $version = 'v2';
	private $apiurl = null;
		
	/**
	 * Initial ImageClient setup.
	 * @param string $clientid
	 * @param string $clientsecret
	 */
	public function __construct($apikey) {
		$this->SetApiKey($apikey);
		$this->SetApiUrl();
	}
	
	/**
	 * Set api key
	 * {@inheritDoc}
	 * @see \PhpFanatic\clarifAI\Api\AuthInterface::SetApiKey()
	 */
	public function SetApiKey($apikey) {
		$this->apikey = $apikey;
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
	 * Validate if a Api Key is set and if it is valid.
	 * {@inheritDoc}
	 * @see \PhpFanatic\clarifAI\Api\AuthInterface::IsTokenValid()
	 * @return bool
	 */
	public function IsApiKeySet() {
		if(!isset($this->apikey) && is_null($this->apikey)) {
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
		$header[] = 'Authorization: Key ' . $this->apikey;
				
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $this->apiurl . '/' . $service);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->GetClientAgent());
		
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
		$header[] = 'Authorization: Key ' . $this->apikey;
	
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $this->apiurl . '/' . $service);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->GetClientAgent());
	
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
		$header[] = 'Authorization: Key ' . $this->apikey;
	
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $this->apiurl . '/' . $service);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->GetClientAgent());
	
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
		$header[] = 'Authorization: Key ' . $this->apikey;
		
		if($data === '') {
			$url = $this->apiurl . '/' . $service;
		} else {
			$url = $this->apiurl . '/' . $service . '/' . $data;
		}
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->GetClientAgent());	
		
		$result = curl_exec($ch);
		curl_close($ch);
	
		return $result;
	}
}
