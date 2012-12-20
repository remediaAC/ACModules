<?php

  /**
   * on_reports_panel event handler
   */
  
  /**
   * Handle on_reports_panel event
   *
   * @param ReportsPanel $panel
   * @param IUser $user
   */
  function frosso_estimated_cost_handle_on_reports_panel(ReportsPanel &$panel, IUser &$user) {
    if($user->isProjectManager()) {
        $panel->defineRow('remedia_reports', new ReportsPanelRow(lang('FRosso Reports')));

        $panel->addTo('remedia_reports', 'my_projects_report', lang('reMedia Reports'), 
        		Router::assemble('frosso_estimated_cost_reports'), 
        		AngieApplication::getImageUrl('reports/assignments.png', SYSTEM_MODULE, AngieApplication::INTERFACE_DEFAULT));
    } // if
  }