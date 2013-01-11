<?php

/**
 * on_admin_panel event handler
 *
 * @package custom.modules.tasks_plus
 * @subpackage handlers
 */

/**
 * Handle on_admin_panel event
 *
 * @param AdminPanel $admin_panel
 */
function frosso_authentication_handle_on_admin_panel(AdminPanel &$admin_panel) {

	$admin_panel->addToOther('frosso_authentication', lang('SSO Settings'), Router::assemble('auth_login_frosso_admin'), AngieApplication::getImageUrl('admin_panel/tasks.png', TASKS_MODULE), array(
			'onclick' => new FlyoutFormCallback(array(
					'success_event' => 'frosso_authentication_updated',
					'success_message' => lang('SSO settings have been updated'),
					'width' => 500,
			)),
	));
} // frosso_authentication_handle_on_admin_panel