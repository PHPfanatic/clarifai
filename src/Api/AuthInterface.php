<?php namespace PhpFanatic\clarifAI\Api;
/**
 * Required methods to handle authentication to clarifAI API
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/clarifai
 * @version  2.0.1
 */

interface AuthInterface {

	/**
	 * Set API Key for authentication.
	 */
	public function SetApiKey($apikey);
}
