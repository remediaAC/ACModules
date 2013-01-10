
/**
 * Renders attachments indicator
 *
 * @param boolean has_attachments
 */
App.Wireframe.Utils['renderAttachmentsIndicator'] = function (has_attachments) {

	if(typeof(has_attachments) != undefined && has_attachments != false){
		return '<img src="' + App.Wireframe.Utils.imageUrl('16x16/icon-attachments.png', 'frosso_tasks_tab_mod') + '" title="' + App.lang("This item has attachments") + '" class="has_attachments"/>';
	}
	
	return '';
	
};







