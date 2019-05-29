<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Book Fixture Detail Controller
*| --------------------------------------------------------------------------
*| Jrp Book Fixture Detail site
*|
*/
class Jrp_book_fixture_detail extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_book_fixture_detail');
	}

	/**
	* show all Jrp Book Fixture Details
	*
	* @var $offset String
	*/
	public function index($projectId, $offset = 0)
	{
		$this->is_allowed('jrp_book_fixture_detail_list');

        $filter = $this->input->get('q');
        $field 	= $this->input->get('f');

        $parent_field = $projectId;
		
		$select_fields = array('jrp_book_fixture_detail.*');

		$this->data['jrp_book_fixture_details'] = $this->model_jrp_book_fixture_detail->get($filter, $field,$parent_field, $this->limit_page, $offset,$select_fields);
		$this->data['jrp_book_fixture_detail_counts'] = $this->model_jrp_book_fixture_detail->count_all($filter, $field,$parent_field);
		
		$this->data['project_id'] = $projectId;
		
		$config = [
			'base_url'     => 'administrator/jrp_book_fixture_detail/index/'.$projectId.'/',
			'total_rows'   => $this->model_jrp_book_fixture_detail->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

        $this->data['alphabet'] = array('/','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Fixture Detail List');
		$this->render('backend/standart/administrator/jrp_book_fixture_detail/jrp_book_fixture_detail_list', $this->data);
	}

    public function change_revision()
    {

        //$this->is_allowed('jrp_book_layout_revision');
        //var_dump($_POST);die;
        $table_id = $_POST['id'];
        $revision = $_POST['revision'];

        //change revision
        $save_layout = [
            'date_revision' => date('Y-m-d'),
            'revision' => $revision
        ];

        $save_jrp_book_layout = $this->model_jrp_book_fixture_detail->change($table_id, $save_layout);


        echo 'success';
        exit();
    }
	
	/**
	* Add new jrp_book_fixture_details
	*
	*/
	public function add($project_id)
	{
		$this->is_allowed('jrp_book_fixture_detail_add');

		$this->template->title('Fixture Detail New');
		$this->data['project_id'] =$project_id;
		$this->render('backend/standart/administrator/jrp_book_fixture_detail/jrp_book_fixture_detail_add', $this->data);
	}

	/**
	* Add New Jrp Book Fixture Details
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_book_fixture_detail_add', false)) {
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
		
			$save_data = [
				'document_id' => $this->input->post('document_id'),
				'title' => $this->input->post('title'),
				'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_book_fixture_detail = $this->model_jrp_book_fixture_detail->store($save_data);

			if ($save_jrp_book_fixture_detail) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_book_fixture_detail;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_book_fixture_detail/edit/' . $save_jrp_book_fixture_detail, 'Edit Jrp Book Fixture Detail'),
						anchor('administrator/jrp_book_fixture_detail/index/'.$this->input->post('project_id'), ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_book_fixture_detail/edit/' . $save_jrp_book_fixture_detail, 'Edit Jrp Book Fixture Detail')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_fixture_detail/index/'.$this->input->post('project_id'));
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_fixture_detail/index/'.$this->input->post('project_id'));
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Book Fixture Details
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_book_fixture_detail_update');

		$this->data['jrp_book_fixture_detail'] = $this->model_jrp_book_fixture_detail->find($id);

		$this->template->title('Fixture Detail Update');
		$this->render('backend/standart/administrator/jrp_book_fixture_detail/jrp_book_fixture_detail_update', $this->data);
	}

	/**
	* Update Jrp Book Fixture Details
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_book_fixture_detail_update', false)) {
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
		
			$save_data = [
				'document_id' => $this->input->post('document_id'),
				'title' => $this->input->post('title'),
				'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_book_fixture_detail = $this->model_jrp_book_fixture_detail->change($id, $save_data);

			if ($save_jrp_book_fixture_detail) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_book_fixture_detail', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_fixture_detail');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_fixture_detail');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Book Fixture Details
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_book_fixture_detail_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_book_fixture_detail'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_book_fixture_detail'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Book Fixture Details
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_book_fixture_detail_view');

		$this->data['jrp_book_fixture_detail'] = $this->model_jrp_book_fixture_detail->join_avaiable()->find($id);

		$this->template->title('Fixture Detail Detail');
		$this->render('backend/standart/administrator/jrp_book_fixture_detail/jrp_book_fixture_detail_view', $this->data);
	}
	
	/**
	* delete Jrp Book Fixture Details
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_book_fixture_detail = $this->model_jrp_book_fixture_detail->find($id);

		
		
		return $this->model_jrp_book_fixture_detail->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_book_fixture_detail_export');

		$this->model_jrp_book_fixture_detail->export('jrp_book_fixture_detail', 'jrp_book_fixture_detail');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_book_fixture_detail_export');

		$this->model_jrp_book_fixture_detail->pdf('jrp_book_fixture_detail', 'jrp_book_fixture_detail');
	}
	
	public function export_pdf_layout($project_id)
	{
		$this->is_allowed('jrp_book_layout_export');
		$this->load->model('model_jrp_project_book');

		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_book_fixture_detail->pdf_layout('jrp_book_fixture_detail', 'Fixture Detail', $project);
	}
}


/* End of file jrp_book_fixture_detail.php */
/* Location: ./application/controllers/administrator/Jrp Book Fixture Detail.php */