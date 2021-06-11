<?php

class Zend_View_Helper_AdminCssUrl extends Zend_View_Helper_Abstract {

    public function adminCssUrl() {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$configUrl = $config->getOption('resources');
		$baseUrl = $configUrl['frontController']['baseUrl'];

        $url = $baseUrl.'/public/styles/cms';
        return $url;
    }
}