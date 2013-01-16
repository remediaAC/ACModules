{title}Set milestone completion{/title}
{if $milestone }
	<div id="set_milestone_completion">
	  {form action=$form_action}
	    {wrap_fields}
	      {wrap field=operation}
	        <div>
	          {text_field name='percent' value=$milestone->getPercentsDone(false) label='Percent completion' id="percent_completion_value"}
	        </div>

	      {/wrap}


	    {/wrap_fields}

	    {wrap_buttons}
	        {submit}Change completion{/submit}
	    {/wrap_buttons}
	  {/form}
	</div>
{/if}