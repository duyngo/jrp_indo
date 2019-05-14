<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_jrp_book_circuit extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'jrp_book_circuit';
	private $field_search 	= ['layout_id', 'circuit', 'quantity', 'circuit_desc'];//'project_Id'

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function count_all($q = null, $field = null, $parent_field=null)
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "jrp_book_circuit.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_book_circuit.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

            $where = "($where AND $this->table_name.project_id LIKE '%$parent_field%')";
        } else {
            $where .= "($this->table_name.$field  LIKE '%$q%' AND $this->table_name.project_id LIKE '%$parent_field%')";
        }

		$this->join_avaiable();
        $this->db->where($where);
		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = null, $field = null,$parent_field=null, $limit = 0, $offset = 0, $select_field = [])
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "jrp_book_circuit.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_book_circuit.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

            $where = "($where AND $this->table_name.project_id LIKE '%$parent_field%')";
        } else {
            $where .= "($this->table_name.$field  LIKE '%$q%' AND $this->table_name.project_id LIKE '%$parent_field%')";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('jrp_book_layout.document_id', "ASC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {

		$this->db->join('jrp_project_book', 'jrp_project_book.id = jrp_book_circuit.project_Id', 'LEFT');
	    	$this->db->join('jrp_book_layout', 'jrp_book_layout.id = jrp_book_circuit.layout_id', 'LEFT');
	    	
    	return $this;
	}

}

/* End of file Model_jrp_book_circuit.php */
/* Location: ./application/models/Model_jrp_book_circuit.php */