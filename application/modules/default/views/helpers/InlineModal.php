<?php
class Zend_View_Helper_InlineModal extends Zend_View_Helper_Abstract {
    public function inlineModal(int $id, string $showFields, string $imageSize = null) {
        $fields = array(
            'modaltytul',
            'modaleditor',
            'modaleditortext',
            'modallink',
            'obrazek',
            'obrazek_alt',
            'modallinkbutton'
        );
        $fields_hidden = explode(',', $showFields);
        $array_diff = array_diff($fields, $fields_hidden);
        $fields_to_hide = implode(',', $array_diff);

        if($imageSize) {
            $imgParam = explode(',', $imageSize);
        }
        if(Zend_Auth::getInstance()->hasIdentity()) {
            return '<div class="container"><div class="row"><div class="col-12 text-center col-inline-nav"><button type="button" class="btn btn-primary btn-modal btn-sm" data-toggle="modal" data-target="#inlineModal" data-inline="' . $id . '" data-hideinput="' . $fields_to_hide . '" data-method="update" data-imgwidth="' . $imgParam[0] . '" data-imgheight="' . $imgParam[1] . '"></button></div></div></div>';
        }
    }
}