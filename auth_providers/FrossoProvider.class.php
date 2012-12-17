<?php

class FrossoProvider extends AuthenticationProvider {

	/**
	 * Secreat key used for session ID and passwords
	 *
	 * @var unknown_type
	 */
	protected $secret_key;

	/**
	 * Session ID variable name (in $_COOKIE)
	 *
	 * @var string
	 */
	protected $session_id_var_name = 'sid';

	/**
	 * ID of current session, set by logUserIn()
	 *
	 * @var integer
	 */
	protected $session_id = null;

	/**
	 * Initialize basic authentication
	 *
	 * Try to get user from cookie or session
	 *
	 * @param array $params
	 * @throws InvalidParamError
	 * @return User|null
	 */
	function initialize($params) {
		$this->secret_key = array_var($params, 'secret_key');

		if(empty($this->secret_key)) {
			throw new InvalidParamError('params', $params, 'params[secret_key] value is required');
		} // if

		$this->session_id_var_name = array_var($params, 'sid_prefix') . '_sid_' . substr($this->secret_key, 0, 10);

		DB::execute('DELETE FROM ' . TABLE_PREFIX . 'user_sessions WHERE expires_on < ?', date(DATETIME_MYSQL)); // Expire old sessions

		$cookie_session_id = Cookies::getVariable($this->session_id_var_name);

		$settings = array(
				'remember' => false,
				'new_visit' => false,
		);

		if($cookie_session_id && strpos($cookie_session_id, '/') !== false) {
			list($session_id, $session_key, $session_time) = explode('/', $cookie_session_id);

			if((time() - USER_SESSION_LIFETIME) > strtotime($session_time)) {
				$settings['new_visit'] = true;
			} // if

			$user = Users::findBySessionId($session_id, $session_key);

			if($user instanceof User && $user->isActive()) {
				if(is_array($settings)) {
					$settings['existing_session_id'] = $session_id;
				} else {
					$settings = array('existing_session_id' => $session_id);
				} // if

				$this->logUserIn($user, $settings);
			} // if
		} // if
	} // init

	/**
	 * Performs an authentication for the following email
	 */
	function authenticate($email) {
		$user = Users::findByEmail($email);
		$interface = AngieApplication::getPreferedInterface();

		if($user instanceof User) {
			return $this->logUserIn($user, array(
					'remember' => false,
					'interface' => $interface,
					'new_visit' => true,
			));
		}
	}

	function &logUserIn(User $user, $settings = null) {

		$existing_session_id = isset($settings['existing_session_id']) && $settings['existing_session_id'] ? $settings['existing_session_id'] : null;

		try {
			DB::beginWork('Logging user in @ ' . __CLASS__);

			$users_table = TABLE_PREFIX . 'users';
			$user_sessions_table = TABLE_PREFIX . 'user_sessions';

			$remember = (boolean) array_var($settings, 'remember', false);
			$new_visit = (boolean) array_var($settings, 'new_visit', false);

			// Some initial data
			$session_id = null;
			$new_expires_on = $remember ? time() + 1209600 : time() + 1800; // 30 minutes or 2 weeks?

			// Existing session
			if($existing_session_id) {
				$existing_session_data = DB::executeFirstRow("SELECT remember, session_key, interface FROM $user_sessions_table WHERE id = ?", $existing_session_id);

				if($existing_session_data && isset($existing_session_data['remember']) && isset($existing_session_data['session_key'])) {
					if($existing_session_data['remember']) {
						$new_expires_on = time() + 1209600;
					} // if

					$session_key = $existing_session_data['session_key'];

					DB::execute("UPDATE $user_sessions_table SET user_ip = ?, user_agent = ?, last_activity_on = UTC_TIMESTAMP(), expires_on = ?, visits = visits + 1 WHERE id = ?", AngieApplication::getVisitorIp(), AngieApplication::getVisitorUserAgent(), date(DATETIME_MYSQL, $new_expires_on), $existing_session_id);
					$session_id = $existing_session_id;

					AngieApplication::setPreferedInterface($existing_session_data['interface']);
				} // if
			} // if

			// New session?
			if($session_id === null) {
				AngieApplication::setPreferedInterface(array_var($settings, 'interface'));
					
				do {
					$session_key = make_string(40);
				} while(DB::executeFirstCell("SELECT COUNT(id) AS 'row_count' FROM $user_sessions_table WHERE session_key = ?", $session_key) > 0);

				DB::execute("INSERT INTO $user_sessions_table (user_id, user_ip, user_agent, visits, remember, interface, created_on, last_activity_on, expires_on, session_key) VALUES (?, ?, ?, ?, ?, ?, UTC_TIMESTAMP(), ?, ?, ?)", $user->getId(), AngieApplication::getVisitorIp(), AngieApplication::getVisitorUserAgent(), 1, (integer) $remember, AngieApplication::getPreferedInterface(), date(DATETIME_MYSQL), date(DATETIME_MYSQL, $new_expires_on), $session_key);
				$session_id = DB::lastInsertId();
			} // if

			// Update last visit time
			if($new_visit) {
				DB::execute("UPDATE $users_table SET last_visit_on = last_login_on, last_login_on = ?, last_activity_on = ? WHERE id = ?", date(DATETIME_MYSQL), date(DATETIME_MYSQL), $user->getId());
			} else {
				DB::execute("UPDATE $users_table SET last_activity_on = ? WHERE id = ?", date(DATETIME_MYSQL), $user->getId());
			} // if

			DB::commit('User logged in @ ' . __CLASS__);

			$this->session_id = $session_id; // remember it, for logout

			Cookies::setVariable($this->session_id_var_name, "$session_id/$session_key/" . date(DATETIME_MYSQL));
			return parent::logUserIn($user);
		} catch(Exception $e) {
			DB::rollback('Failed to log user in @ ' . __CLASS__);
			throw $e;
		} // try

	}

	/**
	 * Return session ID var name
	 *
	 * @return string
	 */
	function getSessionIdVarName() {
		return $this->session_id_var_name;
	} // getSessionIdVarName

	/**
	 * Log user out
	 */
	function logUserOut() {
		DB::execute("DELETE FROM " . TABLE_PREFIX . 'user_sessions WHERE id = ?', $this->session_id);
		Cookies::unsetVariable($this->session_id_var_name);
		parent::logUserOut();
	} // logUserOut

}