<?php
class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract 
{
    public function loggedInAs ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->login;
            $this->view->userid = $auth->getIdentity()->id;
            return 'Witaj: <b>'.$username.'</b>';
        } 
    }
}
