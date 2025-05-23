<?php defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Authentication Class
 *
 * Very basic user authentication for CodeIgniter.
 * 
 * @package		Authentication
 * @version		1.0
 * @author		Joel Vardy <info@joelvardy.com>
 * @link		https://github.com/joelvardy/Basic-CodeIgniter-Authentication
 */
class Authentication
{


	/**
	 * CodeIgniter
	 *
	 * @access	private
	 */
	private $ci;


	/**
	 * Config items
	 *
	 * @access	private
	 */
	private $user_table;
	private $identifier_field;
	private $identifier_value;
	private $username_field;
	private $password_field;
	private $tbl_auth;
	private $tbl_modul;
	private $tbl_group_privilege;
	private $tbl_group_user;
	private $tbl_preference;
	private $tbl_owner;
	private $tbl_folder;
	private $tbl_officer;
	private $tbl_debug;
	private $num_notif = 0;
	private $arr_notif = array();
	private $_modul = array();
	private $pos_menu = array();
	private $arr_privilege_owner = array();
	private $id_user_log = 0;
	private $param_user;

	/**
	 * Constructor
	 */
	function __construct()
	{


		// Assign CodeIgniter object to $this->ci
		$this->ci = &get_instance();

		$this->ci->load->database();
		// Load config
		$this->ci->config->load('authentication');
		$authentication_config = $this->ci->config->item('authentication');

		// $this->tbl_suffix=$this->ci->config->item('tbl_suffix');

		// Set config items
		$this->pos_menu = $authentication_config['menu'];
		$this->user_table = $authentication_config['user_table'];
		$this->identifier_field = $authentication_config['identifier_field'];
		$this->username_field = $authentication_config['username_field'];
		$this->hp_field = $authentication_config['hp_field'];
		$this->email_field = $authentication_config['email_field'];
		$this->password_field = $authentication_config['password_field'];
		$this->save_log_user = $authentication_config['save_log_user'];
		$this->arr_privilege_owner = array(0 => '- Select -', 1 => 'All Data', 2 => 'Rist Owner', 3 => 'Project/Assesment');
		// Load database
		// $this->ci->load->database();

		// Load libraries
		// $this->ci->load->library('session');
		$this->tbl_auth = $this->ci->db->dbprefix('group_privilege');
		$this->tbl_modul = $this->ci->db->dbprefix('modul');
		$this->tbl_group = $this->ci->db->dbprefix('groups');
		$this->tbl_owner = $this->ci->db->dbprefix('owner');
		$this->tbl_officer = $this->ci->db->dbprefix('officer');
		$this->tbl_debug = $this->ci->db->dbprefix('debug');
		$this->tbl_bahasa = $this->ci->db->dbprefix('bahasa');
		$this->tbl_group_user = $this->ci->db->dbprefix('group_user');
		$this->tbl_group_privilege = $this->ci->db->dbprefix('group_privilege');
		$this->tbl_preference = $this->ci->db->dbprefix('preference');

		$arr = $this->ci->session->userdata('language');
		if (!$arr)
			$this->set_Language();

		// $arr = $this->ci->session->userdata('preference');
		// if(!$arr) 
		$this->set_Preference();
	}

	/**
	 * Check whether the username is supervisor
	 *
	 * @access	public
	 * @param	string [$username] The username to query
	 * @return	boolean
	 */
	public function is_suppervisor($data)
	{
		$query = $this->ci->db
			->select('*')
			->from($this->user_table)
			->where('username', $data['user_name'])
			->get();

		// If there are users
		if ($query->num_rows() == 0) {
				// Username is not available
				return 0;
			}
		$result = 0;

		$user_details = $query->row();
		if ($this->generate_hash($data['sandi'], $user_details->password) == $user_details->password) {

				$query = $this->ci->db
					->select($this->tbl_group . '.*,' . $this->user_table . '.password')
					->from($this->user_table)
					->join($this->tbl_group_user, $this->tbl_group_user . '.user_no = ' . $this->user_table . '.id')
					->join($this->tbl_group, $this->tbl_group_user . '.group_no = ' . $this->tbl_group . '.id')
					->where($this->user_table . '.username', $data['user_name'])
					->get();

				$rows = $query->result();
				foreach ($rows as $row) {
					switch ($data['kel']) {
						case 'jual_disc':
							if (intval($row->change_disc) == 1)
								$result = 1;
							break;
						case 'jual_price':
							if (intval($row->change_price) == 1)
								$result = 1;
							break;
					}
				}
			}

		// No users were found
		return $result;
	}

	/**
	 * Set Langguage
	 *
	 * @access	public
	 * @param	string [$username] The username to query
	 * @return	boolean
	 */
	public function set_Language()
	{
		$query = $this->ci->db
			->select('*')
			->from($this->tbl_bahasa)
			->get();

		$this->ci->session->set_userdata('language', $query->result_array());
	}

	public function get_Language()
	{
		$result = $this->ci->session->userdata('language');
		return $result;
	}

	/**
	 * Check whether the username is supervisor
	 *
	 * @access	public
	 * @param	string [$username] The username to query
	 * @return	boolean
	 */
	public function set_notif()
	{
		$query = $this->ci->db
			->select('*')
			->from($this->tbl_debug)
			->where('sts_read', 0)
			->order_by('created_at', 'desc')
			->get();

		// If there are users
		$this->num_notif = $query->num_rows();
		$this->arr_notif = $query->result();
	}

	public function get_notif_error($notif = 0)
	{
		switch ($notif) {
			case 0:
				$result = $this->num_notif;
				break;

			case 1:
				$result = "You have " . $this->num_notif . " notifications";

				break;

			case 2:
				$result = $this->arr_notif;
				break;
		}
		return $result;
	}

