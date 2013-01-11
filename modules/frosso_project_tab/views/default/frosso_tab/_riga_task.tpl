<tr>
<td class="cella_labels" width="200px">
<span class="label" style="color : {$task.label.fg_color};background-color : {$task.label.bg_color};">{$task.label.name}</span>
<span width="20px">&nbsp;</span>
<span class="priorita {$task.priority}">
<img src="{image_url name='/priority-'|cat:$task.priority|cat:'.png' module=$smarty.const.FROSSO_PT_MODULE}" title="{lang}Priority {$task.priority}{/lang}"></span>
</td>
<td class="cella_id" width="50px"><span title="Task id">#{$task.id}</span></td>
<td class="cella_nome_task">
<a class="task_url quick_view_item" href="{$task.permalink}">
{$task.name}
</a>
</td>
<td class="cella_responsabile" width="150px"><span title="Persona assegnata">{$task.assignee_name}</span></td>
<td class="cella_data_scadenza {$task.stato}" width="130px"><span title="Data di scadenza">{$task.due_on}</span></td>
<td class="cella_data_modifica" width="150px"><span title="Data ultima modifica">{$task.updated_on}</span></td>
<td class="cella_azioni" width="30px">
{if AngieApplication::isModuleLoaded('tracking') and Tasks::findById($task.id)->tracking()->canEstimate($active_user) and Tasks::findById($task.id)->tracking()->canAdd($active_user)}
<span class="object_tracking" id="object_tracking_for_{$task.id}"></span>
<script type="text/javascript">
$('#object_tracking_for_{$task.id}').objectTime({
    object: {$task|json nofilter},
    show_label: false,
    default_billable_status: true
});
</script>
{/if}
</td>
</tr>