<?php

class Zend_View_Helper_FilesUrl extends Zend_View_Helper_Abstract {

    public function filesUrl() {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$configUrl = $config->getOption('resources');
		$baseUrl = $configUrl['frontController']['baseUrl'];

        $url = $baseUrl.'/files';
        return $url;
    }
}