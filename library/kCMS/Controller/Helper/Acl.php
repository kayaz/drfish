<?php
class kCMS_Controller_Helper_Acl
{
	public $acl;
	public function __construct()
	{
		$this->acl = new Zend_Acl();
	}
	public function setRoles()
	{
		$this->acl->addRole(new Zend_Acl_Role('guest'))
		->addRole(new Zend_Acl_Role('user'))
		->addRole(new Zend_Acl_Role('admin'));
	}

	public function setResources()
	{
		$this->acl->add(new Zend_Acl_Resource('admin'));
		$this->acl->add(new Zend_Acl_Resource('default'));
		$this->acl->add(new Zend_Acl_Resource('logowanie'));
	}

	public function setPrivilages()
	{
		// Gość
		$this->acl->deny('guest', 'admin');
		$this->acl->allow('guest', 'default');
		$this->acl->allow('guest', 'logowanie');

		// Użytkownik
		$this->acl->allow('user', 'admin');
		$this->acl->allow('user', 'default');
		$this->acl->allow('user', 'logowanie');

		// Administrator
		$this->acl->allow('admin');
	}

	public function setAcl()
	{
		Zend_Registry::set('acl', $this->acl);
	}
}