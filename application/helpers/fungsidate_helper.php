<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//untuk mengetahui bulan bulan
if ( ! function_exists('bulan'))
{
    function bulan($bln)
    {
        switch ($bln) 
		{
			case '01':
				return "Januari";
				break;
			case '02':
				return "Februari";
				break;
			case '03':
				return "Maret";
				break;
			case '04':
				return "April";
				break;
			case '05':
				return "Mei";
				break;
			case '06':
				return "Juni";
				break;
			case '07':
				return "Juli";
				break;
			case '08':
				return "Agustus";
				break;
			case '09':
				return "September";
				break;
			case '10':
				return "Oktober";
				break;
			case '11':
				return "November";
				break;
			case '12':
				return "Desember";
				break;
		}
    }
}

//untuk mengetahui hari
if ( ! function_exists('hari'))
{
    function hari($tanggal)
	{
		$hari = date('D', strtotime($tanggal));

		switch($hari)
		{     
			case 'Sun':
				return "Minggu";
				break;
			case 'Mon':
				return "Senin";
				break;
			case 'Tue':
				return "Selasa";
				break;
			case 'Wed':
				return "Rabu";
				break;
			case 'Thu':
				return "Kamis";
				break;
			case 'Fri':
				return "Jumat";
				break;
			case 'Sat':
				return "Sabtu";
				break;
			case 'Sunday':
				return "Minggu";
				break;
			case 'Monday':
				return "Senin";
				break;
			case 'Tuesday':
				return "Selasa";
				break;
			case 'Wednesday':
				return "Rabu";
				break;
			case 'Thursday':
				return "Kamis";
				break;
			case 'Friday':
				return "Jumat";
				break;
			case 'Saturday':
				return "Sabtu";
				break;
    	}
	}
}

//format tanggal timestamp
if( ! function_exists('tgl_indonesia'))
{
	function tgl_indonesia($tgl)
	{
		if (!empty($tgl)) {
			$tgltime 	= explode(' ', $tgl);
			$tglBaru 	= explode('-', $tgltime[0]);

			$hari 	= hari($tgltime[0]);
			$tgl 	= $tglBaru[2];
			$bln 	= bulan($tglBaru[1]);
			$thn 	= $tglBaru[0];

		    $ubahTanggal = $hari.', '.$tgl.' '.$bln.' '.$thn; //hasil akhir tanggal
		 
		    return $ubahTanggal;
		}
	}
}

if( ! function_exists('tanggal_format'))
{
function tanggal_format($tgl='',$format='')
    {
      $tgl_ = '';
      if ($tgl) {
        $tgl_ = date($format, strtotime($tgl));
      }
      return $tgl_;
    }
}

function jumlah_tanggal_bulan_cos($y='',$m='')
{
	  $tahun = $y; //Mengambil tahun saat ini
	  $bulan = $m; //Mengambil bulan saat ini
	  $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

	  return $tanggal;
}

function name_degree($name='', $gl_d='', $gl_b='') { 
    if ($gl_d) {
          $gl_d = $gl_d.'. ';
    }
    if ($gl_b) {
        $gl_b = ', '.$gl_b;
    }

    return $gl_d.$name.$gl_b;
}

function _name($name='')
{
    return ucwords(strtolower($name));
}

