<?php

  /**
   * FRed Tab module on_available_project_tabs event handler
   */

  /**
   * Populate list of available project tabs
   * 
   * @param array $tabs
   */
  function frosso_gantt_chart_handle_on_available_project_tabs(&$tabs) {
    $tabs['fred_gc'] = lang('FRosso GanttChart');
  } // frosso_gantt_chart_handle_on_available_project_tabs