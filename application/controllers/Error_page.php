<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_page extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->_init();
	}

	private function _init()
	{
		$this->output->set_template('mobile');
	}

	public function fake_gps()
	{
		$this->load->view('mobile/v_error_fake_gps', $this->data);
	}

	public function gps_disabled()
	{
		$this->load->view('mobile/v_error_gps_disabled', $this->data);
	}

}

/* End of file Erorr.php */
/* Location: ./application/controllers/Erorr.php */