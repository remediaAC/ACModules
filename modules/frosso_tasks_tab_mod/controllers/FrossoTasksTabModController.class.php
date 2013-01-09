<?php

if(AngieApplication::isModuleLoaded('tasks_plus')) {
	require_once dirname(__FILE__) . '/TasksPlusEnabledController.class.php';
} else {
	require_once dirname(__FILE__) . '/TasksPlusDisabledController.class.php';
}