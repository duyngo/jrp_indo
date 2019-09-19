<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_jrp_project_book extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'jrp_project_book';
	private $field_search 	= ['name'];

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
	                $where .= "jrp_project_book.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_project_book.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "jrp_project_book.".$field . " LIKE '%" . $q . "%' )";
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
	                $where .= "jrp_project_book.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "jrp_project_book.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "jrp_project_book.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('jrp_project_book.name', "ASC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {

		
    	return $this;
	}
	
	public function pdf_layout($table, $title, $project)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        
        $this->db->select("pl.document_id as 'Document', pl.title as 'Title'");
        $this->db->from($table.' pl');
        $this->db->join('jrp_project_book pb','pl.project_id = pb.id');
        $this->db->where('pl.project_id = '.$project->id);
        $this->db->order_by('pl.document_id','ASC');
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
    
    public function pdf_fixtures_note($project, $get_html = false)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);
        

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/fixtures-notes', [
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $content;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output('fixtures_note.pdf', 'H');
    }
    
    public function pdf_fixture_spec($table, $title, $project, $get_html = false)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);
        
        //$this->db->start_cache();
        $this->db->distinct();
        $this->db->select("fixtures, f.code, quantity, image_ref");
        $this->db->from('jrp_book_circuit_schedule cs');
        $this->db->join('jrp_project_book pb','cs.project_id = pb.id');
        $this->db->join('jrp_fixture f','cs.fixtures = f.id');
        $this->db->where('cs.project_id = '.$project->id);
        $this->db->order_by('f.code','ASC');
        $fixtures = $this->db->get()->result();

		
        //$this->db->stop_cache();
        
        //$this->db->flush_cache();

		$arrId = array();
		foreach($fixtures as $fixture) {
			$arrId[] = $fixture->fixtures;
		}

		if(count($arrId)){
            $this->db->select("fc.*,c.name,c.watt,m.name as manufacturer_name,c.catalog_number,c.finishing,c.notes");
            $this->db->from('jrp_fixture_component fc');
            $this->db->join('jrp_component c','fc.component_id = c.id');
            $this->db->join('jrp_manufacturer m','c.manufacturer = m.id');
            $this->db->where('fixture_id IN ('.implode(',',$arrId).')');
            $result = $this->db->get()->result();
        }else{
            $result = array();
        }
        

        //$fields = $result->list_fields();

		//print_r($fc);
        $content = $this->pdf->loadHtmlPdf('core_template/pdf/fixtures', [
	        'fixtures' => $fixtures,
	        'fixture_components' => $result,
            //'results' => $result->result(),
            //'fields' => $fields,
            'title' => $title,
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $content;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }
    
    public function pdf_circuit_qty($table, $title, $project, $get_html = false)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);
        
        $this->db->select("bl.document_id AS 'Layout',bl.title as 'Drawing Name', c.circuit,c.quantity");
        $this->db->from($table.' c');
        $this->db->join('jrp_project_book pb','c.project_id = pb.id');
        $this->db->join('jrp_book_layout bl','c.layout_id = bl.id');
        $this->db->where('c.project_id = '.$project->id);
        $this->db->order_by('bl.document_id','ASC');
        $result = $this->db->get();
        
        $fields = $result->list_fields();
        

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/qty', [
            'results' => $result->result(),
            'fields' => $fields,
            'title' => $title,
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $get_html;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }

    public function pdf_agent($table, $title, $project, $get_html = false)
    {
        $this->load->library('HtmlPdf');

        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);

        $sql_query = " SELECT DISTINCT manu.`name` AS `Manufacturer Name`, manu.`contact_person`,manu.`contact_email`, manu.`contact_phone`,manu.`contact_address`
                        FROM jrp_book_circuit_schedule AS book_fix 
                        INNER JOIN jrp_fixture_component AS fix_compo ON (fix_compo.`fixture_id` = book_fix.`fixtures`)
                        INNER JOIN jrp_component AS compo ON (compo.`id` = fix_compo.`component_id`)
                        INNER JOIN jrp_manufacturer AS manu ON (manu.id = compo.`manufacturer`)
                        WHERE book_fix.`project_id` = $project->id
                      ";

        $result = $this->db->query($sql_query);

        $fields = $result->list_fields();


        $content = $this->pdf->loadHtmlPdf('core_template/pdf/agent', [
            'results' => $result->result(),
            'fields' => $fields,
            'title' => $title,
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $content;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }
    
    public function pdf_fixture_qty($table, $title, $project, $get_html = false)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);
        
        //$this->db->start_cache();
        $this->db->distinct();
        $this->db->select("bl.id as layout_id, bl.document_id, bl.title");
        $this->db->from('jrp_book_layout bl');
        $this->db->join('jrp_project_book pb','bl.project_id = pb.id');
        $this->db->where('bl.project_id = '.$project->id);
        $this->db->order_by('bl.document_id','ASC');
        $layouts = $this->db->get()->result();
        
        //$this->db->stop_cache();
        
        //$this->db->flush_cache();

		$arrId = array();
		foreach($layouts as $layout) {
			$arrId[] = $layout->layout_id;
		}
        if(count($arrId)){
            $this->db->select("c.layout_id,f.code, cs.quantity as fixture_qty, c.quantity as layout_qty");
            $this->db->from($table.' cs');
            $this->db->join('jrp_project_book pb','cs.project_id = pb.id');
            $this->db->join('jrp_fixture f','cs.fixtures = f.id');
            $this->db->join('jrp_book_circuit c', 'cs.circuit_id = c.id');
            $this->db->where('cs.project_id = '.$project->id.' AND c.layout_id IN ('.implode(',',$arrId).')');
            $this->db->order_by('f.code','ASC');
            $result = $this->db->get()->result();
        }else{
            $result = array();
        }

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/qty-fixture', [
	        'layouts' => $layouts,
            'results' => $result,
