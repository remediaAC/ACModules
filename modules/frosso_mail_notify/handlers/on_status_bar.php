<?php

/**
 * status module on_status_bar event handler
 *
 * @package activeCollab.modules.status
 * @subpackage handlers
 */

/**
 * Register status bar items
 *
 * @param StatusBar $status_bar
 * @param IUser $logged_user
 */
function frosso_mail_notify_handle_on_status_bar(StatusBar &$status_bar, IUser &$user) {
	$status_bar->add('frosso_mn_updates', 
		lang('Notifications'), 
		Router::assemble('frosso_mail_notify'), 
		AngieApplication::getImageUrl('icons/12x12/my-subscriptions.png', SYSTEM_MODULE), 
		array(
			'group' => StatusBar::GROUP_RIGHT, 
			'badge' => NotificationsActivityLogs::countSinceLastVisit($user),
			)
	);
} // frosso_mail_notify_handle_on_status_bar
