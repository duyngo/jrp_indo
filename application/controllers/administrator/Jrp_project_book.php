<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Project Book Controller
*| --------------------------------------------------------------------------
*| Jrp Project Book site
*|
*/
class Jrp_project_book extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_project_book');
	}

	/**
	* show all Jrp Project Books
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('jrp_project_book_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['jrp_project_books'] = $this->model_jrp_project_book->get($filter, $field, $this->limit_page, $offset);
		$this->data['jrp_project_book_counts'] = $this->model_jrp_project_book->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/jrp_project_book/index/',
			'total_rows'   => $this->model_jrp_project_book->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Project Book List');
		$this->render('backend/standart/administrator/jrp_project_book/jrp_project_book_list', $this->data);
	}
	
	/**
	* Add new jrp_project_books
	*
	*/
	public function add()
	{
		$this->is_allowed('jrp_project_book_add');

		$this->template->title('Project Book New');
		$this->render('backend/standart/administrator/jrp_project_book/jrp_project_book_add', $this->data);
	}

	/**
	* Add New Jrp Project Books
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_project_book_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'name' => $this->input->post('name'),
			];

			
			$save_jrp_project_book = $this->model_jrp_project_book->store($save_data);

			if ($save_jrp_project_book) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_project_book;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_project_book/edit/' . $save_jrp_project_book, 'Edit Jrp Project Book'),
						anchor('administrator/jrp_project_book', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_project_book/edit/' . $save_jrp_project_book, 'Edit Jrp Project Book')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_project_book');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_project_book');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Project Books
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_project_book_update');

		$this->data['jrp_project_book'] = $this->model_jrp_project_book->find($id);

		$this->template->title('Project Book Update');
		$this->render('backend/standart/administrator/jrp_project_book/jrp_project_book_update', $this->data);
	}

	/**
	* Update Jrp Project Books
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_project_book_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'name' => $this->input->post('name'),
			];

			
			$save_jrp_project_book = $this->model_jrp_project_book->change($id, $save_data);

			if ($save_jrp_project_book) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_project_book', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_project_book');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_project_book');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Project Books
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_project_book_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_project_book'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_project_book'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Project Books
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_project_book_view');

		$this->data['jrp_project_book'] = $this->model_jrp_project_book->join_avaiable()->find($id);

		$this->data['alphabet'] = array('/','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

		$this->template->title('Project Book Detail');
		$this->render('backend/standart/administrator/jrp_project_book/jrp_project_book_view', $this->data);
	}
	
	/**
	* delete Jrp Project Books
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_project_book = $this->model_jrp_project_book->find($id);

		
		
		return $this->model_jrp_project_book->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_project_book_export');

		$this->model_jrp_project_book->export('jrp_project_book', 'jrp_project_book');
	}

	public function vew_all_pdf($project_id){


        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);

        $this->load->model('model_jrp_book_layout');
        $this->load->model('model_jrp_project_app_detail');
        $this->load->model('model_jrp_book_fixture_detail');
        //$this->load->model('model_jrp_project_app_detail');

        //$this->load->model('model_jrp_project_app_detail');

        //$project_id = $_POST['project_id'];
        $full_content = '';

        $project = $this->model_jrp_project_book->get_single("id = ".$project_id);

        $full_content .= $this->model_jrp_book_layout->pdf_layout('jrp_book_layout', 'Layout', $project, true);
        $full_content .= $this->model_jrp_project_app_detail->pdf_layout('jrp_project_app_detail', 'Application Detail', $project, true);
        $full_content .= $this->model_jrp_book_fixture_detail->pdf_layout('jrp_book_fixture_detail', 'Fixture Detail', $project,true);
        $full_content .= $this->model_jrp_project_book->pdf_agent('jrp_book_circuit_schedule','Agent List',$project, true);
        $full_content .= $this->model_jrp_project_book->pdf_fixtures_note($project, true);
        $full_content .= $this->model_jrp_project_book->pdf_fixture_spec('jrp_book_layout','Layout',$project, 'true');
        $full_content .= $this->model_jrp_project_book->pdf_circuit_qty('jrp_book_circuit','Circuit Quantities',$project, true);
        $full_content .= $this->model_jrp_project_book->pdf_fixture_qty('jrp_book_circuit_schedule','Fixture Quantities',$project, true);
        $full_content .= $this->model_jrp_project_book->pdf_component_qty('jrp_book_circuit_schedule','Component Quantities',$project, true);
        $full_content .= $this->model_jrp_project_book->pdf_schedule_note($project, true);
        $full_content .= $this->model_jrp_project_book->pdf_circuit_schedule('jrp_book_circuit_schedule','Circuit & Dimming Schedule',$project, true);
        $full_content .= $this->model_jrp_project_book->pdf_lcp('jrp_project_lcp','LCP',$project, true);
        $full_content .= $this->model_jrp_project_book->pdf_dimming('jrp_book_dimming_setting','DIMMING SETTING',$project, true);


        $this->load->library('HtmlPdf');

        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(15, 15, 15, 15)
        );
        $this->pdf = new HtmlPdf($config);

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullwidth');
        $this->pdf->writeHTML(trim($full_content));

        $pdf_name = "vew_all_pdf.pdf";
        $this->pdf->Output(FCPATH . "/uploads/pdf/$pdf_name", 'F');
        echo $pdf_name;

    }

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function download_pdf($path)
	{
		//$this->is_allowed('jrp_project_book_export');

		//$this->model_jrp_project_book->pdf('jrp_project_book', 'jrp_project_book');

		$path = FCPATH."uploads/test/cover.pdf";
		echo($path);
		// EDIT: I added some permission/file checking.
		if (!file_exists($path)) {
		    throw new Exception("File $path does not exist");
		}
		if (!is_readable($filepath)) {
		    throw new Exception("File $path is not readable");
		}
		http_response_code(200);
		header('Content-Length: '.filesize($path));
		header("Content-Type: application/pdf");
		header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
		readfile($path);
		
		exit; // this is important so that Co
	}
	
	
	public function export_pdf_fixtures_note($project_id)
	{
		$this->is_allowed('jrp_book_layout_export');
		
		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_project_book->pdf_fixtures_note($project, false, true);

	}
	
	public function export_pdf_fixtures_spec($project_id)
	{
//		$this->is_allowed('jrp_book_layout_export');
		
		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_project_book->pdf_fixture_spec('jrp_book_layout','Layout',$project, false, true);
	}


	public function export_pdf_circuit_qty($project_id)
	{
		$this->is_allowed('jrp_book_layout_export');
		
		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_project_book->pdf_circuit_qty('jrp_book_circuit','Circuit Quantities',$project, false, true);
	}

    public function export_pdf_agent($project_id)
    {
        //$this->is_allowed('jrp_book_layout_export');

        $project = $this->model_jrp_project_book->get_single("id = ".$project_id);

        $this->model_jrp_project_book->pdf_agent('jrp_book_circuit_schedule','Agent List',$project, false, true);
    }

    public function export_pdf_lcp($project_id)
    {
        $this->is_allowed('jrp_book_layout_export');

        $project = $this->model_jrp_project_book->get_single("id = ".$project_id);

        $this->model_jrp_project_book->pdf_lcp('jrp_project_lcp','LCP',$project, false, true);
    }
    public function export_pdf_dimming($project_id)
    {
        $this->is_allowed('jrp_book_layout_export');

        $project = $this->model_jrp_project_book->get_single("id = ".$project_id);

        $this->model_jrp_project_book->pdf_dimming('jrp_book_dimming_setting','DIMMING SETTING',$project, false, true);
    }
	
	public function export_pdf_fixture_qty($project_id)
	{
		$this->is_allowed('jrp_book_layout_export');
		
		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_project_book->pdf_fixture_qty('jrp_book_circuit_schedule','Fixture Quantities',$project, false, true);
	}
	
	public function export_pdf_component_qty($project_id)
	{
		$this->is_allowed('jrp_book_layout_export');
		
		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_project_book->pdf_component_qty('jrp_book_circuit_schedule','Component Quantities',$project, false, true);
	}
	
	public function export_pdf_schedule_note($project_id)
	{
		$this->is_allowed('jrp_book_layout_export');
		
		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_project_book->pdf_schedule_note($project, false, true);
	}

    public function export_pdf_cover($project_id)
    {
        $this->is_allowed('jrp_book_layout_export');

        $project = $this->model_jrp_project_book->get_single("id = ".$project_id);

        $this->model_jrp_project_book->pdf_cover($project);
    }
	
	
	public function export_pdf_circuit_schedule($project_id)
	{
		$this->is_allowed('jrp_book_layout_export');
		
		$project = $this->model_jrp_project_book->get_single("id = ".$project_id);

		$this->model_jrp_project_book->pdf_circuit_schedule('jrp_book_circuit_schedule','Circuit & Dimming Schedule',$project, false, true);
	}
}


/* End of file jrp_project_book.php */
/* Location: ./application/controllers/administrator/Jrp Project Book.php */