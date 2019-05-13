<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Jrp Manufacturer Controller
*| --------------------------------------------------------------------------
*| Jrp Manufacturer site
*|
*/
class Jrp_manufacturer extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_jrp_manufacturer');
	}

	/**
	* show all Jrp Manufacturers
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('jrp_manufacturer_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['jrp_manufacturers'] = $this->model_jrp_manufacturer->get($filter, $field, $this->limit_page, $offset);
		$this->data['jrp_manufacturer_counts'] = $this->model_jrp_manufacturer->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/jrp_manufacturer/index/',
			'total_rows'   => $this->model_jrp_manufacturer->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Manufacturer List');
		$this->render('backend/standart/administrator/jrp_manufacturer/jrp_manufacturer_list', $this->data);
	}
	
	/**
	* Add new jrp_manufacturers
	*
	*/
	public function add()
	{
		$this->is_allowed('jrp_manufacturer_add');

		$this->template->title('Manufacturer New');
		$this->render('backend/standart/administrator/jrp_manufacturer/jrp_manufacturer_add', $this->data);
	}

	/**
	* Add New Jrp Manufacturers
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('jrp_manufacturer_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[512]');
		$this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|max_length[512]');
		$this->form_validation->set_rules('contact_email', 'Contact Email', 'trim|max_length[64]');
		$this->form_validation->set_rules('contact_phone', 'Contact Phone', 'trim|max_length[16]');
		$this->form_validation->set_rules('contact_address', 'Contact Address', 'trim|max_length[512]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'name' => $this->input->post('name'),
				'contact_person' => $this->input->post('contact_person'),
				'contact_email' => $this->input->post('contact_email'),
				'contact_phone' => $this->input->post('contact_phone'),
				'contact_address' => $this->input->post('contact_address'),
			];

			
			$save_jrp_manufacturer = $this->model_jrp_manufacturer->store($save_data);

			if ($save_jrp_manufacturer) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_jrp_manufacturer;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/jrp_manufacturer/edit/' . $save_jrp_manufacturer, 'Edit Jrp Manufacturer'),
						anchor('administrator/jrp_manufacturer', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/jrp_manufacturer/edit/' . $save_jrp_manufacturer, 'Edit Jrp Manufacturer')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_manufacturer');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_manufacturer');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Jrp Manufacturers
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('jrp_manufacturer_update');

		$this->data['jrp_manufacturer'] = $this->model_jrp_manufacturer->find($id);

		$this->template->title('Manufacturer Update');
		$this->render('backend/standart/administrator/jrp_manufacturer/jrp_manufacturer_update', $this->data);
	}

	/**
	* Update Jrp Manufacturers
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('jrp_manufacturer_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[512]');
		$this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|max_length[512]');
		$this->form_validation->set_rules('contact_email', 'Contact Email', 'trim|max_length[64]');
		$this->form_validation->set_rules('contact_phone', 'Contact Phone', 'trim|max_length[16]');
		$this->form_validation->set_rules('contact_address', 'Contact Address', 'trim|max_length[512]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'name' => $this->input->post('name'),
				'contact_person' => $this->input->post('contact_person'),
				'contact_email' => $this->input->post('contact_email'),
				'contact_phone' => $this->input->post('contact_phone'),
				'contact_address' => $this->input->post('contact_address'),
			];

			
			$save_jrp_manufacturer = $this->model_jrp_manufacturer->change($id, $save_data);

			if ($save_jrp_manufacturer) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/jrp_manufacturer', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/jrp_manufacturer');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/jrp_manufacturer');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Jrp Manufacturers
	*
	* @var $id String
	*/
	public function delete($id)
	{
		$this->is_allowed('jrp_manufacturer_delete');

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
            set_message(cclang('has_been_deleted', 'jrp_manufacturer'), 'success');
        } else {
            set_message(cclang('error_delete', 'jrp_manufacturer'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Jrp Manufacturers
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('jrp_manufacturer_view');

		$this->data['jrp_manufacturer'] = $this->model_jrp_manufacturer->join_avaiable()->find($id);

		$this->template->title('Manufacturer Detail');
		$this->render('backend/standart/administrator/jrp_manufacturer/jrp_manufacturer_view', $this->data);
	}
	
	/**
	* delete Jrp Manufacturers
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$jrp_manufacturer = $this->model_jrp_manufacturer->find($id);

		
		
		return $this->model_jrp_manufacturer->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('jrp_manufacturer_export');

		$this->model_jrp_manufacturer->export('jrp_manufacturer', 'jrp_manufacturer');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('jrp_manufacturer_export');

		$this->model_jrp_manufacturer->pdf('jrp_manufacturer', 'jrp_manufacturer');
	}
}


/* End of file jrp_manufacturer.php */
/* Location: ./application/controllers/administrator/Jrp Manufacturer.php */