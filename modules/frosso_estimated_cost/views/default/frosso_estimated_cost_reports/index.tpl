{title}Milestone Estimates{/title}
{add_bread_crumb}Milestones estimates{/add_bread_crumb}

<div id="project_tasks_reports" class="filter_criteria project_tasks_picker_for_reports">
  {if $projects_exist}
    <form action="{assemble route=frosso_estimated_cost_report_run}" method="get">
      <!-- Project Picker -->

      <div class="criteria_head">
        <div class="criteria_head_inner">
          <div class="criteria_project_picker">
            {lang}Project{/lang}
            {select_project name='task_report[project_id]' user=$logged_user show_all=true class=long}
          </div>
          <div class="criteria_run">{button type="submit" class="default"}Run{/button}</div>
        </div>
      </div>
    </form>
  {else}
    <p class="empty_page"><span class="inner">{lang}You are not assigned to any project{/lang}.</span></p>
  {/if}
  
  <div class="filter_results"></div>
</div>

<script type="text/javascript">
	$('#project_tasks_reports form').each(function() {
	  var form = $(this);
	  
	  form.find('button').click(function() {
	    var data = {
	      'project_id' : form.find('.criteria_project_picker option:selected').val(),
	      'async' : 1
	    };
	    
		  $.get(form.attr('action'), data, function(response) {
	      $('#project_tasks_reports div.filter_results').html(response);
	    });
	    
		  return false;
	  });
	});
</script>