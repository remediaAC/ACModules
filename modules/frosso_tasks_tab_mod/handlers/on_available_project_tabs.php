<?php

  /**
   * Frosso Tasks Tab Mod module on_available_project_tabs event handler
   */

  /**
   * Populate list of available project tabs
   * 
   * @param array $tabs
   */
  function frosso_tasks_tab_mod_handle_on_available_project_tabs(&$tabs) {
    $tabs['tasks_mod'] = lang('OldTasks');
  } // frosso_tasks_tab_mod_handle_on_available_project_tabs