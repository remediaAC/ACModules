<?php

  /**
   * FRed Tab module on_available_project_tabs event handler
   */

  /**
   * Populate list of available project tabs
   * 
   * @param array $tabs
   */
  function frosso_project_tab_handle_on_available_project_tabs(&$tabs) {
    $tabs['fred_pt'] = lang('FRed');
  } // source_handle_on_available_project_tabs