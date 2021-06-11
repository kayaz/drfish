<?php

class Zend_View_Helper_GetInline extends Zend_View_Helper_Abstract {

	function getInline($array, $id, $element){
		foreach($array as $a){
			if($a->id_item == $id){
				$array = json_decode(json_encode($a), true);
				
				if($element == 'obrazek') {
					$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
					$configUrl = $config->getOption('resources');
					$baseUrl = $configUrl['frontController']['baseUrl'];
					
					return $baseUrl.'/files/inline/'.$array[$element];
				} else {
					return $array[$element];
				}
			}
		}
	}
}