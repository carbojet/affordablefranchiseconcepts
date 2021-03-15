<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

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
	  $this->load->model("Paymentdb");
	}	
	//default load seller page		
	public function index()
	{
		$this->all_payments(0,5);	
	}
	public function all_payments($current_page=0,$limit=5)
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		$current_page = $this->input->post("navigation_page");
		$direction = $this->input->post("page_click");
		
		if($direction=="next")
		{$current_page +=1;}
		elseif($direction=="prev")
		{$current_page -=1;}
		
		$this->data = $this->Paymentdb->payments($current_page,$limit);
		$this->load->view("all_payments",$this->data);
	}
	public function approved_payments($current_page=0,$limit=5)
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		$current_page = $this->input->post("navigation_page");
		$direction = $this->input->post("page_click");
		
		if($direction=="next")
		{$current_page +=1;}
		elseif($direction=="prev")
		{$current_page -=1;}
		
		$data =array("payment_status"=>"approved");
				
		$this->data = $this->Paymentdb->payments($current_page,$limit,$data);
		$this->load->view("approved_payments",$this->data);
	}
	public function pending_payments($current_page=0,$limit=5)
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		$current_page = $this->input->post("navigation_page");
		$direction = $this->input->post("page_click");
		
		if($direction=="next")
		{$current_page +=1;}
		elseif($direction=="prev")
		{$current_page -=1;}
		
		$data =array("payment_status"=>"pending");
				
		$this->data = $this->Paymentdb->payments($current_page,$limit,$data);
		$this->load->view("pending_payments",$this->data);
	}
	public function cancelled_payments($current_page=0,$limit=5)
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		$current_page = $this->input->post("navigation_page");
		$direction = $this->input->post("page_click");
		
		if($direction=="next")
		{$current_page +=1;}
		elseif($direction=="prev")
		{$current_page -=1;}
		
		$data =array("payment_status"=>"rejected");
				
		$this->data = $this->Paymentdb->payments($current_page,$limit,$data);
		$this->load->view("cancelled_payments",$this->data);
	}
	public function approve_payment($payment_id=0)
	{
		if($payment_id>0)
		{
			$this->data["success_msg"] = $this->Paymentdb->update_payment_status($payment_id,"approved");
			$this->approved_payments();
		}
		else
		{
			$this->all_payments();
		}
	}
	public function cancel_payment($payment_id=0)
	{
		if($payment_id>0)
		{
			$this->data["success_msg"] = $this->Paymentdb->update_payment_status($payment_id,"rejected");
			$this->cancelled_payments();
		}
		else
		{
			$this->all_payments();
		}
	}
	
}
