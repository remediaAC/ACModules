<div id="eta_project">

{if is_foreachable($milestones)}

<table class="common" cellspacing="0">
<thead>
<tr>
<th>Milestone</th>
<th>Tempo impiegato su tempo stimato</th>
<th>Tempo rimanente</th>
<th>Percentuale completamento</th>
{if $detailed_report}
<th>Task completati / Task totali</th>
{/if}
<th>Previsione globale</th>
</tr>
</thead>
<tbody>
{foreach from=$milestones item=object}
<tr>
<td>
	<a href="{assemble route='project_milestone' project_slug=$object->getProject()->getSlug() milestone_id=$object->getId()}" class="quick_view_item">{$object->getName()}</a>
</td>
<td>
{assign var=estimate_value value=$object->tracking()->getEstimate()->getValue()}
{assign var=summed_time_value value=$object->tracking()->sumTime($user)}
<span id="milestone_estimated_container_id_{$object->getId()}" style="
{if $estimate_value lt $summed_time_value}
color: red;
{else}
color: green;
{/if}
	" sum_time="{$summed_time_value}">
{$summed_time_value}h di {remedia_milestone_estimate_icon object=$object user=$logged_user show_label=false}

</span>		
</td>
<td>
{if $object->getPercentsDone(false)}
<span id="rem_time_{$object->getId()}">{$object->getRemainingTime()}h</span>
{else}
<span id="rem_time_{$object->getId()}">&#8734;</span>
{/if} 
</td>
<td>
{if $object->getPercentsDone(false)}
<span class="percent_value" id="percent_value_milestone_{$object->getId()}">{$object->getPercentsDone(false)}%</span>
{else}
<span class="percent_value" id="percent_value_milestone_{$object->getId()}">0%</span>
{/if}
<a href="{assemble route='frosso_ec_set_milestone_percent' project_slug=$object->getProject()->getSlug() milestone_id=$object->getId()}" title="Cambia questo valore" class="set_milestone_percent_completion">
<img src="{image_url name="icons/12x12/edit.png" module=$smarty.const.ENVIRONMENT_FRAMEWORK}" id="edit_percent_icon_{$object->getId()}" class="icon_list_icon" alt="Edit value"  />
</a>
</td>
{if $detailed_report}
<td>{$object->getCompletedTaskCount()} of {$object->getTotalTasksCount()} tasks done ({$object->getPercentsDone()} % done)</td>
{/if}
<td>
{if $object->getPercentsDone(false)}
<span id="sum_e_rem_{$object->getId()}" title="">{$object->getRemainingTime()+$summed_time_value}h</span>
{else}
<span id="sum_e_rem_{$object->getId()}" title="Impostare una percentuale di completamento">?</span>
{/if} 
</td>
</tr>
{/foreach}
</tbody>
</table>	

<script type="text/javascript">
$(document).ready(function(){
	$('.set_milestone_percent_completion').each(function(){
		$(this).attr('href', App.extendUrl($(this).attr('href'), { async: 1 }) );
		$(this).flyoutForm({
	        width: 400,
	        success: function (milestone) {
	            if (typeof (milestone) == "object" && milestone) {
	            	var id = milestone.id;
	            	$('#percent_value_milestone_'+id).text(milestone.custom_percent_complete+'%');
	            	if(milestone.custom_percent_complete>0){
	            		$('#sum_e_rem_'+id).html((milestone.summed_time+milestone.remaining_time)+'h');
	            		$('#sum_e_rem_'+id).attr('title','');
	            		$('#rem_time_'+id).html((milestone.remaining_time)+'h');
	            	}else{
	            		$('#sum_e_rem_'+id).html('?');
	            		$('#sum_e_rem_'+id).attr('title','Impostare una percentuale di completamento');
	            		$('#rem_time_'+id).html('&#8734;');
	            	}
	            	
	            }
	        }
	    })
		
	});
	});
</script>

{/if}

</div>
