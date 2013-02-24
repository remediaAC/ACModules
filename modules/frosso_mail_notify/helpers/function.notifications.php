<?php

function smarty_function_notifications($params, &$smarty) {
	$user = array_required_var($params, 'user', true, 'IUser');
	$activity_logs = NotificationsActivityLogs::findRecent($user);

	$interface = array_var($params, 'interface', AngieApplication::getPreferedInterface(), true);

	$id = isset($params['id']) && $params['id'] ? $params['id'] : HTML::uniqueId('activity_log');

	$wrapper = '<div id="' . $id . '" class="quick_view_item">';

	$wrapper .= '</div>';

	list($authors, $subjects, $targets) = 
			ActivityLogs::loadRelatedDataFromActivities($activity_logs, $user);
	// Load related data, so we can pass it to callbacks

	return $wrapper .= '<script type="text/javascript">$("#' . $id . '").activityLog(' . JSON::encode(array(
      'entries' => $activity_logs,
      'authors' => $authors,
      'subjects' => $subjects,
      'targets' => $targets,
      'callbacks' => ActivityLogs::getCallbacks(),
      'decorator' => ActivityLogs::getDecorator($interface),
      'interface' => $interface,
    )) . ');</script>';
}
