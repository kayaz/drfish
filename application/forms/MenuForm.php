<?php
class Form_MenuForm extends Zend_Form
{
    public function __construct($options = null)
    {
        $this->addElementPrefixPath('App', 'App/');
        parent::__construct($options);
        $this->setName('nazwa');
        $this->setAttrib('class', 'mainForm');

        $nazwa = new Zend_Form_Element_Text('nazwa');
        $nazwa->setLabel('Nazwa')
            ->setRequired(true)
            ->setAttrib('size', 83)
            ->setAttrib('class', 'validate[required]')
            ->setFilters(array('StripTags', 'StringTrim'))
            ->addValidator('NotEmpty')
            ->setDecorators(array(
                'ViewHelper',
                'Errors',
                array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRight')),
                array('Label'),
                array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formRow'))));

        $nazwa_en = new Zend_Form_Element_Text('nazwa_en');
        $nazwa_en->setLabel('Nazwa EN')
            ->setRequired(true)
            ->setAttrib('size', 83)
            ->setAttrib('class', 'validate[required]')
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
                array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'formSubmit'))));

        $this->setDecorators(array('FormElements',array('HtmlTag'),'Form',));
        $this->addElements(array($nazwa, $nazwa_en, $submit));
    }
}