<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Frontend_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_init();
		$this->load->model(['m_user', 'm_absen', 'm_instansi', 'm_data_lkh', 'm_verifikator', 'm_sch_lkh', 'm_sch_apel']);
		$this->m_user->set_session();
		if ($this->pengguna == false) {
			redirect('auth', 'refresh');
		}
		$this->_lkh_jum      = $this->m_sch_lkh->Getsch_lkh($this->session->userdata('tpp_dept_id'), date('Y-m-d'))->row();
	}

	private function _init()
	{
		$this->output->set_template('mobile');
		$this->load->js('assets/themes/plugins/Highcharts-7.2.0/code/highcharts.js');
	}

	public function index()
	{
		if ($this->session->userdata('tgl')) {
			$this->session->unset_userdata(['tgl']);
		}
		$this->data['id_back'] = $this->input->get('id');

		$this->load->view('mobile/v_index', $this->data);
	}

	public function ajax_get()
	{
		$this->output->unset_template();
		if ($this->input->get('id') == "home") {
			$this->data['jadwal']   = $this->m_absen->jadwal($this->pengguna->user_id, tgl_plus(date('Y-m-d'), 1));
			$this->data['absen_shift_hari_ini'] = start_jadwal($this->m_absen->jadwal($this->pengguna->user_id, date('Y-m-d')));

			$this->data['absen_hari_ini'] = $this->m_absen->absen_now($this->pengguna->user_id);
			$this->data['pejabat_instansi'] = $this->m_instansi->GetCheckPejabatInstansi($this->session->userdata('tpp_user_id'), $this->session->userdata('tpp_dept_id'));


			$cek_tidak_apel = $this->m_sch_apel->get_tidakapel(date('Y-m-d'), $this->pengguna->dept_id, $this->pengguna->user_id);

			if (empty($cek_tidak_apel)) {
				$this->data['jadwal_apel'] = $this->m_absen->jadwal_apel(date('Y-m-d'), $this->pengguna->dept_id, $this->pengguna->user_id);
				$this->data['jadwal_apel_hari_ini'] = $this->m_absen->jadwal_apel(date('Y-m-d'), $this->pengguna->dept_id);
			}

			if ($this->data['absen_shift_hari_ini']->jam_kerja_status == "Shift") {
				$this->data['absen_shift_kemarin'] = start_jadwal($this->m_absen->jadwal($this->pengguna->user_id, tgl_minus(date('Y-m-d'), 1)));
				$this->data['absen_masuk_kemarin'] = $this->m_absen->absen_now_shift($this->pengguna->user_id, $this->data['absen_shift_kemarin']->start_date, $this->data['absen_shift_kemarin']->end_date, $this->data['absen_shift_kemarin']->check_in_time1, $this->data['absen_shift_kemarin']->check_in_time2, "masuk");
				$this->data['absen_pulang_kemarin'] = $this->m_absen->absen_now_shift($this->pengguna->user_id, $this->data['absen_shift_kemarin']->start_date, $this->data['absen_shift_kemarin']->end_date, $this->data['absen_shift_kemarin']->check_out_time1, $this->data['absen_shift_kemarin']->check_out_time2, "pulang");

				$this->data['absen_masuk'] = $this->m_absen->absen_now_shift($this->pengguna->user_id, $this->data['absen_shift_hari_ini']->start_date, $this->data['absen_shift_hari_ini']->end_date, $this->data['absen_shift_hari_ini']->check_in_time1, $this->data['absen_shift_hari_ini']->check_in_time2, "masuk");
				$this->data['absen_pulang'] = $this->m_absen->absen_now_shift($this->pengguna->user_id, $this->data['absen_shift_hari_ini']->start_date, $this->data['absen_shift_hari_ini']->end_date, $this->data['absen_shift_hari_ini']->check_out_time1, $this->data['absen_shift_hari_ini']->check_out_time2, "pulang");

				$view = $this->load->view('mobile/home/v_menu_home_shift', $this->data, TRUE);
			} else {
				$view = $this->load->view('mobile/home/v_menu_home', $this->data, TRUE);
			}
			$this->return = true;
		} elseif ($this->input->get('id') == "profil") {

			$tahun 		= date('Y');
			$bulan 		= date('m');
			$hari_ini 	= "$tahun-$bulan-01";
			$rank1 		= date('Y-m-01', strtotime($hari_ini));
			$rank2 		= date('Y-m-t', strtotime($hari_ini));
			$this->data['pegawai_absen'] = $this->m_absen->PegawaiAbsenQueryRekapitulasi([$this->pengguna->user_id], $rank1, $rank2)->result();
			$this->data['biodata']  = $this->db->get_where('v_users_pegawai_all', ['id' => $this->pengguna->user_id])->row();
			$this->data['instansi'] = $this->m_instansi->get_instansi($this->pengguna->dept_id);
			$view = $this->load->view('mobile/home/v_menu_profil', $this->data, TRUE);
			$this->return = true;
		} elseif ($this->input->get('id') == "lkh") {
			$date_now = date('Y-m-d');
			$set_jadwal	      = $this->m_data_lkh->sistem_lkh_set($this->_lkh_jum);
			$data_tgl = '';
			if (!empty($set_jadwal['tanggal_lkh_inday'])) {
				$data_tgl = str_replace(['[', ']', '"', ','], ['', '', '', '+'], json_encode($set_jadwal['tanggal_lkh_inday']));
			}
			$rank1 = format_tgl_eng($this->session->userdata('rank1'), 'd-m-Y');
			$rank2 = format_tgl_eng($this->session->userdata('rank2'), 'd-m-Y');

			$this->db->select('a.id, tgl_lkh, jam_mulai, jam_selesai, kegiatan, hasil, jenis, a.status, verifikasi_by, b.nama as ver_nama, b.gelar_dpn as ver_gelar_dpn, b.gelar_blk as ver_gelar_blk, comment, a.jenis, a.persentase')
				->from('data_lkh a')
				->join('v_users_all b', 'a.verifikasi_by=b.id', 'left')
				->join('lkh_rejected c', 'a.id=c.lkh_id', 'left')
				->order_by('tgl_lkh,jam_mulai, id', 'desc')
				->where('user_id', $this->session->userdata('tpp_user_id'));
			if ($rank1 && $rank2) {
				$this->db->where('tgl_lkh >=', $rank1);
				$this->db->where('tgl_lkh <=', $rank2);
				// $this->db->where("tgl_lkh::date BETWEEN '$rank1' and '$rank2'", NULL, FALSE );
			}

			$this->data['data_lkh'] = $this->db->get()->result();
			$this->data['jumlah_nonver'] = $this->m_data_lkh->jumlah_nonver($this->session->userdata('tpp_user_id'));
			$this->data['verifikasi_user'] = $this->m_data_lkh->getDataLkhAbsen($this->session->userdata('tpp_user_id'));
			$this->data['verifikator']	= $this->m_verifikator->GetVerifikator($this->session->userdata('tpp_user_id'))->row();

			// if($this->session->userdata('tpp_user_id') == 10290 || $this->session->userdata('tpp_user_id') == 304 || $this->session->userdata('tpp_user_id') == 294|| $this->session->userdata('tpp_user_id') == 311){
			$view = $this->load->view('mobile/lkh/v_menu_lkh', $this->data, TRUE);

			$this->return = true;
		} elseif ($this->input->get('id') == "laporan") {
			$this->data['laporan'] = $this->m_absen->RekapAbsensi($this->pengguna->user_id);
			$view = $this->load->view('mobile/home/v_menu_laporan', $this->data, TRUE);
			$this->return = true;
		} elseif ($this->input->get('id') == "set_tanggal_lkh") {
			$data = ([
				'rank1' => $this->input->get('tanggal_1_lkh'),
				'rank2' => $this->input->get('tanggal_2_lkh')
			]);
			$this->session->set_userdata($data);
			$view = '';
			$this->return = true;
		} elseif ($this->input->get('id') == "set_tanggal") {
			$data = ([
				'rank1' => $this->input->get('tanggal_1'),
				'rank2' => $this->input->get('tanggal_2')
			]);
			$this->session->set_userdata($data);
			$view = '';
			$this->return = true;
		}

		if ($this->return) {
			$this->output->set_output(json_encode(['status' => TRUE, 'message' => '', 'data' => $view]));
		} else {
			$this->output->set_output(json_encode(['status' => FALSE, 'message' => '']));
		}
	}

	public function peta()
	{
		if ($this->input->get('tgl')) {
			$tgl = $this->input->get('tgl');
		} else $tgl = date('Y-m-d');
		$this->load->js('https://maps.googleapis.com/maps/api/js?key=AIzaSyDIJ9XX2ZvRKCJcFRrl-lRanEtFUow4piM');
		$this->load->js('assets/themes/custom/js/services.js');
		$this->data['absen']	= $this->m_absen->get_absen_instansi($this->pengguna->dept_id, $tgl);
		$this->data['tgl_peta'] = tgl_indonesia($tgl);
		$this->load->view('mobile/home/v_menu_peta', $this->data);
	}

	public function panduan()
	{
		$this->load->view('mobile/v_panduan', $this->data);
	}

	public function panduan_absen()
	{
		$this->load->view('mobile/panduan/v_panduan_absen', $this->data);
	}
	public function panduan_lkh()
	{
		$this->load->view('mobile/panduan/v_panduan_lkh', $this->data);
	}
	public function panduan_verifikasi()
	{
		$this->load->view('mobile/panduan/v_panduan_verifikasi', $this->data);
	}
	public function panduan_indikator()
	{
		$this->load->view('mobile/panduan/v_panduan_indikator', $this->data);
	}
	public function panduan_ditolak()
	{
		$this->load->view('mobile/panduan/v_panduan_ditolak', $this->data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */