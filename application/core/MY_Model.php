<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $_table_name 		= '';
	protected $_primary_key 	= 'id';
	protected $_primary_filter 	= 'intval';
	protected $_order_by 		= '';
	protected $_order 			= 'DESC';
	public $rules 				= array();
	protected $_timestamps 		= FALSE;
	protected $return 			= FALSE;
	protected $result			= FALSE;
	public $paging = array(
		'full_tag_open' => '<div class="pagination"><ul>',
		'full_tag_close' => '</ul></div>',

		'first_link' => '&laquo; Awal',
		'first_tag_open' => '<li class="prev page">',
		'first_tag_close' => '</li>',

		'last_link' => 'Akhir &raquo;',
		'last_tag_open' => '<li class="next page">',
		'last_tag_close' => '</li>',

		'next_link' => 'Selanjutnya &rarr;',
		'next_tag_open' => '<li class="next page">',
		'next_tag_close' => '</li>',

		'prev_link' => '&larr; Sebelumnya',
		'prev_tag_open' => '<li class="prev page">',
		'prev_tag_close' => '</li>',

		'cur_tag_open' => '<li class="active"><a href="">',
		'cur_tag_close' => '</a></li>',

		'num_tag_open' => '<li class="page">',
		'num_tag_close' => '</li>'
		);
	
	function __construct() {
		parent::__construct();
		$this->class_name 		 = $this->router->fetch_class();
	    $this->function 		 = $this->router->fetch_method();
	    $this->login 			 = $this->session->userdata('bola_loggedin');
	    $this->level 			 = $this->session->userdata('bola_level');
	    $this->user_id 			 = $this->session->userdata('bola_user_id');
	}
	
	public function array_from_post($fields){
		$data = array();
		foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		}
		return $data;
	}

	public function QueryValue($query) {
		$query = $this->db->query($query);
		if ($query->num_rows() > 0)	{
	            return $query->result();        		
		}else{
	            return $query->row(); 
	    }
	}
	
	public function get($id = NULL, $single = FALSE){
		
		if ($id != NULL) {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->where($this->_primary_key, $id);
			$method = 'row';
		}
		elseif($single == TRUE) {
			$method = 'row';
		}
		else {
			$method = 'result';
		}
		
		if ($this->_order_by) {
			$this->db->order_by("$this->_table_name.$this->_order_by","$this->_order");
		}

		return $this->db->get($this->_table_name)->$method();
	}

	public function get_limit($limit,$where=NULL){
		if ($where) {
			$this->db->where($where);
		}

		if($limit == 1) {
			$method = 'row';
		}
		else {
			$method = 'result';
		}

		$this->db->order_by("$this->_table_name.$this->_order_by",'DESC');
		$this->db->limit($limit);
		return $this->db->get($this->_table_name)->$method();

	}

	public function get_slug($slug){
		
		$this->db->where(array('slug'=>$slug));
		return $this->db->get($this->_table_name)->row();
	}
	
	// Ambil data dengan kondisi tertentu
	public function get_where($where, $single = FALSE){
		if ($this->_order_by) {
			$this->db->order_by("$this->_table_name.$this->_order_by","$this->_order");
		}
		$this->db->where($where);
		if($single == TRUE) {
			$method = 'row';
		}
		else {
			$method = 'result';
		}
		
		return $this->db->get($this->_table_name)->$method();
	}

	// Ambil data dalam bentuk paging
	public function get_paging($num, $offset,$where=NULL) {
		if ($where) {
			$this->db->where($where);
		}
		$this->db->order_by("$this->_table_name.$this->_order_by",'DESC');
		$data = $this->db->get($this->_table_name, $num, $offset); 
		return $data->result();
	}

	// Mengambil data random
	public function get_random($limit=NULL,$where=NULL){
		if ($where) {
			$this->db->where($where);
		}
		$this->db->order_by("$this->_table_name.$this->_order_by", 'RANDOM');
		return $this->db->get($this->_table_name, $limit)->result();
	}
	
	public function save($data, $id = NULL){
		
		// Set timestamps
		if ($this->_timestamps == TRUE) {
			$now = date('Y-m-d H:i:s');
			$id || $data['created_at'] = $now;
			$data['updated_at'] = $now;
		}
		
		// Insert
		if ($id === NULL) {
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			$id = $this->db->insert_id();
		}
		// Update
		else {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->set($data);
			$this->db->where($this->_primary_key, $id);
			$this->db->update($this->_table_name);
		}
		
		return $id;
	}

	public function save_batch($data) {
		$this->db->insert_batch($this->_table_name, $data);
	}
	
	public function delete($id){
		$filter = $this->_primary_filter;
		$id = $filter($id);
		
		if (!$id) {
			return FALSE;
		}else {
			//set log
			$this->save_log([$this->_primary_key => $id], 'delete');
			$this->db->where($this->_primary_key, $id);
			$this->db->limit(1);
			return $this->db->delete($this->_table_name);
		}
		
	}

	public function save_log($where='', $action=NULL)
	{
		$data = $this->db->get_where($this->_table_name, $where)->row();
		$data_field = json_encode($data);
		$data_log = array('tabel_name' 	=> $this->_table_name, 
						  'tabel_id' 	=> $data->id,
						  'data'		=> $data_field,
						  'tabel_action'=> $action
						);
		if ($this->user_id) {
			$data_log['created_by'] = $this->user_id;
		}
		$this->db->insert('_data_log',$data_log);
	}

	public function delete_where($where, $single = FALSE) {
		if (!$where) {
			return false;
		}
		$this->db->where($where);
		if ($single) {
			$this->db->limit(1);
		}
		$this->db->delete($this->_table_name);
	}

	public function totalRow($where = NULL){
		if ($where === NULL) {
			$num_rows = $this->db->get($this->_table_name);
		} else{
			$this->db->where($where);
			$num_rows = $this->db->get($this->_table_name);
		}
		return $num_rows->num_rows();
	}

}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */