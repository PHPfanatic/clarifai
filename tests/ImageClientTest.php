<?php

use PhpFanatic\clarifAI\ImageClient;

class ImageClientTest extends PHPUnit_Framework_TestCase {

	private $clientid='testid';
	private $clientsecret='testsecret';
	private $client;
		
	protected function setUp() {
		$this->client = new ImageClient($this->clientid, $this->clientsecret);
	}

	protected function tearDown() {
		unset($this->client);
	}
	
	/**
	 * Test sending invalid model to predict.
	 */
	public function testPredictInvalidModel() {
		$this->expectException(InvalidArgumentException::class);
		$this->client->AddImage('https://homepages.cae.wisc.edu/~ece533/images/cat.png');
		$this->client->Predict('unknown_model');
	}
	
	/**
	 * Test sending predict without an image.
	 */
	public function testPredictNoImage() {
		$this->expectException(LogicException::class);
		$this->client->Predict();
	}
}