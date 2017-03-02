<?php namespace PhpFanatic\clarifAI;

use PhpFanatic\clarifAI\Api\AbstractBaseApi;

class ImageClient extends AbstractBaseApi 
{	
	public $data = array();
	public $image = array('inputs'=>array());
	
	private $model = [
			'General'=>'general-v1.3',
			'Adult'=>'nsfw-v1.0',
			'Weddings'=>'weddings-v1.0',
			'Travel'=>'travel-v1.0',
			'Food'=>'food-items-v1.0'];
	
	public function __construct($clientid, $clientsecret) {
		parent::__construct($clientid, $clientsecret);
	}
	
	public function InputAdd() {
		if(!isset($this->data) || !is_array($this->data)) {
			throw new \ErrorException('You must add at least one image via AddImage().');	
		}
		
		if(!$this->IsTokenValid()) {
			$result = $this->GenerateToken();
			
			if($result['status']['code'] == '10000'){
				$this->access['token'] = $result['access_token'];
				$this->access['token_time'] = (int)date('U');
				$this->access['token_expires'] = $result['expires_in'];
			}
			else {
				throw new \ErrorException('Token generation failed.');
			}
		}
		
		$json = json_encode($this->image);
		
		return $this->SendPost($json);
	}
	
	public function InputGet() {
		
	}
	
	public function InputDelete() {
		
	}
	
	public function ClearImage() {
		unset($this->data);
		$this->image = array('inputs'=>array());
	}
	
	public function AddImage($image, $id, $concept=array(), $metadata=array(), $crop=array()) {
	
		//Base package format
		$this->data = array('data'=>array('image'=>array()), 'id'=>$id);
	
		//Is the image a url or bytes
		if(filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
			$this->data['data']['image']['base64'] = base64_encode($image);
		} else {
			$this->data['data']['image']['url'] = $image;
		}
	
		if(count($concept)) {
			array_push($this->data['data'], array('concepts'=>$concept));
		}
	
		if(count($metadata)) {
			array_push($this->data['data'], array('metadata'=>$metadata));
		}
	
		if(count($crop)) {
			array_push($this->data['data']['image'], array('crop'=>$crop));
		}
		
		$this->image['inputs'][] = $this->data;
	}
}