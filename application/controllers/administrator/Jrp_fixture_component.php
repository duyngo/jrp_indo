<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Fixture Component Controller
*| --------------------------------------------------------------------------
*| Jrp Fixture Component site
*|
*/
class Jrp_fixture_component extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_fixture_component');
	}

	/**
	* show all Jrp Fixture Components
	*
	* @var $offset String
	*/
	public function index($id, $offset = 0)
	{
		$this->is_allowed('jrp_fixture_component_list');

		$filter = $id;
		$field 	= 'fixture_id';
		$select_field = array('jrp_fixture_component.*','jrp_component.name','jrp_component.finishing','jrp_component.width','jrp_component.length','jrp_component.depth','jrp_manufacturer.name as manufacturer_name');

		$this->data['jrp_fixture_components'] = $this->model_jrp_fixture_component->get($filter, $field, $this->limit_page, $offset,$select_field);
		$this->data['jrp_fixture_component_counts'] = $this->model_jrp_fixture_component->count_all($filter, $field);
		$this->data['fixture_id'] = $id;
		$config = [
			'base_url'     => 'administrator/jrp_fixture_component/index/',
			'total_rows'   => $this->model_jrp_fixture_component->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Fixture Component List');
		$this->render('backend/standart/administrator/jrp_fixture_component/jrp_fixture_component_list', $this->data);
	}
	
	/**
	* Add new jrp_fixture_components
	*
	*/
	public function add($fixtureId)
	{
		$this->is_allowed('jrp_fixture_component_add');
		$this->data['fixture_id'] =$fixtureId;
		$this->template->title('Fixture Component New');
		$this->render('backend/standart/administrator/jrp_fixture_component/jrp_fixture_component_add', $this->data);
	}

	/**
	* Add New Jrp Fixture Components
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_fixture_component_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('fixture_id', 'Fixture Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('component_id', 'Component Id', 'trim|required|max_length[11]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'fixture_id' => $this->input->post('fixture_id'),
				'component_id' => $this->input->post('component_id'),
				'component_qty' => $this->input->post('component_qty'),
			];

			
			$save_jrp_fixture_component = $this->model_jrp_fixture_component->store($save_data);

			if ($save_jrp_fixture_component) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_fixture_component;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_fixture_component/edit/' . $save_jrp_fixture_component, 'Edit Jrp Fixture Component'),
						anchor('administrator/jrp_fixture_component/index/'.$this->input->post('fixture_id'), ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_fixture_component/edit/' . $save_jrp_fixture_component, 'Edit Jrp Fixture Component')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_fixture_component/index/'.$this->input->post('fixture_id'));
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_fixture_component/index/'.$this->input->post('fixture_id'));
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Fixture Components
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_fixture_component_update');

		$this->data['jrp_fixture_component'] = $this->model_jrp_fixture_component->find($id);

		$this->template->title('Fixture Component Update');
		$this->render('backend/standart/administrator/jrp_fixture_component/jrp_fixture_component_update', $this->data);
	}

	/**
	* Update Jrp Fixture Components
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_fixture_component_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('fixture_id', 'Fixture Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('component_id', 'Component Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'fixture_id' => $this->input->post('fixture_id'),
				'component_id' => $this->input->post('component_id'),
				'component_qty' => $this->input->post('component_qty'),
			];

			
			$save_jrp_fixture_component = $this->model_jrp_fixture_component->change($id, $save_data);

			if ($save_jrp_fixture_component) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_fixture_component', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_fixture_component');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_fixture_component');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Fixture Components
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_fixture_component_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_fixture_component'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_fixture_component'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Fixture Components
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_fixture_component_view');

		$this->data['jrp_fixture_component'] = $this->model_jrp_fixture_component->join_avaiable()->find($id);

		$this->template->title('Fixture Component Detail');
		$this->render('backend/standart/administrator/jrp_fixture_component/jrp_fixture_component_view', $this->data);
	}
	
	/**
	* delete Jrp Fixture Components
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_fixture_component = $this->model_jrp_fixture_component->find($id);

		
		
		return $this->model_jrp_fixture_component->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_fixture_component_export');

		$this->model_jrp_fixture_component->export('jrp_fixture_component', 'jrp_fixture_component');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_fixture_component_export');

		$this->model_jrp_fixture_component->pdf('jrp_fixture_component', 'jrp_fixture_component');
	}
}


/* End of file jrp_fixture_component.php */
/* Location: ./application/controllers/administrator/Jrp Fixture Component.php */