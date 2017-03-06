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
	 * Test adding an image builds the correct structure.
	 */
	public function testAddImage() {
		$this->client->AddImage('https://homepages.cae.wisc.edu/~ece533/images/cat.png');
		$this->assertArrayHasKey('url', $this->client->image['inputs'][0]['data']['image'], 'Adding an image failed.');
	}
	
	/**
	 * Test adding multiple images builds array of images.
	 */
	public function testAddImageMultiple() {
		$this->client->AddImage('https://homepages.cae.wisc.edu/~ece533/images/cat1.png');
		$this->client->AddImage('https://homepages.cae.wisc.edu/~ece533/images/cat2.png');
		$this->assertCount(2, $this->client->image['inputs'], 'Adding multiple images failed.');
	}
	
	/**
	 * Test sending predict without an image.
	 */
	public function testPredictNoImage() {
		$this->expectException(LogicException::class);
		$this->client->Predict();
	}
	
	/**
	 * Test token validation is working as intended.
	 */
	public function testIsTokenValid() {
		$response = $this->client->IsTokenValid();
		$this->assertFalse($response, 'Token validation failed');
	}
}