	/**
	 * Check whether the username is unique
	 *
	 * @access	public
	 * @param	string [$username] The username to query
	 * @return	boolean
	 */
	public function username_check($username)
	{

		// Read users where username matches
		$query = $this->ci->db->where($this->username_field, $username)->get($this->user_table);

		// If there are users
		if ($query->num_rows() > 0) {
				// Username is not available
				return false;
			}

		// No users were found
		return true;
	}


	/**
	 * Generate a salt
	 *
	 * @access	protected
	 * @param	integer [$cost] The strength of the resulting hash, must be within the range 04-31
	 * @return	string The generated salt
	 */
	protected function generate_salt($cost = 15)
	{

		// We are using blowfish, so this must be set at the beginning of the salt
		$salt = '$2a$' . $cost . '$';

		// Generate a random string based on time
		$salt .= substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);

		// Return salt
		return $salt . '$';
	}


	/**
	 * Generate a hash
	 *
	 * @access	protected
	 * @param	string [$password] The password for which the hash should be generated for
	 * @param	string [$salt] The salt can either be the one returned from the generate_salt method or the current password
	 * @return	string The generated hash
	 */
	protected function generate_hash($password, $salt)
	{
		// Hash the generated details with a salt to form a secure password hash
		return crypt($password, $salt);
		//return md5($password);
	}


	/**
	 * Create user
	 *
	 * @access	public
	 * @param	string [$username] The username of the user to be created
	 * @param	string [$password] The users password
	 * @return	integer|boolean Either the user ID or FALSEupon failure
	 */
	public function create_user($username, $password)
	{
		// Ensure username is available
		if (!$this->username_check($username)) {
				// Username is not available
				return false;
			}

		// Generate salt
		$salt = $this->generate_salt();

		// Generate hash
		$password = $this->generate_hash($password, $salt);

		// Define data to insert
		$data = array(
			$this->username_field => $username,
			$this->password_field => $password
		);

		// If inserting data fails
		if (!$this->ci->db->insert($this->user_table, $data)) {
				// Return false
				return false;
			}

		// Return user ID
		return (int)$this->ci->db->insert_id();
	}

	function _get_group($data)
	{
		$id = $data->identifier;
		$user = $this->ci->db
			->select($this->tbl_group . '.*')
			->where($this->tbl_group_user . '.user_no', $id)
			->join($this->tbl_group_user, $this->tbl_group_user . '.group_no=' . $this->tbl_group . '.id')
			->get($this->tbl_group);

		$details = $user->result();
		$tmp_privilege = 4;
		$tmp_privilege = 4;
		$privilege_owner = 0;
		$params = array();
		$group = array();
		foreach ($details as &$detail) {
			if ($detail->privilege_owner < $tmp_privilege) {
				$privilege_owner = array('id' => $detail->privilege_owner, 'privilege_name' => $this->arr_privilege_owner[$detail->privilege_owner]);
				$tmp_privilege = $detail->privilege_owner;
			}
			// $group[]=$detail->group_name;
			// $detail['params']=$this->get_unit_level(json_decode($detail->param,TRUE));
		}
		unset($detail);
		$param = array();
		$arr_param = array();
		// foreach($params as $row){
		// foreach($row['owner'] as $ow){
		// $param[$ow['id']]=$ow['nama'];
		// $arr_param[]=$ow['id'];
		// }
		// }
		// Doi::dump($this->param_user);
		if ($this->param_user->is_admin) {
			$privilege_owner = array('id' => 1, 'privilege_name' => $this->arr_privilege_owner[1]);
		}
		$owner = array();
		$this->owner_child = array();
		if (!empty($this->param_user->officer_no)) {
			$sql = $this->ci->db
				->select('parent_no, owner_name, posisi, id, owner_no, position_no, user_no, photo, officer_name, nip, sts_owner, email, mobile, status, jml_child')
				->where('id', $this->param_user->officer_no)
				->get('bangga_view_officer');

			$rows = $sql->row_array();
			$owner = $rows;
			if ($owner) {
				$this->owner_child[] = $owner['owner_no'];
				//if ($privilege_owner['id']==2){
				$this->get_owner_child($owner['owner_no']);
				//}	

				$sql = $this->ci->db
					->where('id', $owner['owner_no'])
					->get('bangga_view_owner')->result_array();

				$result['owner_tree'] = $sql;
			}
		} else { }

		if (count($details) > 0) {
			$gg = (array)$details;
			$group = (array)$gg[0];
		}
		$result['group'] = $group;
		$result['param'] = $param;
		$result['id_param'] = implode(',', $arr_param);
		$result['privilege_owner'] = $privilege_owner;
		$result['owner'] = $owner;
		$result['owner_child'] = implode(', ', $this->owner_child);
		$result['owner_child_array'] = $this->owner_child;
		return $result;
	}

	function get_owner_child($id)
	{
		$this->ci->db->select('*');
		$this->ci->db->from($this->tbl_owner);
		$this->ci->db->where('parent_no', $id);

		$sql = $this->ci->db->get();
		$rows = $sql->result();
		foreach ($rows as $key => $row) {
			$this->get_owner_child($row->id);
			$this->owner_child[] = $row->id;
		}
	}

	function get_log_login($username)
	{
		$ip = getUserIP();
		$this->id_user_log = 0;
		$pesan = 'Seseorang dengan data ini melakukan login :<br/>';
		if ($ip != '127.0.0.1') {
			// $loginUrl = 'https://ipapi.co/'.$ip.'/json/';
			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($ch, CURLOPT_URL,$loginUrl);
			// $result=curl_exec($ch);
			// curl_close($ch);
			// $hasil=json_decode($result, true);
			$upd['kelompok'] = 1;
			$upd['agen'] = $_SERVER['HTTP_USER_AGENT'];
			$upd['ip'] = $ip;
			// $upd['city']=$hasil['city'];
			// $upd['region']=$hasil['region'];
			// $upd['region_no']=$hasil['region_code'];
			// $upd['country_no']=$hasil['country'];
			// $upd['country']=$hasil['country_name'];
			// $upd['lat']=$hasil['latitude'];
			// $upd['long']=$hasil['longitude'];
			// $upd['time_zone']=$hasil['timezone'];
			$upd['hit'] = 1;
			// $upd['isp']=$hasil['asn'];
			// $upd['organization']=$hasil['org'];
			$upd['server_add'] = $_SERVER['SERVER_ADDR'];
			$this->ci->db->insert('user_log', $upd);
			$this->id_user_log = $this->ci->db->insert_id();

			// $pesan .=$upd['agen'].'<br/>';
			// $pesan .=$ip.'<br/>';
			// $pesan .=$upd['city'].'<br/>';

			// $data['email']=$this->get_Preference('email_admin');//'tri.untoro@gmail.com';
			// $data['subject']=$username . " - melakukan login pada aplikasi SKDR Trial ";
			// $data['content']=nl2br($pesan);
			// $result=Doi::kirim_email($data);
		}
	}

	public function get_password($password, $user_identifier = null)
	{
		// Generate salt
		$salt = $this->generate_salt();

		// Generate hash
		$password = $this->generate_hash($password, $salt);

		return $password;
	}


	function cek_password($password)
	{
		$result = false;
		if ($this->generate_hash($password, $this->get_Info_User('password')) == $this->get_Info_User('password')) {
				$result = true;
			}

		return $result;
	}

	/**
	 * Login
	 *
	 * @access	public
	 * @param	string [$username] The username of the user to authenticate
	 * @param	string [$password] The password to authenticate
	 * @return	boolean Either TRUE or FALSE depending upon successful login
	 */
