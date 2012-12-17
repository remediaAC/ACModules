<div id="contenitore_progetto" class="filter_criteria">

<div class="filter_criteria_head">
<div class="filter_criteria_inner">
<ul> 
<li>Ordina per:
<ul>
<li><a href="{assemble route='frosso_tab_route_order' project_slug=$active_project->getSlug() order_name='id'}">{lang}Task #id{/lang}</a></li>
<li><a href="{assemble route='frosso_tab_route_order' project_slug=$active_project->getSlug() order_name='label'}">{lang}Label{/lang}</a></li>
<li><a href="{assemble route='frosso_tab_route_order' project_slug=$active_project->getSlug() order_name='priority'}">{lang}Priority{/lang}</a></li>
<li><a href="{assemble route='frosso_tab_route_order' project_slug=$active_project->getSlug() order_name='due_on'}">{lang}Due date{/lang}</a></li>
<li><a href="{assemble route='frosso_tab_route_order' project_slug=$active_project->getSlug() order_name='updated_on'}">{lang}Updated on{/lang}</a></li>
<li><a href="{assemble route='frosso_tab_route_order' project_slug=$active_project->getSlug() order_name='responsible'}">{lang}Responsible{/lang}</a></li>
</ul>
</li>
<li>In modalit&agrave;:
<ul>
<li><a href="{assemble route='frosso_tab_route_order_custom' project_slug=$active_project->getSlug() order_name=$order_name sorting='asc'}">Crescente</a></li>
<li><a href="{assemble route='frosso_tab_route_order_custom' project_slug=$active_project->getSlug() order_name=$order_name sorting='desc'}">Decrescente</a></li>
</ul>
</li>
</ul>
</div>
</div>
{if count($tasks)}
{foreach $map as $id_milestone=>$nome_milestone}
{include file=get_view_path('_milestone', 'frosso_tab', $smarty.const.FROSSO_PT_MODULE) tasks=$tasks nome_milestone=$nome_milestone id_milestone=$id_milestone}
{/foreach}
{else}
<h3>Nessun task da completare</h3>
{/if}

</div>
