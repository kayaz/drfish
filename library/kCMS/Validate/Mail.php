<?php

class kCMS_Validate_Mail extends Zend_Validate_Abstract
{
const USERNAME_TAKEN = 'mailtaken';

protected $_messageTemplates = array(
self::USERNAME_TAKEN => 'Adres e-mail jest już zarejestrowany.'
);

public function isValid($value, $context = null)
{
$value = (string) $value;
$this->_setValue($value);

$db = Zend_Registry::get('db');
$result = $db->fetchRow($db->select()->from('uzytkownicy')->where('email =?', $value));

if($result) 
{
$this->_error(self::USERNAME_TAKEN);
return false; 
}else{
return true; 
} 
}
}

?>