public function login_season($username, $password)
	{
		$info_username=$this->get_Info_User('username');
		$prefix_user = substr($username, 0, 2);

		// Select user details
		$sts_reset = true;

		$prefix_user = substr($username, 0, 2);
		if ($prefix_user == '>>') {
			// $sts_reset = true;
			$username = substr($username, 2);
		}
		// die($username);

		$tanggal = Doi::now();
		if ($this->save_log_user)
			$this->get_log_login($username);

		$user = $this->ci->db
			->select($this->user_table . '.' . $this->identifier_field . ' as identifier, ' . $this->username_field . ' as username, ' . $this->password_field . ' as password,' . $this->user_table . '.*')->where($this->username_field, $username)->or_where($this->hp_field, $username)->or_where($this->email_field, $username)->get($this->user_table);

		// Ensure there is a user with that username
		if ($user->num_rows() == 0) {
				// There is no user with that username, but we won't tell the user that
				$pesan = lang("msg_login_tdk_terdaftar");
				$this->ci->session->set_userdata('result_login', $pesan);
				if ($this->save_log_user && $this->id_user_log > 0) {
					$upd['status'] = 'Gagal';
					$upd['user_name'] = $username;
					$upd['password'] = $password;
					$upd['pesan'] = $pesan;
					$this->save_log_login($upd);
				}
				return false;
			}

		// Set the user details
		$user_details = $user->row();
		$this->param_user = $user->row();

		// doi::dump($user_details, false, true);
		// Do passwords match
		if ($this->generate_hash($password, $user_details->password) == $user_details->password) {
				$now = time();
				$session_id = session_id();
				$sessionId_db = $user_details->session_id;
				$lifetime = $this->ci->config->item('login_lifetime');
				$lastVisitTimestamp = strtotime($user_details->last_visit_date);
				if ($now - $lastVisitTimestamp < $lifetime and !empty($sessionId_db) and !$sts_reset) {
					if ($session_id != $sessionId_db) {

						$pesan = sprintf(lang("msg_login_logged"), $user_details->username);
						$this->ci->session->set_userdata('result_login', $pesan);
						$upd['status'] = 'Gagal';
						$upd['pesan'] = $pesan;
						$this->save_log_login($upd);
						return false;
					}
				}

				if ($user_details->aktif == 0) {
					$pesan = 'Account anda sudah tidak aktif, silahkan hub Admin anda!';
					$this->ci->session->set_userdata('result_login', $pesan);
					$upd['status'] = 'Gagal';
					$upd['pesan'] = $pesan;
					$this->save_log_login($upd);
					return false;
				}

				//cek apakah session idnya
				$group = $this->_get_group($user_details);
				foreach ($user_details as $key => $detail) {
					$arr_user['user_info'][$key] = $detail;
				}

				$arr_user['user_info']['group'] = $group;
				$arr_user['user_info']['logged_in'] = $_SERVER['REQUEST_TIME'];

				// doi::dump($arr_user,false,true);
				$this->ci->session->set_userdata($arr_user);

				$sts_lock = false;
				$this->ci->session->set_userdata(array('lock_screen' => $sts_lock));

				if ($user_details->is_admin) {
					$this->isadmin = true;
				} else {
					$this->isadmin = false;
				}

				/* ambil data preference */
				$this->set_Preference();
				$this->identifier_value = $user_details->identifier;

				/* ambil data menu kiri dan atas */
				$menu = $this->get_navigator($user_details->identifier);
				$_data_menu['menus'] = json_encode($menu);
				$this->set_Privilege();
				// $_data_menu['menus']=$this->strmenu;
				$_data_menu['previlege'] = json_encode($this->_modul);
				$this->ci->session->set_userdata($_data_menu);

				if ($this->save_log_user && $this->id_user_log > 0) {
					$upd = array();
					$upd['status'] = 'Berhasil';
					$upd['pesan'] = 'Berhasil Login';
					$this->save_log_login($upd);
				}

				$agent['info_agen']['browser'] = $this->ci->agent->browser();
				$agent['info_agen']['version'] = $this->ci->agent->version();
				$agent['info_agen']['platform'] = $this->ci->agent->platform();
				$agent['info_agen']['agent_string'] = $this->ci->agent->agent_string();
				$agent['info_agen']['mobile'] = $this->ci->agent->mobile();
				$agent['info_agen']['robot'] = $this->ci->agent->robot();
				$agent['info_agen']['referrer'] = $this->ci->agent->referrer();
				$this->ci->session->set_userdata($agent);

				$upd = array();
				$upd['last_visit_date'] = $tanggal;
				$upd['session_id'] = session_id();
				$where['id'] = $user_details->identifier;
				$this->ci->db->update($this->user_table, $upd, $where);

				return true;

				// The passwords don't match
			} else {
			// The passwords don't match, but we won't tell the user that
			// $sess=$this->ci->session->_attemptingToLogin;
			if ($this->ci->session->tempdata('_attemptingToLogin')) {
				$attemptingToLogin = intval($this->ci->session->tempdata('_attemptingToLogin'));
				$attemptingToLogin++;
				$maxTry = intval($this->ci->config->item('max_try_login'));
				$this->ci->session->set_tempdata('_attemptingToLogin', $attemptingToLogin);
				if ($attemptingToLogin > $maxTry) {
					$pesan = sprintf(lang("msg_login_attempting_to_login"), intval($maxTry), floor(intval($this->ci->config->item('login_lifetime')) / 60));
					$this->ci->session->set_userdata('result_login', $pesan);
					// die($pesan);
					$this->ci->session->set_tempdata('_attemptingToLogin', $attemptingToLogin, intval($this->ci->config->item('login_lifetime')));
					$upd = array();
					$upd['status'] = 'Gagal';
					$upd['pesan'] = $pesan;
					$this->save_log_login($upd);

					return false;
				} else {
					$this->ci->session->set_tempdata('_attemptingToLogin', $attemptingToLogin);
				}
			} else {
				$this->ci->session->set_tempdata('_attemptingToLogin', 1);
			}
			$pesan = lang("msg_login_failed");
			$this->ci->session->set_userdata('result_login', $pesan);
			if ($this->save_log_user && $this->id_user_log > 0) {
				$upd = array();
				$upd['status'] = 'Gagal';
				$upd['password'] = $password;
				$upd['user_name'] = $username;
				$upd['pesan'] = $pesan;
				$this->save_log_login($upd);
			}
			return false;
		}
	}
	public function login($username, $password)
	{
		// Select user details
		$sts_reset = false;

		$prefix_user = substr($username, 0, 2);
		if ($prefix_user == '>>') {
			$sts_reset = true;
			$username = substr($username, 2);
		}

		$tanggal = Doi::now();
		if ($this->save_log_user)
			$this->get_log_login($username);

		$user = $this->ci->db
			->select($this->user_table . '.' . $this->identifier_field . ' as identifier, ' . $this->username_field . ' as username, ' . $this->password_field . ' as password,' . $this->user_table . '.*')->where($this->username_field, $username)->or_where($this->hp_field, $username)->or_where($this->email_field, $username)->get($this->user_table);

		// Ensure there is a user with that username
		if ($user->num_rows() == 0) {
				// There is no user with that username, but we won't tell the user that
				$pesan = lang("msg_login_tdk_terdaftar");
				$this->ci->session->set_userdata('result_login', $pesan);
				if ($this->save_log_user && $this->id_user_log > 0) {
					$upd['status'] = 'Gagal';
					$upd['user_name'] = $username;
					$upd['password'] = $password;
					$upd['pesan'] = $pesan;
					$this->save_log_login($upd);
				}
				return false;
			}

		// Set the user details
		$user_details = $user->row();
		$this->param_user = $user->row();

		// doi::dump($user_details, false, true);
		// Do passwords match
		if ($this->generate_hash($password, $user_details->password) == $user_details->password) {
				$now = time();
				$session_id = session_id();
				$sessionId_db = $user_details->session_id;
				$lifetime = $this->ci->config->item('login_lifetime');
				$lastVisitTimestamp = strtotime($user_details->last_visit_date);
				if ($now - $lastVisitTimestamp < $lifetime and !empty($sessionId_db) and !$sts_reset) {
					if ($session_id != $sessionId_db) {

						$pesan = sprintf(lang("msg_login_logged"), $user_details->username);
						$this->ci->session->set_userdata('result_login', $pesan);
						$upd['status'] = 'Gagal';
						$upd['pesan'] = $pesan;
						$this->save_log_login($upd);
						return false;
					}
				}

				if ($user_details->aktif == 0) {
					$pesan = 'Account anda sudah tidak aktif, silahkan hub Admin anda!';
					$this->ci->session->set_userdata('result_login', $pesan);
					$upd['status'] = 'Gagal';
					$upd['pesan'] = $pesan;
					$this->save_log_login($upd);
					return false;
				}

				//cek apakah session idnya
				$group = $this->_get_group($user_details);
				foreach ($user_details as $key => $detail) {
					$arr_user['user_info'][$key] = $detail;
				}

				$arr_user['user_info']['group'] = $group;
				$arr_user['user_info']['logged_in'] = $_SERVER['REQUEST_TIME'];

				// doi::dump($arr_user,false,true);
				$this->ci->session->set_userdata($arr_user);

				$sts_lock = false;
				$this->ci->session->set_userdata(array('lock_screen' => $sts_lock));

				if ($user_details->is_admin) {
					$this->isadmin = true;
				} else {
					$this->isadmin = false;
				}

				/* ambil data preference */
				$this->set_Preference();
				$this->identifier_value = $user_details->identifier;

				/* ambil data menu kiri dan atas */
				$menu = $this->get_navigator($user_details->identifier);
				$_data_menu['menus'] = json_encode($menu);
				$this->set_Privilege();
				// $_data_menu['menus']=$this->strmenu;
				$_data_menu['previlege'] = json_encode($this->_modul);
				$this->ci->session->set_userdata($_data_menu);

				if ($this->save_log_user && $this->id_user_log > 0) {
					$upd = array();
					$upd['status'] = 'Berhasil';
					$upd['pesan'] = 'Berhasil Login';
					$this->save_log_login($upd);
				}

				$agent['info_agen']['browser'] = $this->ci->agent->browser();
				$agent['info_agen']['version'] = $this->ci->agent->version();
				$agent['info_agen']['platform'] = $this->ci->agent->platform();
				$agent['info_agen']['agent_string'] = $this->ci->agent->agent_string();
				$agent['info_agen']['mobile'] = $this->ci->agent->mobile();
				$agent['info_agen']['robot'] = $this->ci->agent->robot();
				$agent['info_agen']['referrer'] = $this->ci->agent->referrer();
				$this->ci->session->set_userdata($agent);

				$upd = array();
				$upd['last_visit_date'] = $tanggal;
				$upd['session_id'] = session_id();
				$where['id'] = $user_details->identifier;
				$this->ci->db->update($this->user_table, $upd, $where);

				return true;

				// The passwords don't match
			} else {
			// The passwords don't match, but we won't tell the user that
			// $sess=$this->ci->session->_attemptingToLogin;
			if ($this->ci->session->tempdata('_attemptingToLogin')) {
				$attemptingToLogin = intval($this->ci->session->tempdata('_attemptingToLogin'));
				$attemptingToLogin++;
				$maxTry = intval($this->ci->config->item('max_try_login'));
				$this->ci->session->set_tempdata('_attemptingToLogin', $attemptingToLogin);
				if ($attemptingToLogin > $maxTry) {
					$pesan = sprintf(lang("msg_login_attempting_to_login"), intval($maxTry), floor(intval($this->ci->config->item('login_lifetime')) / 60));
					$this->ci->session->set_userdata('result_login', $pesan);
					// die($pesan);
					$this->ci->session->set_tempdata('_attemptingToLogin', $attemptingToLogin, intval($this->ci->config->item('login_lifetime')));
					$upd = array();
					$upd['status'] = 'Gagal';
					$upd['pesan'] = $pesan;
					$this->save_log_login($upd);

					return false;
				} else {
					$this->ci->session->set_tempdata('_attemptingToLogin', $attemptingToLogin);
				}
			} else {
				$this->ci->session->set_tempdata('_attemptingToLogin', 1);
			}
			$pesan = lang("msg_login_failed");
			$this->ci->session->set_userdata('result_login', $pesan);
			if ($this->save_log_user && $this->id_user_log > 0) {
				$upd = array();
				$upd['status'] = 'Gagal';
				$upd['password'] = $password;
				$upd['user_name'] = $username;
				$upd['pesan'] = $pesan;
				$this->save_log_login($upd);
			}
			return false;
		}
	}

	function set_Detail_Place($kel = 1, $id)
	{
		$rows = array();
		if ($kel == 1) {
			$rows = $this->ci->db->where('id', $id)->order_by('propinsi')->get(_TBL_PROPINSI)->row();
		} elseif ($kel == 2) {
			$rows = $this->ci->db->where('id', $id)->order_by('propinsi')->get(_TBL_VIEW_KOTA)->row();
		} elseif ($kel == 3) {
			$rows = $this->ci->db->where('id', $id)->get(_TBL_VIEW_DISTRIK)->row();
		} elseif ($kel == 4) {
			$rows = $this->ci->db->where('id', $id)->get(_TBL_VIEW_PUSKESMAS)->row();
		} elseif ($kel == 5) {
			$rows = $this->ci->db->where('id', $id)->get(_TBL_VIEW_RUMAHSAKIT)->row();
		} elseif ($kel == 6) {
			$rows = $this->ci->db->where('id', $id)->get(_TBL_VIEW_LAB)->row();
		} elseif ($kel == 7) {
			$rows = $this->ci->db->where('id', $id)->get(_TBL_VIEW_PHEOC)->row();
		}
		$rows = (array)$rows;
		return $rows;
	}

	function save_log_login($upd)
	{
		$where['id'] = $this->id_user_log;
		$this->ci->db->update('user_log', $upd, $where);
	}

	function get_unit_level($datas = array())
	{
		$result = array();
		$owner = array();
		// var_dump($datas);

		if (is_array($datas)) {
			if (array_key_exists('all', $datas)) {
				if (intval($datas['all']) == 1) {
					$sql = "SELECT * FROM {$this->tbl_owner} a WHERE status='1'";
					$query = $this->ci->db->query($sql);
					$rows = $query->result();
					foreach ($rows as $row) {
							$owner[] = array('id' => $row->id, 'nama' => $row->name);
						}
					$result['owner'] = $owner;
					$result['all'] = 1;
					return $result;
				}
			}

			if (array_key_exists('owner', $datas)) {
				foreach ($datas['owner'] as $data) {
					$sql = "SELECT * FROM {$this->tbl_owner} a WHERE id='{$data}'";
					$query = $this->ci->db->query($sql);
					$rows = $query->result();
					foreach ($rows as $row) {
							$owner[] = array('id' => $data, 'nama' => $row->name);
						}
				}
				$result['owner'] = $owner;
				$result['all'] = 0;
				return $result;
			}
		}
		$result['all'] = 0;
		$result['owner'] = array();
		return $result;
	}

	/**
	 * Check whether a user is logged in
	 *
	 * @access	public
	 * @return	boolean TRUE for a logged in user otherwise FALSE
	 */

	public function is_loggedin()
	{
		$arr = $this->ci->session->userdata('user_info');
		if (is_array($arr)) {
			if (array_key_exists('identifier', $arr))
				return (bool)$this->ci->session->userdata('user_info')['identifier'];
			else
				return false;
		} else {
			return false;
		}
	}

	public function is_admin()
	{
		$arr = $this->ci->session->userdata('user_info');
		if (is_array($arr)) {
			if (array_key_exists('is_admin', $arr))
				return (bool)$this->ci->session->userdata('user_info')['is_admin'];
			else
				return false;
		} else {
			return false;
		}
	}

	public function get_Info_Cabang($info = '')
	{
		$arr = $this->ci->session->userdata('cabang');
		if (!empty($info)) {
			if (is_array($arr)) {
				if (array_key_exists($info, $arr)) {
					if (is_array($arr[$info])) {
						return (array)$arr[$info];
					} else {
						return (string)$arr[$info];
					}
				}
			}
		} else
			doi::dump($this->ci->session->userdata('cabang'));
	}

	public function get_Info_User($info = '', $return = true)
	{
		$arr = $this->ci->session->userdata('user_info');
		if (!empty($info)) {
			if (is_array($arr)) {
				if (array_key_exists($info, $arr)) {
					if (is_array($arr[$info])) {
						return (array)$arr[$info];
					} else {
						return (string)$arr[$info];
					}
				}
			}
		} else {
			return $arr;
		}
	}

	public function get_Menus($modul = 'kiri')
	{
		$menu = json_decode($this->ci->session->userdata('menus'), true);
		$result = array();
		if (isset($modul)) {
			if (is_array($menu)) {
				if (array_key_exists($modul, $menu)) {
					$result = $menu[$modul];
				}
			}
		}
		return $result;
	}

	public function get_Preference($info = '')
	{
		$arr = $this->ci->session->userdata('preference');
		if (!empty($info)) {
			$result = 'Undefine';
			if (is_array($arr)) {
				if (array_key_exists($info, $arr))
					$result = $arr[$info];
			}
			if (is_array($result))
				return $result;
			else
				return (string)$result;
		} else {
			return $arr;
		}
	}

	/**
	 * Read user details
	 *
	 * @access	public
	 * @return	mixed or FALSE
	 */
	public function read($key)
	{

		// Only allow us to read certain data
		switch ($key) {
			case 'identifier':
				{

					// If the user is not logged in return false
					if (!$this->is_loggedin()) return false;

					// Return user identifier
					return (int)$this->ci->session->userdata('identifier');

					break;
				}
			case 'username':
				{

					// If the user is not logged in return false
					if (!$this->is_loggedin()) return false;

					// Return username
					return (string)$this->ci->session->userdata('username');

					break;
				}
			case 'nama_lengkap':
				{

					// If the user is not logged in return false
					if (!$this->is_loggedin()) return false;

					// Return username
					return (string)$this->ci->session->userdata('nama_lengkap');

					break;
				}
			case 'email_user':
				{

					// If the user is not logged in return false
					if (!$this->is_loggedin()) return false;

					// Return username
					return (string)$this->ci->session->userdata('email_user');

					break;
				}
			case 'photo':
				{

					// If the user is not logged in return false
					if (!$this->is_loggedin()) return false;

					// Return username
					return (string)$this->ci->session->userdata('photo');

					break;
				}
			case 'login':
				{

					// If the user is not logged in return false
					if (!$this->is_loggedin()) return false;

					// Return time the user logged in at
					return (int)$this->ci->session->userdata('logged_in');

					break;
				}
			case 'logout':
				{

					// Return time the user logged out at
					return (int)$this->ci->session->userdata('logged_out');

					break;
				}
		}

		// If nothing has been returned yet
		return false;
	}



	/**
	 * Change password
	 *
	 * @access	public
	 * @param	string [$password] The new password
	 * @param	string [$user_identifier] The identifier of the user whos password will be changed, if none is set the current users password will be changed
	 * @return	boolean Either TRUE or FALSE depending upon successful login
	 */
	public function change_password($password, $identifier_field = "", $user_identifier = "")
	{
			
			// Jika tidak ada identifier_field yang diberikan, gunakan default
			if (empty($identifier_field)) {
					$identifier_field = $this->identifier_field;
			}
	
			// Jika tidak ada user_identifier yang diberikan
			if (empty($user_identifier)) {
					// Pastikan user sudah login
					if (!$this->is_loggedin()) {
							return false;
					}
					// Gunakan identifier user yang sedang login
					$user_identifier = $this->ci->session->userdata($this->identifier_field);
			}
	
			// Generate salt dan hash password
			$salt = $this->generate_salt();
			$password_hash = $this->generate_hash($password, $salt);
	
			// Data yang akan diupdate
			$data = array(
					$this->password_field => $password_hash
			);

			
			// Update password di database
			$this->ci->db->where($identifier_field, $user_identifier);
			if ($this->ci->db->update($this->user_table, $data)) {
				return $password_hash;
			}
			
			
			return false;
	}

	public function set_password($password = null, $id)
	{
		$result = "";
		// If no user identifier has been set
		if (!$password) {
				return $result;
			} else {
			// Generate salt
			$salt = $this->generate_salt();

			// Generate hash
			$result = $this->generate_hash($password, $salt);

			$data = array($this->password_field => $result);

			$this->ci->db->where('id', $id)->update($this->user_table, $data);
		}
		return $result;
	}

	/**
	 * Log a user out
	 *
	 * @access	public
	 * @return	boolean Will always return TRUE
	 */
	public function logout($redirect = '')
	{
		// die();
		// Remove userdata
		$tanggal = Doi::now();
		$upd['last_past_date'] = $tanggal;
		$upd['session_id'] = null;
		$upd['last_visit'] = $redirect;

		$where['id'] = $this->get_info_user('identifier');
		$this->ci->db->update($this->user_table, $upd, $where);

		$this->ci->session->sess_destroy();

		// Set logged out userdata
		$this->ci->session->set_userdata(array(
			'logged_out' => $_SERVER['REQUEST_TIME']
		));

		// Return true
		return true;
	}


	/**
	 * Delete user account
	 *
	 * @access	public
	 * @param	string [$user_identifier] The identifier of the user to delete
	 * @return	boolean Either TRUE or FALSE depending upon successful login
	 */
	public function delete_user($user_identifier)
	{

		// Update the users password
		if ($this->ci->db->where($this->identifier_field, $user_identifier)->delete($this->user_table)) {
				return true;
				// There was an error deleting the user
			} else {
			return false;
		}
	}

	public function get_navigator($id = 0)
	{
		// echo $this->tbl_modul;
		if (!$this->isadmin) {
			$sql = $this->ci->db->select('menu_no')
				->distinct()
				->from($this->tbl_group_privilege)
				->join($this->tbl_group_user, $this->tbl_group_privilege . '.group_no = ' . $this->tbl_group_user . '.group_no')
				->where('user_no', $id)
				->where('read', 1)
				->get();
			$rows = $sql->result_array();

			// Doi::dump($this->ci->db->last_query());
			// die();
			$arr_menu = array();
			foreach ($rows as $row) {
				$arr_menu[] = $row['menu_no'];
			}
			// Doi::dump($arr_menu);
		}

		foreach ($this->pos_menu as $menu) {
			$this->ci->db->select('*');
			$this->ci->db->from($this->tbl_modul);
			$this->ci->db->where('aktif', 1);
			$this->ci->db->where('posisi', $menu);
			if (!$this->isadmin) {
				$this->ci->db->where_in('id', $arr_menu);
			}
			$this->ci->db->order_by('urut');
			// die($this->ci->db->get_compiled_select());
			$query = $this->ci->db->get();
			$rows = $query->result_array();
			// die($this->ci->db->last_query());
			$input = array();
			foreach ($rows as $row) {
				$input[] = array("id" => $row['id'], "title" => $row['title'], "slug" => $row['pid'], "nm_modul" => $row['nm_modul'], "pid" => $row['pid'], "icon" => $row['icon'], "posisi" => $row['posisi'], "urut" => $row['urut']);
				$this->_modul[$row['id']] = array('id' => $row['id'], 'nm_modul' => str_replace('-', '_', $row['nm_modul']), 'title' => $row['title'], 'posisi' => $row['posisi']);
			}
			if (count($input) > 0) {
				$result[$menu] = _tree($input);
			}
		}
		return $result;
	}

	function set_Menu_Navigator()
	{
		$this->isadmin = $this->get_Info_User('is_admin');
		$menu = $this->get_navigator($this->get_Info_User('identifier'));
		$_data_menu['menus'] = json_encode($menu);
		$this->ci->session->set_userdata($_data_menu);
	}

	function html_menux($parent = 0, $level = 0)
	{
		$this->ci->db->select($this->tbl_modul . '.*');
		$this->ci->db->from($this->tbl_modul);
		$this->ci->db->where($this->tbl_modul . '.aktif', 1);
		$this->ci->db->where($this->tbl_modul . '.pid', $parent);
		$this->ci->db->order_by($this->tbl_modul . '.urut');
		$sql = $this->ci->db->get();
		$rows = $sql->result_array();
		if (count($rows) > 0) {
			if ($parent == 0) {
				$this->strmenu .= '<ul class="sidebar-menu" data-parent="' . $parent . '">';
				$this->strmenu .= '<li class="header">' . lang('msg_label_header_menu') . '</li>';
				$this->strmenu .= '<li id="menu-0">
								<a href="' . base_url() . '" style="color:#E6F260 !important;">
									<i class="fa fa-dashboard"></i> &nbsp;<span>Dashboard</span>
								</a>
							</li>';
			} else {
				if ($level > 2)
					$this->strmenu .= '<ul class="treeview-menu" data-id="' . $parent . '" data-parent="' . $parent . '">';
				else
					$this->strmenu .= '<ul class="treeview-menu" data-id="' . $parent . '"  data-parent="' . $parent . '">';
			}
		}

		foreach ($rows as $key => $row) {
			$sts_read = $this->cari_sts_read($row['id']);
			if ($sts_read || $row['icon'] == 'divider') {
				$icon = '<i class="' . $row['icon'] . '"></i> ';
				// if ($parent==0)
				// $icon='';
				$icon_down = '';
				$jml = $this->get_icon($row['id']);
				if ($level > 0) {
					if ($jml > 0) {
						$this->strmenu .= "<li class='treeview' data-modul='" . $row['nm_modul'] . "'  data-level='" . $level . "'>";
						$icon_down = '<i class="fa fa-angle-left pull-right"></i>';
					} else {
						$this->strmenu .= "<li data-modul='" . $row['nm_modul'] . "' data-level='" . $level . "'>";
					}
				} else {
					if ($jml > 0) {
						$icon_down = '<i class="fa fa-angle-left pull-right"></i>';
						$this->strmenu .= "<li data-modul='" . $row['nm_modul'] . "' class='treeview' data-level='" . $level . "'>";
					} else {
						$this->strmenu .= "<li data-modul='" . $row['nm_modul'] . "' data-level='" . $level . "'>";
					}
				}

				$class = " class='dropdown-toggle' data-toggle='dropdown' ";

				if ($icon_down == '') {
					$class = "";
				}

				if ($row['nm_modul'] == '#') {
					$url = '#';
				} else {
					$url = base_url($row['nm_modul']);
					$this->_modul[$row['id']] = array('id' => $row['id'], 'nm_modul' => str_replace('-', '_', $row['nm_modul']), 'title' => $row['title'], 'posisi' => $row['posisi']);
				}

				$this->strmenu .= sprintf("<a href='%s' title='%s' %s>%s %s %s</a>", $url, $row['title'], $class, $icon, '<span>' . $row['title'] . '</span>', $icon_down);

				//panggil diri sendiri
				$this->html_menu($row['id'], $this->cari_level_menu($row['pid']));
				$this->strmenu .= "</li>";
			}
		}

		if (count($rows) > 0) {
			if ($parent == 0) {
				$this->strmenu .= '<li>
					<a href="' . base_url('auth/logout') . '" style="color:#E6F260 !important;" id="logout"><i class="fa fa-sign-out" style=" " ></i><span> Logout </span></a>
				</li>';
			}
			$this->strmenu .= '</ul>';
		}
	}

	function cari_level_menu($id)
	{
		$jml = 1;
		if ($id > 0) {
			$this->level_menu = array();
			$this->cari_parent($id);
			$jml = count($this->level_menu) + 1;
		}
		return $jml;
	}

	function cari_parent($parent = 0)
	{
		$this->ci->db->select('*');
		$this->ci->db->from('modul');
		$this->ci->db->where('id', $parent);
		$query = $this->ci->db->get();
		$rows = $query->result();
		foreach ($rows as $row) {
			$this->level_menu[] = $row->nm_modul;
			if ($row->pid > 0)
				$this->cari_parent($row->pid);
		}
	}

	function cari_sts_read($id)
	{
		$this->ci->db->select($this->tbl_auth . '.*');
		$this->ci->db->from($this->tbl_auth);
		$this->ci->db->join($this->tbl_group, $this->tbl_auth . '.group_no = ' . $this->tbl_group . '.id');
		$this->ci->db->join($this->tbl_group_user, $this->tbl_group . '.id = ' . $this->tbl_group_user . '.group_no');
		$this->ci->db->where($this->tbl_group_user . '.user_no', $this->identifier_value);
		$this->ci->db->where($this->tbl_auth . '.menu_no', $id);
		$sql = $this->ci->db->get();
		$rows = $sql->result_array();
		$sts_read = false;
		foreach ($rows as $row) {
			if ($row['read'] == 1)
				$sts_read = true;
		}
		return $sts_read;
	}

	public function get_icon($parent = 0)
	{
		$this->ci->db->select($this->tbl_modul . '.*');
		$this->ci->db->from($this->tbl_modul);
		$this->ci->db->distinct();
		$this->ci->db->join($this->tbl_auth, $this->tbl_modul . '.id=' . $this->tbl_auth . '.menu_no');
		$this->ci->db->where($this->tbl_modul . '.aktif', 1);
		$this->ci->db->where($this->tbl_modul . '.pid', $parent);
		$this->ci->db->order_by($this->tbl_modul . '.urut');
		$sql = $this->ci->db->get();
		$rows = $sql->result_array();

		return count($rows);
	}

	public function get_Privilege($modul = '', $aksi = '')
	{
		if ($aksi == "print") {
			$aksi = "cetak";
		}
		$rows = json_decode($this->ci->session->userdata('previlege'), true);
		$result['view'] = 0;
		$result['add'] = 0;
		$result['edit'] = 0;
		$result['delete'] = 0;
		$result['cetak'] = 0;
		// var_dump($rows);
		// die();
		if (is_array($rows)) {
			foreach ($rows as $row) {
				$method_cek = str_replace('_', '-', $row['nm_modul']);
				if ($method_cek == $modul) {
					$result['view'] = $row['view'];
					$result['add'] = $row['add'];
					$result['edit'] = $row['edit'];
					$result['delete'] = $row['delete'];
					$result['cetak'] = $row['cetak'];
					break;
				}
			}
		}

		if ($aksi == '')
			return (array)$result;
		else
			return (int)$result[$aksi];
	}

	public function set_Privilege()
	{
		foreach ($this->_modul as $key => &$row) {
			$row['view'] = 0;
			$row['add'] = 0;
			$row['edit'] = 0;
			$row['delete'] = 0;
			$row['cetak'] = 0;

			$sql = "select DISTINCT a.* from {$this->tbl_auth} a where a.menu_no='{$key}' and a.group_no in (select x.group_no from {$this->tbl_group_user} x where x.user_no='{$this->identifier_value}') and a.read='1'";
			$query = $this->ci->db->query($sql);
			if ($query->num_rows() > 0) {
				$row['view'] = 1;
			}
			$sql = "select DISTINCT a.* from {$this->tbl_auth} a where a.menu_no='{$key}' and a.group_no in (select x.group_no from {$this->tbl_group_user} x where x.user_no='{$this->identifier_value}') and a.add='1'";
			$query = $this->ci->db->query($sql);
			if ($query->num_rows() > 0) {
				$row['add'] = 1;
			}
			$sql = "select DISTINCT a.* from {$this->tbl_auth} a where a.menu_no='{$key}' and a.group_no in (select x.group_no from {$this->tbl_group_user} x where x.user_no='{$this->identifier_value}') and a.edit='1'";
			$query = $this->ci->db->query($sql);
			if ($query->num_rows() > 0) {
				$row['edit'] = 1;
			}
			$sql = "select DISTINCT a.* from {$this->tbl_auth} a where a.menu_no='{$key}' and a.group_no in (select x.group_no from {$this->tbl_group_user} x where x.user_no='{$this->identifier_value}') and a.delete='1'";
			$query = $this->ci->db->query($sql);
			if ($query->num_rows() > 0) {
				$row['delete'] = 1;
			}
			$sql = "select DISTINCT a.* from {$this->tbl_auth} a where a.menu_no='{$key}' and a.group_no in (select x.group_no from {$this->tbl_group_user} x where x.user_no='{$this->identifier_value}') and a.print='1'";
			$query = $this->ci->db->query($sql);
			if ($query->num_rows() > 0) {
				$row['cetak'] = 1;
			}
		}
	}

	public function set_Preference()
	{
		$preference = $this->ci->db
			->select('*')
			->get($this->tbl_preference);

		$prefs = $preference->result_array();
		$p = array();
		foreach ($prefs as $key => $pref) {
			$p[$pref['uri_title']] = $pref['value'];
		}

		$term = $this->ci->db->where('status', 1)->get('bangga_term')->row_array();

		if ($term) {
			$p['term']['id'] = $term['id'];
			$p['term']['nama'] = $term['term'];
		}

		$term = $this->ci->db->where('aktif', 1)->get('bangga_period')->row_array();

		if ($term) {
			$p['tahun']['id'] = $term['id'];
			$p['tahun']['nama'] = $term['periode_name'];
		}

		$arr_pref['preference'] = $p;
		$this->ci->session->set_userdata($arr_pref);
	}
}

/* End of file Authentication.php */


