<?php

class FrossoAuthenticationModule extends AngieModule {
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	*/
	protected $name = 'frosso_authentication';
	
	/*
	 * Versione
	*/
	protected $version = '0.3';
	
	public function getDisplayName(){
		return lang('Modulo creato da FRosso');
	}
	
	public function getDescription(){
		return lang("Modulo creato per reMedia per customizzare il metodo di autenticazione");
	}
	
	function defineRoutes(){
		Router::map('auth_login_frosso', 'login-frosso', array('controller' => 'frosso_auth', 'action' => 'login'));
	}
	
}