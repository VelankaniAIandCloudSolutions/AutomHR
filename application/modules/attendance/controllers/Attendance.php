<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Attendance extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model(array( 'App', 'Attendance_model'));
        /*if (!User::is_admin()) {
            $this->session->set_flashdata('message', lang('access_denied'));
            redirect('');
        }*/
        $all_routes = $this->session->userdata('all_routes');
        foreach($all_routes as $key => $route){
            if($route == 'attendance'){
                $routname = attendance;
            } 
        }
        if(empty($routname)){
             $this->session->set_flashdata('message', lang('access_denied'));
            redirect('');
        }
        App::module_access('menu_attendance');
        $this->load->helper(array('inflector'));
        $this->applib->set_locale();
    }

    function index()
    {
        if($this->tank_auth->is_logged_in()) {
          $role_id = $this->tank_auth->get_role_id();
          if($this->input->post()){
            $params = $this->input->post();
            if(isset($params['attendance_month'])){
              $month = $params['attendance_month'];
            }else{              
             
              $month = date('m');
              $params['attendance_month'] =  date('m');
            }

            if(isset($params['attendance_year'])){              
              $year = $params['attendance_year'];

            }else{              
              $year = date('Y');
              $params['attendance_year'] =  date('Y');
            }
            $month  = $params['attendance_month'];
            $year  = $params['attendance_year'];
            $data['attendance_month'] = $params['attendance_month'];
            $data['attendance_year'] = $params['attendance_year'];
            $last_day = $year.'-'.$month.'-1';
           
            
            $data['employee_name']      = $params['employee_name'];
            if(($role_id==4) || ($role_id==1)) {
              $attendance_list = Attendance_model::attendance_list($params); 

              $data['attendance_list']  =  $attendance_list[1];
              $data['total_page']       =  $attendance_list[0];
            }
            $data['last_day']         = date('t',strtotime($last_day));  
            
          } else{
            
           
            $params = array();
             $data = array();
            $month = date('m');
            $year  = date('Y');
            $last_day = $year.'-'.$month.'-1';
            $params['attendance_month'] = date('m');
            $params['attendance_year'] = date('Y');
            $data['attendance_month'] = date('m');
            $data['attendance_year'] = date('Y');
            $data['current_page']     = $params['page'];
            if(($role_id==4) || ($role_id==1)) {
              $attendance_list = Attendance_model::attendance_list($params); 
              $data['attendance_list']  =  $attendance_list[1];
              $data['total_page']       =  $attendance_list[0];
            }
            $data['last_day']         = date('t',strtotime($last_day));  
           
          }

            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title('Attendance');
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['page']       = 'Attendance';
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $this->tank_auth->get_user_id();



            $role_id = $this->tank_auth->get_role_id();
            $page = (($role_id==4) || ($role_id==1))?'attendance':'create_attendance';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
          }else{
           redirect('');
          }
    }


     function details($user_id)
    {
        if($this->tank_auth->is_logged_in()) {
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title('Attendance');
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['page']       = 'attendance';
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $user_id;

            $role_id = $this->tank_auth->get_role_id();
            $page = 'attendance_details';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
          }else{
           redirect('');
          }
    }

     function get_list(){
        if($_POST){
           $user_id = $_POST['user_id'];
           $date = date("Y-m-d", strtotime($_POST['date']));
           $attendance_list = Attendance_model::get_list($user_id, $date);
           $records = array();
           $length = count($attendance_list);
           $total_hours = 0;
           for($i = 0; $i < $length; ++$i) {
             $row = array();
             $row['fullname'] = $attendance_list[$i]->fullname;
             $row['punch_in_date_time'] = $attendance_list[$i]->punch_in_date_time;
             $row['punch_in_note'] = $attendance_list[$i]->punch_in_note;
             $row['punch_in_address'] = $attendance_list[$i]->in_address;
             $row['punch_out_date_time'] = $attendance_list[$i]->punch_out_date_time;
             $row['punch_out_note'] = $attendance_list[$i]->punch_out_note;
             $row['punch_out_address'] = $attendance_list[$i]->out_address;
             $row['cal_hours'] = $attendance_list[$i]->cal_hours;
             $total_hours += $attendance_list[$i]->cal_hours;

               $row['total_hours'] = '--';
               $j = $i+1;
               $user_id = !empty($attendance_list[$j]->user_id)?($attendance_list[$j]->user_id):'';
               if ((($attendance_list[$i]->user_id) !== $user_id) ||  empty($user_id)) {
                 $row['total_hours'] = $total_hours;
                 $total_hours = 0;
               }
             $records[] = $row;
           }
           echo json_encode($records);
           exit;
        }
      }

      public function attendance_list()
      {
        
        if($this->input->post()){
        
          $params = $this->input->post();
          $params['branch_id']=$this->session->userdata('branch_id');

          $month = $params['attendance_month'];
          $year  = $params['attendance_year'];
          $last_day = $year.'-'.$month.'-1';
        
          $records = array();
          $records['current_page']     = $params['page'];
          $attendance_list = Attendance_model::attendance_list($params); 

          $records['attendance_list']  =  $attendance_list[1];
          $records['total_page']       =  $attendance_list[0];
          $records['last_day']         = date('t',strtotime($last_day));  
          echo json_encode($records);
          exit;
       }
      }

      public function save_punch_details(){

        if($this->input->post()){


        $params = $this->input->post();
       
        if(!empty($params['punch_in_date_time'])){

            $strtotime = strtotime(date('Y-m-d H:i'));
            $user_id   = $params['user_id'];

            $a_year    = date('Y',$strtotime);
            $a_month   = date('m',$strtotime);
            $a_day     = date('d',$strtotime);
            $a_cin     = date('H:i',$strtotime);
            $where     = array('user_id'=>$user_id,'a_month'=>(int)$a_month,'a_year'=>$a_year);
            $this->db->select('month_days,month_days_in_out');
            $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();

            if(empty($record)){
              $inputs['attendance_month'] =$a_month;
              $inputs['attendance_year'] = $a_year;
              Attendance_model::attendance($user_id,$inputs);
              $this->db->select('month_days,month_days_in_out');
              $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
            }
            
            if(!empty($record['month_days'])){
              $record_day = unserialize($record['month_days']);
              $month_days_in_out_record = unserialize($record['month_days_in_out']);
			  
 
              $a_day -=1;
              
              if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
                $current_days = $month_days_in_out_record[$a_day];
                $total_records = count($current_days);
                $current_day = end($current_days);
                
        
// echo '<pre>';print_r($a_cin);exit;

                // if($record_day[$a_day]['punch_in'] ==''){
					
                  $record_day[$a_day]['punch_in'] = $a_cin;
                  $record_day[$a_day]['punch_out'] = '';
                  $record_day[$a_day]['day'] = 1;
                // }
                
                if($total_records == 1 && empty($current_day['punch_out'])){
                  
                  $current_days = array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'');
                  $month_days_in_out_record[$a_day][0] = $current_days;
                }else{
                  
                  // if(!empty($current_day['punch_in']) && !empty($current_day['punch_out']))
                  // {
                    $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>'');
                    $month_days_in_out_record[$a_day] = $current_days;
                  // } 
                }
				
				// $month_days_in_out_record[$a_day][0]['punch_in']='';
				// $month_days_in_out_record[$a_day][0]['punch_out']='';
                // unset($month_days_in_out_record[$a_day][0]['punch_in']);
                // unset($month_days_in_out_record[$a_day][0]['punch_out']);

              }
            }

            $this->db->where($where);
            $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
			
        }

        $this->session->set_flashdata('tokbox_success', 'Check in successfully saved');
        return redirect('attendance');
        }

        }

        public function save_punch_details_out(){

        if($this->input->post()){

        $params = $this->input->post();

        if(!empty($params['punch_out_date_time'])){

            $strtotime = strtotime(date('Y-m-d H:i'));
            $user_id   = $params['user_id'];

            $a_year    = date('Y',$strtotime);
            $a_month   = date('m',$strtotime);
            $a_day     = date('d',$strtotime);
            $a_cout     = date('H:i',$strtotime);
            $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
            $this->db->select('month_days,month_days_in_out');
            $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
          
            if(empty($record)){
              $inputs['attendance_month'] =$a_month;
              $inputs['attendance_year'] = $a_year;
              Attendance_model::attendance($user_id,$inputs);
              $this->db->select('month_days,month_days_in_out');
              $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
            }
            
            if(!empty($record['month_days'])){
              
              $record_day = unserialize($record['month_days']);
              $month_days_in_out_record = unserialize($record['month_days_in_out']);
              
                $a_day -=1;
                
                $current_days = $month_days_in_out_record[$a_day];
                $total_records = count($current_days);
                $current_day = end($current_days);

            
              if(!empty($record_day[$a_day])){
                  $record_day[$a_day]['punch_out'] = $a_cout;
                  $record_day[$a_day]['day'] = 1;
              }
              if($total_records == 1 && empty($current_day['punch_out'])){
                
                  $month_days_in_out_record[$a_day][0]['punch_out'] = $a_cout;
                }else{
                    
                  if(!empty($current_day['punch_in']) && empty($current_day['punch_out']))
                  {
                    
                    $current_days[$total_records-1]['punch_out'] = $a_cout;
                    $month_days_in_out_record[$a_day] = $current_days;
                  } 
                }
              
            }
            
            $this->db->where($where);
            $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
        }
        $this->session->set_flashdata('tokbox_success', 'Check out successfully saved');
        // $this->session->set_flashdata('message', 'Check out successfully saved.');
        return redirect('attendance');
        }

   }


   public function attendance_details($user_id,$day,$month,$year)
   {
            $data['user_id'] = $user_id;
            $data['atten_day'] = $day;
            $data['atten_month'] = $month;
            $data['atten_year'] = $year;
             $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year);
             $this->db->select('month_days,month_days_in_out');
             $data['record']  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
             $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year,'a_day'=>$day);
             $this->db->select('reason');
             $reason =  $this->db->get_where('dgt_attendance_reason',$where)->row_array();
             $data['reason']  = '';
             if(!empty($reason)){
               $data['reason']  = $reason['reason'];
             }

            $this->load->view('modal/attendance', $data);
   }
   function ro_attendance_view()
	{
		
			 
		if($_POST)
		{
			
            $params = $this->input->post();

            if(isset($params['attendance_month'])){
              $month = $params['attendance_month'];
            }else{              
             
              $month = date('m');
              $params['attendance_month'] =  date('m');
            }

            if(isset($params['attendance_year'])){              
              $year = $params['attendance_year'];

            }else{              
              $year = date('Y');
              $params['attendance_year'] =  date('Y');
            }
            $month  = $params['attendance_month'];
            $year  = $params['attendance_year'];
            $data['attendance_month'] = $params['attendance_month'];
            $data['attendance_year'] = $params['attendance_year'];
            $last_day = $year.'-'.$month.'-1';
           
            
            $data['employee_name']      = $params['employee_name'];
		}
		else
		{
			$params = array();
             $data = array();
            $month = date('m');
            $year  = date('Y');
            $last_day = $year.'-'.$month.'-1';
            $params['attendance_month'] = date('m');
            $params['attendance_year'] = date('Y');
            $data['attendance_month'] = date('m');
            $data['attendance_year'] = date('Y');
		}
            $params['teamlead_id']=$this->session->userdata('user_id');
            $data['current_page']     = $params['page'];
            $attendance_list = Attendance_model::attendance_list($params); 
            $data['attendance_list']  =  $attendance_list[1];
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day)); 
			$this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('attendance').' - '.config_item('company_name'));  
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['datatables']       = TRUE;
            $data['page']       = lang('attendance');
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $this->tank_auth->get_user_id();
			

            $role_id = $this->tank_auth->get_role_id();
            $page = 'ro_attendance';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
           
	}
	
	function regularization_request_ro()
	{
		// echo '<pre>';print_r($this->session->userdata('role_id'));exit;
		if($_POST)
		{
			
            $params = $this->input->post();

            if(isset($params['attendance_month'])){
              $month = $params['attendance_month'];
            }else{              
             
              $month = date('m');
              $params['attendance_month'] =  date('m');
            }

            if(isset($params['attendance_year'])){              
              $year = $params['attendance_year'];

            }else{              
              $year = date('Y');
              $params['attendance_year'] =  date('Y');
            }
            $month  = $params['attendance_month'];
            $year  = $params['attendance_year'];
            $params['attendance_month'] = $params['attendance_month'];
            $params['attendance_year'] = $params['attendance_year'];
            $last_day = $year.'-'.$month.'-1';
           
            
            $params['employee_name']      = $params['employee_name'];
		}
		else
		{
			$params = array();
             $data = array();
            $month = date('m');
            $year  = date('Y');
            $last_day = $year.'-'.$month.'-1';
            $params['attendance_month'] = date('m');
            $params['attendance_year'] = date('Y');
            $data['attendance_month'] = date('m');
            $data['attendance_year'] = date('Y');
		}
		
		// 
            $params['teamlead_id']=$this->session->userdata('user_id');
            $data['current_page']     = $params['page'];
			$params['role_id']=$this->session->userdata('role_id');
            $attendance_list = Attendance_model::attendance_list_request_regul($params); 
			// echo '<pre>';print_r($attendance_list);exit;
            $data['attendance_list']  =  $attendance_list[1];
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day)); 
			$this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('attendance').' - '.config_item('company_name'));  
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['datatables']       = TRUE;
            $data['page']       = lang('attendance');
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $this->tank_auth->get_user_id();
			

            $role_id = $this->tank_auth->get_role_id();
            $page = 'regularization_request_ro';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
           
	}
	
	
  public function update_attendance($user_id,$day,$month,$year)
 {
	   if($_POST)
	   {
		   
     

       $params = $this->input->post();

		   if(!empty($params['punch_in_time'])){
		
			$punch_in_time = date('H:i',strtotime($params['punch_in_time']));
			$punch_out_time = date('H:i',strtotime($params['punch_out_time']));
			$in_date=$year.'-'.$month.'-'.$day.' '.$punch_in_time;
			$out_date=$year.'-'.$month.'-'.$day.' '.$punch_out_time;
			$strtotime = strtotime($in_date);
			$strtotime_out = strtotime($out_date);
			$user_id   = $user_id;
      $a_year    = date('Y',$strtotime);
			$a_month   = date('m',$strtotime);
			$a_day     = date('d',$strtotime);
			$a_cin     = date('H:i',$strtotime);
			$a_cout    = date('H:i',$strtotime_out);
		  $where= array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
      $this->db->select('month_days,month_days_in_out');
      $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
      if(empty($record)){
        $inputs['attendance_month'] =$a_month;
        $inputs['attendance_year'] = $a_year;
        Attendance_model::attendance($user_id,$inputs);
        $this->db->select('month_days,month_days_in_out');
        $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
      }
     
      if(!empty($record['month_days'])){
        $record_day = unserialize($record['month_days']);
        $month_days_in_out_record = unserialize($record['month_days_in_out']);

        $a_day -=1;
		
        
         if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
          $current_days = $month_days_in_out_record[$a_day];
          $total_records = count($current_days);
          $current_day = end($current_days);
          
  

          if($record_day[$a_day]['punch_in'] ==''){
            $record_day[$a_day]['punch_in'] = $a_cin;
			 $record_day[$a_day]['punch_out'] = $a_cout;
            $record_day[$a_day]['day'] = 1;
          }
		  $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>$a_cout);
		$month_days_in_out_record[$a_day] = $current_days;
		 }
		  
      }
 
		
      $this->db->where($where);
      $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));

      $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year,'a_day'=>$a_day+1);
      $this->db->select('reason');
      $reason =  $this->db->get_where('dgt_attendance_reason',$where)->row_array();
      if(!empty($reason) && !empty($params['reason'])){
        $this->db->where($where);
        $this->db->update('dgt_attendance_reason', array('reason'=>$params['reason']));
      }
      else{
        if(!empty($params['reason'])){
          $where['reason'] = $params['reason'];
          $this->db->insert('dgt_attendance_reason',$where );
        }
      }

   }		

		
			$this->session->set_flashdata('tokbox_success', 'Check out successfully saved');
      if (User::is_admin()) {
			redirect('attendance');
      }
      else{
        redirect('attendance/ro_attendance_view');
      }
   
		 }  
	   
	   else
	   {
        $data['user_id'] = $user_id;
        $data['atten_day'] = $day;
        $data['atten_month'] = $month;
        $data['atten_year'] = $year;
        $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year);
        $this->db->select('month_days,month_days_in_out');
        $data['record']  = $this->db->get_where('dgt_attendance_details',$where)->row_array();

        $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year,'a_day'=>$day);
        $this->db->select('reason');
        $reason =  $this->db->get_where('dgt_attendance_reason',$where)->row_array();
        $data['reason']  = '';
        if(!empty($reason)){
          $data['reason']  = $reason['reason'];
        }
        $this->load->view('modal/update_attendance', $data);
	   }
            
   }


 function attendance_regularization()
	{
		
			 
		if($_POST)
		{
			
            $params = $this->input->post();

            if(isset($params['attendance_month'])){
              $month = $params['attendance_month'];
            }else{              
             
              $month = date('m');
              $params['attendance_month'] =  date('m');
            }

            if(isset($params['attendance_year'])){              
              $year = $params['attendance_year'];

            }else{              
              $year = date('Y');
              $params['attendance_year'] =  date('Y');
            }
            $month  = $params['attendance_month'];
            $year  = $params['attendance_year'];
            $data['attendance_month'] = $params['attendance_month'];
            $data['attendance_year'] = $params['attendance_year'];
            $last_day = $year.'-'.$month.'-1';
           
            
            $data['employee_name']      = $params['employee_name'];
		}
		else
		{
			$params = array();
             $data = array();
            $month = date('m');
            $year  = date('Y');
            $last_day = $year.'-'.$month.'-1';
            $params['attendance_month'] = date('m');
            $params['attendance_year'] = date('Y');
            $data['attendance_month'] = date('m');
            $data['attendance_year'] = date('Y');
		}
            // $params['teamlead_id']=$this->session->userdata('user_id');
            $params['employee_id']=$this->session->userdata('user_id');
            $data['current_page']     = $params['page'];
            $attendance_list = Attendance_model::attendance_list($params); 
            $data['attendance_list']  =  $attendance_list[1];
            
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day)); 
			$this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('attendance').' - '.config_item('company_name'));  
            $data['datepicker'] = TRUE;
            $data['form']       = TRUE;
            $data['datatables']       = TRUE;
            // $data['page']       = 'attendance_regularization';
            $data['role']       = $this->tank_auth->get_role_id();
            $data['user_id']    = $this->tank_auth->get_user_id();
			

            $role_id = $this->tank_auth->get_role_id();
            $page = 'attendance_regularization';
            $this->template
                  ->set_layout('users')
                  ->build($page,isset($data) ? $data : NULL);
           
	}
	
	
	
	
	public function update_attendance_ar($user_id,$day,$month,$year)
	{
	   if($_POST)
	   {
		   $params = $this->input->post();
		   if(!empty($params['punch_in_time'])){
			
			$punch_in_time = date('H:i',strtotime($params['punch_in_time']));
			$punch_out_time = date('H:i',strtotime($params['punch_out_time']));
			$in_date=$year.'-'.$month.'-'.$day.' '.$punch_in_time;
			$out_date=$year.'-'.$month.'-'.$day.' '.$punch_out_time;
			$strtotime = strtotime($in_date);
			$strtotime_out = strtotime($out_date);
			$user_id   = $user_id;
			$a_year    = date('Y',$strtotime);
			$a_month   = date('m',$strtotime);
			$a_day     = date('d',$strtotime);
			$a_cin     = date('H:i',$strtotime);
			$a_cout    = date('H:i',$strtotime_out);
			// $a_day -=1;
		  $where= array('user_id'=>$user_id,'a_day'=>$a_day,'a_month'=>$a_month,'a_year'=>$a_year);
		  // echo '<pre>';print_r($where);exit;
      $this->db->select('*');
      $record  = $this->db->get_where('dgt_attendance_details_ar',$where)->row_array();
	 
      if(empty($record)){
        $inputs['a_day'] =$a_day;
        $inputs['attendance_month'] =$a_month;
        $inputs['attendance_year'] = $a_year;
        $inputs['reason'] = $params['reason'];
		 // echo '<pre>';print_r($inputs);exit;
		$user_details=$this->db->get_where('dgt_users',array('id'=>$user_id))->row_array();
        Attendance_model::attendance_ar($user_id,$inputs);
		// echo '<pre>';print_r($inputs);exit;
        $this->db->select('*');
        $record  = $this->db->get_where('dgt_attendance_details_ar',$where)->row_array();
      }
    // echo '<pre>';print_r($record);exit;
      if(!empty($record['month_days'])){
        $record_day = unserialize($record['month_days']);
        $month_days_in_out_record = unserialize($record['month_days_in_out']);

        $a_day -=1;
		
        
         if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
          $current_days = $month_days_in_out_record[$a_day];
          $total_records = count($current_days);
          $current_day = end($current_days);
          
  

          if($record_day[$a_day]['punch_in'] ==''){
            $record_day[$a_day]['punch_in'] = $a_cin;
			 $record_day[$a_day]['punch_out'] = $a_cout;
            $record_day[$a_day]['day'] = 1;
          }
		  $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>$a_cout);
		$month_days_in_out_record[$a_day] = $current_days;
		 }
		  
      }
  
		
      $this->db->where($where);
      $this->db->update('dgt_attendance_details_ar', array('reason'=>$params['reason'],'month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record),'ro_id'=>$user_details['teamlead_id']));

      // $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year,'a_day'=>$a_day+1);
      // $this->db->select('reason');
      // $reason =  $this->db->get_where('dgt_attendance_reason',$where)->row_array();
      // if(!empty($reason) && !empty($params['reason'])){
        // $this->db->where($where);
        // $this->db->update('dgt_attendance_reason', array('reason'=>$params['reason']));
      // }
      // else{
        // if(!empty($params['reason'])){
          // $where['reason'] = $params['reason'];
          // $this->db->insert('dgt_attendance_reason',$where );
        // }
      // }

   }		

		
			$this->session->set_flashdata('tokbox_success', 'Check out successfully saved');
      if (User::is_admin()) {
			redirect('attendance');
      }
      else{
        redirect('attendance/attendance_regularization');
      }
   
		 }  
	   
	   else
	   {
        $data['user_id'] = $user_id;
        $data['atten_day'] = $day;
        $data['atten_month'] = $month;
        $data['atten_year'] = $year;
        $where     = array('user_id'=>$user_id,'a_day'=>$day,'a_month'=>$month,'a_year'=>$year);
        $this->db->select('*');
        // $data['record']  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
        $data['record']  = $this->db->get_where('dgt_attendance_details_ar',$where)->row_array();

        // $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year,'a_day'=>$day);
        // $this->db->select('reason');
        // $reason =  $this->db->get_where('dgt_attendance_reason',$where)->row_array();
        // $data['reason']  = '';
        // if(!empty($reason)){
          // $data['reason']  = $reason['reason'];
        // }
        $this->load->view('modal/update_attendance_ar', $data);
	   }
            
   }
   
   
   
	public function update_attendance_ar_ro($user_id,$day,$month,$year)
	{
	   if($_POST)
	   {
		   $params = $this->input->post();
		   if(!empty($params['punch_in_time'])){
			
			$punch_in_time = date('H:i',strtotime($params['punch_in_time']));
			$punch_out_time = date('H:i',strtotime($params['punch_out_time']));
			$in_date=$year.'-'.$month.'-'.$day.' '.$punch_in_time;
			$out_date=$year.'-'.$month.'-'.$day.' '.$punch_out_time;
			$strtotime = strtotime($in_date);
			$strtotime_out = strtotime($out_date);
			$user_id   = $user_id;
			$a_year    = date('Y',$strtotime);
			$a_month   = date('m',$strtotime);
			$a_day     = date('d',$strtotime);
			$a_cin     = date('H:i',$strtotime);
			$a_cout    = date('H:i',$strtotime_out);
			$where= array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
		  $this->db->select('month_days,month_days_in_out');
		  $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
		  if(empty($record) && $params['ro_status']==1){
			$inputs['attendance_month'] =$a_month;
			$inputs['attendance_year'] = $a_year;
			Attendance_model::attendance($user_id,$inputs);
			$this->db->select('month_days,month_days_in_out');
			$record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
		  }
     
      if(!empty($record['month_days'])){
        $record_day = unserialize($record['month_days']);
        $month_days_in_out_record = unserialize($record['month_days_in_out']);

        $a_day -=1;
		
        
         if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
          $current_days = $month_days_in_out_record[$a_day];
          $total_records = count($current_days);
          $current_day = end($current_days);
          
  

          if($record_day[$a_day]['punch_in'] ==''){
            $record_day[$a_day]['punch_in'] = $a_cin;
			 $record_day[$a_day]['punch_out'] = $a_cout;
            $record_day[$a_day]['day'] = 1;
          }
		  $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>$a_cout);
		$month_days_in_out_record[$a_day] = $current_days;
		 }
		  
      }
 
	if($params['ro_status']==1){
	
      $this->db->where($where);
      $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
	}

	$where1= array('user_id'=>$user_id,'a_day'=>$a_day+1,'a_month'=>$a_month,'a_year'=>$a_year);
	  $this->db->where($where1);
      $this->db->update('dgt_attendance_details_ar', array('ro_status'=>$params['ro_status'],'reject_reason'=>$params['reject_reason'],'ro_id'=>$this->session->userdata('user_id')));
	  
	  
	  

      // $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year,'a_day'=>$a_day+1);
      // $this->db->select('reason');
      // $reason =  $this->db->get_where('dgt_attendance_reason',$where)->row_array();
      // if(!empty($reason) && !empty($params['reason'])){
        // $this->db->where($where);
        // $this->db->update('dgt_attendance_reason', array('reason'=>$params['reason']));
      // }
      // else{
        // if(!empty($params['reason'])){
          // $where['reason'] = $params['reason'];
          // $this->db->insert('dgt_attendance_reason',$where );
        // }
      // }

   }		

		
			$this->session->set_flashdata('tokbox_success', 'Check out successfully saved');
      if (User::is_admin()) {
			redirect('attendance');
      }
      else{
        redirect('attendance/ro_attendance_view');
      }
   
		 }  
	   
	   else
	   {
        $data['user_id'] = $user_id;
        $data['atten_day'] = $day;
        $data['atten_month'] = $month;
        $data['atten_year'] = $year;
        $where = array('user_id'=>$user_id,'a_day'=>$day,'a_month'=>$month,'a_year'=>$year);
        $this->db->select('*');
        // $data['record']  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
        $data['record']  = $this->db->get_where('dgt_attendance_details_ar',$where)->row_array();
		// echo '<pre>';print_r($data);exit;
        // $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year,'a_day'=>$day);
        $this->db->select('reason');
        $reason =  $this->db->get_where('dgt_attendance_details_ar',$where)->row_array()->reason;
        $data['reason']  = '';
        if(!empty($reason)){
          $data['reason']  = $reason['reason'];
        }
        $this->load->view('modal/update_attendance_ar_ro', $data);
	   }
            
   }
	

