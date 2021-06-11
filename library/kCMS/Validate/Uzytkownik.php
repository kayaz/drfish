<?php

class kCMS_Validate_Uzytkownik extends Zend_Validate_Abstract
{
const USERNAME_TAKEN = 'usernametaken';

protected $_messageTemplates = array(
self::USERNAME_TAKEN => 'Taki użytkownik już istnieje'
);

public function isValid($value, $context = null)
{
$value = (string) $value;
$this->_setValue($value);

$db = Zend_Registry::get('db');
$result = $db->fetchRow($db->select()->from('uzytkownicy')->where('login =?', $value));

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