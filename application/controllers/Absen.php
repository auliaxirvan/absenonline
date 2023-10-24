<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->_init();
		$this->load->model(['m_instansi','m_absen','m_sch_apel']);
		
		if ($this->pengguna == false) {
			redirect('auth','refresh');
		}
	}

	private function _init()
	{
		$this->output->set_template('mobile');
		$this->load->js('https://maps.googleapis.com/maps/api/js?key=AIzaSyDIJ9XX2ZvRKCJcFRrl-lRanEtFUow4piM');
		$this->load->js('assets/themes/custom/js/services.js');
	}

	public function index_1()
	{
		$this->data['latlng_kantor'] = $this->m_instansi->get_latlng($this->pengguna->dept_id);
		$this->data['jadwal']		 = $this->m_absen->get_jadwal_now($this->pengguna->user_id);
		if (!empty($this->data['jadwal'])) {
			if ($this->data['jadwal']->start_time != '00:00:00') {
				    $status ='';
					if (date('H:i:s') >= $this->data['jadwal']->check_in_time1 && date('H:i:s') <= $this->data['jadwal']->check_in_time2) {
						$time1 = date('Y-m-d').' '.$this->data['jadwal']->check_in_time1;
						$time2 = date('Y-m-d').' '.$this->data['jadwal']->check_in_time2;
						$status = "masuk";
					}elseif (date('H:i:s') >= $this->data['jadwal']->check_out_time1 && date('H:i:s') <= $this->data['jadwal']->check_out_time2) {
						$time1 = date('Y-m-d').' '.$this->data['jadwal']->check_out_time1;
						$time2 = date('Y-m-d').' '.$this->data['jadwal']->check_out_time2;
						$status = "pulang";
					}
					if (!empty($time1) && !empty($time2)) {
						$this->data['telah_absen'] = $this->m_absen->cek_telah_absen($this->pengguna->user_id,$time1,$time2);
					}

					if ($status == "pulang") {
						$this->data['cek_status_kerja1'] = $this->m_absen->cek_telah_absen($this->pengguna->user_id,date('Y-m-d').' '.$this->data['jadwal']->check_in_time1,date('Y-m-d').' '.$this->data['jadwal']->check_in_time2);
					}
			}
		}
		if (!empty($status)) {
			$this->data['status'] = $status;
		}
		$this->load->view('mobile/absen/v_index', $this->data);
	}

	public function index_2()
	{
		if ($this->pengguna->absen_online_app == 1) {
			$this->data['latlng_kantor'] = $this->m_instansi->get_latlng($this->pengguna->dept_id);
			$this->data['jadwal']		 = $this->m_absen->jadwal($this->pengguna->user_id,date('Y-m-d'));
			if (!empty($this->data['jadwal'])) {
				$this->data['start_jadwal'] = start_jadwal($this->data['jadwal']);
				if (!empty($this->data['jadwal']->daysoff_id)) {
					$this->data['libur'] = 1;
				}
				if (!empty($this->data['jadwal']->cuti)) {
					$this->data['libur'] = 1;
				}

				if ($this->data['start_jadwal']->start_time != "00:00:00") {				   
					    if (empty($this->data['libur'])) {
					    	 $status ='';
							if (date('H:i:s') >= $this->data['start_jadwal']->check_in_time1 && date('H:i:s') <= $this->data['start_jadwal']->check_in_time2) {
								$time1 = date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time1;
								$time2 = date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time2;
								$status = "masuk";
							}elseif (date('H:i:s') >= $this->data['start_jadwal']->check_out_time1 && date('H:i:s') <= $this->data['start_jadwal']->check_out_time2) {
								$time1 = date('Y-m-d').' '.$this->data['start_jadwal']->check_out_time1;
								$time2 = date('Y-m-d').' '.$this->data['start_jadwal']->check_out_time2;
								$status = "pulang";
							}
							if (!empty($time1) && !empty($time2)) {
								$this->data['telah_absen'] = $this->m_absen->cek_telah_absen($this->pengguna->user_id,$time1,$time2);
							}

							if ($status == "pulang") {
								$this->data['cek_status_kerja1'] = $this->m_absen->cek_telah_absen($this->pengguna->user_id,date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time1,date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time2);
							}
					  }
				}
			}
			if (!empty($status)) {
				$this->data['status'] = $status;
			}
			$this->load->view('mobile/absen/v_index_absen', $this->data);
		}else {
			$this->load->view('mobile/absen/v_index_absen_disable_online', $this->data);
		}
		
	}

	public function index($tgl = NULL)
	{
		if (!empty($tgl)) {
			$this->session->set_userdata('tgl',$tgl);
			// redirect('/absen','refresh');

			$return = <<<EOF
				<script type="text/javascript">
					
					history.replaceState({urlPath: '/absenonline/absen'}, "Absen", '/absenonline/absen')
					window.location.replace(window.location);
				</script>
			EOF;

			echo $return;
		}
			
		if ($this->session->userdata('tgl')) {
			$tgl = $this->session->userdata('tgl');
		}
		if ($this->pengguna->absen_online_app == 1) {
			if($tgl == NULL){
				$tgl = date('Y-m-d');
			}
		
			$cek_titik_apel = $this->m_sch_apel->get_latlng(date('Y-m-d'), $this->pengguna->dept_id);
			$cek_absen = $this->m_instansi->get_latlng($this->pengguna->dept_id);
			$cek_tidak_apel = $this->m_sch_apel->get_tidakapel(date('Y-m-d'), $this->pengguna->dept_id, $this->pengguna->user_id);

			if(!empty($cek_tidak_apel)){
				$cek_titik_apel = "";
			}else {
				$this->data['jadwal_apel'] = $this->m_absen->jadwal_apel($tgl,$this->pengguna->dept_id);
				$this->data['jadwal_apel_hari_ini'] = $this->m_absen->jadwal_apel($tgl,$this->pengguna->dept_id,$this->pengguna->user_id);
			}

			if(!empty($cek_titik_apel['end_time'])){
				if(strtotime(date("Y-m-d H:i:s")) <= strtotime(date("Y-m-d ".$cek_titik_apel['end_time']."") )) {
					$this->data['latlng_kantor'] = $cek_titik_apel;
				}else{
					$this->data['latlng_kantor'] = $cek_absen;
				}
			}else{
					$this->data['latlng_kantor'] = $cek_absen;
			}
			

			$this->data['jadwal'] = $this->m_absen->jadwal($this->pengguna->user_id,$tgl);
			$this->data['id_allow'] = $this->db->get_where('_cek_gps',['user_id' => $this->pengguna->user_id])->result();
		
			if (!empty($this->data['jadwal'])) {
				$this->data['start_jadwal'] = start_jadwal($this->data['jadwal']);
				if (!empty($this->data['jadwal']->daysoff_id)) {
					if($this->data['start_jadwal']->jam_kerja_status == "Shift"){
						$this->data['libur'] = 1;
					}
				}
				if (!empty($this->data['jadwal']->cuti)) {
					$this->data['libur'] = 1;
				}

				if ($this->data['start_jadwal']->start_time != "00:00:00") {
					    if (empty($this->data['libur'])) {
					    	 $status ='';
							 if($this->data['start_jadwal']->jam_kerja_status == "Shift")
							 {
								 if($this->data['start_jadwal']->start_date == $this->data['start_jadwal']->end_date)
								 {
									if (date('H:i:s') >= $this->data['start_jadwal']->check_in_time1 && date('H:i:s') <= $this->data['start_jadwal']->check_in_time2) {
									$time1 = date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time1;
									$time2 = date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time2;
									$status = "masuk";
									}elseif (date('H:i:s') >= $this->data['start_jadwal']->check_out_time1 && date('H:i:s') <= $this->data['start_jadwal']->check_out_time2) {
										$time1 = date('Y-m-d').' '.$this->data['start_jadwal']->check_out_time1;
										$time2 = date('Y-m-d').' '.$this->data['start_jadwal']->check_out_time2;
										$status = "pulang";
									}
								 } else {
									if($this->data['start_jadwal']->start_date == date('Y-m-d')){
										$time1 = date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time1;
										$time2 = date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time2;
										if (date('H:i:s') >= $this->data['start_jadwal']->check_in_time1 && date('H:i:s') <= $this->data['start_jadwal']->check_in_time2) {
											$status = "masuk";
										}
									} 

									if($this->data['start_jadwal']->end_date == date('Y-m-d')){										
										$time1 = date('Y-m-d').' '.$this->data['start_jadwal']->check_out_time1;
										$time2 = date('Y-m-d').' '.$this->data['start_jadwal']->check_out_time2;	
										if (date('H:i:s') >= $this->data['start_jadwal']->check_out_time1 && date('H:i:s') <= $this->data['start_jadwal']->check_out_time2) {
											$status = "pulang";
										}
									}
								} 
							 }else {
								if (date('H:i:s') >= $this->data['start_jadwal']->check_in_time1 && date('H:i:s') <= $this->data['start_jadwal']->check_in_time2) {
									$time1 = date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time1;
									$time2 = date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time2;
									$status = "masuk";
								}elseif (date('H:i:s') >= $this->data['start_jadwal']->check_out_time1 && date('H:i:s') <= $this->data['start_jadwal']->check_out_time2) {
									$time1 = date('Y-m-d').' '.$this->data['start_jadwal']->check_out_time1;
									$time2 = date('Y-m-d').' '.$this->data['start_jadwal']->check_out_time2;
									
									$status = "pulang";
								}
							}
							if (!empty($time1) && !empty($time2)) {
								$this->data['telah_absen'] = $this->m_absen->cek_telah_absen($this->pengguna->user_id,$time1,$time2,$status);
							}

							if ($status == "pulang") {
								$this->data['cek_status_kerja1'] = $this->m_absen->cek_telah_absen($this->pengguna->user_id,date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time1,date('Y-m-d').' '.$this->data['start_jadwal']->check_in_time2);
							
							}
					  }
				}
			}
			if (!empty($status)) {
				$this->data['status'] = $status;
			}
			if(is_null($this->data['jadwal']->start_time_shift)) {
				$this->load->view('mobile/absen/v_index_absen_demo', $this->data);
			}else {
				$this->load->view('mobile/absen/v_index_absen_demo_shift', $this->data);
			}
		}else {
			$this->load->view('mobile/absen/v_index_absen_disable_online', $this->data);
		}
	}


	public function ajax_get()
	{	
		$message = 'data tidak dapat disimpan';
		$this->output->unset_template();
		$status_kerja ='';
		if ($this->input->post('id') == "wfo_btn") {
				$status_kerja = 'WFO';
		}elseif($this->input->post('id') == "wfh_btn") {
			    $status_kerja = 'WFH';
		}

		if (!empty($this->pengguna->id)) {
			$mylatlng 		 = $this->input->post('mylatlng[lat]').','.$this->input->post('mylatlng[lng]');
			$latlng_kantor   = $this->input->post('latlng_kantor[lat]').','.$this->input->post('latlng_kantor[lng]');

			$data_checkinout = array('user_id' => $this->pengguna->user_id,
									 'checktime' => date('Y-m-d H:i:s'),
									 'dept_id' 		=> $this->pengguna->dept_id,
									 'group' 		=> 10,
									 );
			$this->db->insert('mf_checkinout', $data_checkinout);
			$checkinout_id = $this->db->insert_id();

			$checkinout_gps = array('checkinout_id'		=> $checkinout_id,
									'lokasi' 			=> $mylatlng,
									'status_kerja' 		=> $status_kerja,
									'latlong_dept' 		=> $latlng_kantor,
									'id_device' 		=> $this->pengguna->id_device,
									'jarak' 			=> $this->input->post('jarak'),
									'status_in_out' 	=> $this->input->post('status_check'),
									'time_in_out' 		=> $this->input->post('time_in_out'),
									'alamat_lokasi'		=> ($this->input->post('status_check') == "masuk") ?  $this->input->post('alamat_lokasi') : NULL,
								 );
			$this->db->insert('checkinout_gps', $checkinout_gps);
			$checkinout_gps_id = $this->db->insert_id();
			$this->return = true;
			$message = 'data berhasil disimpan';
		}

		if ($this->return) {
			// $telegram_chat_id = $this->m_instansi->GetPejabatInstansiChatId($this->session->userdata('tpp_dept_id'));
			// if(!empty($telegram_chat_id->telegram_chat_id)) {
			// 	$msg = "\nPegawai <b>".$this->pengguna->nama_lengkap."</b> telah mengambil absen <i>".$this->input->post('status_check')."</i> pada <b>Hari</b> ". tgl_indonesia(date('Y-m-d H:i:s'))." <b>Jam</b> ".jm(date('Y-m-d H:i:s')) ;
			// 	telegram_send($telegram_chat_id->telegram_chat_id, "Hai <b>".$telegram_chat_id->nama."</b>". $msg);
			// }
			$this->output->set_output(json_encode(['status'=>TRUE, 'message'=>$message,'data'=>['checkinout_gps_id'=> $checkinout_gps_id]]));
		} else{
			$this->output->set_output(json_encode(['status'=>FALSE, 'message'=> $message]));	
		}
	}

	public function ajax_save_lokasi()
	{	
		$message = 'data tidak dapat disimpan';
		$this->output->unset_template();
		$status_kerja ='';
		if ($this->input->post('checkinout_gps_id')) {
			$this->db->update('checkinout_gps',['alamat_lokasi'=> $this->input->post('alamat')],['id'=> $this->input->post('checkinout_gps_id')]);
			$this->return = true;
			$message = 'data berhasil disimpan';
		}

		if ($this->return) {
			$this->output->set_output(json_encode(['status'=>TRUE, 'message'=>$message]));
		} else{
			$this->output->set_output(json_encode(['status'=>FALSE, 'message'=> $message]));	
		}
	}

	public function get_latlng()
	{
		$this->output->unset_template();
		$this->return = true;
		$data = array('lat' => $this->input->get('lat'),
					  'lng' => $this->input->get('lng'), );

		if ($this->return) {
			$this->output->set_output(json_encode(['status'=>TRUE, 'message'=> '','data' => $data]));
		} else{
			$this->output->set_output(json_encode(['status'=>FALSE, 'message'=> '']));	
		}
	}
	
	public function ajax_get_apel()
	{	
		$message = 'data tidak dapat disimpan';
		$this->output->unset_template();

		if (!empty($this->pengguna->id)) {
			$mylatlng = $this->input->post('mylatlng[lat]').','.$this->input->post('mylatlng[lng]');

			$data_apel = array('user_id' => $this->pengguna->user_id,
									 'hadir' => 1,
									 'dept_id' 		=> $this->pengguna->dept_id,
									 'sch_apel_id' => $this->input->post('id'),
									 'checktime' => date('Y-m-d H:i:s'),
									 'created_at' => date('Y-m-d H:i:s'),
									 'created_by' => $this->pengguna->user_id,
									 'id_device' => $this->pengguna->id_device,
									 'jarak' => $this->input->post('jarak'),
									 'lokasi' => $mylatlng,
					);
			$this->db->insert('apel_pegawai', $data_apel);
			$this->return = true;
			$message = 'data berhasil disimpan';
		}

		if ($this->return) {
			// $telegram_chat_id = $this->m_instansi->GetPejabatInstansiChatId($this->session->userdata('tpp_dept_id'));
			//if(!empty($telegram_chat_id->telegram_chat_id)) {
			//	$msg = "\nPegawai <b>".$this->pengguna->nama_lengkap."</b> telah mengambil absen apel<i>".$this->input->post('status_check')."</i> pada <b>Hari</b> ". tgl_indonesia(date('Y-m-d H:i:s'))." <b>Jam</b> ".jm(date('Y-m-d H:i:s')) ;
			//	telegram_send($telegram_chat_id->telegram_chat_id, "Hai ".$telegram_chat_id->nama. $msg);
			// }
			$this->output->set_output(json_encode(['status'=>TRUE, 'message'=>$message]));
		} else{
			$this->output->set_output(json_encode(['status'=>FALSE, 'message'=> $message]));	
		}
	}

}

/* End of file Absen.php */
/* Location: ./application/controllers/Absen.php */