public function update_attendance_ar_ro_regul($user_id,$day,$month,$year)
	{
	   if($_POST)
	   {
		   $params = $this->input->post();
		   if(!empty($params['punch_in_time'])){
			
			$punch_in_time = date('H:i',strtotime($params['punch_in_time']));
			$punch_out_time = date('H:i',strtotime($params['punch_out_time']));
			$in_date=$year.'-'.$month.'-'.$day.' '.$punch_in_time;
			$out_date=$year.'-'.$month.'-'.$day.' '.$punch_out_time;
			$strtotime = strtotime($in_date);
			$strtotime_out = strtotime($out_date);
			$user_id   = $user_id;
			$a_year    = date('Y',$strtotime);
			$a_month   = date('m',$strtotime);
			$a_day     = date('d',$strtotime);
			$a_cin     = date('H:i',$strtotime);
			$a_cout    = date('H:i',$strtotime_out);
			$where= array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
		  $this->db->select('month_days,month_days_in_out');
		  $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
		  if(empty($record) && $params['ro_status']==1){
			$inputs['attendance_month'] =$a_month;
			$inputs['attendance_year'] = $a_year;
			Attendance_model::attendance($user_id,$inputs);
			$this->db->select('month_days,month_days_in_out');
			$record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
		  }
     
      if(!empty($record['month_days'])){
        $record_day = unserialize($record['month_days']);
        $month_days_in_out_record = unserialize($record['month_days_in_out']);

        $a_day -=1;
		
        
         if(!empty($record_day[$a_day]) && !empty($month_days_in_out_record[$a_day])){
          $current_days = $month_days_in_out_record[$a_day];
          $total_records = count($current_days);
          $current_day = end($current_days);
          
  

          if($record_day[$a_day]['punch_in'] ==''){
            $record_day[$a_day]['punch_in'] = $a_cin;
			 $record_day[$a_day]['punch_out'] = $a_cout;
            $record_day[$a_day]['day'] = 1;
          }
		  $current_days[$total_records] =array('day'=>1,'punch_in'=>$a_cin,'punch_out'=>$a_cout);
		$month_days_in_out_record[$a_day] = $current_days;
		 }
		  
      }
	if($params['ro_status']==1){
	
      $this->db->where($where);
      $this->db->update('dgt_attendance_details', array('month_days'=>serialize($record_day),'month_days_in_out'=>serialize($month_days_in_out_record)));
    
	}

	$where1= array('user_id'=>$user_id,'a_day'=>$a_day+1,'a_month'=>$a_month,'a_year'=>$a_year);
	  $this->db->where($where1);
      $this->db->update('dgt_attendance_details_ar', array('ro_status'=>$params['ro_status'],'reject_reason'=>$params['reject_reason'],'ro_id'=>$this->session->userdata('user_id')));
	  
	  

      // $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year,'a_day'=>$a_day+1);
      // $this->db->select('reason');
      // $reason =  $this->db->get_where('dgt_attendance_reason',$where)->row_array();
      // if(!empty($reason) && !empty($params['reason'])){
        // $this->db->where($where);
        // $this->db->update('dgt_attendance_reason', array('reason'=>$params['reason']));
      // }
      // else{
        // if(!empty($params['reason'])){
          // $where['reason'] = $params['reason'];
          // $this->db->insert('dgt_attendance_reason',$where );
        // }
      // }

   }		
	if($params['ro_status']==1)
	{
		$this->session->set_flashdata('tokbox_success', 'Approved successfully..!');
	}
	else
	{
		$this->session->set_flashdata('tokbox_success', 'Rejected successfully..!');
	}
		
      if (User::is_admin()) {
			redirect('attendance/regularization_request_ro');
      }
      else{
        redirect('attendance/regularization_request_ro');
      }
   
		 }  
	   
	   else
	   {
        $data['user_id'] = $user_id;
        $data['atten_day'] = $day;
        $data['atten_month'] = $month;
        $data['atten_year'] = $year;
        $where = array('user_id'=>$user_id,'a_day'=>$day,'a_month'=>$month,'a_year'=>$year);
        $this->db->select('*');
        // $data['record']  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
        $data['record']  = $this->db->get_where('dgt_attendance_details_ar',$where)->row_array();
		// echo '<pre>';print_r($data);exit;
        // $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year,'a_day'=>$day);
        $this->db->select('reason');
        $reason =  $this->db->get_where('dgt_attendance_details_ar',$where)->row_array()->reason;
        $data['reason']  = '';
        if(!empty($reason)){
          $data['reason']  = $reason['reason'];
        }
        $this->load->view('modal/update_attendance_ar_ro_regul', $data);
	   }
            
   }
   
   
}
