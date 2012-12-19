{title}My Projects{/title}
{add_bread_crumb}My Projects{/add_bread_crumb}
	Progetto: {select_project name='task_report[project_id]' user=$logged_user show_all=true class=long}
{if $projects}
<table class="common" cellspacing="0">
  <thead>
  <tr>
    <th>{lang}Project{/lang}</th>
    <th>{lang}Leader{/lang}</th>
    <th>{lang}Cost so Far{/lang}</th>
  </tr>
  </thead>
  <tbody>
    {foreach $projects as $project}
    <tr>
      <td>{project_link project=$project}</td>
      <td>{user_link user=$project->getLeader()}</td>
      <td>{$project->getCostSoFar($logged_user)|money:$project->getCurrency()}</td>
    </tr>
    {/foreach}
  </tbody>
</table>
  {else}
<p class="empty_page">{lang}No projects loaded{/lang}</p>
{/if}