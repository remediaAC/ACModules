<div class="contenitore_milestone">
<div class="nome_milestone">
<h2>{$nome_milestone}</h2>
</div>

<div class="lista">
<table width="100%">

{foreach $tasks as $task}
{if $id_milestone eq $task.milestone_id}
{include file=get_view_path('_riga_task', 'frosso_tab', $smarty.const.FROSSO_PT_MODULE) task=$task}
{/if}
{/foreach}

</table>
</div>
</div>