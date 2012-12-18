<div style="width:99%;height:99%;position:absolute" id="GanttChart">
</div>
<pre>{*print_r($milestones)*}</pre>
<script type="text/javascript">
// Create Gantt control
var ganttChartControl = new GanttChart();
// Setup paths and behavior
ganttChartControl.setImagePath("/ActiveCollab3/custom/modules/frosso_gantt_chart/assets/default/images/"); //TODO: cambiare con il path corretto
ganttChartControl.setEditable(false);
ganttChartControl.showTreePanel(true);
ganttChartControl.showContextMenu(true);
ganttChartControl.showDescTask(true,'n,s-f');
ganttChartControl.showDescProject(true,'n,d');
// Load data structure

var milestones = {$milestones|json nofilter};
var tasks = {$tasks|json nofilter};
for(var i =0; i < milestones.length; i++){
	var proj = new GanttProjectInfo(milestones[i]['id'], milestones[i]['name'], new Date(milestones[i]['start_on_y'], milestones[i]['start_on_m'], milestones[i]['start_on_d']));
	ganttChartControl.addProject(proj);
}

//Build control on the page
ganttChartControl.create("GanttChart");

for(var i =0; i < tasks.length; i++){
	var proj = ganttChartControl.getProjectById(tasks[i]['milestone_id']);
	if(proj){
		proj.insertTask(tasks[i]['id'], tasks[i]['name'], new Date(tasks[i]['start_on_y'], tasks[i]['start_on_m'], tasks[i]['start_on_d']), tasks[i]['durata'], tasks[i]['percent_completion'], "", "");
	}
}

</script>