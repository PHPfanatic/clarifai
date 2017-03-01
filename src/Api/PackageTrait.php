<?php namespace PhpFanatic\clarifAI\Api;

trait PackageTrait
{
	public function add($image, $id, $concept=array(), $metadata=array(), $crop=array()) {
		
		$data = array('image'=>$image, 'id'=>$id);
		
		if(count($concept)) {
			array_push($data, $concept);
		}
		
		if(count($metadata)) {
			array_push($data, $metadata);
		}
		
		if(count($crop)) {
			array_push($data, $crop);
		}
		
		return json_encode(self::buildJson($data));
		
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