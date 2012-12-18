<div style="width:99%;height:99%;position:absolute" id="GanttChart">
</div>
<pre>{*print_r($milestones)*}</pre>
<script type="text/javascript">
//Initialize Gantt data structures
////project 1
//var project1 = new GanttProjectInfo(1, "Applet redesign", new Date(2010, 5, 11));
//var parentTask1 = new GanttTaskInfo(1, "Old code review", new Date(2010, 5, 11), 208, 50, "");
//parentTask1.addChildTask(new GanttTaskInfo(2, "Convert to J#", new Date(2010, 5, 11), 100, 40, ""));
//parentTask1.addChildTask(new GanttTaskInfo(13, "Add new functions", new Date(2010, 5, 12), 80, 90, ""));
//var parentTask2 = new GanttTaskInfo(3, "Hosted Control", new Date(2010, 6, 7), 190, 80, "1");
//var parentTask5 = new GanttTaskInfo(5, "J# interfaces", new Date(2010, 6, 14), 60, 70, "6");
//var parentTask123 = new GanttTaskInfo(123, "use GUIDs", new Date(2010, 6, 14), 60, 70, "");
//parentTask5.addChildTask(parentTask123);
//parentTask2.addChildTask(parentTask5);
//parentTask2.addChildTask(new GanttTaskInfo(6, "Task D", new Date(2010, 6, 10), 30, 80, "14"));
//var parentTask4 = new GanttTaskInfo(7, "Unit testing", new Date(2010, 6, 15), 118, 80, "6");
//var parentTask8 = new GanttTaskInfo(8, "core (com)", new Date(2010, 6, 15), 100, 10, "");
//parentTask8.addChildTask(new GanttTaskInfo(55555, "validate uids", new Date(2010, 6, 20), 60, 10, ""));
//parentTask4.addChildTask(parentTask8);
//parentTask4.addChildTask(new GanttTaskInfo(9, "Stress test", new Date(2010, 6, 15), 80, 50, ""));
//parentTask4.addChildTask(new GanttTaskInfo(10, "User interfaces", new Date(2010, 6, 16), 80, 10, ""));
//parentTask2.addChildTask(parentTask4);
//parentTask2.addChildTask(new GanttTaskInfo(11, "Testing, QA", new Date(2010, 6, 21), 60, 100, "6"));
//parentTask2.addChildTask(new GanttTaskInfo(12, "Task B (Jim)", new Date(2010, 6, 8), 110, 1, "14"));
//parentTask2.addChildTask(new GanttTaskInfo(14, "Task A", new Date(2010, 6, 7), 8, 10, ""));
//parentTask2.addChildTask(new GanttTaskInfo(15, "Task C", new Date(2010, 6, 9), 110, 90, "14"));
//project1.addTask(parentTask1);
//project1.addTask(parentTask2);
////project 2
//var project2 = new GanttProjectInfo(2, "Web Design", new Date(2010, 5, 17));
//var parentTask22 = new GanttTaskInfo(62, "Fill HTML pages", new Date(2010, 5, 17), 157, 50, "");
//parentTask22.addChildTask(new GanttTaskInfo(63, "Cut images", new Date(2010, 5, 22), 78, 40, ""));
//parentTask22.addChildTask(new GanttTaskInfo(64, "Manage CSS", null, 90, 90, ""));
//project2.addTask(parentTask22);
//var parentTask70 = new GanttTaskInfo(70, "PHP coding", new Date(2010, 5, 18), 120, 10, "");
//parentTask70.addChildTask(new GanttTaskInfo(71, "Purchase D control", new Date(2010, 5, 18), 50, 0, ""));
//project2.addTask(parentTask70);

// Create Gantt control
var ganttChartControl = new GanttChart();
// Setup paths and behavior
ganttChartControl.setImagePath("/ActiveCollab3/custom/modules/frosso_gantt_chart/assets/default/images/");
ganttChartControl.setEditable(false);
ganttChartControl.showTreePanel(false);
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
//	alert(ganttChartControl.getProjectById(tasks[i]['milestone_id']).getId());
	if(proj){
		proj.insertTask(tasks[i]['id'], tasks[i]['name'], new Date(tasks[i]['start_on_y'], tasks[i]['start_on_m'], tasks[i]['start_on_d']), tasks[i]['durata'], tasks[i]['percent_completion'], "", "");
	}
}

//ganttChartControl.addProject(project1);
//ganttChartControl.addProject(project2);

</script>