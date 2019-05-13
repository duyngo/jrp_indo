<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Book Layout History Controller
*| --------------------------------------------------------------------------
*| Jrp Book Layout History site
*|
*/
class Jrp_book_layout_history extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_book_layout_history');
	}

	/**
	* show all Jrp Book Layout Historys
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('jrp_book_layout_history_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['jrp_book_layout_historys'] = $this->model_jrp_book_layout_history->get($filter, $field, $this->limit_page, $offset);
		$this->data['jrp_book_layout_history_counts'] = $this->model_jrp_book_layout_history->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/jrp_book_layout_history/index/',
			'total_rows'   => $this->model_jrp_book_layout_history->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Jrp Book Layout History List');
		$this->render('backend/standart/administrator/jrp_book_layout_history/jrp_book_layout_history_list', $this->data);
	}
	
	/**
	* Add new jrp_book_layout_historys
	*
	*/
	public function add()
	{
		$this->is_allowed('jrp_book_layout_history_add');

		$this->template->title('Jrp Book Layout History New');
		$this->render('backend/standart/administrator/jrp_book_layout_history/jrp_book_layout_history_add', $this->data);
	}

	/**
	* Add New Jrp Book Layout Historys
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_book_layout_history_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('layout_id', 'Layout Id', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('revision_no', 'Revision No', 'trim|required|max_length[2]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'layout_id' => $this->input->post('layout_id'),
				'date' => $this->input->post('date'),
				'revision_no' => $this->input->post('revision_no'),
			];

			
			$save_jrp_book_layout_history = $this->model_jrp_book_layout_history->store($save_data);

			if ($save_jrp_book_layout_history) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_book_layout_history;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_book_layout_history/edit/' . $save_jrp_book_layout_history, 'Edit Jrp Book Layout History'),
						anchor('administrator/jrp_book_layout_history', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_book_layout_history/edit/' . $save_jrp_book_layout_history, 'Edit Jrp Book Layout History')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_layout_history');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_layout_history');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Book Layout Historys
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_book_layout_history_update');

		$this->data['jrp_book_layout_history'] = $this->model_jrp_book_layout_history->find($id);

		$this->template->title('Jrp Book Layout History Update');
		$this->render('backend/standart/administrator/jrp_book_layout_history/jrp_book_layout_history_update', $this->data);
	}

	/**
	* Update Jrp Book Layout Historys
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_book_layout_history_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('layout_id', 'Layout Id', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('revision_no', 'Revision No', 'trim|required|max_length[2]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'layout_id' => $this->input->post('layout_id'),
				'date' => $this->input->post('date'),
				'revision_no' => $this->input->post('revision_no'),
			];

			
			$save_jrp_book_layout_history = $this->model_jrp_book_layout_history->change($id, $save_data);

			if ($save_jrp_book_layout_history) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_book_layout_history', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_layout_history');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_layout_history');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Book Layout Historys
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_book_layout_history_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_book_layout_history'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_book_layout_history'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Book Layout Historys
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_book_layout_history_view');

		$this->data['jrp_book_layout_history'] = $this->model_jrp_book_layout_history->join_avaiable()->find($id);

		$this->template->title('Jrp Book Layout History Detail');
		$this->render('backend/standart/administrator/jrp_book_layout_history/jrp_book_layout_history_view', $this->data);
	}
	
	/**
	* delete Jrp Book Layout Historys
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_book_layout_history = $this->model_jrp_book_layout_history->find($id);

		
		
		return $this->model_jrp_book_layout_history->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_book_layout_history_export');

		$this->model_jrp_book_layout_history->export('jrp_book_layout_history', 'jrp_book_layout_history');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_book_layout_history_export');

		$this->model_jrp_book_layout_history->pdf('jrp_book_layout_history', 'jrp_book_layout_history');
	}
}


/* End of file jrp_book_layout_history.php */
/* Location: ./application/controllers/administrator/Jrp Book Layout History.php */