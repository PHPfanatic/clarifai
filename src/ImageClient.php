<?php namespace PhpFanatic\clarifAI;
/**
 * Image client for the clarifAI API.
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/clarifai
 * @version  0.1.1
 */

use PhpFanatic\clarifAI\Api\AbstractBaseApi;
use PhpFanatic\clarifAI\Response\Response;

class ImageClient extends AbstractBaseApi 
{	
	public $data = array();
	protected $image;
	protected $search;
	
	
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
	 * @throws \LogicException
	 * @throws \ErrorException
	 * @throws \InvalidArgumentException
	 * @return string Json response from ClarifAI.
	 */
	public function Predict($model='General') {
		if(!isset($this->image) || !is_array($this->image)) {
			throw new \LogicException('You must add at least one image via AddImage().');
		}
		
		if(!array_key_exists($model, $this->models)) {
			throw new \InvalidArgumentException('The model requested is not valid.');
		}
		
		if(!$this->IsTokenValid()) {
			if($this->GenerateToken() === false) {
				throw new \ErrorException('Token generation failed.');
			}
		}
		
		$service = 'models/' . $this->models[$model] . '/outputs';
		$json = json_encode($this->image);
		
		$result = $this->SendPost($json, $service);
		
		return (Response::GetJson($result));
	}
	
	/**
	 * Add an image(s) to be indexed.
	 * @throws \LogicException
	 * @throws \ErrorException
	 * @return string Json response from ClarifAI.
	 */
	public function Inputs() {
		if(!isset($this->image) || !is_array($this->image)) {
			throw new \LogicException('You must add at least one image via AddImage().');
		}
		
		if(!$this->IsTokenValid()) {
			if($this->GenerateToken() === false) {
				throw new \ErrorException('Token generation failed.');
			}
		}
		
		$service = 'inputs';
		$json = json_encode($this->image);
		
		$result = $this->SendPost($json, $service);
		
		return (Response::GetJson($result));
	}
	
	/**
	 * Search your indexed images, you may search by concept, user concept, metadata or url.
	 * the $term variable should only be an array when searching metadata.
	 * ClarifAI... this search array structure hurts my head.
	 * @throws InvalidArgumentException
	 * @throws ErrorException
	 * @param mixed $term
	 * @return string Json response from ClarifAI. 
	 */
	public function Search($term, $by='concept', $exists=true) {
		$search_by = array(
				'concept'		=> array('data_type'=>'concepts', 'direction'=>'output', 'content'=>array(array('name'=>$term, 'value'=>$exists))),
				'user_concept'	=> array('data_type'=>'concepts', 'direction'=>'input',  'content'=>array(array('name'=>$term, 'value'=>$exists))),
				'meta'			=> array('data_type'=>'metadata', 'direction'=>'input',  'content'=>array($term[0]=>$term[1])),
				'url'			=> array('data_type'=>'image', 	  'direction'=>'input',  'content'=>array('url'=>$term)),
				'image'			=> array('data_type'=>'image',	  'direction'=>'output', 'content'=>array('url'=>$term))
		);
		
		// Light validation
		if(!array_key_exists($by, $search_by)) {
			throw new \InvalidArgumentException('Invalid \'search by\' parameter.');
		}
		
		if($by == 'meta' && !is_array($term)) {
			throw new \InvalidArgumentException('Metadata search requires your search term to be an array of [0]=key, [1]=value.');
		}
		
		if($by != 'meta' && !is_string($term)) {
			throw new \InvalidArgumentException('Search term should be a string.');
		}
		
		$this->search = array(
			'query'=>array(
				'ands'=>array(
					array(
						$search_by[$by]['direction']=>array(
							'data'=>array(
								$search_by[$by]['data_type']=>$search_by[$by]['content']
							)
						)
					)
				)
			)
		);
		
		// Dynamically adjust output/input for image search.
		if($by === 'image') {
			$this->search['query']['ands'][0]['output'] = array('input'=>$this->search['query']['ands'][0]['output']);
		}
		
		if(!$this->IsTokenValid()) {
			if($this->GenerateToken() === false) {
				throw new \ErrorException('Token generation failed.');
			}
		}
		
		$service = 'searches';
		$json = json_encode($this->search);
		
		$result = $this->SendPost($json, $service);
		
		return (Response::GetJson($result));
	}
	
	public function Delete() {
		
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
			$data['data']['concepts'] = array($concept);
		}
	
		if(count($metadata)) {
			$data['data']['metadata'] = $metadata;
		}
	
		if(count($crop)) {
			$data['data']['image']['crop'] = $crop;
		}
		
		$this->image['inputs'][] = $data;
		
		return null;
	}
	
	/**
	 * Used to clear/reset $this->image variable after adding an image via AddImage.
	 *
	 * @return null  
	 */
	public function ClearImage() {
		unset($this->image);
		return null;
	}
}