{if AngieApplication::isModuleLoaded('tasks_plus')}
{include file=get_view_path('view', 'tasks_plus', $smarty.const.TASKS_PLUS_MODULE) interface=AngieApplication::INTERFACE_PRINTER}
{else}
{include file=get_view_path('view', 'tasks', $smarty.const.TASKS_MODULE) interface=AngieApplication::INTERFACE_PRINTER}
{/if}