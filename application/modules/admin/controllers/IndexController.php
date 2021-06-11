<?php

class Admin_IndexController extends kCMS_Admin
{
		
		public function preDispatch() {
			$this->_redirect('/admin/ustawienia/');
	
		}
}