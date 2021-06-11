<?php

class Logowanie_IndexController extends kCMS_Site
{
	public function preDispatch() {
		$sciezka = new kCMS_Sciezka();
		$sciezka->saveRequestUri();
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
	}

    function indexAction() 
    { 

		// Czyszczenie starych sesji
		$db = Zend_Registry::get('db');
		$data2 = time() - (86400);
		$where = $db->quoteInto('modified < ?', $data2);
		$db->delete('session', $where);

        if ($this->_request->isPost()) {
			$login = $this->_request->getPost('login');
			$haslo = $this->_request->getPost('haslo');
			$remember = $this->_request->getPost('remember');
			
			$db = Zend_Db_Table::getDefaultAdapter();
			$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'uzytkownicy', 'login', 'haslo');
			$authAdapter->setIdentity($login);
			$hasloSalt = '1B2M2Y8AsgTpgAmY7PhCfg==';
			$hasloHash = sha1($haslo.strlen($haslo).strrev($haslo).$hasloSalt).strlen($haslo);
			$authAdapter->setCredential($hasloHash);
			$result = $authAdapter->authenticate();
			
			if ($result->isValid()) {
			  // umieszczamy w sesji dane użytkownika
			  $auth = Zend_Auth::getInstance();
			  $storage = $auth->getStorage();
			  $storage->write($authAdapter->getResultRowObject(null, 'haslo'));


			if ($remember) {
				Zend_Session::rememberMe();
			}
			else {
				Zend_Session::forgetMe();
			}
				//$sciezka = new kCMS_Sciezka();
				//$sciezka->redirect();
				//return;

				$date = date('Y-m-d H:i:s');
				$ip = $_SERVER['REMOTE_ADDR'];
				$data = array('now' => $date, 'ip' => $ip);
				$whereUser = $db->quoteInto('login = ?', $login);
				$db->update('uzytkownicy', $data, $whereUser);

				return $this->_redirect('/logowanie/');
			} else {
			  $this->view->loginMessage = "1";
			}

        } 
    }
}