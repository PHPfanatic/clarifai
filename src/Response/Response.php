<?php namespace PhpFanatic\clarifAI\Response;
/**
 * Basic response handler, this will extend as development moves forward.
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/clarifai
 * @version  2.0.1
 */

class Response
{
	/**
	 * Return a json response.  By default ClarifAI returns json.
	 * @param string $result
	 * @return string
	 */
	public static function GetJson($result) {
		return $result;	
	}
	
	/**
	 * Return an array.
	 * @param string $result
	 * @return array
	 */
	public static function GetArray($result) {
		return json_decode($result, true);
	}
	
	/**
	 * Return the resulting status code.
	 * @param string $result
	 * @return int
	 */
	public static function GetStatusCode($result) {
		$result = json_decode($result, true);
		
		return $result['status']['code'];
	}
}
