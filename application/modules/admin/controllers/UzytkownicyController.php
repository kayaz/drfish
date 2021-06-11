<?php

class Admin_UzytkownicyController extends kCMS_Admin
{
		public function preDispatch() {
			$this->view->controlname = "Użytkownicy";
			
			$user = Zend_Auth::getInstance()->getIdentity();
			if($user->role == 'user') { return $this->_redirect('/admin/inwestycje/'); }
			
		}
// Pokaz użytkowników
		public function indexAction() {
			$db = Zend_Registry::get('db');
			$this->view->result = $db->fetchAll($db->select()->from('uzytkownicy'));
		}
// Zmien hasło
		public function zmienhasloAction() {
			$db = Zend_Registry::get('db');
			$this->_helper->viewRenderer('form', null, true);
			$this->view->pagename = " - Zmień hasło użytkownika";

			$id = (int)$this->getRequest()->getParam('id');
			$this->view->back = '<div class="back"><a href="'.$this->view->baseUrl().'/admin/uzytkownicy/">Wróć do listy użytkowników</a></div>';
			$this->view->info = '<div class="info">Ustaw bardzo trudne hasło.</div>';

			//Pobranie i wyswietlenie forma
			$form = new Form_HasloForm();
			$this->view->form = $form;		

			// Polskie tlumaczenie errorów
			$polish = kCMS_Polish::getPolishTranslation();
			$translate = new Zend_Translate('array', $polish, 'pl');
			$form->setTranslator($translate);


			//Akcja po wcisnieciu Submita
			if ($this->_request->getPost()) {

				//Odczytanie wartosci z inputów
				$haslo = $this->_request->getPost('haslo');
				$hasloSalt = '1B2M2Y8AsgTpgAmY7PhCfg==';
				$hasloHash = sha1($haslo.strlen($haslo).strrev($haslo).$hasloSalt).strlen($haslo);
				$formData = $this->_request->getPost();
				
				//Sprawdzenie poprawnosci forma
				if ($form->isValid($formData)) {

						//Pomyslnie
						$data = array('haslo' => $hasloHash,);
						$db->update('uzytkownicy', $data, 'id = '.$id);
						$this->_redirect('/admin/uzytkownicy/?message=1');

					} else {
						
						//Wyswietl bledy	
						$this->view->message = '<div class="error">Formularz zawiera błędy</div>';
						$form->populate($formData);

					}
				}
			}
// Dodaj nowego użytkownika
		public function nowyAction() {
			$db = Zend_Registry::get('db');
			$this->_helper->viewRenderer('form', null, true);
			$this->view->pagename = " - Dodaj nowego użytkownika";
			$this->view->back = '<div class="back"><a href="'.$this->view->baseUrl().'/admin/uzytkownicy/">Wróć do listy użytkowników</a></div>';
			$this->view->info = '<div class="info">Ustaw bardzo trudne hasło.</div>';

			// Laduj form
			$form = new Form_NowyUForm();
			$this->view->form = $form;

			// Polskie tlumaczenie errorów
			$polish = kCMS_Polish::getPolishTranslation();
			$translate = new Zend_Translate('array', $polish, 'pl');
			$form->setTranslator($translate);

			if ($this->_request->isPost()) {

				//Odczytanie wartosci z inputów
				$login = $this->_request->getPost('login');
				$mail = $this->_request->getPost('email');
				$haslo = $this->_request->getPost('haslo');
				$typ = $this->_request->getPost('typ');
				$hasloSalt = '1B2M2Y8AsgTpgAmY7PhCfg==';
				$hasloHash = sha1($haslo.strlen($haslo).strrev($haslo).$hasloSalt).strlen($haslo);
				$formData = $this->_request->getPost();

				//Sprawdzenie poprawnosci forma
				if ($form->isValid($formData)) {

					//Pomyslnie
					$data = array(
                        'login' => $login,
                        'email' => $mail,
                        'haslo' => $hasloHash,
                        'role' => $typ
					);
					$db->insert('uzytkownicy', $data);
					$this->_redirect('/admin/uzytkownicy/');

				} else {

					//Wyswietl bledy    
					$this->view->message = '<div class="error">Formularz zawiera błędy</div>';
					$form->populate($formData);

				}
			}
		}
		
// Edytuj panel
		function edytujAction() {
			$db = Zend_Registry::get('db');
			$this->_helper->viewRenderer('form', null, true);

			// Odczytanie id
			$id = (int)$this->_request->getParam('id');
			$user = $db->fetchRow($db->select()->from('uzytkownicy')->where('id = ?', $id));

			$this->view->pagename = " - Edytuj użytkownika: ".$user->login;
			$this->view->back = '<div class="back"><a href="'.$this->view->baseUrl().'/admin/uzytkownicy/">Wróć do listy uzytkowników</a></div>';

			$form = new Form_NowyUForm();
			$this->view->form = $form;
			
			$form->removeElement('login');
			$form->removeElement('haslo');
			$form->removeElement('email');

			// Polskie tlumaczenie errorów
			$polish = kCMS_Polish::getPolishTranslation();
			$translate = new Zend_Translate('array', $polish, 'pl');
			$form->setTranslator($translate);

			// Załadowanie do forma
			$form->typ->setvalue($user->role);

			if ($this->_request->isPost()) {

				//Odczytanie wartosci z inputów
				$typ = $this->_request->getPost('typ');
				$formData = $this->_request->getPost();
				
				//Sprawdzenie poprawnosci forma
				if ($form->isValid($formData)) {
					$data = array('role' => $typ);
					$db->update('uzytkownicy', $data, 'id = '.$id);
					$this->_redirect('/admin/uzytkownicy/');
				} else {
					
					//Wyswietl bledy    
					$this->view->message = '<div class="error">Formularz zawiera błędy</div>';
					$form->populate($formData);
				}
			}
		}
		
// Usuń użytkownika
		public function usunAction() {
			$db = Zend_Registry::get('db');
			$id = (int)$this->_request->getParam('id');
			$where = $db->quoteInto('id = ?', $id);
			$db->delete('uzytkownicy', $where);
			$this->_redirect('/admin/uzytkownicy/?message=2');
		}
}