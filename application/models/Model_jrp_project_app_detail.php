<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_jrp_project_app_detail extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'jrp_project_app_detail';
	private $field_search 	= ['document_id', 'title'];//, 'project_id'

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function count_all($q = null, $field = null, $parent_field = null)
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                if ($iterasi == 1) {
                    $where .= "jrp_project_app_detail.$field  LIKE '%$q%' ";
                } else {
                    $where .= "OR jrp_project_app_detail.$field  LIKE '%$q%' ";
                }
                $iterasi++;
            }

            $where = "( ($where) AND $this->table_name.project_id LIKE '%$parent_field%')";
        } else {
            $where .= "( ($this->table_name.$field  LIKE '%$q%') AND $this->table_name.project_id LIKE '%$parent_field%')";
        }

		$this->join_avaiable();
        $this->db->where($where);
		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = null, $field = null, $parent_field = null,$limit = 0, $offset = 0, $select_field = [])
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                if ($iterasi == 1) {
                    $where .= "jrp_project_app_detail.$field  LIKE '%$q%' ";
                } else {
                    $where .= "OR jrp_project_app_detail.$field  LIKE '%$q%' ";
                }
                $iterasi++;
            }

            $where = "( ($where) AND $this->table_name.project_id LIKE '%$parent_field%')";
        } else {
            $where .= "( ($this->table_name.$field  LIKE '%$q%') AND $this->table_name.project_id LIKE '%$parent_field%')";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('jrp_project_app_detail.document_id', "ASC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {

		$this->db->join('jrp_project_book', 'jrp_project_book.id = jrp_project_app_detail.project_id', 'LEFT');
	    	
    	return $this;
	}
	
	public function pdf_layout($table, $title, $project)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        
        $this->db->select("pl.document_id as 'Document', pl.title as 'Title',IF(pl.revision IS NULL,'/',pl.revision) AS revision,DATE_FORMAT(IF(pl.date_revision IS NULL,NOW(),pl.date_revision),'%D %M %Y') AS date_revision");
        $this->db->from($table.' pl');
        $this->db->join('jrp_project_book pb','pl.project_id = pb.id');
        $this->db->where('pl.project_id = '.$project->id);
        $this->db->order_by('pl.document_id');
        $result = $this->db->get();
        
        $fields = $result->list_fields();

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/layout', [
            'results' => $result->result(),
            'fields' => $fields,
            'title' => $title,
            'project_name' => $project->name
        ], TRUE);

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }

}

/* End of file Model_jrp_project_app_detail.php */
/* Location: ./application/models/Model_jrp_project_app_detail.php */