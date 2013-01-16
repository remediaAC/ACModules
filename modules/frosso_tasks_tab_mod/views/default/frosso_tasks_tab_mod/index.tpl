{title}Tasks{/title}
{add_bread_crumb}Tasks{/add_bread_crumb}

<div id="tasks">
  <div class="empty_content">
      <div class="objects_list_title">{lang}Tasks{/lang}</div>
      <div class="objects_list_icon"><img src="{image_url name='icons/48x48/tasks.png' module=$smarty.const.TASKS_MODULE}" alt=""/></div>
      <div class="objects_list_details_actions">
        <ul>
          {if $add_task_url}<li><a href="{assemble route='project_tasks_add' project_slug=$active_project->getSlug()}" id="new_project_task">{lang}New Task{/lang}</a></li>{/if}
          {if $smarty.const.APPLICATION_VERSION <=  '3.2.0' && $can_manage_tasks}
            <li><a href="{assemble route='project_tasks_archive' project_slug=$active_project->getSlug()}">{lang}Archive{/lang}</a></li>
          {/if}
          {if $manage_categories_url}<li><a href="{$manage_categories_url}" class="manage_objects_list_categories" title="{lang}Manage Task Categories{/lang}">{lang}Manage Categories{/lang}</a></li>{/if}
        </ul>
      </div>

      {if $smarty.const.APPLICATION_VERSION >=  '3.2.0' && $can_manage_tasks}
        <div class="object_list_details_additional_actions">
          <a href="{assemble route='project_tasks_archive' project_slug=$active_project->getSlug()}" id="view_archive"><span><img src="{image_url name="icons/12x12/archive.png" module="environment"}">{lang}Browse Archive{/lang}</span></a>
        </div>
      {/if}

      <div class="object_lists_details_bottom">
        {if  $smarty.const.APPLICATION_VERSION >=  '3.2.5' && $to_clean_up}
          <div class="tidy_up_tasks" id="clean_up_tasks" style="display: block;">
            <h3>{lang}Tidy Up!{/lang}</h3>
            <p class="tidy_up_button_wrapper">{button class=default}Move to Archive{/button}</p>
            <p>{lang}Move tasks that you no longer need to archive to keep the main task list lean. By doing that, it will load faster, task will be easier to filter, reorder and more{/lang}.</p>
            {if $to_clean_up == 1}
              <p>{lang}There is <u>one task completed in more than 30 days</u>. Click on the button bellow to move it to archive{/lang}:</p>
              {else}
              <p>{lang num=$to_clean_up}There are <u><strong>:num tasks completed in more than 30 days</strong></u>. Click on the button bellow to move them to archive{/lang}:</p>
            {/if}
          </div>
        {/if}

        <div class="object_lists_details_tips">
          <h3>{lang}Tips{/lang}:</h3>
          <ul>
            <li>{lang}To select a task and load its details, please click on it in the list on the left{/lang}</li>
            <li>{lang}It is possible to select multiple tasks at the same time. Just hold Ctrl key on your keyboard and click on all the tasks that you want to select{/lang}</li>
          </ul>
        </div>
      </div>
  </div>
</div>


{if AngieApplication::isModuleLoaded('tasks_plus')}
{include file=get_view_path('_initialize_objects_list_tp_en', 'frosso_tasks_tab_mod', $smarty.const.FROSSO_TTMOD_MODULE)}
{else}
{include file=get_view_path('_initialize_objects_list_tp_dis', 'frosso_tasks_tab_mod', $smarty.const.FROSSO_TTMOD_MODULE)}
{/if}
<script type="text/javascript">
  $('#clean_up_tasks button').click(function() {
    var button = $(this).hide();

    button.parent().append('<img src="' + App.Wireframe.Utils.indicatorUrl() + '">');

    $.ajax({
      'url' : App.extendUrl({$clean_up_url|json nofilter}, { 'async' : 1 }),
      'type' : 'post',
      'data' : 'submitted=submitted',
      'success' : function(response) {
        if(jQuery.isArray(response)) {
          $("#clean_up_tasks").remove();

          if(response.length === 1) {
            App.Wireframe.Flash.success('One task has been moved to archive');
          } else {
            App.Wireframe.Flash.success(':num tasks have been moved to archive', {
              'num' : response.length
            });
          } // if

          $.each(response, function(k, v) {
            $('#tasks').objectsList('delete_item', v);
          });
        } else {
          App.Wireframe.Flash.error('Invalid response. Please try again later');

          button.parent().find('img').remove();
          button.show();
        } // if
      },
      'error' : function() {
        App.Wireframe.Flash.error('Failed to archive old tasks. Please try again later');

        button.parent().find('img').remove();
        button.show();
      }
    });
  });
</script>