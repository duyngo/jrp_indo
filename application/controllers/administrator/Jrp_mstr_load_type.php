<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Mstr Load Type Controller
*| --------------------------------------------------------------------------
*| Jrp Mstr Load Type site
*|
*/
class Jrp_mstr_load_type extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_mstr_load_type');
	}

	/**
	* show all Jrp Mstr Load Types
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('jrp_mstr_load_type_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['jrp_mstr_load_types'] = $this->model_jrp_mstr_load_type->get($filter, $field, $this->limit_page, $offset);
		$this->data['jrp_mstr_load_type_counts'] = $this->model_jrp_mstr_load_type->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/jrp_mstr_load_type/index/',
			'total_rows'   => $this->model_jrp_mstr_load_type->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Load Type List');
		$this->render('backend/standart/administrator/jrp_mstr_load_type/jrp_mstr_load_type_list', $this->data);
	}
	
	/**
	* Add new jrp_mstr_load_types
	*
	*/
	public function add()
	{
		$this->is_allowed('jrp_mstr_load_type_add');

		$this->template->title('Load Type New');
		$this->render('backend/standart/administrator/jrp_mstr_load_type/jrp_mstr_load_type_add', $this->data);
	}

	/**
	* Add New Jrp Mstr Load Types
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_mstr_load_type_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];

			
			$save_jrp_mstr_load_type = $this->model_jrp_mstr_load_type->store($save_data);

			if ($save_jrp_mstr_load_type) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_mstr_load_type;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_mstr_load_type/edit/' . $save_jrp_mstr_load_type, 'Edit Jrp Mstr Load Type'),
						anchor('administrator/jrp_mstr_load_type', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_mstr_load_type/edit/' . $save_jrp_mstr_load_type, 'Edit Jrp Mstr Load Type')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_mstr_load_type');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_mstr_load_type');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Mstr Load Types
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_mstr_load_type_update');

		$this->data['jrp_mstr_load_type'] = $this->model_jrp_mstr_load_type->find($id);

		$this->template->title('Load Type Update');
		$this->render('backend/standart/administrator/jrp_mstr_load_type/jrp_mstr_load_type_update', $this->data);
	}

	/**
	* Update Jrp Mstr Load Types
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_mstr_load_type_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];

			
			$save_jrp_mstr_load_type = $this->model_jrp_mstr_load_type->change($id, $save_data);

			if ($save_jrp_mstr_load_type) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_mstr_load_type', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_mstr_load_type');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_mstr_load_type');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Mstr Load Types
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_mstr_load_type_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_mstr_load_type'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_mstr_load_type'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Mstr Load Types
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_mstr_load_type_view');

		$this->data['jrp_mstr_load_type'] = $this->model_jrp_mstr_load_type->join_avaiable()->find($id);

		$this->template->title('Load Type Detail');
		$this->render('backend/standart/administrator/jrp_mstr_load_type/jrp_mstr_load_type_view', $this->data);
	}
	
	/**
	* delete Jrp Mstr Load Types
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_mstr_load_type = $this->model_jrp_mstr_load_type->find($id);

		
		
		return $this->model_jrp_mstr_load_type->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_mstr_load_type_export');

		$this->model_jrp_mstr_load_type->export('jrp_mstr_load_type', 'jrp_mstr_load_type');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_mstr_load_type_export');

		$this->model_jrp_mstr_load_type->pdf('jrp_mstr_load_type', 'jrp_mstr_load_type');
	}
}


/* End of file jrp_mstr_load_type.php */
/* Location: ./application/controllers/administrator/Jrp Mstr Load Type.php */