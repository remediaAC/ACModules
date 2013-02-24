<?php

// Include applicaiton specific module base
// require_once APPLICATION_PATH . '/resources/ActiveCollabProjectSectionModule.class.php';

class FrossoMailNotifyModule extends AngieModule {
	
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = 'frosso_mail_notify';
	
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	 */
	protected $name = 'frosso_mail_notify';
	
	/*
	 * Versione
	 */
	protected $version = '0.1';
	
	/**
	 * Name of the project object class (or classes) that this module uses
	 *
	 * @var string
	 */
	//protected $project_object_classes = 'Task';
	
	public function getDisplayName(){
		return lang('ActivitiesNotifications - FRosso');
	}
	
	public function getDescription(){
		return lang("Get notified by last activities!");
	}
	
	function defineRoutes(){
		Router::map('frosso_mail_notify', 'frosso_mail_notify', array('controller' => 'frosso_mail_notify', 'action' => 'index'));
		Router::map('frosso_mail_notify_count_new_messages', 'frosso_mail_notify/count-new-messages', array('controller' => 'frosso_mail_notify', 'action' => 'count_new_messages'));
	}
	
	function defineHandlers(){
		EventsManager::listen('on_wireframe_updates', 'on_wireframe_updates');
		EventsManager::listen('on_status_bar', 'on_status_bar');
	}
}