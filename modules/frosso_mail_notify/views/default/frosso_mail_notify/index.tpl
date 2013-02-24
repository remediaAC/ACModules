{if !$request->isAsyncCall()}
  {title}Activity Updates Archive{/title}
  {add_bread_crumb}Archive{/add_bread_crumb}
{/if}

{assign var=dialog_id value=HTML::uniqueId('frosso_mn_dialog')}

<div id="{$dialog_id}" class="status_updates_dialog">
	{notifications user=$logged_user}
</div>

<script type="text/javascript">
  var status_update_dialog = $("#{$dialog_id}");
  
  // do popup specific stuff
  var popup = status_update_dialog.parents('#context_popup:first');
  if (popup.length) {

    var trigger = popup.data('trigger');
    
    // set trigger badge to 0
    App.Wireframe.Statusbar.setItemBadge(trigger.attr('id'), 0);
  } // if

</script>