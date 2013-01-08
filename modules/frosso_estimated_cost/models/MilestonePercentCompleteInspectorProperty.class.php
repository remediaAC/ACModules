<?php
 class MilestonePercentCompleteInspectorProperty extends InspectorProperty {
 	
 	
 	/**
 	 * Remedia Milestone object
 	 * 
 	 * @var RemediaMilestone
 	 */
 	private $object = null;
 	
 	/**
 	 * Constructor
 	 *
 	 * @param Milestone $object
 	 */
 	function __construct($object) {
 		if($object instanceof RemediaMilestone) {
 			$this->object = $object;
 		} else {
 			$this->object = new RemediaMilestone ( $object->getId() );
 		}
 	} // __construct
 	
 	function render() {
//  		return "alert('".$this->object->getPercentsDone(false)."')";

 		return '(function (field, object, client_interface) {
 				var obj = '.JSON::encode($this->object).';
 				var route = "'.Router::assemble("frosso_ec_set_milestone_percent", 
 						array(
 								"project_slug" => $this->object->getProject()->getSlug(), 
 								"milestone_id" => $this->object->getId()
 								)
 						).'";
 				App.Inspector.Properties.MilestoneCustomComplete.apply(field, [obj, client_interface, route]);
 			})';
 	}
 	
 }