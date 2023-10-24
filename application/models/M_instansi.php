<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_instansi extends CI_Model {

    public function get_latlng($instansi_id)
    {
        $query = $this->db->get_where('mf_departments', ['id'=> $instansi_id])->row();
        $data_latlng = explode(",",$query->latlong);
        $data_ = array('lat' => [$data_latlng[0]],
                        'lng' => [$data_latlng[1]],
                        'lokasi' => "",
                        'radius' => [(!empty($query->radius)) ? $query->radius : 30 ]);
        
        return $data_;
    }

    public function get_instansi($id)
    {
        return $this->db->get_where('mf_departments',['id'=> $id])->row();
    }

    public function GetPejabatInstansiChatId($dept_id)
	{
		$this->db->select('pejabat_instansi.telegram_chat_id,v_users_all.nama');
        $this->db->join('v_users_all', 'pejabat_instansi.user_id = v_users_all.id');
		$this->db->where('pejabat_instansi.dept_id',$dept_id);
		$this->db->where('pejabat_instansi.pejabat_id',3);
		$query = $this->db->get('pejabat_instansi')->row();
        return $query;
	}

    public function GetCheckPejabatInstansi($user_id,$dept_id)
	{
		$this->db->select('*');
		$this->db->where('dept_id',$dept_id);
		$this->db->where('user_id',$user_id);
		$this->db->where('pejabat_id',3);
		$query = $this->db->get('pejabat_instansi')->row();
		if(!empty($query)){
			if($query->pejabat_id == 3){
				if(!empty($query->telegram_chat_id)){
					return FALSE;
				}else {
					return TRUE;
				}
			}
		}
	}

}

/* End of file M_instansi.php */
