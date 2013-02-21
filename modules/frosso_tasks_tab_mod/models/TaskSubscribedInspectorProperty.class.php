<?php

class TaskSubscribedInspectorProperty extends InspectorProperty {
	
	function __construct($object) {
		
	}
	
	function render() {
		return '(function (field, object, client_interface) { App.Inspector.Properties.TaskSubscribers.apply(field, [object, client_interface]) })';
	}
}
