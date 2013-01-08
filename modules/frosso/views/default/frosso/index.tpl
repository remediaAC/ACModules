{title}Tasks{/title}
{add_bread_crumb}Tasks{/add_bread_crumb}

<div id="milestone_tasks">
  <div id="milestone_tasks_list"></div>

  <div id="add_new_task_to_milestone">
    <a href="{$add_task_url}" title="{lang}New Task{/lang}" class="add_new_item">{lang}Add New Task{/lang}</a>
  </div>
</div>

<script type="text/javascript">
  $('#milestone_tasks').each(function() {
    var wrapper = $(this);

    var milestone_id = {$milestone_id|json nofilter};
    var total_items = {$total_items|json nofilter};
    var milestone_tasks_per_page = {$milestone_tasks_per_page|json nofilter};
    var milestone_state = {$active_milestone->getState()|json nofilter};
    var milestone_inspector = wrapper.parents('div.object_wrapper:first').find('.object_inspector:first');
    var add_task = $('#add_new_task_to_milestone a');
    var add_task_url = {$add_task_url|json nofilter};
    var original_state = {$active_milestone->getState()|json nofilter};

    add_task.flyoutForm({
      'success_event' : 'task_created'
    });

    App.Wireframe.Events.bind('task_created.inline_tabs', function (event, data) {
      if (data.milestone_id == milestone_id) {
        milestone_inspector.objectInspector('refresh');
      } // if

      handle_add_link(original_state);
    });

    App.Wireframe.Events.bind('task_updated.inline_tabs', function (event, task) {
      var current_item = wrapper.find('tr[list_item_id=' + task.id + ']');

      // if task was in list, and now it's not more, we have to remove it
      if (current_item.length) {
        if (task.milestone_id != milestone_id) {
          current_item.remove();
          milestone_inspector.objectInspector('refresh');

          if (wrapper.find('tr.list_item').length == 0) {
            wrapper.find('#milestone_tasks_list table').hide();
            wrapper.find('#milestone_tasks_list p.empty_page').show();
          } // if
        } // if
      } else {
        if (task.milestone_id == milestone_id) {
          App.Wireframe.Events.trigger('task_created', [task]);
          return true;
        } // if
      } // if

      handle_add_link(original_state);
    });

    /**
     * Refresh milestone inspector
     */
    App.Wireframe.Events.bind('task_deleted.inline_tabs', function(event, data) {
      if (data.milestone_id == milestone_id) {
        milestone_inspector.objectInspector('refresh');
      } // if

      handle_add_link(original_state);
    });

    App.Wireframe.Events.bind('milestone_updated.inline_tabs, milestone_deleted.inline_tabs', function (event, milestone) {
      handle_add_link(milestone.state);
    });

    /**
     * Handles how add links behave
     *
     * @param state
     */
    var handle_add_link = function(state) {
      setTimeout(function () {
        original_state = state;

        var has_items = wrapper.find('tr.list_item').length;
        var add_another = wrapper.find('p.add_another');

        if (state < 3 || !add_task_url) {
          add_task.hide();
          add_another.hide();
        } else {
          if (has_items) {
            add_task.show();
            add_another.show();
          } else {
            add_task.hide();
            add_another.show();
          } // if
        } // if
      }, 100);
    }; // handle_add_link

    wrapper.find('#milestone_tasks_list').pagedObjectsList({
      'init'              : function () {
        handle_add_link(original_state);
      },
      'load_more_url'     : {$more_results_url|json nofilter},
      'items'             : {$tasks|json nofilter},
      'items_per_load'    : milestone_tasks_per_page,
      'total_items'       : total_items,
      'list_items_are'    : 'tr',
      'columns'           : {
        'favorite'            : '',
        'details'             : App.lang('Task Details'),
        'options'             : ''
      },
      'empty_message'     : function () {
        var empty_string = $('<p>' + App.lang('There are no tasks in this milestone') + '</p>');
        var add_url = {$add_task_url|json nofilter};

        if (typeof(add_url) == 'string' && add_url) {
          var create_paragraph = $('<p class="add_another">' + App.lang('Would you like to <a href=":add_url" title="New Task">create one now</a>?', {
            'add_url' : add_url
          }) + '</p>').appendTo(empty_string);

          create_paragraph.find('a').flyoutForm({
            'success_event' : 'task_created'
          });
        } // if

        return empty_string;
      },
      'listen' : 'task',
      'listen_constraint' : function(event, item) {
        return typeof(item) == 'object' && item && item['milestone_id'] == milestone_id;
      },
      'listen_scope' : 'inline_tab',
      'on_add_item' : function(task) {
        $('#add_new_task_to_milestone').show();
        var row = $(this);

        row.append(
          '<td class="favorite"></td>' +
          '<td class="details"></td>' +
          '<td class="options"></td>'
        );
        row.attr('id',task['id']);
        row.find('td.favorite').append($('<a href="#"></a>').asyncToggler({
          'is_on' : task['is_favorite'],
          'content_when_on' : "<img src='" + App.Wireframe.Utils.imageUrl('heart-on.png', 'favorites') + "'></img>",
          'content_when_off' : "<img src='" + App.Wireframe.Utils.imageUrl('heart-off.png', 'favorites') + "'></img>",
          'title_when_on' : App.lang('Remove from Favorites'),
          'title_when_off' : App.lang('Add to Favorites'),
          'url_when_on' : task['urls']['remove_from_favorites'],
          'url_when_off' : task['urls']['add_to_favorites'],
          'success_event' : 'task_updated'
        }));
        
		/*
		* Inizio FRosso Hack
		*/
		var assignee_line;
		if(task['assignee_id'] != null && task['assignee_id'] != 'null'){
			assignee_line = App.Wireframe.Utils.userLink(task['assignee_id']);
		}else{
			assignee_line = App.lang('not assigned');
		}
		
        row.find('td.details').append(App.Wireframe.Utils.renderPriority(task['priority'], true))
		  .append(App.Wireframe.Utils.renderLabel(task['label']) + " ")
          .append('<a class="task_url quick_view_item" href="' + task['urls']['view'] + '">' + task['name'] + '</a>')
          .append('<br />' + App.lang('Assigned to') + ' ')
          .append(assignee_line)
          .append('. ' + App.lang('Updated on') + ' ' + App.Wireframe.Utils.ago(task['updated_on']));
		/*
		* Fine FRosso Hack
		*/
        
        if (task['is_completed']) {
          row.find('td.details a.task_url').wrap("<del></del>");
        } //if

        if (task['permissions']['can_edit'] && task['permissions']['can_trash']) {
          row.find('td.options')
            .append('<a href="' + task['urls']['edit'] + '" class="edit_task" title="' + App.lang('Edit Task') + '"><img src="{image_url name="icons/12x12/edit.png" module=$smarty.const.ENVIRONMENT_FRAMEWORK}" /></a>')
            .append('<a href="' + task['urls']['trash'] + '" class="trash_task" title="' + App.lang('Move to Trash') + '"><img src="{image_url name="icons/12x12/move-to-trash.png" module=$smarty.const.SYSTEM_MODULE}" /></a>')
          ;
        } //if

        row.find('td.options a.edit_task').flyoutForm({
          'success_event' : 'task_updated'
        });

        row.find('td.options a.trash_task').asyncLink({
          'confirmation' : App.lang('Are you sure that you want to move this task to trash?'),
          'success_event' : 'task_deleted',
          'success_message' : App.lang('Selected task has been moved to trash')
        });
      }
    });
  });
</script>