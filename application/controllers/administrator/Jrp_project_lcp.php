<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Project Lcp Controller
*| --------------------------------------------------------------------------
*| Jrp Project Lcp site
*|
*/
class Jrp_project_lcp extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_project_lcp');
	}

	/**
	* show all Jrp Project Lcps
	*
	* @var $offset String
	*/
	public function index($projectId, $offset = 0)
	{
		$this->is_allowed('jrp_project_lcp_list');

        $filter = $this->input->get('q');
        $field 	= $this->input->get('f');

        $parent_field = $projectId;
		
		$fields = array('jrp_project_lcp.*');

		$this->data['jrp_project_lcps'] = $this->model_jrp_project_lcp->get($filter, $field,$parent_field, $this->limit_page, $offset,$fields);
		$this->data['jrp_project_lcp_counts'] = $this->model_jrp_project_lcp->count_all($filter, $field,$parent_field);
		$this->data['project_id'] = $projectId;

		$config = [
			'base_url'     => 'administrator/jrp_project_lcp/index/',
			'total_rows'   => $this->model_jrp_project_lcp->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Lighting Control Panel List');
		$this->render('backend/standart/administrator/jrp_project_lcp/jrp_project_lcp_list', $this->data);
	}
	
	/**
	* Add new jrp_project_lcps
	*
	*/
	public function add($projectId)
	{
		$this->is_allowed('jrp_project_lcp_add');

		$this->template->title('Lighting Control Panel New');
		$this->data['project_id'] = $projectId;
		$this->render('backend/standart/administrator/jrp_project_lcp/jrp_project_lcp_add', $this->data);
	}

	/**
	* Add New Jrp Project Lcps
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_project_lcp_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('LCP_code', 'LCP Code', 'trim|required|max_length[64]');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('lcp_layout', 'Lcp Layout', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('location', 'Location', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('area', 'Area', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('control_area_name', 'Control Area Name', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('note', 'Note', 'trim|required|max_length[256]');
		$this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'LCP_code' => $this->input->post('LCP_code'),
				'type' => $this->input->post('type'),
				'lcp_layout' => $this->input->post('lcp_layout'),
				'location' => $this->input->post('location'),
				'area' => $this->input->post('area'),
				'control_area_name' => $this->input->post('control_area_name'),
				'note' => $this->input->post('note'),
				'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_project_lcp = $this->model_jrp_project_lcp->store($save_data);

			if ($save_jrp_project_lcp) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_project_lcp;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_project_lcp/edit/' . $save_jrp_project_lcp, 'Edit Jrp Project Lcp'),
						anchor('administrator/jrp_project_lcp', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_project_lcp/edit/' . $save_jrp_project_lcp, 'Edit Jrp Project Lcp')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_project_lcp/index/'.$this->input->post('project_id'));
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_project_lcp/index/'.$this->input->post('project_id'));
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Project Lcps
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_project_lcp_update');

		$this->data['jrp_project_lcp'] = $this->model_jrp_project_lcp->find($id);

		$this->template->title('Lighting Control Panel Update');
		$this->render('backend/standart/administrator/jrp_project_lcp/jrp_project_lcp_update', $this->data);
	}

	/**
	* Update Jrp Project Lcps
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_project_lcp_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('LCP_code', 'LCP Code', 'trim|required|max_length[64]');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('lcp_layout', 'Lcp Layout', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('location', 'Location', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('area', 'Area', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('control_area_name', 'Control Area Name', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('note', 'Note', 'trim|required|max_length[256]');
		$this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'LCP_code' => $this->input->post('LCP_code'),
				'type' => $this->input->post('type'),
				'lcp_layout' => $this->input->post('lcp_layout'),
				'location' => $this->input->post('location'),
				'area' => $this->input->post('area'),
				'control_area_name' => $this->input->post('control_area_name'),
				'note' => $this->input->post('note'),
				'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_project_lcp = $this->model_jrp_project_lcp->change($id, $save_data);

			if ($save_jrp_project_lcp) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_project_lcp', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_project_lcp/index/'.$this->input->post('project_id'));
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_project_lcp/index/'.$this->input->post('project_id'));
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Project Lcps
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_project_lcp_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($remove) {
            set_message(cclang('has_been_deleted', 'jrp_project_lcp'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_project_lcp'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Project Lcps
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_project_lcp_view');

		$this->data['jrp_project_lcp'] = $this->model_jrp_project_lcp->join_avaiable()->find($id);

		$this->template->title('Lighting Control Panel Detail');
		$this->render('backend/standart/administrator/jrp_project_lcp/jrp_project_lcp_view', $this->data);
	}
	
	/**
	* delete Jrp Project Lcps
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_project_lcp = $this->model_jrp_project_lcp->find($id);

		
		
		return $this->model_jrp_project_lcp->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_project_lcp_export');

		$this->model_jrp_project_lcp->export('jrp_project_lcp', 'jrp_project_lcp');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_project_lcp_export');

		$this->model_jrp_project_lcp->pdf('jrp_project_lcp', 'jrp_project_lcp');
	}
}


/* End of file jrp_project_lcp.php */
/* Location: ./application/controllers/administrator/Jrp Project Lcp.php */