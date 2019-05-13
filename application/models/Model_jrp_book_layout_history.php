<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_jrp_book_layout_history extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'jrp_book_layout_history';
	private $field_search 	= ['layout_id', 'date', 'revision_no'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function count_all($q = null, $field = null)
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "jrp_book_layout_history.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_book_layout_history.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "jrp_book_layout_history.".$field . " LIKE '%" . $q . "%' )";
        }

		$this->join_avaiable();
        $this->db->where($where);
		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "jrp_book_layout_history.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_book_layout_history.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "jrp_book_layout_history.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('jrp_book_layout_history.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}
	
	public function get_last_revision() {
		$this->db->where($this->table_name, $where);
		$this->db->order_by('jrp_book_layout_history.date_created','DESC');
		$query = $this->db->get($this->table_name);
		
        return $query->row();
	}

	public function join_avaiable() {

		$this->db->join('jrp_book_layout', 'jrp_book_layout.id = jrp_book_layout_history.layout_id', 'LEFT');
	    	
    	return $this;
	}

}

/* End of file Model_jrp_book_layout_history.php */
/* Location: ./application/models/Model_jrp_book_layout_history.php */