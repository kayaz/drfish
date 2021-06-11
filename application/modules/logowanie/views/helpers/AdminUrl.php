<?php

class Zend_View_Helper_AdminUrl extends Zend_View_Helper_Abstract {

    public function adminUrl() {
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $configUrl = $config->getOption('resources');
        return $configUrl['frontController']['baseUrl'];
    }
}