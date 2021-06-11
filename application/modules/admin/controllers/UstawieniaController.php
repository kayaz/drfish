<?php

class Admin_UstawieniaController extends kCMS_Admin
{
			public function indexAction() {
			$db = Zend_Registry::get('db');
			
			
			$user = Zend_Auth::getInstance()->getIdentity();
			if($user->role == 'user') { return $this->_redirect('/admin/inwestycje/'); }
			

			//Ustawienia główne strony
			if ($this->_request->getPost('submitUstawienia', false)) {

				$nazwa = $this->_request->getPost('nazwa');
				$opis = $this->_request->getPost('opis');
				$adres = $this->_request->getPost('adres');
				$mail = $this->_request->getPost('mail');
				$head = $this->_request->getPost('head');
				$afterbody = $this->_request->getPost('afterbody');
				$footer = $this->_request->getPost('footer');
				$robots = $this->_request->getPost('robots');
				$autor = $this->_request->getPost('autor');
				
				$stopka = $this->_request->getPost('stopka');
				$cookies = $this->_request->getPost('cookies');

				$data = array(
					'nazwa' => $nazwa,
					'opis' => $opis,
					'domena' => $adres,
					'email' => $mail,
					'robots' => $robots,
					'head' => $head,
					'afterbody' => $afterbody,
					'autor' => $autor,
					'footer' => $footer,
					'stopka' => $stopka,
					'cookies' => $cookies,
				);
				$db->update('ustawienia', $data);
				$this->_redirect('/admin/ustawienia/');
			}
		
		}
		
		public function socialAction() {
			$db = Zend_Registry::get('db');

			//Ustawienia główne strony
			if ($this->_request->getPost('submitSocial', false)) {
				$fb = $this->_request->getPost('fb');
				$tw = $this->_request->getPost('tw');
				$gplus = $this->_request->getPost('gplus');
				$yt = $this->_request->getPost('yt');

				$share_tytul = $this->_request->getPost('share_tytul');
				$share_opis = $this->_request->getPost('share_opis');
				
				$obrazek = $_FILES['obrazek']['name'];
				$plik = slugImg('share', $obrazek);

				$data = array(
					'fb' => $fb,
					'tw' => $tw,
					'yt' => $yt,
					'gplus' => $gplus,
					'share_opis' => $share_opis,
					'share_tytul' => $share_tytul,
				);
				$db->update('ustawienia', $data);
				
				if ($obrazek) {
					//Usuwanie starych zdjęć
					$wpis = $this->view->firma = $db->fetchRow($db->select()->from('ustawienia'));
					unlink(FILES_PATH."/share/".$wpis->share_plik);

					move_uploaded_file($_FILES['obrazek']['tmp_name'], FILES_PATH.'/share/'.$plik);
					$upfile = FILES_PATH.'/share/'.$plik;
					chmod($upfile, 0755);
					$dataImg = array('share_plik' => $plik);
					$db->update('ustawienia', $dataImg);
					
				}
				$this->_redirect('/admin/ustawienia/social/');
			}
		}
		
		public function backupAction() {
			//Ustawienia główne strony
			 if ($this->_request->getPost('submitBackup', false)) {
				 $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
				 $db = $config->getOption('resources');
				 $dbUsername = $db['db']['params']['username'];
				 $dbPassword = $db['db']['params']['password'];
				 $host = $db['db']['params']['host'];
				 $dbName = $db['db']['params']['dbname'];

				
				 $backupfile = BACKUP_PATH . '/'.$dbName .'-'. date("Y-m-d") . '.sql';
				 system("mysqldump --host=$host --user=$dbUsername --password=$dbPassword $dbName > $backupfile");
				 $this->_redirect('/admin/ustawienia/backup/');
		    }
		}

		public function mapaAction() {
			$db = Zend_Registry::get('db');

			//Ustawienia główne strony
			if ($this->_request->getPost('submitUstawienia', false)) {
				$kontakt_telefon = $this->_request->getPost('kontakt_telefon');
				$kontakt_email = $this->_request->getPost('kontakt_email');

				$data = array(
					'kontakt_telefon' => $kontakt_telefon,
					'kontakt_email' => $kontakt_email
				);
				$db->update('ustawienia', $data);
				$this->_redirect('/admin/ustawienia/mapa/');
			}
		}
		
		public function banerAction() {
			$db = Zend_Registry::get('db');
			$this->view->tinymce = "1";
			$form = new Form_PopForm();
			$this->view->form = $form;

			// Polskie tlumaczenie errorów
			$polish = kCMS_Polish::getPolishTranslation();
			$translate = new Zend_Translate('array', $polish, 'pl');
			$form->setTranslator($translate);

			// Odczyt z bazy
			$site = $db->fetchRow($db->select()->from('ustawienia'));

			// Załadowanie do forma
			$form->status->setvalue($site->popup_status);
			$form->tryb->setvalue($site->popup_tryb);
			$form->tekst->setvalue($site->popup_tekst);

			//Akcja po wcisnieciu Submita
			if ($this->_request->getPost()) {
				
				//Odczytanie wartosci z inputów
				$tryb = $this->_request->getPost('tryb');
				$status = $this->_request->getPost('status');
				$tekst = $this->_request->getPost('tekst');
				$formData = $this->_request->getPost();

				//Sprawdzenie poprawnosci forma
				if ($form->isValid($formData)) {

					//Pomyslnie
					$data = array('popup_tekst' => $tekst, 'popup_status' => $status, 'popup_tryb' => $tryb);
					$db->update('ustawienia', $data);
					$this->_redirect('/admin/ustawienia/baner/');
				} else {
					//Wyswietl bledy	
					$form->populate($formData);
					$this->view->message = 2;
				}
			}
		}
}