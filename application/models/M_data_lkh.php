<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Created By: Rian Reski A
* 2019
*/

class M_data_lkh extends CI_Model {

	public function cek_jam_lkh($user_id, $tgl)
	{
		$this->db->select('jam_selesai')
				 ->where('user_id', $user_id)
				 ->where('tgl_lkh', $tgl)
				 // ->order_by('tgl_lkh, jam_selesai','desc')
                 ->order_by('id','desc')
				 ->limit(1);
		return $this->db->get('data_lkh');
	}

	public function update_status($id ='',$data_tgl_lkh)
    {   
        if ($data_tgl_lkh) {
            $this->db->where('user_id', $id);
            $this->db->where_in('status','0,4',false);
            $this->db->where_not_in('tgl_lkh',$data_tgl_lkh);
            $this->db->update('data_lkh',['status' => 1,'verifikasi_time'=> date('Y-m-d H:i')]);

            $tempdata = array('tgl_verifikasi_cek' => date('Y-m-d'),'user_id' => $id);
            $this->session->set_tempdata($tempdata, NULL, 7200);
        }
        
    }

    public function GetDatalkhRank($user_id, $rank1, $rank2, $status)
    {
    	$this->db->select('*')
    			 ->from('data_lkh')
    			 ->where('user_id', $user_id)
    			 ->where('status',$status)
    			 ->where("tgl_lkh::date BETWEEN '$rank1' and '$rank2'", NULL, FALSE )
    			 ->order_by('tgl_lkh,jam_mulai','asc');
    	return $this->db->get();
    }

