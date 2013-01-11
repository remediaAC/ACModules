<?php

class FrossoAuthenticationModule extends AngieModule {
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	*/
	protected $name = 'frosso_authentication';
	
	/*
	 * Versione
	*/
	protected $version = '0.5';
	
	public function getDisplayName(){
		return lang('SSO - FRosso per reMedia');
	}
	
	public function getDescription(){
		return lang("Modulo creato per customizzare il metodo di autenticazione");
	}
	
	function defineRoutes(){
		// Login route
		Router::map('auth_login_frosso', 'login-frosso', array('controller' => 'frosso_auth', 'action' => 'login'));
		
		// Admin Route
		Router::map('auth_login_frosso_admin', 'admin/login-frosso-config', array('controller' => 'frosso_auth_admin'));
	}
	
	/**
	 * Define event handlers
	 */
	function defineHandlers() {
		EventsManager::listen('on_admin_panel', 'on_admin_panel');
	} // defineHandlers
	
	function install() {
		ConfigOptions::addOption('frosso_auth_my_pub_key', FROSSO_AUTH_MODULE, '');
		ConfigOptions::addOption('frosso_auth_my_pri_key', FROSSO_AUTH_MODULE, '');
		parent::install();
	}
	
}