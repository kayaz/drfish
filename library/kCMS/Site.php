<?php
require_once 'Zend/Controller/Action.php';
abstract class kCMS_Site extends Zend_Controller_Action {

    public function init() {
        try {
            $db = Zend_Registry::get('db');
        } catch (Zend_Exception $e) {

        }

        $front = Zend_Controller_Front::getInstance();
        $request = $front->getRequest();
        $header = $db->fetchRow($db->select()->from('ustawienia'));

        $sitearray = array(
            'header' => $header,
            'current_action' => $request->getActionName(),
            'current_controller' => $request->getControllerName()
        );
        $this->view->assign($sitearray);
	}
}