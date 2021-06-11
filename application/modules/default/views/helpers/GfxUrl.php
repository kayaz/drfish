<?php

class Zend_View_Helper_GfxUrl extends Zend_View_Helper_Abstract {

    public function gfxUrl() {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$configUrl = $config->getOption('resources');
		$baseUrl = $configUrl['frontController']['baseUrl'];
			
        $url = $baseUrl.'/public/gfx/template';
        return $url;
    }
}