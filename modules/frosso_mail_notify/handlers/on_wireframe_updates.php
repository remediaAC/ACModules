<?php
/**
 * Handle wireframe updates even
 *
 * @param array $wireframe_data
 * @param array $response_data
 * @param User $user
 */
function frosso_mail_notify_handle_on_wireframe_updates(&$wireframe_data, &$response_data, &$user) {
	$response_data['status_bar_badges']['frosso_mn_updates'] = NotificationsActivityLogs::countSinceLastVisit($user);
} // frosso_mail_notify_handle_on_wireframe_updates
