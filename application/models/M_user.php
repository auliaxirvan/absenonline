<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

    public function cek_login($device_id)
    {
        if (!empty($device_id)) {
            $this->db->select('a.id, c.id as users_login_id, c.level, a.user_id,b.pns, b.nama as nama_lengkap, b.dept_id, a.id_device, b.absen_online_app');
            $this->db->join('mf_users b','b.id=a.user_id');
             $this->db->join('users_login c','c.user_id=a.user_id');
            $query = $this->db->get_where('device_users a',['id_device' => $device_id,'a.is_active' =>1])->row();
            if (!empty($query)) {
                    $this->db->update('device_users', ['last_login' => date('Y-m-d H:i:s')], ['id' => $query->id ]);
                    $this->session->set_userdata(['tpp_dept_id' => $query->dept_id,
                                                  'tpp_user_id' => $query->user_id,
                                                  'tpp_pns' => $query->pns,
                                                  'tpp_login_id' => $query->users_login_id,
                                                  'tpp_level'   => $query->level]);
                    return $query;
            }else return false;
        }else return false;
    }

    public function set_session()
    {
         // 1. Daftarkan Session
         if ($this->input->get('id_device')) {
                $data = ([
                    'id_device' 		=> $this->input->get('id_device'),
                    'brand' 		    => $this->input->get('brand'),
                    'model' 		    => $this->input->get('model')]);
                $this->session->set_userdata($data);  
         }
        
    }

    public function _auth_cek()
    {
        $this->db->select('a.id, a.user_id, a.password as password_sikap, e.password, b.id_device, a.level, d.intro, c.pns,e.id as simpeg_user_id,f.total_persen');
        $this->db->join('(select user_id, id_device from device_users where is_active=1) b','a.user_id=b.user_id','left');
	    $this->db->join('mf_users c', 'a.user_id=c.id','left');
        $this->db->join('simpeg.pegawai d','c.nip = d.nip','left');
		$this->db->join('simpeg.users e','d.id = e.pegawai_id','left');
		$this->db->join('v_biodata_simpeg f','f.id = e.pegawai_id','left');
	    $this->db->where('d.nip',$this->input->post('username'));
	    $this->db->or_where('a.username',$this->input->post('username'));
	    $this->db->where('a.status=1');
	    $this->db->limit(1);
	    $query = $this->db->get('users_login a');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            $data = $query->row();
            if($data->level == "1"){
                $password = $data->password_sikap;
            }else {
                $password = $data->password;
            }

            if(empty($password) || $password == NULL){
                $password_ = $data->password_sikap;
            }else{
                $password_ = $password;
            }
            if (password_verify($this->input->post('password'), $password_)) {
                // echo 'Password is vali!';
                return $data;
            } else {
                // echo 'Invalid password.';
                return FALSE;
            }
        }
    }

    public function _update_user($data_user, $id='')
    {   
        return $this->db->insert('device_users',$data_user);
        // return $this->db->update('users',$data_user,['id'=>$id]);
    }

}

/* End of file M_user.php */
