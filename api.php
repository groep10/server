<?php

require('loader.php');

class User {

	const email_regex = "/([a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*)@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i";

	private $authed = false;

	public $session;
	public $user;


	function __construct() {
		$this->load();
	}

	function __destroy() {
		$this->saveSession();
	}

	function load() {
		global $db;

		$sessionid = null;

		if(isset($_SERVER['PHP_AUTH_USER'])) {
			// $username = $_SERVER['PHP_AUTH_USER'];
			$sessionid = $_SERVER['PHP_AUTH_PW'];
		} else if (isset($_POST['token'])) {
			$sessionid = $_POST['token'];
		} else if (isset($_GET['token'])) {
			$sessionid = $_GET['token'];
		}
		if($sessionid == null) {
			return;
		}
		$this->session = $db->fetchRow('sessions', '*', 'sessionid = ?', Array($sessionid));
		if($this->session == false) {
			return;
		}
		$this->user = $db->fetchRow('users', '*', 'id = ?', Array($this->session['userid']));
		
		$this->session['settings'] = json_decode($this->session['settings']);
		$this->user['config'] = json_decode($this->user['config']);
		$this->user['stats'] = json_decode($this->user['stats']);
		$this->authed = true;
	}

	function saveSession() {
		global $db;
		$db->update('sessions', 
			Array('settings' => json_encode($this->session['settings'])),
			'sessionid = ?',
			Array($this->session['sessionid']));
	}

	function saveUser() {
		global $db;
		$db->update('users', 
			Array(
				'displayname' => $this->user['displayname'],
				'config' => json_encode($this->user['config']),
				'stats' => json_encode($this->user['stats'])
			),
			'id = ?',
			Array($this->user['id']));

	}

	function isAuthed() {
		return $this->authed;
	}

	private static function pepper() {
		return hash('sha256', '***');
	}

	static function sessionid($username, $password) {
		return hash("sha256", $username . self::pepper() . $password . User::salt());
	}

	static function hash($password, $salt) {
		return hash("sha256", self::pepper() . $password . $salt);
	}
	
	static function salt() {
		return hash("sha256", mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
	}
}

$action = isset($_GET['action']) ? $_GET['action'] : 'default';
require('./actions/' . $action . '.php');