function start_jadwal($jadwal='')
	{
		 if (!empty($jadwal->start_time)) {
				$start_date 	 = $jadwal->start_date_normal;
				$end_date 		 = $jadwal->end_date_normal;
                $start_time 	 = $jadwal->start_time;
                $end_time 	     = $jadwal->end_time;
                $check_in_time1  = $jadwal->check_in_time1;
                $check_in_time2  = $jadwal->check_in_time2;
                $check_out_time1 = $jadwal->check_out_time1;
                $check_out_time2 = $jadwal->check_out_time2;
                $jam_kerja_status = "";
				$kd_shift	     = "";
		 	 
		 }

		 if (!empty($jadwal->start_time_notfixed)) {
				$start_date 	 = $jadwal->start_date_notfixed;
				$end_date 	 	 = $jadwal->start_date_notfixed;
		 	  	$start_time 	 = $jadwal->start_time_notfixed;
                $end_time 	     = $jadwal->end_time_notfixed;
                $check_in_time1  = $jadwal->check_in_time1_notfixed;
                $check_in_time2  = $jadwal->check_in_time2_notfixed;
                $check_out_time1 = $jadwal->check_out_time1_notfixed;
                $check_out_time2 = $jadwal->check_out_time2_notfixed;
                $jam_kerja_status = "Tidak Tetap";
				$kd_shift	     = "";
		 }

		 if (!empty($jadwal->start_time_shift)) {
				$start_date		 = $jadwal->start_date_shift;
				$end_date		 = $jadwal->end_date_shift;
		 	    $start_time 	 = $jadwal->start_time_shift;
                $end_time 	     = $jadwal->end_time_shift;
                $check_in_time1  = $jadwal->check_in_time1_shift;
                $check_in_time2  = $jadwal->check_in_time2_shift;
                $check_out_time1 = $jadwal->check_out_time1_shift;
                $check_out_time2 = $jadwal->check_out_time2_shift;
                $jam_kerja_status = "Shift";
				$kd_shift	     = $jadwal->kd_shift;
		 }
		 

		 $jadwal_new = (object) array(
			 				'start_date' => (!empty($start_date)) ? $start_date : "", 
							'end_date' => (!empty($end_date)) ? $end_date : "",
							'start_time' => (!empty($start_time)) ? $start_time : "",
			                'end_time' 	     	=> (!empty($end_time)) ? $end_time : "",
			                'check_in_time1' 	=> (!empty($check_in_time1)) ? $check_in_time1 : "",
			                'check_in_time2' 	=> (!empty($check_in_time2)) ? $check_in_time2 : "",
			                'check_out_time1' 	=> (!empty($check_out_time1)) ? $check_out_time1 : "",
			                'check_out_time2' 	=> (!empty($check_out_time2)) ? $check_out_time2 : "",
			                'jam_kerja_status' 	=> (!empty($jam_kerja_status)) ? $jam_kerja_status : "",
							'kd_shift'			=> (!empty($kd_shift)) ? $kd_shift : "",
			            );

		 return $jadwal_new;
	}


function start_jadwal_set($jadwal='')
	{
				$start_date 	 = "";
				$end_date 		 = "";
                $start_time 	 = "";
                $end_time 	     = "";
                $check_in_time1  = "";
                $check_in_time2  = "";
                $check_out_time1 = "";
                $check_out_time2 = "";
				$kd_shift	     = "";
                $jam_kerja_status = "";
		 if (!empty($jadwal->start_time)) {
				$start_date 	 = $jadwal->start_date_normal;
				$end_date 		 = $jadwal->end_date_normal;
                $start_time 	 = $jadwal->start_time;
                $end_time 	     = $jadwal->end_time;
                $check_in_time1  = $jadwal->check_in_time1;
                $check_in_time2  = $jadwal->check_in_time2;
                $check_out_time1 = $jadwal->check_out_time1;
                $check_out_time2 = $jadwal->check_out_time2;
				$kd_shift	     = "";
                $jam_kerja_status = "";
		 	 
		 }

		 if (!empty($jadwal->start_time_notfixed)) {
				$start_date 	 = $jadwal->start_date_notfixed;
				$end_date 	 = $jadwal->start_date_notfixed;
		 	  	$start_time 	 = $jadwal->start_time_notfixed;
                $end_time 	     = $jadwal->end_time_notfixed;
                $check_in_time1  = $jadwal->check_in_time1_notfixed;
                $check_in_time2  = $jadwal->check_in_time2_notfixed;
                $check_out_time1 = $jadwal->check_out_time1_notfixed;
                $check_out_time2 = $jadwal->check_out_time2_notfixed;
				$kd_shift	     = "";
                $jam_kerja_status = "Tidak Tetap";
		 }

		 if (!empty($jadwal->start_time_shift)) {
				$start_date		 = $jadwal->start_date_shift;
				$end_date		 = $jadwal->end_date_shift;
		 	    $start_time 	 = $jadwal->start_time_shift;
                $end_time 	     = $jadwal->end_time_shift;
                $check_in_time1  = $jadwal->check_in_time1_shift;
                $check_in_time2  = $jadwal->check_in_time2_shift;
                $check_out_time1 = $jadwal->check_out_time1_shift;
                $check_out_time2 = $jadwal->check_out_time2_shift;
				$kd_shift	     = $jadwal->kd_shift;
                $jam_kerja_status = "Shift";
		 }

		 $jadwal_new = (object) array(
			 				'start_date' => $start_date,
							'end_date' => $end_date,
			 				'start_time' => jm($start_time),
			                'end_time' 	     	=> jm($end_time),
			                'check_in_time1' 	=> jm($check_in_time1),
			                'check_in_time2' 	=> jm($check_in_time2),
			                'check_out_time1' 	=> jm($check_out_time1),
			                'check_out_time2' 	=> jm($check_out_time2),
			                'jam_kerja_status' 	=> $jam_kerja_status,
							'kd_shift'			=> $kd_shift,
			            );

		 return $jadwal_new;
	}


