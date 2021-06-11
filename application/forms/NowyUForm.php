<?php
class Form_NowyUForm extends Zend_Form 
{
    public function __construct($options = null)
    {
        $this->addElementPrefixPath('App', 'App/');
        parent::__construct($options);
        $this->setName('nowyuzytkownik');
		$this->setAttrib('class', 'mainForm');

		$haslo = new Zend_Form_Element_Password('haslo');
        $haslo->setLabel('Hasło')
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

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Adres email')
		->addPrefixPath('kCMS_Validate', 'kCMS/Validate/', 'validate')
		->addValidator('Mail')
		->setAttrib('class', 'validate[required],custom[email]')
		->setAttrib('size', 47)
		->addValidator('NotEmpty')
		->setFilters(array('StripTags', 'StringTrim'))
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRow'))));

		$login = new Zend_Form_Element_Text('login');
        $login->setLabel('Login')
		->addPrefixPath('kCMS_Validate', 'kCMS/Validate/', 'validate')
		->addValidator('Uzytkownik')
		->setRequired(true)
		->setAttrib('class', 'validate[required]')
		->setAttrib('size', 47)	
		->addValidator('stringLength', false, array(3, 128))
		->setFilters(array('StripTags', 'StringTrim'))
		->addValidator('NotEmpty')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRow'))));

		$typ = new Zend_Form_Element_Select('typ');
        $typ->setLabel('Typ')
		->addMultiOption('admin','Administrator')
		->addMultiOption('user','Sprzedawca')
		->setDecorators(array(
		'ViewHelper',
		'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
		array('Label'),
		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRow'))));

	    $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel ('Dodaj użytkownika')
		->setAttrib('class', 'greyishBtn')
		->setDecorators(array(
		'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formSubmit'))));

		$this->setDecorators(array('FormElements',array('HtmlTag'),'Form',));
        $this->addElements(array($login, $email, $haslo, $typ, $submit));

    }
}