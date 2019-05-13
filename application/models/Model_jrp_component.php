<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_jrp_component extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'jrp_component';
	private $field_search 	= ['name', 'catalog_number', 'manufacturer', 'finishing', 'watt', 'width', 'length', 'depth', 'image_ref', 'notes'];

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
	                $where .= "jrp_component.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_component.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "jrp_component.".$field . " LIKE '%" . $q . "%' )";
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
	                $where .= "jrp_component.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_component.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "jrp_component.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->db->select($this->table_name.'.*, jrp_manufacturer.id as manufacturer_id, jrp_manufacturer.name as manufacturer_name');
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('jrp_manufacturer.name', "ASC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {

		$this->db->join('jrp_manufacturer', 'jrp_manufacturer.id = jrp_component.manufacturer', 'LEFT');
	    	
    	return $this;
	}

}

/* End of file Model_jrp_component.php */
/* Location: ./application/models/Model_jrp_component.php */