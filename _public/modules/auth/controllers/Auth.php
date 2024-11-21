<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends BackendController {

	 
	public function __construct()
	{
        parent::__construct();
    }
	
	public function index()
	{
		
		if (!$this->authentication->is_loggedin())
		{
			$this->template->set_layout('login');
			$dt=array();

			$data['header']=$this->load->view("header",$dt, true);
			$data['menu']=$this->load->view("menu",$dt, true);
			$data['about']=$this->load->view("about",$dt, true);
			$data['contact']=$this->load->view("contact",$dt, true);
			$data['footer']=$this->load->view("footer",$dt, true);
			$data['news']=$this->data->get_news();
			$data['latar']=json_decode($this->_Preference_['gambar_background'], true);
			$this->template->build('auth', $data); 
		}else{
			header('location:'.base_url().'dashboard');
		}
	}
	public function season()
	{
		
$url=$this->input->get('basedata');
$startHttp = strpos($url, "http");

		// Cari posisi awal "https" dalam string
		$startHttps = strpos($url, "https");

		// Periksa apakah "http" atau "https" ditemukan dalam string
		if ($startHttp !== false && ($startHttps === false || $startHttp < $startHttps)) {
			// Ambil substring dari "http" hingga akhir
			$result = substr($url, $startHttp);
		} elseif ($startHttps !== false) {
			// Ambil substring dari "https" hingga akhir
			$result = substr($url, $startHttps);
		} else {
			echo "Tidak ditemukan 'http' atau 'https'";
		}

		// Hapus tanda '>'
		$result = str_replace('>', '', $result);

		
$data['basedata'] = $result ;

		$sts = $this->session->userdata('lock_screen');
		if (!$this->authentication->is_loggedin())
 {
			$redirect_to = isset($_GET["redirect_to"]) ? $_GET["redirect_to"] : "";
			if (!empty($redirect_to)) {
				$redirect_to = urldecode($redirect_to);
			} else {
				$redirect_to = base_url();
			}

			$sts_lock = true;
			// $this->session->set_userdata(array('lock_screen' => $sts_lock, 'lock_screen_url' => $redirect_to));
		}
		// $this->template->set_layout('login');

		$this->template->build('lock_screen', $data);
	}

	function open_lock()
	{
		$x=$this->input->post();
				$basedata = $this->input->post('basedata');

			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$hasil=$this->form_validation->run();
			
			if ($hasil == FALSE)
			{
			echo "<script>alert('Username atau Passrod tidak boleh kosong'); window.history.go(-1);</script>";

			// die('validate');

				// header('location:'.base_url().'auth');
				// $this->template->set_layout('login');
				// $this->template->build('auth', $data); ; 
			}
			else
			{
				if ($this->authentication->login_season($this->input->post('username'), $this->input->post('password'))){
					// die('berhasil');
					// $redirec=$this->authentication->get_Info_User('last_visit');
					$default_modul=$this->authentication->get_Info_User('default_modul');
					$x=$this->session->userdata('user_info');
					if (empty($default_modul)){
						header('location:' . $basedata);
					}else{
						header('location:' . $basedata);
					}
				} else {
	echo "<script>alert('Username atau Passrod yang anda masukan salah'); window.history.go(-1);</script>";

					// die('gagal');
					//header('location:'.base_url($basedata));
					// 	header('location:' . base_url('lock-screen'));
				}
			}
	 

 
	}
	public function login()
	{
		if (!$this->authentication->is_loggedin())
		{
			$x=$this->input->post();
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$hasil=$this->form_validation->run();
			
			if ($hasil == FALSE)
			{
				header('location:'.base_url().'auth');
				$this->template->set_layout('login');
				$this->template->build('auth', $data); 
			}
			else
			{
				// var_dump($this->authentication->login($this->input->post('username'), $this->input->post('password')));die();
				if ($this->authentication->login($this->input->post('username'), $this->input->post('password'))){
					// $redirec=$this->authentication->get_Info_User('last_visit');
					$default_modul=$this->authentication->get_Info_User('default_modul');
					$x=$this->session->userdata('user_info');
					if (empty($default_modul)){
						header('location:'.base_url('dashboard'));
					}else{
						header('location:'.base_url('dashboard'));
					}
				} else {
					header('location:'.base_url('auth'));
				}
			}
		}else{
			header('location:'.base_url().'dashboard');
		}
	}
	
	public function logout()
	{
		$redirect_to = isset($_GET["redirect_to"])?$_GET["redirect_to"]:uri_string();
		if(!empty($redirect_to)){
			$redirect_to = urldecode($redirect_to);
		}else{
			$redirect_to = 'dashboard';
		}
		
		$this->logdata->_log_data('modul', 'login');
		$this->logdata->_log_data('kel', 'Logout');
		$this->logdata->_msg_log_perda_bg('logout dari sistem');
		$this->logdata->_save_log_data();
		if ($this->authentication->logout($redirect_to))
		{
			header('location:'.base_url());
		}
	}
	
	public function language()
	{
		$redirect_to = isset($_GET["redirect_to"])?$_GET["redirect_to"]:"";
		if(!empty($redirect_to)){
			$redirect_to = urldecode($redirect_to);
		}else{
			$redirect_to = base_url();
		}
	
		$bahasa=$this->_Snippets_['uri'][2];;
		$this->session->set_userdata(array('bahasa' => $bahasa));
		
		header('location:'.$redirect_to);
	}
	
	public function faq()
	{
		$this->template->set_layout('login');
		$this->template->build('auth_faq'); 
	}
	
	public function daftar()
	{
		if (!$this->authentication->is_loggedin())
		{
			$user=$this->input->post('username');
			if (!empty($user))
			{
				if ($this->authentication->create_user($this->input->post('username'),$this->input->post('password')))
				{
					$this->session->set_flashdata('result_login', "Pendaftaran berhasil, silahkan anda login");
					header('location:'.base_url().'auth');
				}else{
					$this->session->set_flashdata('result_login', "Maaf, Pendaftaran anda gagal, silahkan coba kembali");
					$this->template->set_layout('login');
					$this->template->build('auth_daftar'); 
				}
			}else{
				$this->template->set_layout('login');
				$this->template->build('auth_daftar'); 
			}
		}else{
			header('location:'.base_url().'dashboard');
		}
	}

	public function forget()
	{
		$data = $this->post();
		// $email=;
		$data['email']=$email;
		$data['subject']="Send Propose";
		$data['content']="Mengirim Email Propose<br>untuk melihat data silahkan klik link dibawah ini<br><a href='http:\\risk.abutiara.com'>Linknya Nih</a>";
		$result=Doi::kirim_email($data);
		return $result;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */