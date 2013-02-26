{if AngieApplication::isModuleLoaded('tasks_plus')}
{include file=get_view_path('archive', 'tasks_plus', $smarty.const.TASKS_PLUS_MODULE)}
{else}
{include file=get_view_path('archive', 'tasks', $smarty.const.TASKS_MODULE)}
{/if}