<?php
require_once 'kCMS/Thumbs/ThumbLib.inc.php';

class Admin_MenuController extends kCMS_Admin
{
    public function preDispatch() {
        $this->view->controlname = "Menu";
    }
################################################ ZDJĘCIA PRODUKTÓW ################################################

// Kategorie
    public function indexAction() {
        $db = Zend_Registry::get('db');
        $this->view->katalog = $db->fetchAll($db->select()->from('menu_kategorie')->order('sort ASC'));
    }

// Pokaz dania wybranej kategorii
    public function pokazAction() {
        $db = Zend_Registry::get('db');
        $this->view->kat = $id = (int)$this->getRequest()->getParam('id');
        $this->view->katalog = $db->fetchRow($db->select()->from('menu_kategorie')->where('id =?', $id));
        $this->view->zdjecia = $db->fetchAll($db->select()->from('menu_danie')->order('sort ASC')->where('kat_id =?', $id));
    }

// Dodaj
    public function nowaAction() {
        $db = Zend_Registry::get('db');
        $this->_helper->viewRenderer('form', null, true);
        $this->view->pagename = " - Nowa kategoria";
        $this->view->back = '<div class="back"><a href="'.$this->view->baseUrl.'/admin/menu/">Wróć do listy galerii</a></div>';

        $form = new Form_MenuForm();
        $this->view->form = $form;

        // Polskie tlumaczenie errorów
        $polish = kCMS_Polish::getPolishTranslation();
        $translate = new Zend_Translate('array', $polish, 'pl');
        $form->setTranslator($translate);

        //Akcja po wcisnieciu Submita
        if ($this->_request->getPost()) {

            //Odczytanie wartosci z inputów
            $nazwa = $this->_request->getPost('nazwa');
            $nazwa_en = $this->_request->getPost('nazwa_en');
            $formData = $this->_request->getPost();

            //Sprawdzenie poprawnosci forma
            if ($form->isValid($formData)) {

                $data = array(
                    'nazwa' => $nazwa,
                    'nazwa_en' => $nazwa_en,
                );

                $db->insert('menu_kategorie', $data);
                $this->_redirect('/admin/menu/');


            } else {

                //Wyswietl bledy
                $this->view->message = '<div class="error">Formularz zawiera błędy</div>';
                $form->populate($formData);

            }
        }
    }

// Edytuj
    public function edytujAction() {
        $db = Zend_Registry::get('db');
        $this->_helper->viewRenderer('form', null, true);
        $this->view->pagename = " - Edytuj kategorię";
        $this->view->back = '<div class="back"><a href="'.$this->view->baseUrl.'/admin/menu/">Wróć do listy</a></div>';

        $form = new Form_MenuForm();
        $this->view->form = $form;

        // Polskie tlumaczenie errorów
        $polish = kCMS_Polish::getPolishTranslation();
        $translate = new Zend_Translate('array', $polish, 'pl');
        $form->setTranslator($translate);

        // Odczytanie id
        $id = (int)$this->getRequest()->getParam('id');
        $katalog = $db->fetchRow($db->select()->from('menu_kategorie')->where('id = ?',$id));

        // Załadowanie do forma
        $form->nazwa->setvalue($katalog->nazwa);
        $form->nazwa_en->setvalue($katalog->nazwa_en);

        //Akcja po wcisnieciu Submita
        if ($this->_request->getPost()) {

            //Odczytanie wartosci z inputów
            $nazwa = $this->_request->getPost('nazwa');
            $nazwa_en = $this->_request->getPost('nazwa_en');
            $formData = $this->_request->getPost();

            //Sprawdzenie poprawnosci forma
            if ($form->isValid($formData)) {

                $data = array(
                    'nazwa' => $nazwa,
                    'nazwa_en' => $nazwa_en,
                );
                $where['id = ?'] = $id;
                $db->update('menu_kategorie', $data, $where);
                $this->_redirect($this->view->baseUrl.'/admin/menu/');

            } else {

                //Wyswietl bledy
                $this->view->message = '<div class="error">Formularz zawiera błędy</div>';
                $form->populate($formData);

            }
        }
    }

// Usun
    public function usunKatalogAction() {
        $db = Zend_Registry::get('db');
        $id = (int)$this->_request->getParam('id');
        $where = $db->quoteInto('id = ?', $id);
        $count = $db->fetchAll($db->select()->from('menu_danie')->where('kat_id = ?',$id));

        $this->_redirect('/admin/menu/');
    }

// Ustaw kolejność
    public function ustawAction() {
        $db = Zend_Registry::get('db');
        $tabela = $this->_request->getParam('co');
        $updateRecordsArray = $_POST['recordsArray'];
        $listingCounter = 1;
        foreach ($updateRecordsArray as $recordIDValue) {
            $data = array('sort' => $listingCounter);
            $db->update($tabela, $data, 'id = '.$recordIDValue);
            $listingCounter = $listingCounter + 1;
        }
    }

################################################ PRODUKTY/ZDJĘCIA ################################################

// Dodaj nowy wpis
    public function noweDanieAction() {
        $db = Zend_Registry::get('db');
        $this->_helper->viewRenderer('form', null, true);
        $this->view->pagename = " - Nowe danie";

        $kat = (int)$this->_request->getParam('kat');

        $this->view->back = '<div class="back"><a href="'.$this->view->baseUrl.'/admin/menu/pokaz/id/'.$kat.'/">Wróć do listy</a></div>';
        $this->view->info = '<div class="info">Wymiary miniaturki: szerokość <b>200 px</b> / wysokość <b>165 px</b></div>';

        $form = new Form_DanieForm();
        $this->view->form = $form;

        //Akcja po wcisnieciu Submita
        if ($this->_request->getPost()) {

            //Odczytanie wartosci z inputów
            $formData = $this->_request->getPost();
            unset($formData['MAX_FILE_SIZE']);
            unset($formData['obrazek']);
            unset($formData['submit']);

            $obrazek = $_FILES['obrazek']['name'];
            if($_FILES['obrazek']['size'] > 0) {
                $plik = slugImg($formData['nazwa'], $obrazek);
            }
            $formData['kat_id'] = $kat;

            //Sprawdzenie poprawnosci forma
            if ($form->isValid($formData)) {

                $db->insert('menu_danie', $formData);
                $lastId = $db->lastInsertId();

                //Miniaturka na liscie
                if ($obrazek) {

                    move_uploaded_file($_FILES['obrazek']['tmp_name'], FILES_PATH.'/menu/'.$plik);
                    $thumbs = FILES_PATH.'/menu/'.$plik;
                    chmod($thumbs, 0755);

                    $options = array('jpegQuality' => 90);
                    PhpThumbFactory::create($thumbs, $options)->adaptiveResizeQuadrant(200, 165)->save($thumbs);
                    $dataImg = array('plik' => $plik);
                    $db->update('menu_danie', $dataImg, 'id = '.$lastId);

                }

                $this->_redirect('/admin/menu/pokaz/id/'.$kat);

            } else {

                //Wyswietl bledy
                $this->view->message = '<div class="error">Formularz zawiera błędy</div>';
                $form->populate($formData);

            }
        }
    }
// Edytuj wpis
    public function edytujDanieAction() {
        $db = Zend_Registry::get('db');
        $this->_helper->viewRenderer('form', null, true);

        $form = new Form_DanieForm();
        $this->view->form = $form;

        // Odczytanie id
        $id = (int)$this->getRequest()->getParam('id');
        $wpis = $db->fetchRow($db->select()->from('menu_danie')->where('id = ?', $id));
        $this->view->pagename = " - Edytuj: ".$wpis->nazwa;

        $this->view->back = '<div class="back"><a href="'.$this->view->baseUrl.'/admin/menu/pokaz/id/'.$wpis->kat_id.'/">Wróć do listy</a></div>';
        $this->view->info = '<div class="info">Wymiary miniaturki: szerokość <b>200 px</b> / wysokość <b>165 px</b></div>';

        // Załadowanie do forma
        $array = json_decode(json_encode($wpis), true);
        $form->populate($array);

        //Akcja po wcisnieciu Submita
        if ($this->_request->getPost()) {

            //Odczytanie wartosci z inputów
            $formData = $this->_request->getPost();
            unset($formData['MAX_FILE_SIZE']);
            unset($formData['obrazek']);
            unset($formData['submit']);

            $obrazek = $_FILES['obrazek']['name'];
            if($_FILES['obrazek']['size'] > 0) {
                $plik = slugImg($formData['nazwa'], $obrazek);
            }
            //Sprawdzenie poprawnosci forma
            if ($form->isValid($formData)) {

                $db->update('menu_danie', $formData, 'id = '.$id);

                //Miniaturka na liscie
                if ($obrazek) {
                    unlink(FILES_PATH."/menu/".$wpis->plik);
                    move_uploaded_file($_FILES['obrazek']['tmp_name'], FILES_PATH.'/menu/'.$plik);
                    $thumbs = FILES_PATH.'/menu/'.$plik;
                    chmod($thumbs, 0755);
                    require_once 'kCMS/Thumbs/ThumbLib.inc.php';

                    $options = array('jpegQuality' => 80);
                    PhpThumbFactory::create($thumbs, $options)->adaptiveResizeQuadrant(200, 165)->save($thumbs);
                    $dataImg = array('plik' => $plik);
                    $db->update('menu_danie', $dataImg, 'id = '.$id);

                }

                $this->_redirect('/admin/menu/pokaz/id/'.$wpis->kat_id);

            } else {

                //Wyswietl bledy
                $this->view->message = '<div class="error">Formularz zawiera błędy</div>';
                $form->populate($formData);

            }
        }
    }

// Usuń
    public function usunDanieAction() {
        $db = Zend_Registry::get('db');
        $id = (int)$this->_request->getParam('id');
        $wpis = $db->fetchRow($db->select()->from('menu_danie')->where('id = ?', $id));
        unlink(FILES_PATH."/menu/".$wpis->plik);
        $where = $db->quoteInto('id = ?', $id);
        $db->delete('menu_danie', $where);
        $this->_redirect('/admin/menu/pokaz/id/'.$wpis->kat_id);
    }
}