<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_branches extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model('App');
    }

    function index()
    {
		if($this->tank_auth->is_logged_in()) {
			$this->load->module('layouts');
			$this->load->library('template');
			$this->template->title(lang('all_branches'));
			$data['datepicker']     = TRUE;
			$data['page']           = lang('all_branches');
			$data['form'] = true;
        	$data['datatables'] = true;
        	$data['all_branches'] = $this->db->get('branches')->result_array();

			

			$this->template
				 ->set_layout('users')
				 ->build('all_branches',isset($data) ? $data : NULL);
	    }else{
		   redirect('');	
		}			 
     }
	 function getEmployees(){
		extract($_GET);

		$this->db->select('U.id,AD.fullname,U.email')->from('dgt_users U')->join('account_details AD','U.id = AD.user_id')->where('U.status',1)->where('U.id!=',1);
		$this->db->where("(AD.fullname like '%".$term['term']."%' OR U.email like '%".$term['term']."%' )", NULL, FALSE);

		$users = $this->db->order_by('AD.fullname','asc')->get()->result_array();
		
		echo json_encode($users);
		exit;

	 }
     function add_branch(){
     	if($_POST){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
			$this->form_validation->set_rules('branch_name', $this->input->post('branch_name'), 'required');
			$this->form_validation->set_rules('branch_prefix', $this->input->post('branch_prefix'), 'required');
			//$this->form_validation->set_rules('employee[]', $this->input->post('employee'), 'required');
			$this->form_validation->set_rules('branch_status', $this->input->post('stuatus'), 'required');

			if ($this->form_validation->run() != FALSE)
			{
				// 
				$branch_details = array(
					'branch_name' => $this->input->post('branch_name'),
					'branch_prefix' => $this->input->post('branch_prefix'),
					'branch_status' => $this->input->post('branch_status'),
					'weekend_workdays' => json_encode($this->input->post('weekend'))
				);
				// echo '<pre>';print_r(json_encode($this->input->post('weekend')));exit;
				$this->db->insert('branches',$branch_details);
				extract($_POST);
				if(!empty($employee)){
					$ins_data['branch_id']	=	$this->db->insert_id();
					foreach($employee as $employee1){
						$ins_data['user_id']	=	$employee1;
						$this->db->insert('assigned_entities',$ins_data);
					}
				}


				$this->session->set_flashdata('tokbox_success', 'New Entity Added!');
				redirect('all_branches');
			}
     	}else{
			$data['users'] = $this->db->select('U.id,AD.fullname')->from('dgt_users U')->join('account_details AD','U.id = AD.user_id')->where('U.status',1)->where('U.id!=',1)->order_by('AD.fullname','asc')->get()->result_array();

			$this->load->view('modal/add_branch',$data);
     	}
     }

     function edit_branch(){
     	if($_POST){
			// echo '<pre>';print_r($this->input->post());exit;
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
			$this->form_validation->set_rules('branch_name', $this->input->post('branch_name'), 'required');
			$this->form_validation->set_rules('branch_prefix', $this->input->post('branch_prefix'), 'required');
			//$this->form_validation->set_rules('employee[]', 'Employee', 'required');
			$this->form_validation->set_rules('branch_status', $this->input->post('stuatus'), 'required');

			if ($this->form_validation->run() != FALSE)
			{
				// echo '<pre>';print_r($this->input->post());exit;
				$branch_details = array(
					'branch_name' => $this->input->post('branch_name'),
					'branch_prefix' => $this->input->post('branch_prefix'),
					'branch_status' => $this->input->post('branch_status'),
					'weekend_workdays' => json_encode($this->input->post('weekend'))
				);
				$this->db->where('branch_id',$this->input->post('branch_id'));
				$this->db->update('branches',$branch_details);


				
				
				extract($_POST);
				if(!empty($employee)){
					$this->db->where('branch_id',$this->input->post('branch_id'));
					$this->db->delete('assigned_entities');

					$ins_data['branch_id']	=	$this->input->post('branch_id');
					foreach($employee as $employee1){
						$ins_data['user_id']	=	$employee1;
						$this->db->insert('assigned_entities',$ins_data);
					}
				}

				$this->session->set_flashdata('tokbox_success', 'Entity Updated!');
				redirect('all_branches');
			}
     	}else{
     		$branch_id = $this->uri->segment(3);
     		$data['branch_id'] = $branch_id;
     		$data['branch_details'] = $this->db->get_where('branches',array('branch_id' => $branch_id))->row_array();
			$data['users'] = $this->db->select('U.id,AD.fullname,U.email')->from('dgt_users U')->join('account_details AD','AD.user_id = U.id')->join('assigned_entities ae','ae.user_id = U.id')->where('U.status',1)->where('ae.branch_id',$branch_id)->order_by('AD.fullname','asc')->get()->result_array();
				
			$this->load->view('modal/edit_branch',$data);
     	}
     }



     function delete_branch(){
     	if($_POST){
     		$this->db->where('branch_id',$this->input->post('branch_id'));
     		$this->db->delete('branches');
     		$this->session->set_flashdata('tokbox_success', 'Branch Deleted!');
     		redirect('all_branches');
     	}else{
     		$branch_id = $this->uri->segment(3);
     		$data['branch_id'] = $branch_id;
			$this->load->view('modal/delete_branch',$data);
     	}
     }
	
}
