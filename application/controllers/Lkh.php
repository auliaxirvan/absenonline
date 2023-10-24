<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Created By: Handika Putra
* 2020
*/

class Lkh extends Frontend_Controller {

	protected $_lkh_jum 	= '';

	public function __construct()
	{
		parent::__construct();
		$this->_init();
		$this->load->model(['m_user','m_absen','m_instansi','m_sch_lkh','m_data_lkh','m_verifikator']);
		$this->m_user->set_session();
		if ($this->pengguna == false) {
			redirect('auth','refresh');
		}
		$this->_lkh_jum      = $this->m_sch_lkh->Getsch_lkh($this->session->userdata('tpp_dept_id'),date('Y-m-d'))->row();
		
	}

	private function _init()
	{
		$this->output->set_template('mobile');
		$this->load->css('assets/themes/plugins/clock/dist/bootstrap-clockpicker.min.css');
		$this->load->js('assets/themes/plugins/clock/dist/bootstrap-clockpicker.min.js');
		$this->load->js('assets/themes/plugins/Highcharts-7.2.0/code/highcharts.js');
	
		$this->load->js('assets/themes/plugins/ckeditor/ckeditor.js');
	}

    public function index()
    {
        $this->data['jumlkh']		= $this->_lkh_jum;
			$this->data['tanggal_lkh']  = $this->m_data_lkh->sistem_lkh_set($this->_lkh_jum)['tanggal_lkh_inday'];
            $this->data['verifikator']	= $this->m_verifikator->GetVerifikator($this->session->userdata('tpp_user_id'))->row();
			$this->data['jumlah_nonver'] = $this->m_data_lkh->jumlah_nonver($this->session->userdata('tpp_user_id'));
			$this->data['verifikasi_user'] = $this->m_data_lkh->getDataLkhAbsen($this->session->userdata('tpp_user_id'));
      
			$this->load->view('mobile/lkh/v_menu_lkh',$this->data);
    }

