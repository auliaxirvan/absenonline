<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sch_apel extends CI_Model {

    public function get_latlng($date,$tpp_dept_id)
    {
        $query = $this->db->select('_jenis_apel.lokasi,_jenis_apel.radius,_jenis_apel.lat,_jenis_apel.long,sch_apel.kondisi_cuaca,sch_apel.end_time,sch_apel.start_time')
                          ->join('_jenis_apel','sch_apel.jenis_apel_id = _jenis_apel.id','left')
                          ->where('tgl_apel',$date)
                          ->where('sch_apel.deleted',1)
                          ->where("'$tpp_dept_id'",'ANY(sch_apel.dept_id)',false)
                          ->get('sch_apel')->row();

        if($query != NULL )
        {
            $lat = pg_to_array($query->lat);
            $long = pg_to_array($query->long);
            $radius = array($query->radius);
            $lokasi = array($query->lokasi);
            $query2 = $this->db->get_where('mf_departments', ['id'=> $tpp_dept_id])->row();
            $data_latlng = explode(",",$query2->latlong);
            if(!empty($query->lat) && !empty($query->long)) {
                if($query->kondisi_cuaca == "0"){
                    $data_ = array('lat' => pg_to_array($lat[$query->kondisi_cuaca]),
                                'lng' => pg_to_array($long[$query->kondisi_cuaca]),
                                'radius' => $radius,
                                'lokasi' => $lokasi,
                                'status' => "apel",
                                'start_time' => $query->start_time,
                                'end_time' => $query->end_time,

                        );    
                }else{
                    if(empty($lat[$query->kondisi_cuaca])){   
                        array_push($lat, $data_latlng[0]);
                        array_push($long, $data_latlng[1]);
                        array_push($radius, (!empty($query2->radius)) ? $query2->radius : 30);
                        array_push($lokasi, $query2->dept_name);
                        
                    }
                    if($query->kondisi_cuaca == "1") {
                        array_push($radius, $query->radius);
                    }
                    $data_ = array('lat' => $lat,
                                    'lng' => $long,
                                    'radius' => $radius,
                                    'lokasi' => $lokasi,
                                    'status' => "apel",
                                    'start_time' => $query->start_time,
                                    'end_time' => $query->end_time,
                        );    
                }

            }else if(empty($query->lat) && empty($query->long))  {
                        unset($lat); 
                        unset($long);
                        unset($radius);
                        unset($lokasi);
                        $lat = array(); 
                        $long = array();    
                        $radius = array();    
                        $lokasi = array();    
                        array_push($lat, $data_latlng[0]);
                        array_push($long, $data_latlng[1]);
                        
                        if(!empty($query2->radius)) {
                            array_push($radius,$query2->radius);
                            array_push($lokasi, $query2->dept_name);
                        }else {
                            array_push($lokasi, "Kab.Agam");
                            array_push($radius,30);
                        }
                  $data_ = array('lat' => $lat,
                                    'lng' => $long,
                                    'radius' => $radius,
                                    'lokasi' => $lokasi,
                                    'status' => "apel",
                                    'start_time' => $query->start_time,
                                    'end_time' => $query->end_time,
                        );    
            } 
        } else {
                $data_ = NULL;
        }
        return $data_;
    }

    public function get_instansi($id)
    {
        return $this->db->get_where('mf_departments',['id'=> $id])->row();
    }
     public function get_tidakapel($tgl_apel,$dept_id,$user_id)
    {
        $query = $this->db->select('id')
                          ->where('tgl_apel',$tgl_apel)
                          ->where('dept_id',$dept_id)
                          ->where("'$user_id'",'ANY(user_id)',false)
                          ->get('v_apel_pagi_opd')->row();
        return $query;
    }

}

/* End of file M_sch_apel.php */
