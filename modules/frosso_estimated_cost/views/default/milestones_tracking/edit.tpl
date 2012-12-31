{title}Edit Milestone{/title}
{add_bread_crumb}Edit{/add_bread_crumb}

<div id="edit_milestone">
  {form action=$active_milestone->getEditUrl() class="big_form"}
    {include file=get_view_path('_milestone_form', 'milestones_tracking', $smarty.const.FROSSO_EC_MODULE)}
    
    {wrap_buttons}
      {submit}Save Changes{/submit}
    {/wrap_buttons}
  {/form}
</div>