	public function add()
	{
			$this->data['jumlkh']		= $this->_lkh_jum;
			$this->data['tanggal_lkh']  = $this->m_data_lkh->sistem_lkh_set($this->_lkh_jum)['tanggal_lkh_inday'];
            $this->data['verifikator']	= $this->m_verifikator->GetVerifikator($this->session->userdata('tpp_user_id'))->row();
			$this->data['jumlah_nonver'] = $this->m_data_lkh->jumlah_nonver($this->session->userdata('tpp_user_id'));
			$this->data['verifikasi_user'] = $this->m_data_lkh->getDataLkhAbsen($this->session->userdata('tpp_user_id'));
			$this->data['cek_persentase_kemarin'] = $this->m_data_lkh->getPersentaseLkh($this->session->userdata('tpp_user_id'),$this->data['tanggal_lkh'][1]);       			

			$this->load->view('mobile/lkh/v_add_lkh',$this->data);
	}
	public function view($id)
	{
		$datalkh_id 				= $id;
		$this->data['verifikator']	= $this->m_verifikator->GetVerifikator($this->session->userdata('tpp_user_id'))->row();
		$this->data['datalkh']		= $this->db->get_where('data_lkh', ['id' => $datalkh_id])->row();
		$this->data['comment'] 		= $this->db->select('comment')->where('lkh_id', $this->data['datalkh']->id)->get('lkh_rejected')->row();
		
		$this->load->view('mobile/lkh/v_view_lkh', $this->data);
	}
	public function update($id)
	{
		$datalkh_id 				= $id;
		$this->data['verifikator']	= $this->m_verifikator->GetVerifikator($this->session->userdata('tpp_user_id'))->row();
									  $this->db->join('lkh_rejected b','a.id=b.lkh_id');
		$this->data['datalkh']		= $this->db->get_where('data_lkh a', ['a.id' => $datalkh_id])->row();
		$this->load->view('mobile/lkh/v_update_lkh', $this->data);
	}
	public function AjaxGet()
	{
		$this->output->unset_template();
		if ($this->input->get('mod') == "time" && $this->input->get('tgl_id')) {
				$jam_mulai = date('H:i');
				$date_now = date('Y-m-d');
				$tgl_id = $this->input->get('tgl_id');

				$cekJadwal = $this->m_data_lkh->cekJadwalLkh($this->session->userdata('tpp_user_id'), $tgl_id)->row();
				if ($cekJadwal) {
						$start_time 				= $cekJadwal->start_time;
						$end_time   				= $cekJadwal->end_time;
						$start_time_shift   		= $cekJadwal->start_time_shift;
						$end_time_shift   			= $cekJadwal->end_time_shift;
						$start_time_notfixed   		= $cekJadwal->start_time_notfixed;
						$end_time_notfixed   		= $cekJadwal->end_time_notfixed;

						if ($start_time && $end_time) {
								$jam_masuk  = jm($start_time);
								$jam_pulang = jm($end_time);
						}

						if ($start_time_shift && $end_time_shift) {
								$jam_masuk  = jm($start_time_shift);
								$jam_pulang = jm($end_time_shift);
						}

						if ($start_time_notfixed && $end_time_notfixed) {
								$jam_masuk  = jm($start_time_notfixed);
								$jam_pulang = jm($end_time_notfixed);
						}
				}

				if ($jam_masuk) {
					$jam_mulai =  $jam_masuk;
				}


				$last_jam = $this->m_data_lkh->cek_jam_lkh($this->session->userdata('tpp_user_id'),$tgl_id)->row();
				if ($last_jam) {
					$jam_mulai =  jm($last_jam->jam_selesai);
				}

				$total_jam ='';
				$total_jam_reg ='';
				$persen ='';

				if ($jam_masuk && $jam_pulang) {
					$data_time = array(
					    array('masuk' => $jam_masuk, 'keluar' => $jam_pulang,),
					);

					$total_jam = hitung_total_jam($data_time);
					// var_dump($data_time);

					$data_time_reg = array(
					    array('masuk' => $jam_mulai, 'keluar' => $jam_pulang,),
					);

					$total_jam_reg = hitung_total_jam($data_time_reg);

					if ($total_jam_reg > $total_jam) {
							$total_jam_reg = "00.00";	
					}

					// $kurang = ($total_jam-$total_jam_reg);
					// $bagi = ($kurang/$total_jam);
					// $persen = round($total_jam*100,2);

					// hitung menit 
					$kurang = hitung_menit($total_jam)-hitung_menit($total_jam_reg);
					$bagi = ($kurang/hitung_menit($total_jam));
					// persen
					$persen = round($bagi*100,2);

				}

				$data = array('jam_mulai' => $jam_mulai,
							  'jam_masuk' => $jam_masuk,
							  'jam_pulang'=> $jam_pulang,
							  'total_jam' => $total_jam,
							  'total_jam_reg' => $total_jam_reg,
							  'persen'	=> $persen,
							  'jam_mulai_encry' => $jam_mulai,
							  'total_jam_encry' => $total_jam,
							  'jam_pulang_encry' => $jam_pulang);

				$this->result = array('status' => true,
			    			   		   'message' => 'Berhasil mengabil data',
			    			   		   'data' => $data);
				
		}

		if ($this->result) {
			$this->output->set_output(json_encode($this->result));	
		}else {
			$this->output->set_output(json_encode(['status'=>FALSE, 'message'=> 'Gagal mengambil data.']));
		}
	}
	public function AjaxSave()
	{
		$this->output->unset_template();
		$this->form_validation->set_rules('tgl', 'tanggal kegiatan', 'required');
		$this->form_validation->set_rules('jam1', 'jam mulai kegiatan', 'required');
		$this->form_validation->set_rules('jam2', 'jam selesai kegiatan', 'required');
		$this->form_validation->set_rules('kegiatan', 'uraian kegiatan', 'required');
		$this->form_validation->set_rules('hasil', 'hasil', 'required');
		// $this->form_validation->set_rules('verifikator', 'verifikator', 'required');
		$this->form_validation->set_error_delimiters('','');

		if ($this->form_validation->run() == TRUE) {
			$this->mod = $this->input->post('mod');	
			
			$verifikator 	  = $this->input->post('verifikator');
			$jenis = 1;
			if ($this->input->post('dl')) {
				$jenis = 3;
			}

			if ($this->mod == "add") {
				$date_now = date('Y-m-d');
				$tgl = $this->input->post('tgl');

				$total_jam = $this->input->post('total_jam_encry');
				$data_time_reg = array(
				    array('masuk' => $this->input->post('jam2'), 'keluar' => $this->input->post('jam_pulang_encry'), ),
				);

				$total_jam_reg = hitung_total_jam($data_time_reg);

				if ($total_jam_reg > $total_jam) {
						$total_jam_reg = "00.00";	
				}

				// $kurang = ($total_jam-$total_jam_reg);
				// $bagi = ($kurang/$total_jam);
				// $persen = round($bagi*100,2);
				
				// hitung menit 
				$kurang = hitung_menit($total_jam)-hitung_menit($total_jam_reg);
				$bagi = ($kurang/hitung_menit($total_jam));
				// persen
				$persen = round($bagi*100,2);

				$data = array(
							  'user_id' 		=> $this->session->userdata('tpp_user_id'),
							  'dept_id' 		=> $this->session->userdata('tpp_dept_id'),
							  'tgl_lkh' 		=> $tgl,
							  'jam_mulai' 		=> $this->input->post('jam1_encry'),
							  'jam_selesai' 	=> $this->input->post('jam2'),
							  'kegiatan' 		=> $this->input->post('kegiatan'),
							  'hasil' 			=> $this->input->post('hasil'),
							  'jenis' 			=> $jenis,
							  'status'			=> 0,
							  'created_at' 		=> date('Y-m-d H:i:s'),
							  'persentase'		=> $persen,
							  'poin'		    => 1
				 );
				if ($verifikator) {
					$data['verifikator']	= $verifikator;
				}
        
        
				$this->return = $this->db->insert('data_lkh',$data);
        
	
			}elseif ($this->mod == "edit") {
				$data = array(
							  'kegiatan' 		=> $this->input->post('kegiatan'),
							  'hasil' 			=> $this->input->post('hasil'),
							  'jenis' 			=> $jenis,
				 );
				$this->return = $this->db->update('data_lkh',$data,['id' => $this->input->post('id')]);
			}elseif ($this->mod == "update") {
				$datalkh_id 				= $this->input->post('id');
				$lkh_data_update = $this->db->get_where('data_lkh', ['id' => $datalkh_id])->row();

				$data = array(
							  'user_id' 		=> $this->session->userdata('tpp_user_id'),
							  'dept_id' 		=> $this->session->userdata('tpp_dept_id'),
							  'tgl_lkh' 		=> $lkh_data_update->tgl_lkh,
							  'jam_mulai' 		=> $lkh_data_update->jam_mulai,
							  'jam_selesai' 	=> $lkh_data_update->jam_selesai,
							  'kegiatan' 		=> $this->input->post('kegiatan'),
							  'hasil' 			=> $this->input->post('hasil'),
							  'jenis' 			=> $jenis,
							  'status'			=> 4,
							  'persentase'		=> $lkh_data_update->persentase,
							  'verifikator' 	=> $lkh_data_update->verifikator,
							  'created_at' 		=> date('Y-m-d H:i:s'),
				 );
				$this->return = $this->db->insert('data_lkh',$data);
				$this->db->update('data_lkh', ['status' => 3],  ['id' => $datalkh_id]);
			}

			if ($this->return) {
				 $this->result = array('status' => true,
			    			    'message' => 'Data berhasil disimpan');
			}else{
				 $this->result = array('status' => false,
			    			    'message' => 'Data gagal disimpan');
			}

		}else {
			$this->result = array('status' => false,
				    		'message' => validation_errors(),);
		}

		if ($this->result) {
			$this->output->set_output(json_encode($this->result));	
		}else {
			$this->output->set_output(json_encode(['status'=>FALSE, 'message'=> 'Gagal mengambil data.']));
		}
	}
	public function AjaxDel()
	{
		$this->output->unset_template();
		$this->return = $this->db->delete('data_lkh',['id' => $this->input->post('id')]);

		if ($this->return) {
			$this->result = array('status' => true,
						   'message' => 'Data berhasil dihapus');
	   	}else{
			$this->result = array('status' => false,
						   'message' => 'Data gagal dihapus');
	   	}

		if ($this->result) {
			$this->output->set_output(json_encode($this->result));
		} else{
			$this->output->set_output(json_encode(['status'=>FALSE, 'message'=> 'Gagal dihapus atau data sedang digunakan.']));	
		}
	}
 
 
 
 
}