<?php

class kCMS_Validate_Haslo extends Zend_Validate_Abstract
{
const USERNAME_TAKEN = 'oldpassword';

protected $_messageTemplates = array(
self::USERNAME_TAKEN => 'Złe hasło'
);

public function isValid($value, $context = null)
{
$value = (string)$value;
$this->_setValue($value);
$hasloSalt = '1B2M2Y8AsgTpgAmY7PhCfg==';
$hasloHash = sha1($value.strlen($value).strrev($value).$hasloSalt).strlen($value);

$db = Zend_Registry::get('db');
$result = $db->fetchRow($db->select()->from('uzytkownicy')->where('haslo =?', $hasloHash));
if(!$result) 
{
$this->_error(self::USERNAME_TAKEN);
return false; 
}else{
return true; 
} 
}
}

?>