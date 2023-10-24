<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->_init();
		if (!empty($this->pengguna)) {
			redirect('home','refresh');
		}
	}

	private function _init()
	{
		$this->output->set_template('mobile');
	}

	public function index()
	{
		$this->load->view('auth/v_index', $this->data);
	}

	public function dologin()
	{
		$this->output->unset_template();
		$this->form_validation->set_rules('username', 'username', 'trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('password', 'password', 'required|trim|min_length[6]|max_length[30]');

		$this->form_validation->set_error_delimiters('','');
		$this->messages  = 'device anda tidak sesuai';
		if ($this->form_validation->run() == TRUE) {
			$this->return = $this->m_user->_auth_cek();
			if ($this->return) {
					if ($this->session->userdata('id_device') && empty($this->return->id_device)) {
						if($this->return->pns == 1){
							if($this->return->intro != 1){
								$this->result = "AKTIVASI";
								$this->encrypt = encrypt_url_public($this->return->simpeg_user_id."#".date("Y-m-d H:i:s"),'login');
							}else if(empty($this->return->total_persen)){
								$this->result = "AKTIVASI";
								$this->encrypt = encrypt_url_public($this->return->simpeg_user_id."#".date("Y-m-d H:i:s"),'login');	
							}else if($this->return->total_persen != "100" ){
								$this->result = "AKTIVASI";
								$this->encrypt = encrypt_url_public($this->return->simpeg_user_id."#".date("Y-m-d H:i:s"),'login');
							}else{
								$data_user = array('id_device' => $this->session->userdata('id_device'),
										'brand'     => $this->session->userdata('brand'),
										'model'     => $this->session->userdata('model'),
										'user_id'   => $this->return->user_id,
										'is_active' => 1, );
								$this->m_user->_update_user($data_user);
								$this->result = TRUE;
							}
						}else if($this->return->pns == 2 || $this->return->level == 1){
							$data_user = array('id_device' => $this->session->userdata('id_device'),
										'brand'     => $this->session->userdata('brand'),
										'model'     => $this->session->userdata('model'),
										'user_id'   => $this->return->user_id,
										'is_active' => 1, );
							$this->m_user->_update_user($data_user);
							$this->result = TRUE;
						}
					}
					if (!empty($this->return->id_device)) {
						$this->messages  = 'akun anda telah digunakan oleh device lain, jika anda ingin mengganti device hubungi admin untuk reset device';
					}
			}else {
					$this->messages  = 'nama pengguna atau kata sandi salah';
			}
		}else {
			$this->messages = validation_errors();
		}

		if ($this->result) {
			if($this->result === "AKTIVASI"){
				$this->output->set_output(json_encode(['status'=>"AKTIVASI", 'data'=> $this->encrypt]));
			}else {
				$this->output->set_output(json_encode(['status'=>TRUE, 'message'=> 'Berhasil Login.']));
			}
		} else{
			$this->output->set_output(json_encode(['status'=>FALSE, 'message'=> $this->messages]));	
		}
	}

	public function start()
	{
		$this->load->view('auth/v_start', $this->data);
	}

	public function register()
	{
		$this->load->view('auth/v_register', $this->data);
	}

	public function forgot_password()
	{
		$this->load->view('auth/v_forgot_password', $this->data);
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */