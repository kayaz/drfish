<?php

class Zend_View_Helper_CssUrl extends Zend_View_Helper_Abstract {

    public function cssUrl() {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$configUrl = $config->getOption('resources');
		$baseUrl = $configUrl['frontController']['baseUrl'];

        $url = $baseUrl.'/public/styles/template';
        return $url;
    }
}