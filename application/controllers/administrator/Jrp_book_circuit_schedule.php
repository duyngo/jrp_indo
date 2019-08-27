<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Book Circuit Schedule Controller
*| --------------------------------------------------------------------------
*| Jrp Book Circuit Schedule site
*|
*/
class Jrp_book_circuit_schedule extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_book_circuit_schedule');
	}

	/**
	* show all Jrp Book Circuit Schedules
	*
	* @var $offset String
	*/
	public function index($projectId, $offset = 0)
	{
		$this->is_allowed('jrp_book_circuit_schedule_list');

        $filter = $this->input->get('q');
        $field 	= $this->input->get('f');

        $parent_field = $projectId;


		$select_fields = array("jrp_book_circuit_schedule.*","jrp_book_circuit.id AS 'cid'","jrp_book_circuit.circuit AS 'circuit_code'","jrp_fixture.code AS 'fixtures_code'","jrp_mstr_load_type.name AS 'load_name'","jrp_project_app_detail.document_id");
		
		$this->data['jrp_book_circuit_schedules'] = $this->model_jrp_book_circuit_schedule->get($filter, $field,$parent_field, $this->limit_page, $offset, $select_fields);
		$this->data['jrp_book_circuit_schedule_counts'] = $this->model_jrp_book_circuit_schedule->count_all($filter, $field,$parent_field);

		$config = [
			'base_url'     => 'administrator/jrp_book_circuit_schedule/index/'.$projectId.'/',
			'total_rows'   => $this->model_jrp_book_circuit_schedule->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);
		
		$this->data['project_id'] = $projectId;
		$this->template->title('Circuit Schedule List');
		$this->render('backend/standart/administrator/jrp_book_circuit_schedule/jrp_book_circuit_schedule_list', $this->data);
	}
	
	/**
	* Add new jrp_book_circuit_schedules
	*
	*/
	public function add($projectId)
	{
		$this->data['project_id'] = $projectId;
		
		$this->is_allowed('jrp_book_circuit_schedule_add');

		$this->template->title('Circuit Schedule New');
		$this->render('backend/standart/administrator/jrp_book_circuit_schedule/jrp_book_circuit_schedule_add', $this->data);
	}

	/**
	* Add New Jrp Book Circuit Schedules
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_book_circuit_schedule_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('circuit_id', 'Circuit Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('feed_from', 'Feed From', 'trim|max_length[128]');
		$this->form_validation->set_rules('dim_rack', 'Dim Rack', 'trim|max_length[128]');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|max_length[11]');
		$this->form_validation->set_rules('fixtures', 'Fixtures', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('AD', 'AD', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('load_type', 'Load Type', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'circuit_id' => $this->input->post('circuit_id'),
				'feed_from' => $this->input->post('feed_from'),
				'dim_rack' => $this->input->post('dim_rack'),
				'quantity' => $this->input->post('quantity'),
				'fixtures' => $this->input->post('fixtures'),
				'AD' => $this->input->post('AD'),
				'load_type' => $this->input->post('load_type'),
				'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_book_circuit_schedule = $this->model_jrp_book_circuit_schedule->store($save_data);

			if ($save_jrp_book_circuit_schedule) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_book_circuit_schedule;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_book_circuit_schedule/edit/' . $save_jrp_book_circuit_schedule, 'Edit Jrp Book Circuit Schedule'),
						anchor('administrator/jrp_book_circuit_schedule', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_book_circuit_schedule/edit/' . $save_jrp_book_circuit_schedule, 'Edit Jrp Book Circuit Schedule')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_circuit_schedule/index/'.$this->input->post('project_id'));
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_circuit_schedule/index/'.$this->input->post('project_id'));
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Book Circuit Schedules
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_book_circuit_schedule_update');

		$this->data['jrp_book_circuit_schedule'] = $this->model_jrp_book_circuit_schedule->find($id);

		$this->template->title('Circuit Schedule Update');
		$this->render('backend/standart/administrator/jrp_book_circuit_schedule/jrp_book_circuit_schedule_update', $this->data);
	}

	/**
	* Update Jrp Book Circuit Schedules
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_book_circuit_schedule_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('circuit_id', 'Circuit Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('feed_from', 'Feed From', 'trim|max_length[128]');
		$this->form_validation->set_rules('dim_rack', 'Dim Rack', 'trim|max_length[128]');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|max_length[11]');
		$this->form_validation->set_rules('fixtures', 'Fixtures', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('AD', 'AD', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('load_type', 'Load Type', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'circuit_id' => $this->input->post('circuit_id'),
				'feed_from' => $this->input->post('feed_from'),
				'dim_rack' => $this->input->post('dim_rack'),
				'quantity' => $this->input->post('quantity'),
				'fixtures' => $this->input->post('fixtures'),
				'AD' => $this->input->post('AD'),
				'load_type' => $this->input->post('load_type'),
				'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_book_circuit_schedule = $this->model_jrp_book_circuit_schedule->change($id, $save_data);

			if ($save_jrp_book_circuit_schedule) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_book_circuit_schedule', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_circuit_schedule/index/'.$this->input->post('project_id'));
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_circuit_schedule/index/'.$this->input->post('project_id'));
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Book Circuit Schedules
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_book_circuit_schedule_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_book_circuit_schedule'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_book_circuit_schedule'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Book Circuit Schedules
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_book_circuit_schedule_view');

		$this->data['jrp_book_circuit_schedule'] = $this->model_jrp_book_circuit_schedule->join_avaiable()->find($id);

		$this->template->title('Circuit Schedule Detail');
		$this->render('backend/standart/administrator/jrp_book_circuit_schedule/jrp_book_circuit_schedule_view', $this->data);
	}
	
	/**
	* delete Jrp Book Circuit Schedules
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_book_circuit_schedule = $this->model_jrp_book_circuit_schedule->find($id);

		
		
		return $this->model_jrp_book_circuit_schedule->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_book_circuit_schedule_export');

		$this->model_jrp_book_circuit_schedule->export('jrp_book_circuit_schedule', 'jrp_book_circuit_schedule');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_book_circuit_schedule_export');

		$this->model_jrp_book_circuit_schedule->pdf('jrp_book_circuit_schedule', 'jrp_book_circuit_schedule');
	}
}


/* End of file jrp_book_circuit_schedule.php */
/* Location: ./application/controllers/administrator/Jrp Book Circuit Schedule.php */