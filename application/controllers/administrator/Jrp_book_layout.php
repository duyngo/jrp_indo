<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Book Layout Controller
*| --------------------------------------------------------------------------
*| Jrp Book Layout site
*|
*/
class Jrp_book_layout extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_book_layout');
		$this->load->model('model_jrp_project_book');
		$this->load->model('model_jrp_book_layout_history');
	}

	/**
	* show all Jrp Book Layouts
	*
	* @var $offset String
	*/
	public function index($projectId, $offset = 0)
	{
		$this->is_allowed('jrp_book_layout_list');

        $filter = $this->input->get('q');
        $field 	= $this->input->get('f');

        $parent_field = $projectId;

		$select_fields = array('jrp_book_layout.*');
		$this->data['jrp_book_layouts'] = $this->model_jrp_book_layout->get($filter, $field,$parent_field, $this->limit_page, $offset,$select_fields);
		$this->data['jrp_book_layout_counts'] = $this->model_jrp_book_layout->count_all($filter, $field,$parent_field);
		$this->data['project_id']=$projectId;
		$config = [
			'base_url'     => 'administrator/jrp_book_layout/index/'.$projectId.'/',
			'total_rows'   => $this->model_jrp_book_layout->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

        $this->data['alphabet'] = array('/','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');


        $this->template->title('Book Layout List');
		$this->render('backend/standart/administrator/jrp_book_layout/jrp_book_layout_list', $this->data);
	}
	
	/**
	* Add new jrp_book_layouts
	*
	*/
	public function add($project_id)
	{
		$this->is_allowed('jrp_book_layout_add');

		$this->template->title('Book Layout New');
		$this->data["project_id"] = $project_id;
		$this->render('backend/standart/administrator/jrp_book_layout/jrp_book_layout_add', $this->data);
	}

	/**
	* Add New Jrp Book Layouts
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_book_layout_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		

		$this->form_validation->set_rules('document_id', 'Document Id', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
		

		if ($this->form_validation->run()) {
			$project_id = $this->input->post('project_id');
			
			$save_data = [
				'document_id' => $this->input->post('document_id'),
				'title' => $this->input->post('title'),
				'project_id' => $project_id,
			];

			
			$save_jrp_book_layout = $this->model_jrp_book_layout->store($save_data);

			if ($save_jrp_book_layout) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_book_layout;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_book_layout/edit/' . $save_jrp_book_layout, 'Edit Jrp Book Layout'),
						anchor('administrator/jrp_book_layout/index/'.$project_id, ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_book_layout/edit/' . $save_jrp_book_layout, 'Edit Jrp Book Layout')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_layout/index/'.$project_id);
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_layout/index/'.$project_id);
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Book Layouts
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_book_layout_update');

		$this->data['jrp_book_layout'] = $this->model_jrp_book_layout->find($id);

		$this->template->title('Book Layout Update');
		$this->render('backend/standart/administrator/jrp_book_layout/jrp_book_layout_update', $this->data);
	}

	/**
	* Update Jrp Book Layouts
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_book_layout_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('document_id', 'Document Id', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[128]');

        $project_id = $_POST['project_id'];
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'document_id' => $this->input->post('document_id'),
				'title' => $this->input->post('title'),
				//'project_id' => $this->input->post('project_id'),
			];

			
			$save_jrp_book_layout = $this->model_jrp_book_layout->change($id, $save_data);

			if ($save_jrp_book_layout) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_book_layout/index/'.$project_id, ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_book_layout/index/'.$project_id);
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_book_layout');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Book Layouts
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_book_layout_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_book_layout'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_book_layout'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Book Layouts
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_book_layout_view');

		$this->data['jrp_book_layout'] = $this->model_jrp_book_layout->join_avaiable()->find($id, array('jrp_book_layout.*, jrp_project_book.name'));

		$this->template->title('Book Layout Detail');
		$this->render('backend/standart/administrator/jrp_book_layout/jrp_book_layout_view', $this->data);
	}
	
	/**
	* delete Jrp Book Layouts
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_book_layout = $this->model_jrp_book_layout->find($id);

		
		
		return $this->model_jrp_book_layout->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_book_layout_export');

		$this->model_jrp_book_layout->export('jrp_book_layout', 'jrp_book_layout');
	}
	
	public function export_pdf_layout($project_id)
	{
		$this->is_allowed('jrp_book_layout_export');
		
		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_book_layout->pdf_layout('jrp_book_layout', 'Layout', $project);
	}


	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_book_layout_export');

		$this->model_jrp_book_layout->pdf('jrp_book_layout', 'jrp_book_layout');
	}
	
	
	public function change_revision()
	{

        //$this->is_allowed('jrp_book_layout_revision');
	    //var_dump($_POST);die;
        $layout_id = $_POST['id'];
        $revision = $_POST['revision'];

        //change revision
        $save_layout = [
            'date_revision' => date('Y-m-d'),
            'revision' => $revision
        ];

        $save_jrp_book_layout = $this->model_jrp_book_layout->change($layout_id, $save_layout);


        echo 'success';
		exit();
	}
    public function next_revision($layout_id)
    {

        $total_revision = $this->model_jrp_book_layout_history->count_all($layout_id,'layout_id');
        if($total_revision == 0) {
            $save_data = [
                'layout_id' => $layout_id,
                'date' => date('Y-m-d'),
                'revision_no' => '/',
            ];

            $save_jrp_book_layout_history = $this->model_jrp_book_layout_history->store($save_data);

            if ($save_jrp_book_layout_history) {
                $save_layout = [
                    'revision' => $save_jrp_book_layout_history
                ];


                $save_jrp_book_layout = $this->model_jrp_book_layout->change($layout_id, $save_layout);
                if($save_jrp_book_layout) {
                    set_message(
                        'Revision success', 'success');
                }
                else {
                    set_message(
                        'Revision failed', 'failed');
                }

            } else {
                set_message(
                    'Revision failed', 'failed');
            }
        }
        else {

        }

        redirect_back();
    }
}


/* End of file jrp_book_layout.php */
/* Location: ./application/controllers/administrator/Jrp Book Layout.php */