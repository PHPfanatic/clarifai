<?php namespace PhpFanatic\clarifAI\Api;
/**
 * Required methods to handle authentication to clarifAI API
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/clarifai
 * @version  1.2.0
 */

interface AuthInterface {

	/**
	 * Set client id for OAUTH2 authentication.
	 * @param string $clientid
	 */
	public function SetClientId($clientid);

	/**
	 * Set client secret for OAUTH2 authentication.
	 * @param string $clientsecret
	 */
	public function SetClientSecret($clientsecret);
	
	/**
	 * Verify if an existing token exists.
	 */
	public function IsTokenValid();
	
	/**
	 * Generate OAUTH2 token.
	 */
	public function GenerateToken();
}