function tgl_plus($tgl='', $nilai='')
{

  $tgl1 = $tgl;// pendefinisian tanggal awal
  $tgl2 = date('Y-m-d', strtotime('+'.$nilai.' days', strtotime($tgl1))); //operasi penjumlahan tanggal sebanyak 6 hari
  return  $tgl2; //print tanggal
}

function jm($jam='')
{
  if ($jam) {
    $a = date('H:i', strtotime($jam));
  }else $a='';
  return $a;
}


function convert_meter($meter='')
{
	if ($meter) {
		 if ($meter >= 1000) {
	        $jar = round($meter/1000,2)." Km";
	    }else {
	        $jar = $meter." m";
	    }

	    return $jar;
	}
}

function sisa_waktu($waktu='')
  {
    // $awal  = strtotime('2017-08-10 10:05:25');
    // $akhir = strtotime('2017-08-11 11:07:33');
    // $diff  = $akhir - $awal;

    $jam   = floor($waktu / (60 * 60));
    $menit = $waktu - $jam * (60 * 60);
    if ($jam==0) {
        return  floor( $menit / 60 ) . ' menit';
      }else {
         return  $jam .  ' jam, ' . floor( $menit / 60 ) . ' menit';
      }
   
  }

  function tgl_minus($tgl='', $nilai='')
  {

	$tgl1 = $tgl;// pendefinisian tanggal awal
	$tgl2 = date('Y-m-d', strtotime('-'.$nilai.' days', strtotime($tgl1))); //operasi penjumlahan tanggal sebanyak 6 hari
	return  $tgl2; //print tanggal
  }

function hitung_total_jam($data_jam='')
{

	$total = 0;
	foreach ($data_jam as $item_jam) {
	    $keluar = strtotime($item_jam['keluar']);
	    $masuk = strtotime($item_jam['masuk']);
	    $total += $keluar - $masuk;
	}

	return gmdate('H:i', $total); 
	  
}

