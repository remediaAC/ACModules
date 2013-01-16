<?php

class TestingEnvironmentFrossoModule extends AngieModule {
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = 'testing_environment_frosso';
	
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	*/
	protected $name = 'testing_environment_frosso';
	
	/*
	 * Versione
	*/
	protected $version = '0.1';
	
	public function getDisplayName(){
		return lang('Test - FRosso per reMedia');
	}
	
	public function getDescription(){
		return lang("Test environment");
	}
	
	function defineRoutes(){
		Router::map('frosso_testing_route', 'frosso-test', array('controller' => 'frosso_testing', 'action' => 'index'));
	}
	
	function defineHandlers(){
	}
	
	function install(){
		return parent::install();
	}
	
}