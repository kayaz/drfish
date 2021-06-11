<?php
require_once 'kCMS/Thumbs/ThumbLib.inc.php';
class Default_InlineController extends kCMS_Site
{
    public function loadinlineAction() {
        $this->getHelper('Layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $id = (int)$this->_request->getParam('id');
        $lang = $this->getRequest()->getParam('language');

        $inlineModel = new Model_InlineModel();
        $inline = $inlineModel->getInlineItem($id);

        if(!$inline){
            $responseArray = array(
                'error' => 'Brak wpisu w bazie! Zapisując dodasz tłumaczenie do języka: '.$lang,
                'id' => $id
            );
            $this->_helper->json->sendJson($responseArray);
        } else {
            unset($inline->id);
            unset($inline->obrazek);
            $this->_helper->json->sendJson($inline);
        }
    }

    public function zapiszinlineAction() {
        $this->getHelper('Layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->getResponse()->setHeader('Content-Type', 'application/json');

        $id = (int)$this->_request->getParam('id');
        $method = $this->_request->getParam('metoda');

        $inlineModel = new Model_InlineModel();
        $inlineQuery = $inlineModel->getInlineItem($id);

        $formData = $this->_request->getPost();
        unset($formData['MAX_FILE_SIZE']);
        unset($formData['obrazek']);
        unset($formData['id_element']);

        if($method == 'update'){

            $inlineModel->updateInline($id, $formData);

            if($_FILES['obrazek']['size'] > 0) {

                $plik = date('mdhis').'-'.slugImg($formData['obrazek_alt'], $_FILES['obrazek']['name']);

                unlink(FILES_PATH."/inline/".$inlineQuery->obrazek);

                move_uploaded_file($_FILES['obrazek']['tmp_name'], FILES_PATH.'/inline/'.$plik);
                $uploadFile = FILES_PATH.'/inline/'.$plik;
                chmod($uploadFile, 0755);

                $options = array('jpegQuality' => 80);
                PhpThumbFactory::create($uploadFile, $options)
                    ->adaptiveResizeQuadrant($formData['obrazek_width'], $formData['obrazek_height'])
                    ->save($uploadFile);
                chmod($uploadFile, 0755);

                $dataImg = array('obrazek' => $plik);
                $inlineModel->updateInline($id, $dataImg);

                $formData['obrazek'] = $plik;

            }

            $responseArray = array(
                'status' => 'success',
                'items' => array_filter($formData),
                'item' => $id
            );

            $this->_helper->json->sendJson($responseArray);
        }

        if($method == 'add'){

            $inlineElement = $inlineModel->get($id);

            $formData['id_place'] = $inlineElement->id_place;
            $formData['id_item'] = $inlineElement->id_item;
            $formData['lang'] = Zend_Registry::get('Zend_Locale')->getLanguage();
            $inlineModel->save($formData);

            if($_FILES['obrazek']['size'] > 0) {

                $plik = date('mdhis').'-'.slugImg($formData['obrazek_alt'], $_FILES['obrazek']['name']);
                move_uploaded_file($_FILES['obrazek']['tmp_name'], FILES_PATH.'/inline/'.$plik);
                $uploadFile = FILES_PATH.'/inline/'.$plik;
                chmod($uploadFile, 0755);

                $options = array('jpegQuality' => 80);
                PhpThumbFactory::create($uploadFile, $options)
                    ->adaptiveResizeQuadrant($formData['obrazek_width'], $formData['obrazek_height'])
                    ->save($uploadFile);
                chmod($uploadFile, 0755);

                $dataImg = array('obrazek' => $plik);
                $inlineModel->updateInline($inlineElement->id_item, $dataImg);

                $formData['obrazek'] = $plik;

            }
            $responseArray = array(
                'status' => 'success',
                'items' => array_filter($formData),
                'item' => $inlineElement->id_item
            );

            $this->_helper->json->sendJson($responseArray);
        }
    }
}