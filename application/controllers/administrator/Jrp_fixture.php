<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Fixture Controller
*| --------------------------------------------------------------------------
*| Jrp Fixture site
*|
*/
class Jrp_fixture extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_fixture');
	}

	/**
	* show all Jrp Fixtures
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('jrp_fixture_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['jrp_fixtures'] = $this->model_jrp_fixture->get($filter, $field, $this->limit_page, $offset);
		$this->data['jrp_fixture_counts'] = $this->model_jrp_fixture->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/jrp_fixture/index/',
			'total_rows'   => $this->model_jrp_fixture->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Fixture List');
		$this->render('backend/standart/administrator/jrp_fixture/jrp_fixture_list', $this->data);
	}
	
	/**
	* Add new jrp_fixtures
	*
	*/
	public function add()
	{
		$this->is_allowed('jrp_fixture_add');

		$this->template->title('Fixture New');
		$this->render('backend/standart/administrator/jrp_fixture/jrp_fixture_add', $this->data);
	}

	/**
	* Add New Jrp Fixtures
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_fixture_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('code', 'Code', 'trim|required|max_length[5]');
		$this->form_validation->set_rules('jrp_fixture_image_ref_name', 'Image Ref', 'trim|required|max_length[512]');
		

		if ($this->form_validation->run()) {
			$jrp_fixture_image_ref_uuid = $this->input->post('jrp_fixture_image_ref_uuid');
			$jrp_fixture_image_ref_name = $this->input->post('jrp_fixture_image_ref_name');
		
			$save_data = [
				'code' => $this->input->post('code'),
			];

			if (!is_dir(FCPATH . '/uploads/jrp_fixture/')) {
				mkdir(FCPATH . '/uploads/jrp_fixture/');
			}

			if (!empty($jrp_fixture_image_ref_name)) {
				$jrp_fixture_image_ref_name_copy = date('YmdHis') . '-' . $jrp_fixture_image_ref_name;

				rename(FCPATH . 'uploads/tmp/' . $jrp_fixture_image_ref_uuid . '/' . $jrp_fixture_image_ref_name, 
						FCPATH . 'uploads/jrp_fixture/' . $jrp_fixture_image_ref_name_copy);

				if (!is_file(FCPATH . '/uploads/jrp_fixture/' . $jrp_fixture_image_ref_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image_ref'] = $jrp_fixture_image_ref_name_copy;
			}
		
			
			$save_jrp_fixture = $this->model_jrp_fixture->store($save_data);

			if ($save_jrp_fixture) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_fixture;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_fixture/edit/' . $save_jrp_fixture, 'Edit Jrp Fixture'),
						anchor('administrator/jrp_fixture', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_fixture/edit/' . $save_jrp_fixture, 'Edit Jrp Fixture')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_fixture');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_fixture');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Fixtures
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_fixture_update');

		$this->data['jrp_fixture'] = $this->model_jrp_fixture->find($id);

		$this->template->title('Fixture Update');
		$this->render('backend/standart/administrator/jrp_fixture/jrp_fixture_update', $this->data);
	}

	/**
	* Update Jrp Fixtures
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_fixture_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('code', 'Code', 'trim|required|max_length[5]');
		$this->form_validation->set_rules('jrp_fixture_image_ref_name', 'Image Ref', 'trim|required|max_length[512]');
		
		if ($this->form_validation->run()) {
			$jrp_fixture_image_ref_uuid = $this->input->post('jrp_fixture_image_ref_uuid');
			$jrp_fixture_image_ref_name = $this->input->post('jrp_fixture_image_ref_name');
		
			$save_data = [
				'code' => $this->input->post('code'),
			];

			if (!is_dir(FCPATH . '/uploads/jrp_fixture/')) {
				mkdir(FCPATH . '/uploads/jrp_fixture/');
			}

			if (!empty($jrp_fixture_image_ref_uuid)) {
				$jrp_fixture_image_ref_name_copy = date('YmdHis') . '-' . $jrp_fixture_image_ref_name;

				rename(FCPATH . 'uploads/tmp/' . $jrp_fixture_image_ref_uuid . '/' . $jrp_fixture_image_ref_name, 
						FCPATH . 'uploads/jrp_fixture/' . $jrp_fixture_image_ref_name_copy);

				if (!is_file(FCPATH . '/uploads/jrp_fixture/' . $jrp_fixture_image_ref_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image_ref'] = $jrp_fixture_image_ref_name_copy;
			}
		
			
			$save_jrp_fixture = $this->model_jrp_fixture->change($id, $save_data);

			if ($save_jrp_fixture) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_fixture', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_fixture');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_fixture');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Fixtures
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_fixture_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_fixture'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_fixture'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Fixtures
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_fixture_view');

		$this->data['jrp_fixture'] = $this->model_jrp_fixture->join_avaiable()->find($id);

		$this->template->title('Fixture Detail');
		$this->render('backend/standart/administrator/jrp_fixture/jrp_fixture_view', $this->data);
	}
	
	/**
	* delete Jrp Fixtures
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_fixture = $this->model_jrp_fixture->find($id);

		if (!empty($jrp_fixture->image_ref)) {
			$path = FCPATH . '/uploads/jrp_fixture/' . $jrp_fixture->image_ref;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_jrp_fixture->remove($id);
	}
	
	/**
	* Upload Image Jrp Fixture	* 
	* @return JSON
	*/
	public function upload_image_ref_file()
	{
		if (!$this->is_allowed('jrp_fixture_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'jrp_fixture',
		]);
	}

	/**
	* Delete Image Jrp Fixture	* 
	* @return JSON
	*/
	public function delete_image_ref_file($uuid)
	{
		if (!$this->is_allowed('jrp_fixture_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'image_ref', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'jrp_fixture',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/jrp_fixture/'
        ]);
	}

	/**
	* Get Image Jrp Fixture	* 
	* @return JSON
	*/
	public function get_image_ref_file($id)
	{
		if (!$this->is_allowed('jrp_fixture_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$jrp_fixture = $this->model_jrp_fixture->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'image_ref', 
            'table_name'        => 'jrp_fixture',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/jrp_fixture/',
            'delete_endpoint'   => 'administrator/jrp_fixture/delete_image_ref_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_fixture_export');

		$this->model_jrp_fixture->export('jrp_fixture', 'jrp_fixture');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_fixture_export');

		$this->model_jrp_fixture->pdf('jrp_fixture', 'jrp_fixture');
	}
}


/* End of file jrp_fixture.php */
/* Location: ./application/controllers/administrator/Jrp Fixture.php */