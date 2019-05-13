<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_jrp_fixture_component extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'jrp_fixture_component';
	private $field_search 	= ['fixture_id', 'component_id'];

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
	                $where .= "jrp_fixture_component.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_fixture_component.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "jrp_fixture_component.".$field . " LIKE '%" . $q . "%' )";
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
	                $where .= "jrp_fixture_component.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_fixture_component.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "jrp_fixture_component.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('jrp_fixture_component.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {

		$this->db->join('jrp_fixture', 'jrp_fixture.id = jrp_fixture_component.fixture_id', 'LEFT');
	    	$this->db->join('jrp_component', 'jrp_component.id = jrp_fixture_component.component_id', 'LEFT');
	    	$this->db->join('jrp_manufacturer', 'jrp_manufacturer.id = jrp_component.manufacturer');
    	return $this;
	}

}

/* End of file Model_jrp_fixture_component.php */
/* Location: ./application/models/Model_jrp_fixture_component.php */