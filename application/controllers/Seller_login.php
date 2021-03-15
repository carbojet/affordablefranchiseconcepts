<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller_login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct()
	{
	  parent::__construct();
	}		
	public function index()
	{
		if(array_key_exists("slrd",$this->session->userdata()))
		{
			//redirect('/login/access/','refresh');
			redirect('/seller_dashboard','refresh');
		}
		else
		{
			//$this->data["captcha"] = $this->random_code_gen();
			//$this->load->view('seller_login',$this->data);
			header("Location:http://www.trustedhomecontractors.com/seller-login/");
		}		
	}		
	public function access()
	{
		if(!array_key_exists("slrd",$this->session->userdata()))
		{
			$this->load->model("Logindb");			
			$this->load->library('form_validation');
			$this->form_validation->set_rules("seller_username","User Name","trim|required");
			$this->form_validation->set_rules("seller_password","Password","trim|required");
			$this->form_validation->set_rules("verification_code","Captcha","trim|callback_captcha_matches");
			
			if($this->form_validation->run()!=false)
			{
				$this->data = array("table_name"=>"seller","seller_username"=>$this->input->post("seller_username"),"seller_password"=>$this->input->post("seller_password"));
				$result = $this->Logindb->login($this->data);
				if(count($result)>0)
				{
					foreach($result as $obj){
					
					$this->session->set_userdata("slrd",array("slrstatus"=>"loggedin","slrnm"=>$obj->seller_username,"slrfn"=>$obj->seller_firstname,"slrln"=>$obj->seller_lastname));
					}
					
					redirect('/seller_dashboard','refresh');
				}
				else
				{
					$this->data["validation_errors"] = "Invalid User name & password...";
					$this->data["captcha"] = $this->random_code_gen();
					$this->session->set_flashdata("data",$this->data);
					//redirect('/seller_login/','refresh');
					header("Location:http://www.trustedhomecontractors.com/seller-login/");
				}				
			}
			else
			{
				//form error validation msg
				$this->data["captcha"] = $this->random_code_gen();
				$this->data["validation_errors"] = validation_errors();
				//$this->load->view('seller_login',$this->data);
				header("Location:http://www.trustedhomecontractors.com/seller-login/");
			}
		}
		elseif(array_key_exists("slrd",$this->session->userdata()))
		{
			redirect('/seller_dashboard/','refresh');
		}
		else
		{
			$this->data["captcha"] = $this->random_code_gen();
			$this->load->view('seller_login',$this->data);
		}	
	}
	public function reg_access()
	{
		if(!array_key_exists("slrd",$this->session->userdata()))
		{
			$this->load->model("Logindb");			
			$this->load->library('form_validation');
			$this->form_validation->set_rules("seller_username","User Name","trim|required");
			$this->form_validation->set_rules("seller_password","Password","trim|required");
			$this->form_validation->set_rules("verification_code","Captcha","trim|callback_captcha_matches");
			
			if($this->form_validation->run()!=false)
			{
				$this->data = array("table_name"=>"seller","seller_username"=>$this->input->post("seller_username"),"seller_password"=>$this->input->post("seller_password"));
				$result = $this->Logindb->login($this->data);
				if(count($result)>0)
				{
					foreach($result as $obj){
					
					$this->session->set_userdata("slrd",array("slrstatus"=>"loggedin","slrnm"=>$obj->seller_username,"slrfn"=>$obj->seller_firstname,"slrln"=>$obj->seller_lastname));
					}
					
					redirect('seller/seller_start/','refresh');
				}
				else
				{
					$this->data["validation_errors"] = "Invalid User name & password...";
					$this->data["captcha"] = $this->random_code_gen();
					$this->session->set_flashdata("data",$this->data);
					//redirect('/seller_login/','refresh');
					header("Location:http://www.trustedhomecontractors.com/seller-login/");
				}				
			}
			else
			{
				//form error validation msg
				$this->data["captcha"] = $this->random_code_gen();
				$this->data["validation_errors"] = validation_errors();
				//$this->load->view('seller_login',$this->data);
				header("Location:http://www.trustedhomecontractors.com/seller-login/");
			}
		}
		elseif(array_key_exists("slrd",$this->session->userdata()))
		{
			redirect('/seller_dashboard/','refresh');
		}
		else
		{
			$this->data["captcha"] = $this->random_code_gen();
			$this->load->view('seller_login',$this->data);
		}	
	}	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->data["msg"] = "You have been logged out...";
		$this->data["captcha"] = $this->random_code_gen();
		$this->session->set_flashdata("data",$this->data);
		//redirect('/seller_login/','refresh');
		header("Location:http://www.trustedhomecontractors.com/seller-login/");
	}
	public function ajax_log_status()
	{
		//$this->output->set_content_type('application/json');
		if(!array_key_exists("slrd",$this->session->userdata()))
		{
			//echo json_encode(array("log_status"=>1));
			//to get array output as json object content type 
			$this->output->set_content_type('application/json')->set_output(json_encode(array("log_status"=>1)));
		}
		else
		{
			//echo json_encode(array("log_status"=>0));
			//to get array output as json object content type 
			$this->output->set_content_type('application/json')->set_output(json_encode(array("log_status"=>0)));
		}
	}	
	public function random_code_gen($limit=5)
	{
		$rand ="";
		for($i=1;$i<=$limit;$i++)
		{
			$rand .=rand(0,9);
		}
		return $rand;		
	}
	public function captcha_matches($fst,$snd)
	{
		if($this->input->post("verification_code")!=$this->input->post("required_verification_code"))
		{
			$this->form_validation->set_message('captcha_matches','Please enter valid Captcha');
			return TRUE;
		}
		else
		{
			return TRUE;
		}
	}
}
