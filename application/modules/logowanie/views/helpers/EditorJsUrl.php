<?php

class Zend_View_Helper_EditorJsUrl extends Zend_View_Helper_Abstract {

    public function editorJsUrl() {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$configUrl = $config->getOption('resources');
		$baseUrl = $configUrl['frontController']['baseUrl'];

        $url = $baseUrl.'/public/editor';
        return $url;
    }
}