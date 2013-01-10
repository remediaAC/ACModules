<?php
 class MilestonePercentCompleteInspectorProperty extends InspectorProperty {
 	
 	
 	/**
 	 * Set_milestone_percent object
 	 * 
 	 * @var String
 	 */
 	private $route = null;
 	
 	/**
 	 * Constructor
 	 *
 	 * @param Milestone $object
 	 */
 	function __construct($object) {
 		$this->route = Router::assemble("frosso_ec_set_milestone_percent", 
 						array(
 								"project_slug" => $object->getProject()->getSlug(), 
 								"milestone_id" => $object->getId()
 								)
 						);
 	} // __construct
 	
 	function render() {
 		return '(function (field, object, client_interface) {
 				var route = "'.$this->route.'";
 				App.Inspector.Properties.MilestoneCustomComplete.apply(field, [object, client_interface, route]);
 			})';
 	}
 	
 }