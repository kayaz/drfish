<?php

class Admin_WylogujController extends Zend_Controller_Action
{
		public function indexAction()
		{ 
			$db = Zend_Registry::get('db');
			// Czyszczenie starych sesji

			$data2 = time() - (86400);
			$where = $db->quoteInto('modified < ?', $data2);
			$db->delete('session', $where);
			
			$auth = Zend_Auth::getInstance();
            $login = $auth->getIdentity()->login;
			
			$date = date('Y-m-d H:i:s');
			$ip = $_SERVER['REMOTE_ADDR'];
			$data = array('last' => $date, 'ipold' => $ip);
			$whereUser = $db->quoteInto('login = ?', $login);
			$db->update('uzytkownicy', $data, $whereUser);

			Zend_Session::forgetMe();
			Zend_Auth::getInstance()->clearIdentity();
			Zend_Session::destroy();
			$this->_redirect('/logowanie/'); 
		}
}

