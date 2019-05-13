<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Project App Detail Controller
*| --------------------------------------------------------------------------
*| Jrp Project App Detail site
*|
*/
class Jrp_project_app_detail extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_project_app_detail');
		$this->load->model('model_jrp_project_book');
	}

	/**
	* show all Jrp Project App Details
	*
	* @var $offset String
	*/
	public function index($projectId, $offset = 0)
	{
		$this->is_allowed('jrp_project_app_detail_list');

		$filter = $projectId;
		$field 	= 'project_id';
		
		$select_fields = array('jrp_project_app_detail.*');

		$this->data['jrp_project_app_details'] = $this->model_jrp_project_app_detail->get($filter, $field, $this->limit_page, $offset,$select_fields);
		$this->data['jrp_project_app_detail_counts'] = $this->model_jrp_project_app_detail->count_all($filter, $field);
		
		$this->data['project_id'] = $projectId;
		$config = [
			'base_url'     => 'administrator/jrp_project_app_detail/index/'.$projectId.'/',
			'total_rows'   => $this->model_jrp_project_app_detail->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Application Detail List');
		$this->render('backend/standart/administrator/jrp_project_app_detail/jrp_project_app_detail_list', $this->data);
	}
	
	/**
	* Add new jrp_project_app_details
	*
	*/
	public function add($project_id)
	{
		$this->is_allowed('jrp_project_app_detail_add');

		$this->template->title('Application Detail New');
		$this->data['project_id'] = $project_id;
		
		$this->render('backend/standart/administrator/jrp_project_app_detail/jrp_project_app_detail_add', $this->data);
	}

	/**
	* Add New Jrp Project App Details
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_project_app_detail_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('document_id', 'Document Id', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('project_id', 'Project Id', 'trim|required|max_length[11]');
		

		if ($this->form_validation->run()) {
			$project_id = $this->input->post('project_id');
			$save_data = [
				'document_id' => $this->input->post('document_id'),
				'title' => $this->input->post('title'),
				'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_project_app_detail = $this->model_jrp_project_app_detail->store($save_data);

			if ($save_jrp_project_app_detail) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_project_app_detail;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_project_app_detail/edit/' . $save_jrp_project_app_detail, 'Edit Jrp Project App Detail'),
						anchor('administrator/jrp_project_app_detail/index/'.$project_id, ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_project_app_detail/edit/' . $save_jrp_project_app_detail, 'Edit Jrp Project App Detail')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_project_app_detail/index/'.$project_id);
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_project_app_detail/index/'.$project_id);
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Project App Details
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_project_app_detail_update');

		$this->data['jrp_project_app_detail'] = $this->model_jrp_project_app_detail->find($id);

		$this->template->title('Application Detail Update');
		$this->render('backend/standart/administrator/jrp_project_app_detail/jrp_project_app_detail_update', $this->data);
	}

	/**
	* Update Jrp Project App Details
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_project_app_detail_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('document_id', 'Document Id', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[128]');
		//$this->form_validation->set_rules('project_id', 'Project Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'document_id' => $this->input->post('document_id'),
				'title' => $this->input->post('title'),
				//'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_project_app_detail = $this->model_jrp_project_app_detail->change($id, $save_data);

			if ($save_jrp_project_app_detail) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_project_app_detail', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_project_app_detail');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_project_app_detail');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Project App Details
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_project_app_detail_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_project_app_detail'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_project_app_detail'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Project App Details
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_project_app_detail_view');

		$this->data['jrp_project_app_detail'] = $this->model_jrp_project_app_detail->join_avaiable()->find($id);

		$this->template->title('Application Detail Detail');
		$this->render('backend/standart/administrator/jrp_project_app_detail/jrp_project_app_detail_view', $this->data);
	}
	
	/**
	* delete Jrp Project App Details
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_project_app_detail = $this->model_jrp_project_app_detail->find($id);

		
		
		return $this->model_jrp_project_app_detail->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_project_app_detail_export');

		$this->model_jrp_project_app_detail->export('jrp_project_app_detail', 'jrp_project_app_detail');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_project_app_detail_export');

		$this->model_jrp_project_app_detail->pdf('jrp_project_app_detail', 'jrp_project_app_detail');
	}
	
	public function export_pdf_layout($project_id)
	{
		$this->is_allowed('jrp_book_layout_export');
		
		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_project_app_detail->pdf_layout('jrp_project_app_detail', 'Application Detail', $project);
	}

}


/* End of file jrp_project_app_detail.php */
/* Location: ./application/controllers/administrator/Jrp Project App Detail.php */