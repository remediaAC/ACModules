<?php
// Build on top of reports module
AngieApplication::useController('reports', REPORTS_FRAMEWORK_INJECT_INTO);

class FrossoTestingController extends ReportsController {
	
	/**
	 * Index action
	 */
	function index() {
		
	}
	
}