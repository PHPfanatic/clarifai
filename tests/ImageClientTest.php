<?php

use PhpFanatic\clarifAI\ImageClient;

class ImageClientTest extends PHPUnit_Framework_TestCase {

	private $apikey='testkey';
	private $client;
		
	protected function setUp() {
		$this->client = new ImageClient($this->apikey);
	}

	protected function tearDown() {
		unset($this->client);
	}
	
	/**
	 * Test that adding paginate create the paginate array correctly.
	 */
	public function testPaginate() {
		$this->client->Paginate(1, 20);
		$this->assertEquals(1, $this->client->paginate['page'], 'Paginate page was not added.');
	}
	
	/**
	 * Test moving pagination forward x pages and verify the count is correct.
	 */
	public function testPageForward() {
		$this->client->Paginate(1, 20);
		$this->client->PageForward(5);
		
		$this->assertEquals(6, $this->client->paginate['page'], 'Page forward did not increment correctly.');
	}
	
	/**
	 * Test moving pagination back x pages and verify the count is correct.
	 */
	public function testPageBack() {
		$this->client->Paginate(5, 20);
		$this->client->PageBack(2);
	
		$this->assertEquals(3, $this->client->paginate['page'], 'Page back did not increment correctly.');
	}
	
	/**
	 * Test adding an image builds the correct structure.
	 */
	public function testAddImage() {
		$this->client->AddImage('http://phpfanatic.com/projects/clarifai/cat.png');
		$this->assertArrayHasKey('url', $this->client->image['inputs'][0]['data']['image'], 'Adding an image failed.');
	}
	
	/**
	 * Test adding multiple images builds array of images.
	 */
	public function testAddImageMultiple() {
		$this->client->AddImage('http://phpfanatic.com/projects/clarifai/cat.png');
		$this->client->AddImage('http://phpfanatic.com/projects/clarifai/cat.png');
		$this->assertCount(2, $this->client->image['inputs'], 'Adding multiple images failed.');
	}
	
	/**
	 * Test that adding more than 128 images throws and error.
	 */
	public function testAddMaxImage() {
		$this->expectException(ErrorException::class);
		for ($i = 0; $i < 130; $i++) {
			$this->client->AddImage('http://phpfanatic.com/projects/clarifai/cat.png');
		}
	}
	
	/**
	 * Test adding multiple concepts builds array of concepts.
	 */
	public function testAddConcept() {
		$this->client->AddConcept('testid1', array(array('id'=>'dog', 'value'=>true)));
		$this->client->AddConcept('testid2', array(array('id'=>'dog', 'value'=>false)));
		$this->assertCount(2, $this->client->concept['inputs'], 'Adding multiple concepts failed.');
	}
	
	/**
	 * Test sending predict without an image.
	 */
	public function testPredictNoImage() {
		$this->expectException(LogicException::class);
		$this->client->Predict();
	}
			
	/**
	 * Validate that setting language works as intended.
	 */
	public function testSetLanguage() {
		$this->client->SetLanguage('es');
		$result = $this->client->ShowLanguage();
		$this->assertEquals('es', $result, 'Language modifier was not set.');
	}
	
	/**
	 * Validate that the client version is of the correct format.
	 */
	public function testGetClientVersion() {
		$clientversion = $this->client->GetClientVersion();
		$this->assertRegExp('/^\d{1,3}[.]\d{1,3}[.]\d{1,3}$/', $clientversion);
	}
}