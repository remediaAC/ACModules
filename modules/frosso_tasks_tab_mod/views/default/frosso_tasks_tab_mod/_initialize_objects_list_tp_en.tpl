<script type="text/javascript">
/* INIZIO FRosso Hack */
function filtraNome(nome_completo) {
	var pezzi = nome_completo.split(' ');
	if(pezzi.length < 2)
		return nome_completo;
	var risultato = pezzi[0][0]+'.';
	for(i=1;i<pezzi.length;i++){
		risultato+=' '+pezzi[i];
	}
	return risultato;
}
/* FINE FRosso Hack */
$('#new_project_task').flyoutForm({
  'success_event' : 'task_created',
  'title' : App.lang('New Task')
});

$('#tasks').each(function() {
  var wrapper = $(this);

  var project_id = '{$active_project->getId() nofilter}';
  var categories_map = {$categories|map nofilter};
  var milestones_map = {$milestones|map nofilter};
  var labels_map = {$labels|map nofilter};
  var users_map = {$users|map nofilter};
  var priority_map = {$priority|map nofilter};
  var kanban_url = {$kanban_url|json nofilter};
  var reorder_url = '{assemble route=project_tasks_reorder project_slug=$active_project->getSlug()}';

  /*
	acHack: We want to add print button and want to print multiple kanban 
*/

var events = App.standardObjectsListEvents();

// show/hide the link of new window link for task.
wrapper.delegate('tr.objects_list_item','hover', function( event ) {
$(this).children().closest('.task_options').toggleClass('expand_task_options', event.type === 'mouseenter' );
$(this).find('a.task_new_window_link').toggle( event.type === 'mouseenter' );
});

events.multi = function () {

var selected_tasks_ids = [];
wrapper.find('tr.selected').each(function () {
	  selected_tasks_ids.push(this.getAttribute('item_id'));
});
var selected_tasks_ids_str = selected_tasks_ids.join(',');

 App.Wireframe.PageTitle.setClean('');
 App.Wireframe.PageTitle.addAction('kanban_print', {
      'url' : App.extendUrl(kanban_url, { 'print' : 1, 'selected_tasks_ids_str' : selected_tasks_ids_str}),
      'text' : ' '+App.lang('Print Kanban Cards'),
      'icon' : App.Wireframe.Utils.assetUrl('icons/16x16/kanban_print.png', 'tasks_plus', 'images', 'default'),
      'onclick' : function () {
        App.Wireframe.Print.doPrint($(this).attr('href'));
        return false;
      }
  }, 'kanban_print');
};
//acHack: Over 
  
  var grouping = [{
    'label' : App.lang("Don't group"),
    'property' : '',
    'icon' : App.Wireframe.Utils.imageUrl('objects-list/dont-group.png', 'environment')
  }, {
    'label' : App.lang('By Category'),
    'property' : 'category_id' ,
    'map' : categories_map,
    'icon' : App.Wireframe.Utils.imageUrl('objects-list/group-by-category.png', 'categories'),
    'default' : true
  }, {
    'label' : App.lang('By Milestone'),
    'property' : 'milestone_id',
    'map' : milestones_map ,
    'icon' : App.Wireframe.Utils.imageUrl('objects-list/group-by-milestones.png', 'system'),
    'uncategorized_label' : App.lang('No Milestone')
  }, {
    'label' : App.lang('By Label'),
    'property' : 'label_id',
    'map' : labels_map ,
    'icon' : App.Wireframe.Utils.imageUrl('objects-list/group-by-label.png', 'labels'),
    'uncategorized_label' : App.lang('No Label')
  }, {
    'label' : App.lang('By Assignee'),
    'property' : 'assignee_id',
    'map' : users_map ,
    'icon' : App.Wireframe.Utils.imageUrl('objects-list/group-by-client.png', 'system'),
    'uncategorized_label' : App.lang('Not Assigned')
  }, {
    'label' : App.lang('By Delegate'),
    'property' : 'delegated_by_id',
    'map' : users_map ,
    'icon' : App.Wireframe.Utils.imageUrl('objects-list/group-by-client.png', 'system'),
    'uncategorized_label' : App.lang('Not Delegated')
  }, {
    'label' : App.lang('By Priority'),
    'property' : 'priority',
    'map' : priority_map ,
    'icon' : App.Wireframe.Utils.imageUrl('objects-list/group-by-priority.png', 'system'),
    'uncategorized_label' : App.lang('No Priority')
  }];

  {custom_fields_prepare_objects_list grouping_variable=grouping type='Task' sample=$active_task}

  var init_options = {
    'id' : 'project_' + {$active_project->getId()} + '_tasks',
    'items' : {$tasks|json nofilter},
    'required_fields' : ['id', 'name', 'category_id', 'milestone_id', 'task_id', 'is_completed', 'permalink'],
    'requirements' : {
      'project_id' : '{$active_project->getId()}',
    },
    'objects_type' : 'tasks',
    'print_url' : '{assemble route=project_tasks print=1 project_slug=$active_project->getSlug()}',
    'events' : events,
    'multi_title' : App.lang(':num Tasks Selected'),
    'multi_url' : '{assemble route=project_tasks_mass_edit project_slug=$active_project->getSlug()}',
    'multi_actions' : {$mass_manager|json nofilter},
    'reorder_url' : reorder_url,
    'prepare_item' : function (item) {
      var result = {
        'id'              : item['id'],
        'name'            : item['name'],
        'project_id'      : item['project_id'],
        'task_id'         : item['task_id'],
        'is_completed'    : item['is_completed'],
        'priority'        : item['priority'],
        'permalink'       : item['permalink'],
        'is_favorite'     : item['is_favorite'],
        'total_subtasks'  : item['total_subtasks'],
        'open_subtasks'   : item['open_subtasks'],
        'is_trashed'      : item['state'] == '1' ? 1 : 0,
        'is_archived'     : item['state'] == '2' ? 1 : 0,
        'label'           : item['label'],
        'visibility'      : item['visibility']
      };

      if(typeof(item['assignee']) == 'undefined') {
        result['assignee_id'] = item['assignee_id'];
      } else {
        result['assignee_id'] = item['assignee'] ? item['assignee']['id'] : 0;
      } // if

      if(typeof(item['delegated_by']) == 'undefined') {
        result['delegated_by_id'] = item['delegated_by_id'];
      } else {
        result['delegated_by_id'] = item['delegated_by'] ? item['delegated_by']['id'] : 0;
      } // if

      if(typeof(item['category']) == 'undefined') {
        result['category_id'] = item['category_id'];
      } else {
        result['category_id'] = item['category'] ? item['category']['id'] : 0;
      } // if

      if(typeof(item['milestone']) == 'undefined') {
        result['milestone_id'] = item['milestone_id'];
      } else {
        result['milestone_id'] = item['milestone'] ? item['milestone']['id'] : 0;
      } // if

      if(typeof(item['label']) == 'undefined') {
        result['label_id'] = item['label_id'];
      } else {
        result['label_id'] = item['label'] ? item['label']['id'] : 0;
      } // if

      // Put custom field values as fields, so group by feature can find them
      if(typeof(item['custom_fields']) == 'object' && item['custom_fields']) {
        App.each(item['custom_fields'], function(field_name, details) {
          result[field_name] = details['value'];
        });
      } // if

      return result;
    },
    'render_item' : function (item) {
      var row = '<td class="task_name">' +
        '<span class="task_name_wrapper">' +
        '<span class="task_id">#' + item['task_id'] + '</span>';

      // label
      row += App.Wireframe.Utils.renderLabelTag(item.label);

      /* INIZIO FRosso Hack */
      row += ' ' + App.Wireframe.Utils.renderPriorityIndicator(item['priority']);
      row += ' ' + App.Wireframe.Utils.renderAttachmentsIndicator(item['has_attachments']) + ' ';
      // task name
      row += '<span class="real_task_name">' + item['name'].clean();
      
      // aggiungo il responsabile
      if(item['assignee_id']!=null && item['assignee_id']!=undefined && item['assignee_id']!=0){
    	  var assignee_name = users_map.get(item['assignee_id']);
    	  if(assignee_name){
    		  row += '&nbsp;<span class="ticket_assignee_name">' + filtraNome(assignee_name) + '</span>';
    	  }
      }
      row += App.Wireframe.Utils.renderVisibilityIndicator(item['visibility'])  + ' ' + '</span></span></td><td class="task_options">';
      
      var color_class = 'mono';

      if(typeof(item['estimated_time']) != 'undefined' && typeof(item['tracked_time']) != 'undefined') {
        if(item['estimated_time'] > 0) {
          if(item['tracked_time'] > item['estimated_time']) {
            var color_class = 'red';
          } else if(item['tracked_time'] > 0) {
            var color_class = 'blue';
          } // if
        } else if(item['tracked_time'] > 0) {
          var color_class = 'blue';
        } // if
      } // if

      // Completed task
      if(item['is_completed']) {
          row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-100.png', 'complete') + '">';
        // Still open
      } else {
      /* FINE FRosso Hack */
        var total_subtasks = typeof(item['total_subtasks']) != 'undefined' && item['total_subtasks'] ? item['total_subtasks'] : 0;
        var open_subtasks = typeof(item['open_subtasks']) != 'undefined' && item['open_subtasks'] ? item['open_subtasks'] : 0;
        var completed_subtasks = total_subtasks - open_subtasks;

        if (item['is_completed']) {
	      row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-100.png', 'complete') + '">';
	    } else if (completed_subtasks == 0) {
	      row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-0.png', 'complete') + '">';
	    } else {
	      if(completed_subtasks >= total_subtasks) {
	        row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-100.png', 'complete') + '">';
	      } else {
	        var percentage = Math.ceil((completed_subtasks / total_subtasks) * 100);
	
	        if(percentage <= 10) {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-0.png', 'complete') + '">';
	        } else if(percentage <= 20) {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-10.png', 'complete') + '">';
	        } else if(percentage <= 30) {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-20.png', 'complete') + '">';
	        } else if(percentage <= 40) {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-30.png', 'complete') + '">';
	        } else if(percentage <= 50) {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-40.png', 'complete') + '">';
	        } else if(percentage <= 60) {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-50.png', 'complete') + '">';
	        } else if(percentage <= 70) {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-60.png', 'complete') + '">';
	        } else if(percentage <= 80) {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-70.png', 'complete') + '">';
	        } else if(percentage <= 90) {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-80.png', 'complete') + '">';
	        } else {
	            row += '<img src="' + App.Wireframe.Utils.imageUrl('progress/progress-' + color_class + '-90.png', 'complete') + '">';
	        } // if
	      } // if
	    } // if
	  } // if

      /*
		acHack: Adding Link to open Task in new tab/window
	  */
      row += '<a target="_blank" class ="task_new_window_link" href="' + item['permalink'] + '">' + '<img title="'+ App.lang("Open in new tab") +'" src="' + App.Wireframe.Utils.imageUrl('icons/newwindow.png', 'tasks_plus') + '">' +'</a>';
      // acHack: Over 
      
      row += '</td>';

      return row;
    },

    'search_index' : function (item) {
        
        var terms = item.name.clean() + ' ' + '#' + item.task_id;
        //acHack: Search based on label name and assignedd name
		if (typeof(labels_map[ item['label_id']]) != 'undefined' ) {
    		terms += ' ' + labels_map[ item['label_id']].clean();
		}
		
		if (typeof(users_map[ item['assignee_id']]) != 'undefined') {
			 terms += ' '+ users_map[ item['assignee_id']].clean();
		}
		//acHack: Over

		return terms;
    },

    'grouping' : grouping,
    'filtering' : []
  };

  if (!{$in_archive|json nofilter}) {
    init_options.filtering.push({
      'label' : App.lang('Status'),
      'property' : 'is_completed',
      'values' : [{
        'label' : App.lang('All Tasks'),
        'value' : '',
        'icon' : App.Wireframe.Utils.imageUrl('objects-list/active-and-completed.png', 'complete'),
        'breadcrumbs' : App.lang('All Tasks')
      }, {
        'label' : App.lang('Open Tasks'),
        'value' : '0',
        'icon' : App.Wireframe.Utils.imageUrl('objects-list/active.png', 'complete'),
        'default' : true,
        'breadcrumbs' : App.lang('Open Tasks')
      }, {
        'label' : App.lang('Completed Tasks'),
        'value' : '1',
        'icon' : App.Wireframe.Utils.imageUrl('objects-list/completed.png', 'complete'),
        'breadcrumbs' : App.lang('Completed Tasks')
      }]
    });
    
    /* INIZIO FRosso Hack */
    init_options.filtering.push({
        'label' : App.lang('Current label'),
        'property' : 'label_id',
        'values' : [{
        	'label' : App.lang('Nessun filtro label'),
        	'value' : '',
        	'icon' : App.Wireframe.Utils.imageUrl('status-icons/tag.png', 'frosso_tasks_tab_mod'),
        	'default' : true,
        	'breadcrumbs' : App.lang('Nessun filtro label')
          }, {
        	'label' : 'NEW',
        	'value' : '16',
        	'icon' : App.Wireframe.Utils.imageUrl('status-icons/new.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : 'Label: NEW'
    	  }, {
    	  	'label' : 'REOPENED',
        	'value' : '17',
        	'icon' : App.Wireframe.Utils.imageUrl('status-icons/reopened.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : 'Label: REOPENED'
    	  }, {
    	  	'label' : 'FEEDBACK',
        	'value' : '18',
        	'icon' : App.Wireframe.Utils.imageUrl('status-icons/feedback.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : 'Label: FEEDBACK'
    	  }, {
    	  	'label' : 'ACKNOWLEDGED',
        	'value' : '19',
        	'icon' : App.Wireframe.Utils.imageUrl('status-icons/acknowledged.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : 'Label: ACKNOWLEDGED'
    	  }, {
    	  	'label' : 'ASSIGNED',
        	'value' : '20',
        	'icon' : App.Wireframe.Utils.imageUrl('status-icons/assigned.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : 'Label: ASSIGNED'
    	  }, {
    	  	'label' : 'IN PROGRESS',
        	'value' : '21',
        	'icon' : App.Wireframe.Utils.imageUrl('status-icons/in-progress.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : 'Label: PROGRESS'
    	  }, {
    	  	'label' : 'RESOLVED',
        	'value' : '22',
        	'icon' : App.Wireframe.Utils.imageUrl('status-icons/resolved.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : 'Label: RESOLVED'
    	  }, {
    	  	'label' : 'CLOSED',
        	'value' : '23',
        	'icon' : App.Wireframe.Utils.imageUrl('status-icons/closed.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : 'Label: CLOSED'
    	  }] 
        });
    init_options.filtering.push({
        'label' : App.lang('With attachments'),
        'property' : 'has_attachments',
        'values' : [{
        	'label' : App.lang('Nessun filtro allegati'),
        	'value' : '',
        	'icon' : App.Wireframe.Utils.imageUrl('16x16/icon-attachments.png', 'frosso_tasks_tab_mod'),
        	'default' : true,
        	'breadcrumbs' : App.lang('Nessun filtro allegati')    
          }, {
        	'label' : App.lang('Solo tasks con allegati'),
        	'value' : true,
        	'icon' : App.Wireframe.Utils.imageUrl('16x16/icon-with_attachments.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : App.lang('Con allegati')
    	  }, {
    	  	'label' : App.lang('Solo tasks senza allegati'),
        	'value' : false,
        	'icon' : App.Wireframe.Utils.imageUrl('16x16/icon-no_attachments.png', 'frosso_tasks_tab_mod'),
        	'breadcrumbs' : App.lang('Senza allegati')
    	  }] 
        });
    /* FINE FRosso Hack */
    
    init_options.requirements.is_archived = 0;
  } else {
    init_options.requirements.is_archived = 1;
  } // if

  wrapper.objectsList(init_options);

  if (!{$in_archive|json nofilter}) {
    // Task added
	App.Wireframe.Events.bind('task_created.content', function (event, task) {
      if (task['project_id'] == project_id) {
        wrapper.objectsList('add_item', task);
      } else {
        if ($.cookie('ac_redirect_to_target_project')) {
          App.Wireframe.Content.setFromUrl(task['urls']['view']);
        } // if
      } // if
    });
  } // if

  // Task updated
  App.Wireframe.Events.bind('task_updated.content', function (event, task) {
    if (task['project_id'] == project_id) {
      wrapper.objectsList('update_item', task);
    } else {
      if ($.cookie('ac_redirect_to_target_project')) {
        App.Wireframe.Content.setFromUrl(task['urls']['view']);
      } else {
        wrapper.objectsList('delete_selected_item');
      } // if
    } // if
  });

  // Task deleted
  App.Wireframe.Events.bind('task_deleted.content', function (event, task) {
    if (task['project_id'] == project_id) {
      if (wrapper.objectsList('is_loaded', task['id'], false)) {
        wrapper.objectsList('load_empty');
      } // if
      wrapper.objectsList('delete_item', task['id']);
    } // if
  });

  // Manage mappings
  App.objects_list_keep_milestones_map_up_to_date(wrapper, 'milestone_id', project_id);

  // Keep categories map up to date
  App.objects_list_keep_categories_map_up_to_date(wrapper, 'category_id', {$active_task->category()->getCategoryContextString()|json nofilter}, {$active_task->category()->getCategoryClass()|json nofilter});

  // Pre select item if this is permalink
  {if $active_task->isLoaded()}
    wrapper.objectsList('load_item', {$active_task->getId()|json}, '{$active_task->getViewUrl()}');
  {/if}
});
</script>