function tgl_ind_hari($tanggal='')
{
		$bulan = array (
		1 =>   'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 =>'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 =>'Oktober',
		11 =>'November',
		12 => 'Desember'
	  );
	  $pecahkan = explode('-', $tanggal);
	  return hari_tgl($tanggal). '/'. $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function hari_tgl($tanggal='')
{
	  $day = date('D', strtotime($tanggal));
	  $dayList = array(
		'Sun' => 'Minggu',
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu'
	  );
	 return $dayList[$day];
}
function tglInd_hrtabel($tanggal)
{
	  $pecahkan = explode('-', $tanggal);
	  return _str_limit(hari_tgl($tanggal),3). '/'. $pecahkan[2] . '-' . _str_limit(_bulan((int)$pecahkan[1]),3) . '-' . $pecahkan[0];
}
function _bulan($blnint)
{
	   $bulan = array (
		1 =>   'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 =>'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 =>'Oktober',
		11 =>'November',
		12 => 'Desember'
	  );

	  return $bulan[$blnint];
}

function hitung_menit($jam='')
{
	$total  = '';
	if ($jam) {
			$jam_ = date('H', strtotime($jam));
			$menit_ = date('i', strtotime($jam));

			$total = ($jam_*60)+$menit_;
	}

	return $total;
}

// update by dika
function start_jadwal_report($jadwal='')
	{
		$jadwal_new = [];
		foreach($jadwal as $jadwals){
			if($jadwals->status_in == "1"){
				$jadwals->jam_masuk = $jadwals->start_time;
				$jadwals->dept_masuk = "Absen Manual";
			}else {
				$jadwals->jam_masuk = $jadwals->jam_masuk;
				
			}

			if($jadwals->status_out == "1"){
				$jadwals->jam_pulang = $jadwals->end_time;
				$jadwals->dept_pulang 		 = "Absen Manual";
			}else {
				$jadwals->jam_pulang = $jadwals->jam_pulang;
			}

			if(!empty($jadwals->alamat_lokasi_masuk)){
				$alamat_lokasi_masuk = $jadwals->alamat_lokasi_masuk; 
			}else {
				$alamat_lokasi_masuk = "";
			}

			if (!empty($jadwals->start_time)) {
					$rentan_tanggal		 = $jadwals->rentan_tanggal;
					$dept_masuk 		 = $jadwals->dept_masuk;
					$dept_pulang 		 = $jadwals->dept_pulang;
					$status_kerja_masuk  = $jadwals->status_kerja_masuk;
					$status_kerja_pulang = $jadwals->status_kerja_pulang;
					$status_in_out_masuk = $jadwals->status_in_out_masuk;
					$status_in_out_pulang = $jadwals->status_in_out_pulang;
					$jam_masuk 		  	  = $jadwals->jam_masuk;
					$jam_pulang 		  = $jadwals->jam_pulang;
					$jarak_masuk		  = $jadwals->jarak_masuk;
					$jarak_pulang		  = $jadwals->jarak_pulang;
					$status_in_masuk	  = $jadwals->status_in_out_masuk;
					$status_out_pulang	  = $jadwals->status_in_out_pulang;
					$status_in			  = $jadwals->status_in;
					$status_out			  = $jadwals->status_out;
					$alamat_lokasi		  = $alamat_lokasi_masuk;
					$jam_kerja_status 	  = "";
					$kd_shift	     	  = "";	 	 
			}

			if (!empty($jadwals->start_time_notfixed)) {
					$rentan_tanggal		 = $jadwals->rentan_tanggal;
					$dept_masuk 		 = $jadwals->dept_masuk_notfixed;
					$dept_pulang 		 = $jadwals->dept_pulang_notfixed;
					$status_kerja_masuk  = $jadwals->status_kerja_masuk_notfixed;
					$status_kerja_pulang = $jadwals->status_kerja_pulang_notfixed;
					$status_in_out_masuk = $jadwals->status_in_out_masuk_notfixed;
					$status_in_out_pulang = $jadwals->status_in_out_pulang_notfixed;
					$jam_masuk 		  	  = $jadwals->jam_masuk_notfixed;
					$jam_pulang 		  = $jadwals->jam_pulang_notfixed;
					$jarak_masuk		  = $jadwals->jarak_masuk_notfixed;
					$jarak_pulang		  = $jadwals->jarak_pulang_notfixed;
					$status_in_masuk	  = $jadwals->status_in_out_masuk_notfixed;
					$status_out_pulang	  = $jadwals->status_in_out_pulang_notfixed;
					$status_in			  = $jadwals->status_in;
					$status_out			  = $jadwals->status_out;
					$alamat_lokasi		  = $alamat_lokasi_masuk;
					$jam_kerja_status 	  = "Tidak Tetap";
					$kd_shift	     	  = "";
			}

			if (!empty($jadwals->start_time_shift)) {
					$rentan_tanggal		 = $jadwals->rentan_tanggal;
					$dept_masuk 		 = $jadwals->dept_masuk_shift;
					$dept_pulang 		 = $jadwals->dept_pulang_shift;
					$status_kerja_masuk  = $jadwals->status_kerja_masuk_shift;
					$status_kerja_pulang = $jadwals->status_kerja_pulang_shift;
					$status_in_out_masuk = $jadwals->status_in_out_masuk_shift;
					$status_in_out_pulang = $jadwals->status_in_out_pulang_shift;
					$jam_masuk 		  	  = $jadwals->jam_masuk_shift;
					$jam_pulang 		  = $jadwals->jam_pulang_shift;
					$jarak_masuk		  = $jadwals->jarak_masuk_shift;
					$jarak_pulang		  = $jadwals->jarak_pulang_shift;
					$status_in_masuk	  = $jadwals->status_in_out_masuk_shift;
					$status_out_pulang	  = $jadwals->status_in_out_pulang_shift;
					$status_in			  = $jadwals->status_in;
					$status_out			  = $jadwals->status_out;
					$alamat_lokasi		  = $alamat_lokasi_masuk;
					$jam_kerja_status 	  = "Shift";
					$kd_shift	     	  = $jadwals->kd_shift;
			}	
		 $jadwals_new[] = (object) array(
							'rentan_tanggal'	 => $rentan_tanggal,
							'dept_masuk' 	 	 => $dept_masuk, 		 
							'dept_pulang'    	 => $dept_pulang,
							'status_kerja_masuk' => $status_kerja_masuk,  
							'status_kerja_pulang' => $status_kerja_pulang, 
							'status_in_out_masuk' => $status_in_out_masuk,
							'status_in_out_pulang' => $status_in_out_pulang,			 
							'jam_masuk' 		   => $jam_masuk,
							'jam_pulang' 		   => $jam_pulang, 		 
							'jarak_masuk'		   => $jarak_masuk,		 
							'jarak_pulang'		   => $jarak_pulang,
							'status_in_masuk'	   => $status_in_masuk,	 
							'status_out_pulang'	   => $status_out_pulang,
							'status_in'	  		   => $status_in,
							'status_out'		   => $status_out,			
							'alamat_lokasi'		   => $alamat_lokasi,
                			'jam_kerja_status' 	   => $jam_kerja_status,
							'kd_shift'			   => $kd_shift,	     
			            );
		}
		 return $jadwals_new;
	}
/* End of file formatdate_helper.php */
/* Location: ./application/helpers/formatdate_helper.php */