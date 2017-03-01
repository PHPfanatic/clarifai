<?php namespace PhpFanatic\clarifAI\Api;

trait PackageTrait
{
	public function add($image, $id, $concept=array(), $metadata=array(), $crop=array()) {
		
		//Base package format
		$data = array('data'=>array('image'=>array()), 'id'=>$id);
		
		//Is the image a url or bytes
		if(filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
			array_push($data['data']['image'], array('base64'=>base64_encode($image)));
		} else {
			array_push($data['data']['image'], array('url'=>$image));
		}
		
		if(count($concept)) {
			array_push($data['data'], array('concepts'=>$concept));
		}
		
		if(count($metadata)) {
			array_push($data['data'], array('metadata'=>$metadata));
		}
		
		if(count($crop)) {
			array_push($data['data']['image'], array('crop'=>$crop));
		}
		
		return json_encode($data);
	}
	
	private function buildJson($data) {
	
		$format = array(
				'inputs'=>array(
						'data'=>array(
								'image'=>array(
										'url'=>'',
										'base64'=>'',
										'crop'=>array()
								),
								'concepts'=>array(
										'id'=>'',
										'value'=>''
								),
								'metadata'=>array(
										'key'=>'value'
								)
						),
						'id'=>$id
				)
		);
	}
}