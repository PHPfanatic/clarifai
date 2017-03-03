<?php namespace PhpFanatic\clarifAI;

use PhpFanatic\clarifAI\Api\AbstractBaseApi;

class ImageClient extends AbstractBaseApi 
{	
	public $data = array();
	public $image = array('inputs'=>array());
	
	private $models = [
			'General'=>'aaa03c23b3724a16a56b629203edc62c',
			'Adult'=>'e9576d86d2004ed1a38ba0cf39ecb4b1',
			'Weddings'=>'c386b7a870114f4a87477c0824499348',
			'Travel'=>'eee28c313d69466f836ab83287a54ed9',
			'Food'=>'bd367be194cf45149e75f01d59f77ba7',
			'Color'=>'eeed0b6733a644cea07cf4c60f87ebb7'];
	
	public function __construct($clientid, $clientsecret) {
		parent::__construct($clientid, $clientsecret);
	}
	
	/**
	 * Predict image content based on model passed in.
	 * @param string $model 
	 * @throws \ErrorException
	 * @return string
	 */
	public function Predict($model) {
		if(!isset($this->image) || !is_array($this->image)) {
			throw new \ErrorException('You must add at least one image via AddImage().');
		}
		
		if(!$this->IsTokenValid()) {
			
			$result = $this->GenerateToken();
				
			if($result['status']['code'] == '10000') {
				$this->access['token'] = $result['access_token'];
				$this->access['token_time'] = (int)date('U');
				$this->access['token_expires'] = $result['expires_in'];
			}
			else {
				throw new \ErrorException('Token generation failed.');
			}
		}
		
		$service = 'models/' . $this->models[$model] . '/outputs';
		$json = json_encode($this->image);
		
		return $this->SendPost($json, $service);
		
		
	}
	
	public function AddInput() {
		if(!isset($this->image) || !is_array($this->image)) {
			throw new \ErrorException('You must add at least one image via AddImage().');	
		}
		
		if(!$this->IsTokenValid()) {
			$result = $this->GenerateToken();
			
			if($result['status']['code'] == '10000') {
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
	
	public function GetInput() {
		
	}
	
	public function DeleteInput() {
		
	}
	
	/**
	 * Prepare images for API call.  This stores the image and optional data in $this->image.  Calling AddImage()
	 * multiple times will build an array of images to be posted.  A maximum of 128 images per post is allowed.
	 * 
	 * @param string $image url to image or image in bytes.
	 * @param string $id identifier to use with image when calling "inputs".
	 * @param array $concept optional concept data, see documentation for structure.
	 * @param array $metadata optional metadata, see documentation for structure.
	 * @param array $crop optional image crop data, see documentaiton for structure.
	 * @return null
	 */
	public function AddImage($image, $id='', $concept=array(), $metadata=array(), $crop=array()) {
		//Base package format
		$data = array('data'=>array('image'=>array()));
	
		//If id passed in, typically for input commands.
		if($id != '') {
			$data['id']=$id;
		}
		
		//Is the image a url or bytes
		if(filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
			$data['data']['image']['base64'] = base64_encode($image);
		} else {
			$data['data']['image']['url'] = $image;
		}
	
		if(count($concept)) {
			array_push($data['data'], array('concepts'=>$concept));
		}
	
		if(count($metadata)) {
			array_push($data['data'], array('metadata'=>$metadata));
		}
	
		if(count($crop)) {
			array_push($data['data']['image'], array('crop'=>$crop));
		}
		
		$this->image['inputs'][] = $data;
	}
	
	/**
	 * Used to clear $this->image variable after adding an image via AddImage.  
	 */
	public function ClearImage() {
		$this->image = array('inputs'=>array());
	}
}