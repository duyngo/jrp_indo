<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Book Circuit Controller
*| --------------------------------------------------------------------------
*| Jrp Book Circuit site
*|
*/
class Jrp_book_circuit extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_book_circuit');
	}

	/**
	* show all Jrp Book Circuits
	*
	* @var $offset String
	*/
	public function index($projectId, $offset = 0)
	{
		$this->is_allowed('jrp_book_circuit_list');

        $filter = $this->input->get('q');
        $field 	= $this->input->get('f');

        $parent_field = $projectId;


		$fields = array('jrp_book_circuit.*','jrp_book_layout.document_id');
		$this->data['jrp_book_circuits'] = $this->model_jrp_book_circuit->get($filter, $field,$parent_field, $this->limit_page, $offset,$fields);
		$this->data['jrp_book_circuit_counts'] = $this->model_jrp_book_circuit->count_all($filter, $field,$parent_field);
		$this->data['project_id'] = $projectId;
		
		$config = [
			'base_url'     => 'administrator/jrp_book_circuit/index/'.$projectId.'/',
			'total_rows'   => $this->model_jrp_book_circuit->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Book Circuit List');
		$this->render('backend/standart/administrator/jrp_book_circuit/jrp_book_circuit_list', $this->data);
	}
	
	/**
	* Add new jrp_book_circuits
	*
	*/
	public function add($project_id)
	{
		$this->is_allowed('jrp_book_circuit_add');

		$this->template->title('Book Circuit New');
		$this->data['project_id'] = $project_id;
		$this->render('backend/standart/administrator/jrp_book_circuit/jrp_book_circuit_add', $this->data);
	}

	/**
	* Add New Jrp Book Circuits
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_book_circuit_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('project_Id', 'Project Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('layout_id', 'Layout Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('circuit', 'Circuit', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|max_length[11]');

		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'project_Id' => $this->input->post('project_Id'),
				'layout_id' => $this->input->post('layout_id'),
				'circuit' => $this->input->post('circuit'),
				'quantity' => $this->input->post('quantity'),
				'circuit_desc' => $this->input->post('circuit_desc'),
			];

			
			$save_jrp_book_circuit = $this->model_jrp_book_circuit->store($save_data);

			if ($save_jrp_book_circuit) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_book_circuit;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_book_circuit/edit/' . $save_jrp_book_circuit, 'Edit Jrp Book Circuit'),
						anchor('administrator/jrp_book_circuit', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_book_circuit/edit/' . $save_jrp_book_circuit, 'Edit Jrp Book Circuit')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_circuit/index/'.$this->input->post('project_Id'));
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_circuit/index/'.$this->input->post('project_Id'));
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Book Circuits
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_book_circuit_update');

		$this->data['jrp_book_circuit'] = $this->model_jrp_book_circuit->find($id);

		$this->template->title('Book Circuit Update');
		$this->render('backend/standart/administrator/jrp_book_circuit/jrp_book_circuit_update', $this->data);
	}

	/**
	* Update Jrp Book Circuits
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_book_circuit_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('project_Id', 'Project Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('layout_id', 'Layout Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('circuit', 'Circuit', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|max_length[11]');

        $project_id = $_POST['project_id'];

		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'project_Id' => $this->input->post('project_Id'),
				'layout_id' => $this->input->post('layout_id'),
				'circuit' => $this->input->post('circuit'),
				'quantity' => $this->input->post('quantity'),
				'circuit_desc' => $this->input->post('circuit_desc'),
			];

			
			$save_jrp_book_circuit = $this->model_jrp_book_circuit->change($id, $save_data);

			if ($save_jrp_book_circuit) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor("administrator/jrp_book_circuit/index/$project_id", ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url("administrator/jrp_book_circuit/index/$project_id");
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_circuit');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Book Circuits
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_book_circuit_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_book_circuit'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_book_circuit'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Book Circuits
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_book_circuit_view');

		$this->data['jrp_book_circuit'] = $this->model_jrp_book_circuit->join_avaiable()->find($id, array("jrp_book_circuit.*", "jrp_book_layout.document_id", "jrp_project_book.name"));

		$this->template->title('Book Circuit Detail');
		$this->render('backend/standart/administrator/jrp_book_circuit/jrp_book_circuit_view', $this->data);
	}
	
	/**
	* delete Jrp Book Circuits
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_book_circuit = $this->model_jrp_book_circuit->find($id);

		
		
		return $this->model_jrp_book_circuit->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_book_circuit_export');

		$this->model_jrp_book_circuit->export('jrp_book_circuit', 'jrp_book_circuit');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_book_circuit_export');

		$this->model_jrp_book_circuit->pdf('jrp_book_circuit', 'jrp_book_circuit');
	}
}


/* End of file jrp_book_circuit.php */
/* Location: ./application/controllers/administrator/Jrp Book Circuit.php */