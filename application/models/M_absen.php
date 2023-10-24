<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_absen extends CI_Model {

    public function get_jadwal_now($user_id)
    {
        return $this->db->get_where('v_jadwal_now',['user_id'=>$user_id])->row();
    }

    public function absen_now($user_id)
    {
        $this->db->join('checkinout_gps b','b.checkinout_id=a.id','left');
        return $this->db->get_where('mf_checkinout a',['user_id' => $user_id,'date(checktime)' => date('Y-m-d')])->result();
    }
    public function absen_now_shift($user_id,$start_date,$end_date,$check1,$check2,$status_in_out)
    {

        if($status_in_out == "masuk")
        {
            $range1 = $start_date." ".$check1;
            $range2 = $start_date." ".$check2;
        }else if($status_in_out == "pulang"){
            $range1 = $end_date." ".$check1;
            $range2 = $end_date." ".$check2;
        }
        $time1 = date('Y-m-d H:i:s',strtotime($range1 . "+1 second")); 
        $time2 = date('Y-m-d H:i:s',strtotime($range2 . "+59 second")); 

        $this->db->join('checkinout_gps b','b.checkinout_id=a.id','left');
        return $this->db->get_where('mf_checkinout a',['user_id' => $user_id,'checktime >=' => $time1, 'checktime <=' => $time2 ,'status_in_out' => $status_in_out])->result();
    }

    public function cek_telah_absen($user_id, $time1, $time2,$status=NULL)
    {
        $this->db->select('checktime, status_kerja,status_in_out');
        $this->db->where('user_id', $user_id);
        if($status != NULL){
            $this->db->where('status_in_out', $status);
        }
        $this->db->where("checktime >= '$time1' and checktime <= '$time2'");
        $this->db->join('checkinout_gps b','a.id=b.checkinout_id');
        return $this->db->get('mf_checkinout a')->row();
    }

    public function cek_telah_absen_shift($user_id, $time1, $time2,$status_in_out)
    {
        $this->db->select('checktime, status_kerja,status_in_out');
        $this->db->where('status_in_out', $status_in_out);
        $this->db->where('user_id', $user_id);
        $this->db->where("checktime >= '$time1' and checktime <= '$time2'");
        $this->db->join('checkinout_gps b','a.id=b.checkinout_id');
        return $this->db->get('mf_checkinout a')->row();
    }

    public function get_data_absen($user_id)
    {
            $this->db->where(['user_id' => $user_id,
                              'date(checktime) >=' => $this->session->userdata('rank1'),
                              'date(checktime) <=' => $this->session->userdata('rank2')]);
            $this->db->join('mf_departments b','a.dept_id=b.id','left');
            $this->db->join('checkinout_gps c','a.id=c.checkinout_id','left');
            $this->db->order_by('date(checktime) desc, checktime asc');
           return $this->db->get('mf_checkinout a')->result();
    }

    public function get_absen_instansi($instansi_id, $date)
    {
        $this->db->where(['a.dept_id' => $instansi_id,
                          'date(checktime)' => $date,]);
        $this->db->join('mf_departments b','a.dept_id=b.id','left');
        $this->db->join('mf_users c','a.user_id=c.id','left');
        $this->db->join('checkinout_gps d','a.id=d.checkinout_id','left');
        $this->db->order_by('date(checktime) desc, checktime asc');
        return $this->db->get('mf_checkinout a')->result();
    }

    public function jadwal($user_id='', $rank1='', $rank_plus='')
    {
        if ($rank_plus != '') {
             $rank2 = tgl_plus($rank1, $rank_plus);
        }else $rank2 = $rank1;
        $this->db->select('a.id, 
                            rentan_tanggal, 
                            b.start_date as start_date_normal,
                            b.end_date as end_date_normal,
                            b.start_time, 
                            b.end_time, 
                            b.check_in_time1, 
                            b.check_in_time2, 
                            b.check_out_time1, 
                            b.check_out_time2,
                            c.start_shift as start_date_shift,
                            c.end_shift as end_date_shift,
                            c.start_time as start_time_shift, 
                            c.end_time as end_time_shift, 
                            c.check_in_time1 as check_in_time1_shift, 
                            c.check_in_time2 as check_in_time2_shift, 
                            c.check_out_time1 as check_out_time1_shift, 
                            c.check_out_time2 as check_out_time2_shift,
                            c.kd_shift,
                            d.start_date as start_date_notfixed,
                            d.end_date as end_date_notfixed,
                            d.start_time as start_time_notfixed, 
                            d.end_time as end_time_notfixed, 
                            d.check_in_time1 as check_in_time1_notfixed, 
                            d.check_in_time2 as check_in_time2_notfixed, 
                            d.check_out_time1 as check_out_time1_notfixed, 
                            d.check_out_time2 as check_out_time2_notfixed,
                            e.id as daysoff_id,
                            f.user_id as cuti,
                            g.berita_acara,
                            g.in,
                            g.out')
                        ->from("(select * from mf_users a, (select * from rentan_tanggal('$rank1','$rank2')) as tanggal) as a");
        $this->db->join("v_jadwal_kerja_users b","((rentan_tanggal >= b.start_date and rentan_tanggal <= b.end_date and extract('isodow' from a.rentan_tanggal) = b.s_day) and b.user_id=a.id)",'left',false);
        $this->db->join('v_jadwal_kerja_users_shift c'," (a.id = c.user_id and c.start_shift=a.rentan_tanggal)",'left',false);
        $this->db->join('v_jadwal_kerja_users_notfixed d',"((rentan_tanggal >= d.start_date and rentan_tanggal <= d.end_date and extract('isodow' from a.rentan_tanggal) = d.day_id)and d.user_id=a.id)",'left',false);
        $this->db->join('days_off e',"(rentan_tanggal >= e.start_date and rentan_tanggal <= e.end_date)",'left',false)
                 ->join('data_cuti f',"(a.id = f.user_id and f.deleted =1 and (rentan_tanggal >= f.start_date and rentan_tanggal <= f.end_date))",'left',false)
                  ->join('sch_inout_office g',"(rentan_tanggal >= g.start_date and rentan_tanggal <= g.end_date and $user_id=any(g.user_id))",'left',false);;
        $this->db->order_by('rentan_tanggal','asc');
        $this->db->where('a.id',$user_id);

        if ($rank_plus != '') {
             $method = 'result';
        }else $method = 'row';

        return $this->db->get()->$method();

    }

    public function jadwal_update($user_id='', $rank1='', $rank_plus='')
    {
        $rank1 = date('Y-m-d');
        if ($rank_plus != '') {
             $rank2 = tgl_plus($rank1, $rank_plus);
        }else $rank2 = $rank1;
        $this->db->select('a.id, 
                            rentan_tanggal, 
                            b.start_time, 
                            b.end_time, 
                            b.check_in_time1, 
                            b.check_in_time2, 
                            b.check_out_time1, 
                            b.check_out_time2,
                            c.start_time as start_time_shift, 
                            c.end_time as end_time_shift, 
                            c.check_in_time1 as check_in_time1_shift, 
                            c.check_in_time2 as check_in_time2_shift, 
                            c.check_out_time1 as check_out_time1_shift, 
                            c.check_out_time2 as check_out_time2_shift,
                            d.start_time as start_time_notfixed, 
                            d.end_time as end_time_notfixed, 
                            d.check_in_time1 as check_in_time1_notfixed, 
                            d.check_in_time2 as check_in_time2_notfixed, 
                            d.check_out_time1 as check_out_time1_notfixed, 
                            d.check_out_time2 as check_out_time2_notfixed,
                            e.id as daysoff_id,
                            f.user_id as cuti,
                            g.berita_acara')
        ->from("(select * from mf_users a, (select * from rentan_tanggal('$rank1','$rank2')) as tanggal) as a");
        $this->db->join("v_jadwal_kerja_users b","((rentan_tanggal >= b.start_date and rentan_tanggal <= b.end_date and extract('isodow' from a.rentan_tanggal) = b.s_day) and b.user_id=a.id)",'left',false);
        $this->db->join('v_jadwal_kerja_users_shift c'," (a.id = c.user_id and c.start_shift=a.rentan_tanggal)",'left',false);
        $this->db->join('v_jadwal_kerja_users_notfixed d',"((rentan_tanggal >= d.start_date and rentan_tanggal <= d.end_date and extract('isodow' from a.rentan_tanggal) = d.day_id)and d.user_id=a.id)",'left',false);
        $this->db->join('days_off e',"(rentan_tanggal >= e.start_date and rentan_tanggal <= e.end_date)",'left',false)
                 ->join('data_cuti f',"(a.id = f.user_id and f.deleted =1 and (rentan_tanggal >= f.start_date and rentan_tanggal <= f.end_date))",'left',false)
                 ->join('sch_inout_office g',"(rentan_tanggal >= g.start_date and rentan_tanggal <= g.end_date and $user_id=any(g.user_id))",'left',false);
        $this->db->order_by('rentan_tanggal','asc');
        $this->db->where('a.id',$user_id);

        if ($rank_plus != '') {
             $method = 'result';
        }else $method = 'row';

        return $this->db->get()->$method();

    }

public function RekapAbsensi($user_id)
    {
        $rank1_ = $this->session->userdata('rank1');
        $rank2_  = $this->session->userdata('rank2');
        $this->db->select("a.id,
                            c.dept_name AS dept_masuk,
                            rentan_tanggal,
                            c.status_kerja as status_kerja_masuk,
                            c.status_in_out as status_in_out_masuk,
                            d.status_in_out as status_in_out_pulang,
                            d.status_kerja as status_kerja_pulang,
                            b.start_time,
                            b.end_time,
                            MIN ( ( C.checktime ) :: TIME ) AS jam_masuk,
                            MAX ( ( d.checktime ) :: TIME ) AS jam_pulang,
                            e.kd_shift,
                            e.start_time AS start_time_shift,
                            e.end_time AS end_time_shift,
                            MIN ( ( f.checktime ) :: TIME ) AS jam_masuk_shift,
                            MAX ( ( G.checktime ) :: TIME ) AS jam_pulang_shift,
                            i.kode AS kode_cuti,
                            c.jarak as jarak_masuk,
                            c.alamat_lokasi as alamat_lokasi_masuk,
                            d.jarak as jarak_pulang,
                            j.tgl_lkh AS lkhdl_id,
                            k.user_id AS dinasmanual_id,
                            l.status_in,
                            l.status_out,
                            m.id AS daysoff_id,
                            n.start_time AS start_time_notfixed,
                            n.end_time AS end_time_notfixed,
                            d.dept_name AS dept_pulang,
                            f.dept_name AS dept_masuk_shift,
                            g.dept_name AS dept_pulang_shift,
                            o.dept_name AS dept_masuk_notfixed,
                            p.dept_name AS dept_pulang_notfixed,
                           f.status_kerja as status_kerja_masuk_shift,
                            g.status_kerja as status_kerja_pulang_shift,
                            f.status_in_out as status_in_out_masuk_shift,
                            g.status_in_out as status_in_out_pulang_shift,
                            o.status_in_out as status_in_out_masuk_notfixed,
                            p.status_in_out as status_in_out_pulang_notfixed,
                            o.status_kerja as status_kerja_masuk_notfixed,
                            p.status_kerja as status_kerja_pulang_notfixed,
                            f.jarak as jarak_masuk_shift,
                            g.jarak as jarak_pulang_shift,
                            o.jarak as jarak_masuk_notfixed,
                            p.jarak as jarak_pulang_notfixed,
                            MIN ( ( o.checktime ) :: TIME ) AS jam_masuk_notfixed,
                            MAX ( ( P.checktime ) :: TIME ) AS jam_pulang_notfixed")
                    ->from("(select * from v_users_all, (select * from rentan_tanggal('$rank1_','$rank2_')) as tanggal) as a");
                    	// jadwal user sesuai jam kerja
        	 $this->db->join('v_jadwal_kerja_users b',"((rentan_tanggal >= b.start_date and rentan_tanggal <= b.end_date and extract('isodow' from a.rentan_tanggal) = b.s_day)and b.user_id=a.id)",'left',false);
        	// cari ceklok sesuai jadwal = jam masuk
        	$this->db->join("(SELECT a.id, a.dept_id,c.dept_name,a.checktime,a.user_id,b.status_kerja,b.status_in_out,b.jarak,b.alamat_lokasi FROM mf_checkinout a LEFT JOIN checkinout_gps b ON a.id = b.checkinout_id LEFT JOIN mf_departments c ON a.dept_id = c.id WHERE (b.status_in_out = 'masuk' OR b.status_in_out IS NULL)) c","((a.id = c.user_id) AND (a.rentan_tanggal = date(c.checktime)) AND ((c.checktime)::time  >= b.check_in_time1) AND ((c.checktime)::time  <= b.check_in_time2))",'left',false);
        	// cari ceklok sesuai jadwal = jam keluar
        	$this->db->join("(SELECT a.id, a.dept_id,c.dept_name,a.checktime,a.user_id,b.status_kerja,b.status_in_out,b.jarak,b.alamat_lokasi FROM mf_checkinout a LEFT JOIN checkinout_gps b ON a.id = b.checkinout_id LEFT JOIN mf_departments c ON a.dept_id = c.id WHERE (b.status_in_out = 'pulang' OR b.status_in_out IS NULL)) d","((a.id = d.user_id) AND (a.rentan_tanggal = date(d.checktime)) AND ((d.checktime)::time  >= b.check_out_time1) AND ((d.checktime)::time  <= b.check_out_time2))",'left',false);
        	// jadwal shift user
        	$this->db->join('v_jadwal_kerja_users_shift e',"(a.id = e.user_id and e.start_shift=a.rentan_tanggal)",'left',false);
        	// cari ceklok sesuai jadwal shift = jam masuk shift
        	$this->db->join("(SELECT a.id, a.dept_id,c.dept_name,a.checktime,a.user_id,b.status_kerja,b.status_in_out,b.jarak,b.alamat_lokasi FROM mf_checkinout a LEFT JOIN checkinout_gps b ON a.id = b.checkinout_id LEFT JOIN mf_departments c ON a.dept_id = c.id WHERE (b.status_in_out = 'masuk' OR b.status_in_out IS NULL)) f","((a.id = f.user_id) AND (e.start_shift = date(f.checktime)) AND ((f.checktime)::time  >= e.check_in_time1) AND ((f.checktime)::time  <= e.check_in_time2))",'left',false);
        	// cari ceklok sesuai jadwal shift = jam keluar shift
        	$this->db->join("(SELECT a.id, a.dept_id, c.dept_name, a.checktime,a.user_id, b.status_kerja,b.status_in_out,b.jarak,b.alamat_lokasi FROM mf_checkinout a LEFT JOIN checkinout_gps b ON a.id = b.checkinout_id LEFT JOIN mf_departments c ON a.dept_id = c.id WHERE (b.status_in_out = 'pulang' OR b.status_in_out IS NULL)) g","((a.id = g.user_id) AND (e.end_shift = date(g.checktime)) AND ((g.checktime)::time  >= e.check_out_time1) AND ((g.checktime)::time  <= e.check_out_time2))",'left',false);
        	// data cuti
        	$this->db->join('data_cuti h',"(a.id = h.user_id and h.deleted =1 and (rentan_tanggal >= h.start_date and rentan_tanggal <= h.end_date))",'left',false);
        	$this->db->join('_cuti i','h.cuti_id=i.id','left');
        	// dinas luar lkh
        	$this->db->join('data_lkh j',"(a.id = j.user_id and a.rentan_tanggal=j.tgl_lkh and j.status=1 and j.jenis=3)",'left',false);
        	// dinas muanual
        	$this->db->join('v_dinas_manual k',"(a.id = k.user_id and k.tanggal=a.rentan_tanggal)",'left',false);
        	// absen manual data
        	$this->db->join('v_absenmanual_data l',"(a.id = l.user_id and l.tanggal=a.rentan_tanggal)",'left',false);
        	// hari libur
        	$this->db->join('days_off m',"(rentan_tanggal >= m.start_date and rentan_tanggal <= m.end_date)",'left',false);
        	//jadwal kerja tidak tetap
        	 $this->db->join('v_jadwal_kerja_users_notfixed n',"((rentan_tanggal >= n.start_date and rentan_tanggal <= n.end_date and extract('isodow' from a.rentan_tanggal) = n.day_id)and n.user_id=a.id)",'left',false);
        	 // cari ceklok sesuai jadwal = jam masuk
        	$this->db->join("(SELECT a.id, a.dept_id,c.dept_name,a.checktime,a.user_id,b.status_kerja,b.status_in_out,b.jarak,b.alamat_lokasi FROM mf_checkinout a LEFT JOIN checkinout_gps b ON a.id = b.checkinout_id LEFT JOIN mf_departments c ON a.dept_id = c.id WHERE (b.status_in_out = 'masuk' OR b.status_in_out IS NULL)) o","((a.id = o.user_id) AND (a.rentan_tanggal = date(o.checktime)) AND ((o.checktime)::time >= n.check_in_time1) AND ((o.checktime)::time <= n.check_in_time2))",'left',false);
        	// cari ceklok sesuai jadwal = jam keluar
        	$this->db->join("(SELECT a.id, a.dept_id,c.dept_name,a.checktime,a.user_id,b.status_kerja,b.status_in_out,b.jarak,b.alamat_lokasi FROM mf_checkinout a LEFT JOIN checkinout_gps b ON a.id = b.checkinout_id LEFT JOIN mf_departments c ON a.dept_id = c.id WHERE (b.status_in_out = 'pulang' OR b.status_in_out IS NULL)) P","((a.id = p.user_id) AND (a.rentan_tanggal = date(p.checktime)) AND ((p.checktime)::time >= n.check_out_time1) AND ((p.checktime)::time <= n.check_out_time2))",'left',false);
        	
            
            $this->db->group_by('1,2,3,4,5,6,7,8,9,12,13,14,17,18,19,no_urut,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44');
        	$this->db->order_by('a.no_urut, rentan_tanggal');
            $this->db->where('a.id', $user_id);
            return $this->db->get()->result();

    }
    
    public function PegawaiAbsenQueryRekapitulasi($user_id='', $start_date, $end_date, $dept_id='')
    {   
            $this->db->select('a.id, a.nama, a.nip, a.gelar_dpn, a.gelar_blk, b.json_absen, a.agama_id')
                     ->from('v_users_all a')
                     ->join("(select a.id,
                                json_build_object(
                                        'data_absen',json_agg(
                                        (   rentan_tanggal, 
                                            schrun_id,
                                            start_date, 
                                            end_date, 
                                            start_time, 
                                            end_time,
                                            jam_masuk,
                                            jam_pulang,
                                            kd_shift,
                                            start_time_shift,
                                            end_time_shift,
                                            jam_masuk_shift,
                                            jam_pulang_shift,
                                            kode_cuti,
                                            lkhdl_id,
                                            dinasmanual_id,
                                            status_in,
                                            status_out,
                                            daysoff_id,
                                            start_time_notfixed,
                                            end_time_notfixed,
                                            jam_masuk_notfixed,
                                            jam_pulang_notfixed,
                                            count_day_shift,
                                            jumtidak_upacara,
                                            ibadah_id
                                        ) ORDER BY rentan_tanggal)
                                ) as json_absen
                            from mf_users a
                            left join (
                                            select a.id, 
                                            rentan_tanggal,
                                            b.schrun_id, 
                                            b.start_date, 
                                            b.end_date, 
                                            b.start_time, 
                                            b.end_time,
                                            min((c.checktime)::time without time zone) AS jam_masuk,
                                            max((d.checktime)::time without time zone) AS jam_pulang,
                                            e.kd_shift,
                                            e.start_time as start_time_shift,
                                            e.end_time as end_time_shift,
                                            min((f.checktime)::time without time zone) AS jam_masuk_shift,
                                            max((g.checktime)::time without time zone) AS jam_pulang_shift,
                                            i.kode as kode_cuti,
                                            j.tgl_lkh as lkhdl_id,
                                            k.user_id as dinasmanual_id,
                                            l.status_in,
                                            l.status_out,
                                            m.id as daysoff_id,
                                            n.start_time as start_time_notfixed, 
                                            n.end_time as end_time_notfixed,
                                            min((o.checktime)::time) AS jam_masuk_notfixed,
                                            max((p.checktime)::time) AS jam_pulang_notfixed,
                                            e.count_day as count_day_shift,
                                            q.jum as jumtidak_upacara,
                                            r.ibadah_id
                                            from 
                                            (select a.id, rentan_tanggal from mf_users a, (select * from rentan_tanggal('$start_date','$end_date')) as tanggal) as a
                                            left join v_jadwal_kerja_users b on ((rentan_tanggal >= b.start_date and rentan_tanggal <= b.end_date and extract('isodow' from a.rentan_tanggal) = b.s_day)and b.user_id=a.id)
                                            left join mf_checkinout c on ((a.id = c.user_id) AND (a.rentan_tanggal = date(c.checktime)) AND ((c.checktime)::time without time zone >= b.check_in_time1) AND ((c.checktime)::time without time zone <= b.check_in_time2))
                                            left join mf_checkinout d on ((a.id = d.user_id) AND (a.rentan_tanggal = date(d.checktime)) AND ((d.checktime)::time without time zone >= b.check_out_time1) AND ((d.checktime)::time without time zone <= b.check_out_time2))
                                            left join v_jadwal_kerja_users_shift e on (a.id = e.user_id and e.start_shift=a.rentan_tanggal)
                                            left join mf_checkinout f on ((a.id = f.user_id) AND (e.start_shift = date(f.checktime)) AND ((f.checktime)::time without time zone >= e.check_in_time1) AND ((f.checktime)::time without time zone <= e.check_in_time2))
                                            left join mf_checkinout g on ((a.id = g.user_id) AND (e.end_shift = date(g.checktime)) AND ((g.checktime)::time without time zone >= e.check_out_time1) AND ((g.checktime)::time without time zone <= e.check_out_time2))
                                            left join data_cuti h on (a.id = h.user_id and h.deleted =1 and (rentan_tanggal >= h.start_date and rentan_tanggal <= h.end_date)) 
                                            left join _cuti i on h.cuti_id=i.id
                                            left join data_lkh j on (a.id = j.user_id and a.rentan_tanggal=j.tgl_lkh and j.status=1 and j.jenis=3)
                                            left join v_dinas_manual k on (a.id = k.user_id and k.tanggal=a.rentan_tanggal)
                                            left join v_absenmanual_data l on (a.id = l.user_id and l.tanggal=a.rentan_tanggal)
                                            left join days_off m on (rentan_tanggal >= m.start_date and rentan_tanggal <= m.end_date)
                                            left join v_jadwal_kerja_users_notfixed n on ((rentan_tanggal >= n.start_date and rentan_tanggal <= n.end_date and extract('isodow' from a.rentan_tanggal) = n.day_id)and n.user_id=a.id)
                                            left join mf_checkinout o on ((a.id = o.user_id) AND (a.rentan_tanggal = date(o.checktime)) AND ((o.checktime)::time without time zone >= n.check_in_time1) AND ((o.checktime)::time without time zone <= n.check_in_time2))
                                            left join mf_checkinout p on ((a.id = p.user_id) AND (a.rentan_tanggal = date(p.checktime)) AND ((p.checktime)::time without time zone >= n.check_out_time1) AND ((p.checktime)::time without time zone <= n.check_out_time2))
                                            left join v_tidak_hadir_upacara q on (a.id=q.user_id and a.rentan_tanggal=q.tanggal)
                                            left join ibadah_muslim r on (a.id=r.user_id and a.rentan_tanggal=r.tgl_ibadah)
                                            group by 1,2,3,4,5,6,7,10,11,12,15,16,17,18,19,20,21,22,25,26,27
                            ) as b on a.id=b.id
                            group by 1
                            ) as b",'a.id=b.id','left',false);
                     if ($user_id) {
                            $this->db->where_in('a.id', $user_id);
                     }else {
                            $this->db->where('a.dept_id', $dept_id);
                     }
                     $this->db->order_by('no_urut');
            return $this->db->get();

    }

     public function jadwal_apel($tgl, $tpp_dept_id, $user_id = NULL)
    {
        $query = $this->db->select('sch_apel.id, sch_apel.pengambilan_apel,sch_apel.komandan_apel,sch_apel.tgl_apel,sch_apel.start_time,sch_apel.end_time,_jenis_apel.lokasi,_jenis_apel.name,apel_pegawai.hadir,apel_pegawai.checktime')
                          ->join('_jenis_apel','sch_apel.jenis_apel_id = _jenis_apel.id','left')
                          ->join('apel_pegawai','sch_apel.id = apel_pegawai.sch_apel_id','left')
                          ->where('tgl_apel',$tgl)
                          ->where('sch_apel.deleted',1);
                          if($user_id != NULL)
                          {
                            $query = $this->db->where('apel_pegawai.user_id', $user_id);
                          }
                          $query = $this->db->where("'$tpp_dept_id'",'ANY(sch_apel.dept_id)',false)
                          ->get('sch_apel')->row();

        return $query;
    }
}

/* End of file M_absen.php */