//            'fields' => $fields,
            'title' => $title,
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $content;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }
    
    public function pdf_component_qty($table, $title, $project, $get_html = false)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);
        
        //$this->db->start_cache();
        $this->db->distinct();
        $this->db->select('ma.name as Manufacturer, fi.code, co.name, co.watt, co.catalog_number, co.finishing');
        $this->db->from('jrp_component co');
        $this->db->join('jrp_manufacturer ma','co.manufacturer = ma.id');
        $this->db->join('jrp_fixture_component fc', 'co.id = fc.component_id');
        $this->db->join('jrp_book_circuit_schedule cs', 'fc.fixture_id = cs.fixtures');
        $this->db->join('jrp_fixture fi','cs.fixtures = fi.id');
        $this->db->where('cs.project_id = '.$project->id);
        $this->db->order_by('ma.name ASC, co.name ASC');
        $result = $this->db->get();
        $fields = $result->list_fields();

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/qty', [
            'results' => $result->result(),
            'fields' => $fields,
            'title' => $title,
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $content;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }
    
    public function pdf_schedule_note($project, $get_html = false)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);
        

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/schedule-notes', [
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $content;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output('fixtures_note.pdf', 'H');
    }
    public function pdf_cover($project)
    {
        $this->load->library('HtmlPdf');

        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);


        $content = $this->pdf->loadHtmlPdf('core_template/pdf/cover', [
            'project_name' => $project->name
        ], TRUE);

        //var_dump($content);die;

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output('fixtures_note.pdf', 'H');
    }
    
    public function pdf_circuit_schedule($table, $title, $project, $get_html = false)
    {
        $this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);
        
        //$this->db->start_cache();
        $this->db->distinct();
        $this->db->select("bl.id as layout_id, bl.document_id, bl.title");
        $this->db->from('jrp_book_layout bl');
        $this->db->join('jrp_project_book pb','bl.project_id = pb.id');
        $this->db->where('bl.project_id = '.$project->id);
        $this->db->order_by('bl.document_id','asc');
        $layouts = $this->db->get()->result();
        
        //$this->db->stop_cache();
        
        //$this->db->flush_cache();

		$arrId = array();
		foreach($layouts as $layout) {
			$arrId[] = $layout->layout_id;
		}
        
        $this->db->select("c.circuit, c.circuit_desc, cs.feed_from, cs.dim_rack, cs.quantity, f.code as fixture_code, lt.name AS load_name, c.layout_id, (select SUM(co.watt) from jrp_fixture_component fc
        JOIN jrp_component co ON fc.component_id = co.id
        WHERE fc.`fixture_id` = cs.fixtures) as watt");
        $this->db->from($table.' cs');
        $this->db->join('jrp_project_book pb','cs.project_id = pb.id');
        $this->db->join('jrp_fixture f','cs.fixtures = f.id');
        $this->db->join('jrp_book_circuit c', 'cs.circuit_id = c.id');
        $this->db->join('jrp_mstr_load_type lt', 'cs.load_type = lt.id');
        $this->db->where('cs.project_id = '.$project->id);
        if(count($arrId)){
            $this->db->where("c.layout_id IN (".implode(',',$arrId).")");
        }

        $result = $this->db->get();

        
        $fields = $result->list_fields();

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/schedule', [
	        'layouts' => $layouts,
            'results' => $result->result(),
            'fields' => $fields,
            'title' => $title,
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $content;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }

    public function pdf_lcp($table, $title, $project, $get_html = false)
    {
        $this->load->library('HtmlPdf');

        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);

        $this->db->select("c.LCP_code,c.type,c.lcp_layout,c.location,c.area,c.control_area_name,c.note,c.lcp_finish,c.project_id");
        $this->db->from($table.' c');
        $this->db->join('jrp_project_book pb','c.project_id = pb.id');

        $this->db->where('c.project_id = '.$project->id);
        //$this->db->order_by('bl.document_id','ASC');
        $result = $this->db->get();

        $fields = $result->list_fields();


        $content = $this->pdf->loadHtmlPdf('core_template/pdf/qty', [
            'results' => $result->result(),
            'fields' => $fields,
            'title' => $title,
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $content;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }
    public function pdf_dimming($table, $title, $project, $get_html = false)
    {
        $this->load->library('HtmlPdf');

        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );

        $this->pdf = new HtmlPdf($config);

        $this->db->select("c.circuit_id,c.scene_1,c.scene_2,c.scene_3,c.scene_4,c.scene_5,c.scene_6,c.note,bc.circuit");
        $this->db->from($table.' c');
        $this->db->join('jrp_project_book pb','c.project_id = pb.id');
        $this->db->join('jrp_book_circuit bc','c.circuit_id = bc.id');

        $this->db->where('c.project_id = '.$project->id);
        //$this->db->order_by('bl.document_id','ASC');
        $result = $this->db->get();

        $fields = $result->list_fields();


        $content = $this->pdf->loadHtmlPdf('core_template/pdf/dimming', [
            'results' => $result->result(),
            'fields' => $fields,
            'title' => $title,
            'project_name' => $project->name
        ], TRUE);

        if($get_html){
            return $content;
        }

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
    }

}

/* End of file Model_jrp_project_book.php */
/* Location: ./application/models/Model_jrp_project_book.php */