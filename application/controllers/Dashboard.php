<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		if(array_key_exists("ud",$this->session->userdata()))
		{
			$this->load->model("Approvaldb");
			$array = $this->Approvaldb->seller_approval();
			$this->data["seller_approval"] = count($array);
			
			$array = $this->Approvaldb->visitor_approval();
			$this->data["visitor_approval"] = count($array);
			
			$array = $this->Approvaldb->listing_approval();
			$this->data["listing_approval"] = count($array);
			
			$array = $this->Approvaldb->photo_approval();
			$this->data["photo_approval"] = count($array);
			
			$array = $this->Approvaldb->video_approval();
			$this->data["video_approval"] = count($array);
			
			$array = $this->Approvaldb->review_approval();
			$this->data["review_approval"] = count($array);
			
			$array = $this->users();
			$this->data["users"] = count($array);
			
			$array = $this->payments();
			$payment_amount = 0;
			foreach($array as $k=>$obj)
			{
				$payment_amount += $obj->payment_amount;
			}
			$this->data["payment_amount"] = $payment_amount;
			
			$this->load->view('dashboard',$this->data);
		}
		else
		{
			redirect('/login/access/','refresh');

		}		
	}
	public function users()
	{
		return $this->db->get("user")->result();
	}
	public function payments()
	{
		return $this->db->get("payments")->result();
	}
}
