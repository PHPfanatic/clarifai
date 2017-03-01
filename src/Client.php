<?php namespace PhpFanatic\clarifAI;

use PhpFanatic\clarifAI\Api\AbstractBaseApi;

class Client extends AbstractBaseApi 
{	
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
		
	}
	
	public function InputGet() {
		
	}
	
	public function InputDelete() {
		
	}
}