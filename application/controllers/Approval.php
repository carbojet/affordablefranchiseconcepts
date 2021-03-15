<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller {

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
	  $this->load->model("Approvaldb");
	}	
	//default load seller page		
	public function index()
	{
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->seller_approval();
	}
	
	public function seller_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["seller_approval_list"] = $this->Approvaldb->seller_approval();
		$this->load->view("seller_approval",$this->data);
	}
	public function approve_seller($seller_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data = $this->Approvaldb->approve_seller($seller_id,$status);
		$sellerObj = $this->data["sellerObj"];
		if($status=="approved")
		{
			$mail_template = $this->Approvaldb->get_mail_template(2);
			if(is_object($mail_template))
			{
				$seller_firstname = $sellerObj->seller_firstname;			
				$seller_lastname = $sellerObj->seller_lastname;
				$seller_url = "http://www.trustedhomecontractors.com/seller-login";
				$seller_username = $sellerObj->seller_username;
				$seller_password = $sellerObj->seller_password;
				//send a mail
				$from_email = "info@trustedhomecontractors.com";
				$from_name = "Trusted Home Contractors";
				$to_mail = $this->input->post("seller_email");
				
				$subject = str_replace("[seller_firstname]",$seller_firstname,$mail_template->email_subject_1);
				$subject = str_replace("[seller_lastname]",$seller_lastname,$subject);
				
				
				$content = str_replace("[seller_firstname]",$seller_firstname,$mail_template->email_content_1);
				$content = str_replace("[seller_lastname]",$seller_lastname,$content);
				$content = str_replace("[seller_url]",$seller_url,$content);
				$content = str_replace("[seller_username]",$seller_username,$content);
				$content = str_replace("[seller_password]",$seller_password,$content);
					
				$content = str_replace("[","$",$mail_template->email_content_1);
				$content = str_replace("]"," ",$content);
				
				$this->send_mail("info@trustedhomecontractors.com","Trusted Home Contractors",$sellerObj->seller_email,$subject,$content);
			}
		}
		
		$this->seller_approval();
	}
	
	public function listing_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["listing_approval_list"] = $this->Approvaldb->listing_approval();
		$this->load->view("listing_approval",$this->data);
	}
	public function approve_listing($listing_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_listing($listing_id,$status);
		$this->listing_approval();
	}
	
	public function visitor_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["visitor_approval_list"] = $this->Approvaldb->visitor_approval();
		$this->load->view("visitor_approval",$this->data);
	}
	public function approve_visitor($visitor_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_visitor($visitor_id,$status);
		$this->visitor_approval();
	}
	
	public function photo_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["photo_approval_list"] = $this->Approvaldb->photo_approval();
		$this->load->view("photo_approval",$this->data);
	}
	public function approve_photo($photo_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_photo($photo_id,$status);
		$this->visitor_approval();
	}
	
	public function video_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["video_approval_list"] = $this->Approvaldb->video_approval();
		$this->load->view("video_approval",$this->data);
	}
	public function approve_video($video_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_video($video_id,$status);
		$this->video_approval();
	}
	
	public function document_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["document_approval_list"] = $this->Approvaldb->document_approval();
		$this->load->view("document_approval",$this->data);
	}
	public function approve_document($document_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_document($document_id,$status);
		$this->document_approval();
	}
	
	public function event_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["event_approval_list"] = $this->Approvaldb->event_approval();
		$this->load->view("event_approval",$this->data);
	}
	public function approve_event($event_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_event($event_id,$status);
		$this->event_approval();
	}
	
	public function coupon_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["coupon_approval_list"] = $this->Approvaldb->coupon_approval();
		$this->load->view("coupon_approval",$this->data);
	}
	public function approve_coupon($coupon_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_coupon($coupon_id,$status);
		$this->coupon_approval();
	}
	
	public function product_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["product_approval_list"] = $this->Approvaldb->product_approval();
		$this->load->view("product_approval",$this->data);
	}
	public function approve_product($product_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_product($product_id,$status);
		$this->product_approval();
	}
	
	public function news_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["news_approval_list"] = $this->Approvaldb->news_approval();
		$this->load->view("news_approval",$this->data);
	}
	public function approve_news($news_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_news($news_id,$status);
		$this->news_approval();
	}
	
	public function review_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["review_approval_list"] = $this->Approvaldb->review_approval();
		$this->load->view("review_approval",$this->data);
	}
	public function approve_review($comment_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_review($comment_id,$status);
		$this->review_approval();
	}
	
	public function advertisement_approval()
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["advertisement_approval_list"] = $this->Approvaldb->advertisement_approval();
		$this->load->view("advertisement_approval",$this->data);
	}
	public function approve_advertisement($advertisement_id=0,$status="pending")
	{
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data["success_msg"] = $this->Approvaldb->approve_advertisement($advertisement_id,$status);
		$this->advertisement_approval();
	}
	private function send_mail($from_email,$from_name="",$to_mail,$subject,$content="")
	{
		// load email library
		$this->load->library('email');
		
		// prepare email
		$this->email
			->from($from_email, $from_name)
			->to($to_mail)
			->subject($subject)
			->message($content)
			->set_mailtype('html');
		
		// send email
		$this->email->send();
	}
}
