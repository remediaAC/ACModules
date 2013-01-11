{title}SSO Authentication Settings{/title}
{add_bread_crumb}SSO Authentication Settings{/add_bread_crumb}

<div id="frosso_auth_settings">
  {form action=Router::assemble('auth_login_frosso_admin') method=post}
    <div class="content_stack_wrapper">
	    {wrap_fields}
		    {wrap field=pub_key}
		      {label for=my_pub_key}My Public Key{/label}
		      {textarea_field name='my_pub_key' id=my_pub_key}{$my_pub_key nofilter}{/textarea_field}
		    {/wrap}
		    {wrap field=pri_key}
		      {label for=my_pri_key}My Private Key{/label}
		      {textarea_field name='my_pri_key' id=my_pri_key}{$my_pri_key nofilter}{/textarea_field}
		    {/wrap}
		    {wrap field=token}
		      {label for=token}Shared Token{/label}
			  {text_field name="token" value=$token}
		    {/wrap}
	    {/wrap_fields}
    </div>
    
    {wrap_buttons}
  	  {submit}Save Changes{/submit}
    {/wrap_buttons}
  {/form}
</div>
