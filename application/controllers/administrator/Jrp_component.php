<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Component Controller
*| --------------------------------------------------------------------------
*| Jrp Component site
*|
*/
class Jrp_component extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_component');
	}

	/**
	* show all Jrp Components
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('jrp_component_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		
		$select_fields = array('jrp_component.*');
		$this->data['jrp_components'] = $this->model_jrp_component->get($filter, $field, $this->limit_page, $offset, $select_fields);
		$this->data['jrp_component_counts'] = $this->model_jrp_component->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/jrp_component/index/',
			'total_rows'   => $this->model_jrp_component->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Component List');
		$this->render('backend/standart/administrator/jrp_component/jrp_component_list', $this->data);
	}
	
	/**
	* Add new jrp_components
	*
	*/
	public function add()
	{
		$this->is_allowed('jrp_component_add');

		$this->template->title('Component New');
		$this->render('backend/standart/administrator/jrp_component/jrp_component_add', $this->data);
	}

	/**
	* Add New Jrp Components
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_component_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[512]');
		$this->form_validation->set_rules('catalog_number', 'Catalog Number', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('manufacturer', 'Manufacturer', 'trim|required');
		$this->form_validation->set_rules('finishing', 'Finishing', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('watt', 'Watt', 'trim|max_length[11]');
		$this->form_validation->set_rules('width', 'Width', 'trim');
		$this->form_validation->set_rules('length', 'Length', 'trim');
		$this->form_validation->set_rules('depth', 'Depth', 'trim');
		$this->form_validation->set_rules('jrp_component_image_ref_name', 'Image Ref', 'trim');
		$this->form_validation->set_rules('notes', 'Notes', 'trim');
		

		if ($this->form_validation->run()) {
			$jrp_component_image_ref_uuid = $this->input->post('jrp_component_image_ref_uuid');
			$jrp_component_image_ref_name = $this->input->post('jrp_component_image_ref_name');
		
			$save_data = [
				'name' => $this->input->post('name'),
				'catalog_number' => $this->input->post('catalog_number'),
				'manufacturer' => $this->input->post('manufacturer'),
				'finishing' => $this->input->post('finishing'),
				'watt' => (empty($this->input->post('watt')) ? NULL : $this->input->post('watt')),
				'width' => (empty($this->input->post('width')) ? NULL : $this->input->post('length')),
				'length' => (empty($this->input->post('length')) ? NULL : $this->input->post('length')),
				'depth' => (empty($this->input->post('depth')) ? NULL : $this->input->post('depth')),
				'notes' => $this->input->post('notes'),
			];

			if (!is_dir(FCPATH . '/uploads/jrp_component/')) {
				mkdir(FCPATH . '/uploads/jrp_component/');
			}

			if (!empty($jrp_component_image_ref_name)) {
				$jrp_component_image_ref_name_copy = date('YmdHis') . '-' . $jrp_component_image_ref_name;

				rename(FCPATH . 'uploads/tmp/' . $jrp_component_image_ref_uuid . '/' . $jrp_component_image_ref_name, 
						FCPATH . 'uploads/jrp_component/' . $jrp_component_image_ref_name_copy);

				if (!is_file(FCPATH . '/uploads/jrp_component/' . $jrp_component_image_ref_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image_ref'] = $jrp_component_image_ref_name_copy;
			}
		
			
			$save_jrp_component = $this->model_jrp_component->store($save_data);

			if ($save_jrp_component) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_component;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_component/edit/' . $save_jrp_component, 'Edit Jrp Component'),
						anchor('administrator/jrp_component', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_component/edit/' . $save_jrp_component, 'Edit Jrp Component')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_component');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_component');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Components
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_component_update');

		$this->data['jrp_component'] = $this->model_jrp_component->find($id);

		$this->template->title('Component Update');
		$this->render('backend/standart/administrator/jrp_component/jrp_component_update', $this->data);
	}

	/**
	* Update Jrp Components
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_component_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[512]');
		$this->form_validation->set_rules('catalog_number', 'Catalog Number', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('manufacturer', 'Manufacturer', 'trim|required');
		$this->form_validation->set_rules('finishing', 'Finishing', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('watt', 'Watt', 'trim|max_length[11]');
		$this->form_validation->set_rules('width', 'Width', 'trim');
		$this->form_validation->set_rules('length', 'Length', 'trim');
		$this->form_validation->set_rules('depth', 'Depth', 'trim');
		$this->form_validation->set_rules('jrp_component_image_ref_name', 'Image Ref', 'trim');
		$this->form_validation->set_rules('notes', 'Notes', 'trim');
		
		if ($this->form_validation->run()) {
			$jrp_component_image_ref_uuid = $this->input->post('jrp_component_image_ref_uuid');
			$jrp_component_image_ref_name = $this->input->post('jrp_component_image_ref_name');
		
			$save_data = [
				'name' => $this->input->post('name'),
				'catalog_number' => $this->input->post('catalog_number'),
				'manufacturer' => $this->input->post('manufacturer'),
				'finishing' => $this->input->post('finishing'),
				'watt' => (empty($this->input->post('watt')) ? NULL : $this->input->post('watt')),
				'width' => (empty($this->input->post('width')) ? NULL : $this->input->post('width')),
				'length' => (empty($this->input->post('length')) ? NULL : $this->input->post('length')),
				'depth' => (empty($this->input->post('depth')) ? NULL : $this->input->post('depth')),
				'notes' => $this->input->post('notes'),
			];

			if (!is_dir(FCPATH . '/uploads/jrp_component/')) {
				mkdir(FCPATH . '/uploads/jrp_component/');
			}

			if (!empty($jrp_component_image_ref_uuid)) {
				$jrp_component_image_ref_name_copy = date('YmdHis') . '-' . $jrp_component_image_ref_name;

				rename(FCPATH . 'uploads/tmp/' . $jrp_component_image_ref_uuid . '/' . $jrp_component_image_ref_name, 
						FCPATH . 'uploads/jrp_component/' . $jrp_component_image_ref_name_copy);

				if (!is_file(FCPATH . '/uploads/jrp_component/' . $jrp_component_image_ref_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image_ref'] = $jrp_component_image_ref_name_copy;
			}
		
			
			$save_jrp_component = $this->model_jrp_component->change($id, $save_data);

			if ($save_jrp_component) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_component', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_component');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_component');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Components
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_component_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_component'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_component'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Components
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_component_view');

		$this->data['jrp_component'] = $this->model_jrp_component->find($id);

		$this->template->title('Component Detail');
		$this->render('backend/standart/administrator/jrp_component/jrp_component_view', $this->data);
	}
	
	/**
	* delete Jrp Components
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_component = $this->model_jrp_component->find($id);

		if (!empty($jrp_component->image_ref)) {
			$path = FCPATH . '/uploads/jrp_component/' . $jrp_component->image_ref;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_jrp_component->remove($id);
	}
	
	/**
	* Upload Image Jrp Component	* 
	* @return JSON
	*/
	public function upload_image_ref_file()
	{
		if (!$this->is_allowed('jrp_component_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'jrp_component',
		]);
	}

	/**
	* Delete Image Jrp Component	* 
	* @return JSON
	*/
	public function delete_image_ref_file($uuid)
	{
		if (!$this->is_allowed('jrp_component_delete', false)) {
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
            'table_name'        => 'jrp_component',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/jrp_component/'
        ]);
	}

	/**
	* Get Image Jrp Component	* 
	* @return JSON
	*/
	public function get_image_ref_file($id)
	{
		if (!$this->is_allowed('jrp_component_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$jrp_component = $this->model_jrp_component->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'image_ref', 
            'table_name'        => 'jrp_component',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/jrp_component/',
            'delete_endpoint'   => 'administrator/jrp_component/delete_image_ref_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_component_export');

		$this->model_jrp_component->export('jrp_component', 'jrp_component');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_component_export');

		$this->model_jrp_component->pdf('jrp_component', 'jrp_component');
	}
}


/* End of file jrp_component.php */
/* Location: ./application/controllers/administrator/Jrp Component.php */