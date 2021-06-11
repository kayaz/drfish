<?php
class Form_InlineForm extends Zend_Form
{ 
    public function __construct($options = null)
    {
        $this->addElementPrefixPath('App', 'App/');
        parent::__construct($options);
        $this->setName('zendForm');
		$this->setAttrib('enctype', 'multipart/form-data');
		$this->setAttrib('class', 'mainForm');

        $nazwa = new Zend_Form_Element_Text('modaltytul');
        $nazwa->setLabel('Tytuł')
		->setRequired(true)
		->setAttrib('size', 83)
		->setAttrib('class', 'validate[required] form-control')
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group form-modaltytul'))));
		
        $tekst = new Zend_Form_Element_Text('modaleditor');
        $tekst->setLabel('Tekst')
		->setRequired(true)
		->setAttrib('size', 83)
		->setAttrib('class', 'validate[required] form-control')
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group form-modaleditor'))));

        $tresc = new Zend_Form_Element_Textarea('modaleditortext');
        $tresc->setLabel('Treść')
		->setRequired(true)
		->setAttrib('rows', 19)
		->setAttrib('cols', 100)
		->setAttrib('class', 'editor')
		->setAttrib('id', 'modaleditortext')
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'fullformRowtext')),
		array('Label'), array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group form-modaleditortext'))));
		
        $link = new Zend_Form_Element_Text('modallink');
        $link->setLabel('Button link')
		->setRequired(true)
		->setAttrib('size', 83)
		->setAttrib('class', 'validate[required] form-control')
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group form-modallink'))));
		
        $linkbutton = new Zend_Form_Element_Text('modallinkbutton');
        $linkbutton->setLabel('Button tekst')
		->setRequired(true)
		->setAttrib('size', 83)
		->setAttrib('class', 'validate[required] form-control')
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group form-modallinkbutton'))));
		
		$obrazek = new Zend_Form_Element_File('obrazek');
		$obrazek->setLabel('Obrazek')
		->setRequired(false)
		->addValidator('NotEmpty')
		->addValidator('Extension', false, 'jpg, png, jpeg, gif')
		->setAttrib('class', 'validate[checkFileType[jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF]]')
		->addValidator('Size', false, 4020400)
		->setDecorators(array(
		'File',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group form-obrazek'))));
		
        $obrazek_alt = new Zend_Form_Element_Text('obrazek_alt');
        $obrazek_alt->setLabel('Tytuł obrazka')
		->setRequired(true)
		->setAttrib('size', 83)
		->setAttrib('class', 'validate[required] form-control')
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group form-obrazek_alt'))));
		
		$id_element = new Zend_Form_Element_Hidden('id_element');
		$id_element->setDecorators(array(
		'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group form-hidden'))));
		
	    $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel ('Zapisz')
		->setAttrib('class', 'btn btn-primary')
		->setDecorators(array(
		'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'div'))));

		$this->setDecorators(array('FormElements',array('HtmlTag'),'Form'));
        $this->addElements(array(
			$nazwa,
			$tekst,
			$tresc,
			$link,
			$linkbutton,
			$obrazek,
			$obrazek_alt, 
			$id_element,
			$submit
		));
    }
}