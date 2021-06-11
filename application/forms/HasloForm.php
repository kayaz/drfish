<?php
class Form_HasloForm extends Zend_Form 
{
    public function __construct($options = null)
    {
        $this->addElementPrefixPath('App', 'App/');
        parent::__construct($options);
        $this->setName('password');
		$this->setAttrib('class', 'mainForm');

		$starehaslo = new Zend_Form_Element_Password('starehaslo');
        $starehaslo->addPrefixPath('kCMS_Validate', 'kCMS/Validate/', 'validate')
		->addValidator('Haslo')
		->setLabel('Stare hasło')
		->setAttrib('class', 'validate[required]')
		->setAttrib('size', 35)	
		->addValidator('stringLength', false, array(3, 128))
		->setFilters(array('StripTags', 'StringTrim'))
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRow'))));

		$haslo = new Zend_Form_Element_Password('haslo');
        $haslo->setLabel('Nowe hasło')
		->setAttrib('class', 'validate[required]')
		->setAttrib('size', 35)	
		->setFilters(array('StripTags', 'StringTrim'))
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRow'))));

		$haslo2 = new Zend_Form_Element_Password('haslo2');
        $haslo2->setLabel('Powtórz hasło')
		->setAttrib('class', 'validate[required,equals[haslo]]')
		->setAttrib('size', 35)	
		->setFilters(array('StripTags', 'StringTrim'))
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRow'))));

	    $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel ('Zapisz')
		->setAttrib('class', 'greyishBtn')
		->setDecorators(array(
		'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'submitForm'))));


		$this->setDecorators(array('FormElements',array('HtmlTag'),'Form',));
        $this->addElements(array($starehaslo, $haslo, $haslo2, $submit));

    }
}