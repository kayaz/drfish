<?php

class Zend_View_Helper_BaseUrl extends Zend_View_Helper_Abstract {

    public function baseUrl() {
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $configUrl = $config->getOption('resources');
        return $baseUrl = $configUrl['frontController']['baseUrl'];
    }
}