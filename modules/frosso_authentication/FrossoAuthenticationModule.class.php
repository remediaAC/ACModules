<?php

class FrossoAuthenticationModule extends AngieModule {
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	*/
	protected $name = 'frosso_authentication';
	
	/*
	 * Versione
	*/
	protected $version = '0.4';
	
	public function getDisplayName(){
		return lang('SSO - FRosso per reMedia');
	}
	
	public function getDescription(){
		return lang("Modulo creato per customizzare il metodo di autenticazione");
	}
	
	function defineRoutes(){
		Router::map('auth_login_frosso', 'login-frosso', array('controller' => 'frosso_auth', 'action' => 'login'));
	}
	
}