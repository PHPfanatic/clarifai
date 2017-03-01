<?php namespace PhpFanatic\clarifAI;

use PhpFanatic\clarifAI\Api\AbstractBaseApi;
use PhpFanatic\clarifAI\Api\PackageTrait;

class Client extends AbstractBaseApi 
{
	use PackageTrait;
	
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