<?php namespace PhpFanatic\clarifAI\Api;
/**
 * Required methods to handle authentication to clarifAI API
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/clarifai
 * @version  0.1.1
 */

interface AuthInterface {

	public function SetClientId($clientid);

	public function SetClientSecret($clientsecret);
	
	public function IsTokenValid();
	
	public function GenerateToken();
}