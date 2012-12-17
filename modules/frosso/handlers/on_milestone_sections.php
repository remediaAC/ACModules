<?php

  /**
   * event handler on_milestone_sections - implementazione 
   */

  /**
   * @param Project $project
   * @param Milestone $milestone
   * @param User $user
   * @param NamedList $sections
   * @param string $interface
   */
  function frosso_handle_on_milestone_sections(&$project, &$milestone, &$user, &$sections, $interface) {
  	//uncomment these lines to add a new tab, instead
   	if(Tasks::canAccess($user, $project)) {
   		Router::assemble('tasks_frosso', array('project_slug' => $project->getSlug(), 'milestone_id' => $milestone->getId()));
//   		$section = array(
//         'text' => lang('FRed'),
//         'url' => Router::assemble('tasks_frosso', array('project_slug' => $project->getSlug(), 'milestone_id' => $milestone->getId())),
//         'options' => array(),
//       );
      
//       $sections->add('frosso', $section);
   	} // if

  } // frosso_handle_on_milestone_sections