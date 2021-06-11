<?php
class Default_IndexController extends kCMS_Site
{
    private $inlineModel;

    public function preDispatch() {
        $this->inlineModel = new Model_InlineModel();
    }

    public function indexAction() {
        $db = Zend_Registry::get('db');

        $array = array(
            'inline' => $this->inlineModel->getInlineList(1),
            'kategorie' => $db->fetchAll($db->select()->from('menu_kategorie')->order('sort ASC')),
            'dania' => $db->fetchAll($db->select()->from('menu_danie')->order('sort ASC')),
            'editinline' => 1
        );

        $this->view->assign($array);
    }
}