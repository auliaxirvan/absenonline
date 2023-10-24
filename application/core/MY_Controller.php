<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class MY_Controller extends CI_Controller {

	protected $mod 				= '';
    protected $return 			= '';
    protected $result 			= '';
    protected $messages 		= '';
    protected $del 				= '';

	public $data = array();
		function __construct() {
			parent::__construct();
			$this->data['errors'] 		= array();
			$this->data['messages'] 	= array();
			$this->data['site_name'] 	= "Absen";
			$this->data['keywords'] 	= "";
			$this->data['description'] 	= "";
			$this->data['path_images']	= "";
			$this->data['path_berkas']	= "";
			$this->data['favicon'] 		= base_url('assets/images/favicon.ico');
			$this->data['author'] 		= 'Rian Reski';
			$this->data['lisensi']		= "&copy; 2020";
			$this->_timestamps 		    = date('Y-m-d H:i:s');
			
		}

}

class Frontend_Controller extends MY_Controller {

	public $data = array();
		function __construct() {
			parent::__construct();
			$this->output->set_common_meta(
				$this->data['site_name'], // Title
				$this->data['description'], // Description
				$this->data['keywords'] // Keywords
			);

			$this->load->model('m_user');
			$this->m_user->set_session();
			$this->pengguna = $this->m_user->cek_login($this->session->userdata('id_device'));
			$this->data['biodata'] = $this->pengguna;
			$this->session_tanggal();	
			if (empty($this->session->userdata('id_device'))) {
				echo 'app akses diskominfo kab.agam';
				exit;
			}
		}

		public function session_tanggal()
		{
			if (empty($this->session->userdata('rank1')) && empty($this->session->userdata('rank2'))) {
				$rank1 = date('Y-m-').'01';
				$jum_tgl_bulan_ini = jumlah_tanggal_bulan_cos(date('Y'),date('m'));
				$rank2 = date('Y-m-')."$jum_tgl_bulan_ini";

				$data = (['rank1' => $rank1,
						  'rank2' => $rank2]);
				$this->session->set_userdata($data); 	
			}
			 
		}
		
}

class Admin_Controller extends MY_Controller {

	public $data = array();
		function __construct() {
			parent::__construct();
			$this->class_name 		 = $this->router->fetch_class();
			$this->data['urimod'] 	 = '';
			$this->data['breadcrumb']= '';
			$this->output->set_common_meta(
				$this->data['site_name'], // Title
				$this->data['description'], // Description
				$this->data['keywords'] // Keywords
			);
		}
		
}



/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */