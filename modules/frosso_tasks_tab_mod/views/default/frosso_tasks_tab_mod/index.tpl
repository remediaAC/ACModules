{title}Tasks{/title}
{add_bread_crumb}Tasks{/add_bread_crumb}

<div id="tasks">
  <div class="empty_content">
      <div class="objects_list_title">{lang}Tasks{/lang}</div>
      <div class="objects_list_icon"><img src="{image_url name='icons/48x48/tasks.png' module=$smarty.const.TASKS_MODULE}" alt=""/></div>
      <div class="objects_list_details_actions">
        <ul>
          {if $add_task_url}<li><a href="{assemble route='project_tasks_add' project_slug=$active_project->getSlug()}" id="new_project_task">{lang}New Task{/lang}</a></li>{/if}
          {if $can_manage_tasks}<li><a href="{assemble route='project_tasks_archive' project_slug=$active_project->getSlug()}">{lang}Archive{/lang}</a></li>{/if}
          {if $manage_categories_url}<li><a href="{$manage_categories_url}" class="manage_objects_list_categories" title="{lang}Manage Task Categories{/lang}">{lang}Manage Categories{/lang}</a></li>{/if}
        </ul>
      </div>
      <div class="object_lists_details_tips">
        <h3>{lang}Tips{/lang}:</h3>
        <ul>
          <li>{lang}To select a task and load its details, please click on it in the list on the left{/lang}</li>
          <li>{lang}It is possible to select multiple tasks at the same time. Just hold Ctrl key on your keyboard and click on all the tasks that you want to select{/lang}</li>
        </ul>
      </div>  
  </div>
</div>

{include file=get_view_path('_initialize_objects_list', 'frosso_tasks_tab_mod', $smarty.const.FROSSO_TTMOD_MODULE)}