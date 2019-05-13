<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Book Dimming Setting Controller
*| --------------------------------------------------------------------------
*| Jrp Book Dimming Setting site
*|
*/
class Jrp_book_dimming_setting extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_book_dimming_setting');
	}

	/**
	* show all Jrp Book Dimming Settings
	*
	* @var $offset String
	*/
	public function index($projectId, $offset = 0)
	{
		$this->is_allowed('jrp_book_dimming_setting_list');

		$filter = $projectId;//$this->input->get('q');
		$field 	= 'project_id';//$this->input->get('f');
		
		$fields = array('jrp_book_dimming_setting.*','jrp_book_circuit.circuit');
		
		$this->data['jrp_book_dimming_settings'] = $this->model_jrp_book_dimming_setting->get($filter, $field, $this->limit_page, $offset,$fields);
		$this->data['jrp_book_dimming_setting_counts'] = $this->model_jrp_book_dimming_setting->count_all($filter, $field);

		$this->data['project_id'] = $projectId;
		$config = [
			'base_url'     => 'administrator/jrp_book_dimming_setting/index/',
			'total_rows'   => $this->model_jrp_book_dimming_setting->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Dimming Setting List');
		$this->render('backend/standart/administrator/jrp_book_dimming_setting/jrp_book_dimming_setting_list', $this->data);
	}
	
	/**
	* Add new jrp_book_dimming_settings
	*
	*/
	public function add($projectId)
	{
		$this->is_allowed('jrp_book_dimming_setting_add');

		$this->template->title('Dimming Setting New');
		$this->data['project_id'] = $projectId;
		$this->render('backend/standart/administrator/jrp_book_dimming_setting/jrp_book_dimming_setting_add', $this->data);
	}

	/**
	* Add New Jrp Book Dimming Settings
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_book_dimming_setting_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('circuit_id', 'Circuit Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('scene_1', 'Scene 1', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_2', 'Scene 2', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_3', 'Scene 3', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_4', 'Scene 4', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_5', 'Scene 5', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_6', 'Scene 6', 'trim|max_length[64]');
		$this->form_validation->set_rules('note', 'Note', 'trim');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'circuit_id' => $this->input->post('circuit_id'),
				'scene_1' => $this->input->post('scene_1'),
				'scene_2' => $this->input->post('scene_2'),
				'scene_3' => $this->input->post('scene_3'),
				'scene_4' => $this->input->post('scene_4'),
				'scene_5' => $this->input->post('scene_5'),
				'scene_6' => $this->input->post('scene_6'),
				'note' => $this->input->post('note'),
				'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_book_dimming_setting = $this->model_jrp_book_dimming_setting->store($save_data);

			if ($save_jrp_book_dimming_setting) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_book_dimming_setting;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_book_dimming_setting/edit/' . $save_jrp_book_dimming_setting, 'Edit Jrp Book Dimming Setting'),
						anchor('administrator/jrp_book_dimming_setting', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_book_dimming_setting/edit/' . $save_jrp_book_dimming_setting, 'Edit Jrp Book Dimming Setting')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_dimming_setting/index/'.$this->input->post('project_id'));
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_dimming_setting/index/'.$this->input->post('project_id'));
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Book Dimming Settings
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_book_dimming_setting_update');

		$this->data['jrp_book_dimming_setting'] = $this->model_jrp_book_dimming_setting->find($id);

		$this->template->title('Dimming Setting Update');
		$this->render('backend/standart/administrator/jrp_book_dimming_setting/jrp_book_dimming_setting_update', $this->data);
	}

	/**
	* Update Jrp Book Dimming Settings
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_book_dimming_setting_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('circuit_id', 'Circuit Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('scene_1', 'Scene 1', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_2', 'Scene 2', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_3', 'Scene 3', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_4', 'Scene 4', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_5', 'Scene 5', 'trim|max_length[64]');
		$this->form_validation->set_rules('scene_6', 'Scene 6', 'trim|max_length[64]');
		$this->form_validation->set_rules('note', 'Note', 'trim');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'circuit_id' => $this->input->post('circuit_id'),
				'scene_1' => $this->input->post('scene_1'),
				'scene_2' => $this->input->post('scene_2'),
				'scene_3' => $this->input->post('scene_3'),
				'scene_4' => $this->input->post('scene_4'),
				'scene_5' => $this->input->post('scene_5'),
				'scene_6' => $this->input->post('scene_6'),
				'note' => $this->input->post('note'),
				'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_book_dimming_setting = $this->model_jrp_book_dimming_setting->change($id, $save_data);

			if ($save_jrp_book_dimming_setting) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_book_dimming_setting', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_dimming_setting/index/'.$this->input->post('project_id'));
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_dimming_setting/index/'.$this->input->post('project_id'));
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Book Dimming Settings
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_book_dimming_setting_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_book_dimming_setting'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_book_dimming_setting'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Book Dimming Settings
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_book_dimming_setting_view');

		$this->data['jrp_book_dimming_setting'] = $this->model_jrp_book_dimming_setting->join_avaiable()->find($id);

		$this->template->title('Dimming Setting Detail');
		$this->render('backend/standart/administrator/jrp_book_dimming_setting/jrp_book_dimming_setting_view', $this->data);
	}
	
	/**
	* delete Jrp Book Dimming Settings
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_book_dimming_setting = $this->model_jrp_book_dimming_setting->find($id);

		
		
		return $this->model_jrp_book_dimming_setting->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_book_dimming_setting_export');

		$this->model_jrp_book_dimming_setting->export('jrp_book_dimming_setting', 'jrp_book_dimming_setting');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_book_dimming_setting_export');

		$this->model_jrp_book_dimming_setting->pdf('jrp_book_dimming_setting', 'jrp_book_dimming_setting');
	}
}


/* End of file jrp_book_dimming_setting.php */
/* Location: ./application/controllers/administrator/Jrp Book Dimming Setting.php */