    public function jadwal_lkh_limit($user_id='', $limit='')
    {
        $tgl_now = date('Y-m-d');
        $tgl_end = tgl_minus($tgl_now, 40);

        $this->db->select('a.id, 
                            rentan_tanggal')
                ->from("(select * from mf_users a, (select * from rentan_tanggal('$tgl_end','$tgl_now')) as tanggal) as a")
                ->join('v_jadwal_kerja_users b',"((rentan_tanggal >= b.start_date and rentan_tanggal <= b.end_date and extract('isodow' from a.rentan_tanggal) = b.s_day)and b.user_id=a.id)",'left',false)
                ->join('v_jadwal_kerja_users_shift c',"(a.id = c.user_id and c.start_shift=a.rentan_tanggal)",'left',false)
                ->join('v_jadwal_kerja_users_notfixed d',"((rentan_tanggal >= d.start_date and rentan_tanggal <= d.end_date and extract('isodow' from a.rentan_tanggal) = d.day_id)and d.user_id=a.id)",'left',false)
                ->join('days_off e',"(rentan_tanggal >= e.start_date and rentan_tanggal <= e.end_date)",'left',false)
                ->join('data_cuti f',"(a.id = f.user_id and f.deleted =1 and (rentan_tanggal >= f.start_date and rentan_tanggal <= f.end_date))",'left',false)
                ->where('a.id', $user_id)
                ->where("(b.start_time != '00:00:00' or c.start_time != '00:00:00' or d.start_time != '00:00:00') 
                        and (e.id is null and f.user_id is null or f.user_id is null and c.user_id is not null and class_id != 0)",null,false)
                ->group_by('1,2')
                ->order_by('rentan_tanggal','desc')
                ->limit($limit);
        return $this->db->get();

    }

    public function cekJadwalLkh($user_id, $tanggal)
    {
         $this->db->select('a.id, 
                            rentan_tanggal,
                            b.start_time, 
                            b.end_time,
                            c.start_time as start_time_shift,
                            c.end_time as end_time_shift,
                            d.start_time as start_time_notfixed, 
                            d.end_time as end_time_notfixed,
                            e.id as daysoff_id,
                            f.user_id as cuti')
                ->from("(select * from mf_users a, (select * from rentan_tanggal('$tanggal','$tanggal')) as tanggal) as a")
                ->join('v_jadwal_kerja_users b',"((rentan_tanggal >= b.start_date and rentan_tanggal <= b.end_date and extract('isodow' from a.rentan_tanggal) = b.s_day)and b.user_id=a.id)",'left',false)
                ->join('v_jadwal_kerja_users_shift c',"(a.id = c.user_id and c.start_shift=a.rentan_tanggal)",'left',false)
                ->join('v_jadwal_kerja_users_notfixed d',"((rentan_tanggal >= d.start_date and rentan_tanggal <= d.end_date and extract('isodow' from a.rentan_tanggal) = d.day_id)and d.user_id=a.id)",'left',false)
                ->join('days_off e',"(rentan_tanggal >= e.start_date and rentan_tanggal <= e.end_date)",'left',false)
                ->join('data_cuti f',"(a.id = f.user_id and f.deleted =1 and (rentan_tanggal >= f.start_date and rentan_tanggal <= f.end_date))",'left',false)
                ->where('a.id', $user_id)
                // ->where("(b.start_time != '00:00:00' or c.start_time != '00:00:00' or d.start_time != '00:00:00') and e.id is null and f.user_id is null",null,false)
                ->where("(b.start_time != '00:00:00' or c.start_time != '00:00:00' or d.start_time != '00:00:00') 
                        and (e.id is null and f.user_id is null or f.user_id is null and c.user_id is not null and class_id != 0)",null,false)
                ->group_by('1,2,3,4,5,6,7,8,9,10')
                ->order_by('rentan_tanggal','desc')
                ->limit(1);
        return $this->db->get();
    }

    public function jumlah_nonver($user_id)
    {
        $this->db->select('count(*)')
                ->where('verifikator', $user_id)
                ->where_in('status','0,4', false);
        return $this->db->get('data_lkh')->row()->count;
    }

    public function sistem_lkh_set($jumlkh)
    {
        if ($jumlkh->count_verday > $jumlkh->count_inday) {
            $tanggal_lkh   = $this->jadwal_lkh_limit($this->session->userdata('tpp_user_id'), $jumlkh->count_verday)->result();
        }elseif ($jumlkh->count_verday < $jumlkh->count_inday) {
            $tanggal_lkh   = $this->jadwal_lkh_limit($this->session->userdata('tpp_user_id'), $jumlkh->count_inday)->result();
        }

        $tanggal_lkh_ver   = array();
        $tanggal_lkh_inday = array();
        if (empty($this->session->tempdata('c_tanggal_lkh')) && $this->session->userdata('tpp_user_id') != $this->session->tempdata('lkh_user_id')) {

            if ($jumlkh->count_verday > $jumlkh->count_inday) {
                 if (!empty($tanggal_lkh)) {
                      foreach ($tanggal_lkh as $row) {
                            $tanggal_lkh_ver[] = $row->rentan_tanggal;
                      }  
                 }
                 

                 if (!empty($tanggal_lkh_ver)) {
                      for ($i=0; $i < $jumlkh->count_inday; $i++) { 
                               $tanggal_lkh_inday[] = $tanggal_lkh_ver[$i];
                      }   
                 }
            }else {
                 if (!empty($tanggal_lkh)) {
                      foreach ($tanggal_lkh as $row) {
                            $tanggal_lkh_inday[] = $row->rentan_tanggal;
                      }  
                 }
                 

                 if (!empty($tanggal_lkh_inday)) {
                      for ($i=0; $i < $jumlkh->count_verday; $i++) { 
                               $tanggal_lkh_ver[] = $tanggal_lkh_inday[$i];
                      }   
                 }


            }
            
            if ($this->session->tempdata('tgl_verifikasi_cek') != date('y-m-d') && $this->session->userdata('tpp_user_id') != $this->session->tempdata('user_id')) {
                  $this->update_status($this->session->userdata('tpp_user_id'), $tanggal_lkh_ver);
            }

            $tempdata = array('tanggal_lkh_ver'     => $tanggal_lkh_ver,
                              'tanggal_lkh_inday'   => $tanggal_lkh_inday,
                              'lkh_user_id'         => $this->session->userdata('tpp_user_id'),
                              'c_tanggal_lkh'       => true);
            $this->session->set_tempdata($tempdata, NULL, 300);
            
        }elseif ($this->session->tempdata('c_tanggal_lkh') == true && $this->session->userdata('tpp_user_id') == $this->session->tempdata('lkh_user_id')) {
            $tanggal_lkh_ver   = $this->session->tempdata('tanggal_lkh_ver');
            $tanggal_lkh_inday = $this->session->tempdata('tanggal_lkh_inday');
        }

        $tanggal['tanggal_lkh_ver']   = $tanggal_lkh_ver;
        $tanggal['tanggal_lkh_inday'] = $tanggal_lkh_inday;
        return  $tanggal;

    }

    public function getDataLkhAbsen($user_id)
    {
        $this->db->select('a.id, b.nip, b.nama, b.gelar_dpn, b.gelar_blk, c.jabatan, d.jum_non_ver')
        ->from('verifikator a')
        	->join('v_users_all b','a.user_id=b.id','left',false)
        	->join('sp_pegawai c','a.user_id=c.user_id','left',false)
        	->join('v_jum_non_ver d','a.user_id=d.user_id','left',false)
            ->where('a.user_id_ver', $user_id)
        	->where('key > 0')
        	->where('att_status',1)
        	->order_by('no_urut');
        return $this->db->get()->result();
    }

    public function getPersentaseLkh($user_id,$last_tgl_lkh)
    {
	$this->db->select('id,tgl_lkh,persentase')
	->from('data_lkh')
	->where('user_id',$user_id)
	->where('persentase',100)
	->where('tgl_lkh',$last_tgl_lkh);
      	return $this->db->get()->row();
    }


}

/* End of file M_data_lkh.php */
/* Location: ./application/models/M_data_lkh.php */