<div id="eta_project">

{if is_foreachable($milestones)}

<table class="common" cellspacing="0">
<thead>
<tr>
<th>Milestone</th>
<th>Tempo impiegato su tempo stimato</th>
<th>Tempo rimanente</th>
<th>Percentuale completamento</th>
<th>Previsione completamento</th>
</tr>
</thead>
<tbody>
{foreach from=$milestones item=object}
<tr>
<td>
	<a href="{assemble route='project_milestone' project_slug=$object->getProject()->getSlug() milestone_id=$object->getId()}">{$object->getName()}</a>
</td>
<td>
{assign var=estimate_value value=$object->tracking()->getEstimate()->getValue()}
{assign var=summed_time_value value=$object->tracking()->sumTime($user)}
<span id="milestone_estimated_container_id_{$object->getId()}" style="
{if $estimate_value lte $summed_time_value}
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
{$object->getRemainingTime()}h
{else}
&#8734;
{/if} 
</td>
<td>
{if $object->getPercentsDone(false)}
{$object->getPercentsDone(false)}%
{else}
0%
{/if}
</td>
<td>
{$estimate_value+$summed_time_value}h
</td>
</tr>
{/foreach}
</tbody>
</table>	


{/if}

</div>
