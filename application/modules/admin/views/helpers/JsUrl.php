<?php

class Zend_View_Helper_JsUrl extends Zend_View_Helper_Abstract {

    public function jsUrl() {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$configUrl = $config->getOption('resources');
		$baseUrl = $configUrl['frontController']['baseUrl'];

        $url = $baseUrl.'/public/js';
        return $url;
    }
}