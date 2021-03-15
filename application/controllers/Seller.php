<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller {

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
	  $this->load->model("Sellerdb");
	}	
	//default load seller page		
	public function index()
	{
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		if(isset($this->data["page"])){$page=$this->data["page"];}else{$page=1;}
		$data = $this->Sellerdb->seller_list($page,5);
		$this->data["seller_list"]= $data["seller_list"];
		$this->data["pagination"] = $data["pagination"];
		$this->pages = $this->data["pagination"]["pages"];
		$this->session->set_userdata("search_seller_post",array());
		$this->data["side_menu"] = array("4"=>"active","sub"=>"active");
		
		$this->load->view("seller",$this->data);
	}
	//seller pagenitation
	public function	seller_nxt_page($currentPage)
	{
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		$currentPage++;
		$data = $this->Sellerdb->seller_list($currentPage,5);
		$this->data["seller_list"]= $data["seller_list"];
		$this->data["pagination"] = $data["pagination"];
		
		$this->data["side_menu"] = array("4"=>"active","sub"=>"active");
		$this->load->view("seller",$this->data);
	}
	public function	seller_pre_page($currentPage)
	{	
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
			
		$currentPage--;
		$data = $this->Sellerdb->seller_list($currentPage,5);
		
		$this->data["seller_list"]= $data["seller_list"];
		$this->data["pagination"] = $data["pagination"];
		
		$this->data["side_menu"] = array("4"=>"active","sub"=>"active");
		$this->load->view("seller",$this->data);
	}
	//seller pagination after search
	public function	seller_search_nxt_page()
	{
		$currentPage = $this->input->post("startpage");
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		$currentPage++;
		$data = array(
			"seller_type"=>$this->input->post("seller_type"),
			"seller_username"=>$this->input->post("seller_username"),
			"seller_company"=>$this->input->post("seller_company"),
			"seller_firstname"=>$this->input->post("seller_firstname"),
			"seller_lastname"=>$this->input->post("seller_lastname"),
			"order_by"=>$this->input->post("order_by")
		);
		$data = $this->Sellerdb->get_seller_search_resutl($data,$currentPage,5);
		$this->data["post_data"] = $data["post_data"];
		$this->data["seller_list"]= $data["seller_list"];
		$this->data["pagination"] = $data["pagination"];
		
		$this->data["side_menu"] = array("4"=>"active","sub"=>"active");
		$this->load->view("search_seller_result",$this->data);
	}
	public function	seller_search_pre_page()
	{	
		$currentPage = $this->input->post("startpage");
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
			
		$currentPage--;
		$data = array(
			"seller_type"=>$this->input->post("seller_type"),
			"seller_username"=>$this->input->post("seller_username"),
			"seller_company"=>$this->input->post("seller_company"),
			"seller_firstname"=>$this->input->post("seller_firstname"),
			"seller_lastname"=>$this->input->post("seller_lastname"),
			"order_by"=>$this->input->post("order_by")
		);
		$data = $this->Sellerdb->get_seller_search_resutl($data,$currentPage,5);
		$this->data["post_data"] = $data["post_data"];
		$this->data["seller_list"]= $data["seller_list"];
		$this->data["pagination"] = $data["pagination"];
		
		$this->data["side_menu"] = array("4"=>"active","sub"=>"active");
		$this->load->view("search_seller_result",$this->data);
	}
	//seller edit profile
	public function seller_profile_edit()
	{
		//check weather user logged in or not
		if(!array_key_exists("slrd",$this->session->userdata())){redirect("seller_login");}
		
		$slrd = $this->session->userdata("slrd");
		if(isset($slrd["slrnm"]))
		{
			$result = $this->Sellerdb->select_seller(array("seller_username"=>$slrd["slrnm"]));
			
			foreach($result as $k=>$obj){$this->data["sellerObj"] = $obj;}
			$this->data["countryObjArray"] = $this->Sellerdb->get_country_list();
			$this->data["titleObjArray"] = $this->Sellerdb->get_title_list();
			$this->load->view("seller_profile_edit",$this->data);
		}
		else
		{
			redirect("/seller_dashboard/","refresh");
		}
		  
	}		
	//seller edit sec
	public function seller_edit($id=0,$page=0)
	{
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		if($id>0)
		{
			$result = $this->Sellerdb->select_seller(array("seller_id"=>$id));
			
			foreach($result as $k=>$obj){$this->data["sellerObj"] = $obj;}
			$this->data["countryObjArray"] = $this->Sellerdb->get_country_list();
			$this->data["titleObjArray"] = $this->Sellerdb->get_title_list();
			$this->data["page"] = $page;
			$this->load->view("seller_edit",$this->data);
		}
		else
		{
			redirect("/seller/","refresh");
		}
	}
	//seller profile update sec	
	public function update_seller_profile()
	{	
		//check weather user logged in or not
		
		if(!array_key_exists("slrd",$this->session->userdata())){redirect("seller_login");}
			
			$this->data["sellerObj"] = (object) array(
			"seller_id"=>$this->input->post("seller_id"),
			"seller_title"=>$this->input->post("seller_title"),
			"seller_firstname"=>$this->input->post("seller_firstname"),
			"seller_lastname"=>$this->input->post("seller_lastname"),
			"seller_phone"=>$this->input->post("seller_phone"),
			"seller_mobile"=>$this->input->post("seller_mobile"),
			"seller_fax"=>$this->input->post("seller_fax"),
			"seller_email"=>$this->input->post("seller_email"),
			"seller_website"=>$this->input->post("seller_website"),
			"seller_address"=>$this->input->post("seller_address"),
			"seller_address2"=>$this->input->post("seller_address2"),
			"seller_city"=>$this->input->post("seller_city"),
			"seller_province"=>$this->input->post("seller_province"),
			"seller_zip"=>$this->input->post("seller_zip"),
			"seller_country"=>$this->input->post("seller_country"),
			"seller_type"=>$this->input->post("seller_type"),
			"seller_company"=>$this->input->post("seller_company"),
			"seller_desc_1"=>$this->input->post("seller_desc_1"),
			"seller_language"=>$this->input->post("seller_language"),
			"seller_lastupdate"=>date("Y-m-d H:i:s")				
			);
			$this->data["countryObjArray"] = $this->Sellerdb->get_country_list();
			$this->data["titleObjArray"] = $this->Sellerdb->get_title_list();
			
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules("seller_firstname","First Name","trim|required");
			$this->form_validation->set_rules("seller_lastname","Last Name","trim|required");
			$this->form_validation->set_rules("seller_email","Email","trim|required|valid_email");
			$this->form_validation->set_rules("seller_address","Mailing address","trim|required");
			$this->form_validation->set_rules("seller_city","City / Town","trim|required");
			$this->form_validation->set_rules("seller_province","State / Province","trim|required");
			$this->form_validation->set_rules("seller_zip","Zip / Postal code","trim|required");
		
		if($this->form_validation->run()!=false)
		{
			//validation sucess
			$result = $this->Sellerdb->update_seller_profile();
			$this->data["success_msg"] = $result;
			
			if(!empty($_FILES["seller_logo"]["name"]))
			{
				@unlink("./logo_cache/".$this->input->post("seller_id").".jpg");
				$alert = $this->do_upload($this->input->post("seller_id"));
			}			
			$this->load->view("seller_profile_edit",$this->data);
		}
		else
		{	
			//validation error
			$this->data["validation_errors"] = validation_errors();
			$this->load->view("seller_profile_edit",$this->data);				
		}		
	}
	//seller update sec	
	public function update()
	{	
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules("seller_password","Password","trim|required");
			$this->form_validation->set_rules("seller_expire_date","Expire Date","trim|required");
			$this->form_validation->set_rules("seller_firstname","First Name","trim|required");
			$this->form_validation->set_rules("seller_lastname","Last Name","trim|required");
			$this->form_validation->set_rules("seller_email","Email","trim|required|valid_email");
			$this->form_validation->set_rules("seller_address","Mailing address","trim|required");
			$this->form_validation->set_rules("seller_city","City / Town","trim|required");
			$this->form_validation->set_rules("seller_province","State / Province","trim|required");
			$this->form_validation->set_rules("seller_zip","Zip / Postal code","trim|required");
		
		if($this->form_validation->run()!=false)
		{
			//validation sucess
			$result = $this->Sellerdb->update_seller();
			$this->data["success_msg"] = $result;
                        if(!empty($_FILES["seller_logo"]["name"]))
			{
				@unlink("./logo_cache/".$this->input->post("seller_id").".jpg");
				$alert = $this->do_upload($this->input->post("seller_id"));	
			}	
			$this->data["page"]	= $this->input->post("page");
			$ses = $this->session->userdata("search_seller_post");
			if(!empty($ses))
			{
				$data = $this->session->userdata("search_seller_post");
				$this->data = $this->Sellerdb->get_seller_search_resutl($data,1,5);			
				$this->load->view("search_seller_result",$this->data);
			}
			else
			{	
				$this->index();
			}
		}
		else
		{	
			//validation error
			$this->data["validation_errors"] = validation_errors();
			$this->data["sellerObj"] = (object) array(
				"seller_id"=>$this->input->post("seller_id"),
				"seller_username"=>$this->input->post("seller_username"),
				"seller_password"=>$this->input->post("seller_password"),
				"seller_package"=>$this->input->post("seller_package"),
				"seller_payment_period"=>$this->input->post("seller_payment_period"),
				"seller_expire_date"=>$this->input->post("seller_expire_date"),
				"seller_title"=>$this->input->post("seller_title"),
				"seller_firstname"=>$this->input->post("seller_firstname"),
				"seller_lastname"=>$this->input->post("seller_lastname"),
				"seller_phone"=>$this->input->post("seller_phone"),
				"seller_mobile"=>$this->input->post("seller_mobile"),
				"seller_fax"=>$this->input->post("seller_fax"),
				"seller_email"=>$this->input->post("seller_email"),
				"seller_website"=>$this->input->post("seller_website"),
				"seller_address"=>$this->input->post("seller_address"),
				"seller_address2"=>$this->input->post("seller_address2"),
				"seller_city"=>$this->input->post("seller_city"),
				"seller_province"=>$this->input->post("seller_province"),
				"seller_zip"=>$this->input->post("seller_zip"),
				"seller_country"=>$this->input->post("seller_country"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_company"=>$this->input->post("seller_company"),
				"seller_desc_1"=>$this->input->post("seller_desc_1"),
				"seller_language"=>$this->input->post("seller_language"),
				"seller_status"=>"approved",
				"seller_status_feature"=>"featured",
				"seller_status_email"=>"approved",
				"seller_status_approval"=>"",
				"seller_lastupdate"=>date("Y-m-d H:i:s")				
				);
				$this->data["countryObjArray"] = $this->Sellerdb->get_country_list();
				$this->data["titleObjArray"] = $this->Sellerdb->get_title_list();
				$this->load->view("seller_edit",$this->data);				
		}		
	}
	
	//user edit add new
	public function new_seller()
	{
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		if($this->input->post("seller_username"))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules("seller_username","User Name","trim|required|is_unique[seller.seller_username]");
			$this->form_validation->set_rules("seller_password","Password","trim|required");
			$this->form_validation->set_rules("seller_expire_date","Expire Date","trim|required");
			$this->form_validation->set_rules("seller_firstname","First Name","trim|required");
			$this->form_validation->set_rules("seller_lastname","Last Name","trim|required");
			$this->form_validation->set_rules("seller_email","Email","trim|required|valid_email");
			$this->form_validation->set_rules("seller_address","Mailing address","trim|required");
			$this->form_validation->set_rules("seller_city","City / Town","trim|required");
			$this->form_validation->set_rules("seller_province","State / Province","trim|required");
			$this->form_validation->set_rules("seller_zip","Zip / Postal code","trim|required");
			
			if($this->form_validation->run()!=false)
			{
				//form validation true
				$seller_payment_period = $this->input->post("seller_payment_period");
				if($seller_payment_period=="monthly"){$seller_expire_date = date('Y-m-d',mktime(0,0,0,date("m")+1,date("d"),date("Y")));}
				elseif($seller_payment_period=="quarterly"){$seller_expire_date = date('Y-m-d',mktime(0,0,0,date("m")+3,date("d"),date("Y")));}
				elseif($seller_payment_period=="semiannually"){$seller_expire_date = date('Y-m-d',mktime(0,0,0,date("m")+6,date("d"),date("Y")));}
				elseif($seller_payment_period=="annually"){$seller_expire_date = date('Y-m-d',mktime(0,0,0,date("m")+12,date("d"),date("Y")));}
								
				$this->data = array(
				"seller_username"=>$this->input->post("seller_username"),
				"seller_password"=>$this->input->post("seller_password"),
				"seller_package"=>$this->input->post("seller_package"),
				"seller_payment_period"=>$this->input->post("seller_payment_period"),
				"seller_expire_date"=>$seller_expire_date,
				"seller_title"=>$this->input->post("seller_title"),
				"seller_firstname"=>$this->input->post("seller_firstname"),
				"seller_lastname"=>$this->input->post("seller_lastname"),
				"seller_phone"=>$this->input->post("seller_phone"),
				"seller_mobile"=>$this->input->post("seller_mobile"),
				"seller_fax"=>$this->input->post("seller_fax"),
				"seller_email"=>$this->input->post("seller_email"),
				"seller_website"=>$this->input->post("seller_website"),
				"seller_address"=>$this->input->post("seller_address"),
				"seller_address2"=>$this->input->post("seller_address2"),
				"seller_city"=>$this->input->post("seller_city"),
				"seller_province"=>$this->input->post("seller_province"),
				"seller_zip"=>$this->input->post("seller_zip"),
				"seller_country"=>$this->input->post("seller_country"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_company"=>$this->input->post("seller_company"),
				"seller_desc_1"=>$this->input->post("seller_desc_1"),
				"seller_language"=>$this->input->post("seller_language"),
				"seller_status"=>"approved",
				"seller_status_feature"=>"",
				"seller_status_email"=>"approved",
				"seller_status_approval"=>"off",
				"seller_lastupdate"=>date("Y-m-d H:i:s")				
				);
				
				$result = $this->Sellerdb->add_new_seller($this->data);			
				$this->data["success_msg"] = $result["msg"];
				$file_name = $result["id"].".jpg";
				
				$alert = $this->do_upload($file_name);
				//print_r($alert);				
				$this->index();
			}
			else
			{
				//form validation false
				$this->data["validation_errors"] = validation_errors();
								 
				$this->data["sellerObj"] = (object) array(
				"seller_username"=>$this->input->post("seller_username"),
				"seller_password"=>$this->input->post("seller_password"),
				"seller_package"=>$this->input->post("seller_package"),
				"seller_payment_period"=>$this->input->post("seller_payment_period"),
				"seller_expire_date"=>$this->input->post("seller_expire_date"),
				"seller_title"=>$this->input->post("seller_title"),
				"seller_firstname"=>$this->input->post("seller_firstname"),
				"seller_lastname"=>$this->input->post("seller_lastname"),
				"seller_phone"=>$this->input->post("seller_phone"),
				"seller_mobile"=>$this->input->post("seller_mobile"),
				"seller_fax"=>$this->input->post("seller_fax"),
				"seller_email"=>$this->input->post("seller_email"),
				"seller_website"=>$this->input->post("seller_website"),
				"seller_address"=>$this->input->post("seller_address"),
				"seller_address2"=>$this->input->post("seller_address2"),
				"seller_city"=>$this->input->post("seller_city"),
				"seller_province"=>$this->input->post("seller_province"),
				"seller_zip"=>$this->input->post("seller_zip"),
				"seller_country"=>$this->input->post("seller_country"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_company"=>$this->input->post("seller_company"),
				"seller_desc_1"=>$this->input->post("seller_desc_1"),
				"seller_language"=>$this->input->post("seller_language"),
				"seller_status"=>"approved",
				"seller_status_feature"=>"featured",
				"seller_status_email"=>"approved",
				"seller_status_approval"=>"",
				"seller_lastupdate"=>date("Y-m-d H:i:s")				
				);
				$this->data["countryObjArray"] = $this->Sellerdb->get_country_list();
				$this->data["titleObjArray"] = $this->Sellerdb->get_title_list();
				$this->load->view("new_seller",$this->data);
			}
		}
		else
		{			
			$this->data["countryObjArray"] = $this->Sellerdb->get_country_list();
			$this->data["titleObjArray"] = $this->Sellerdb->get_title_list();
						
			$this->load->view("new_seller",$this->data);
		}				
	}
	//seller reg from front end
	public function seller_register()
	{		
		if($this->input->post("seller_username"))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules("seller_username","User Name","trim|required|is_unique[seller.seller_username]");
			$this->form_validation->set_rules("seller_password","Password","trim|required");
			$this->form_validation->set_rules("seller_firstname","First Name","trim|required");
			$this->form_validation->set_rules("seller_lastname","Last Name","trim|required");
			$this->form_validation->set_rules("seller_email","Email","trim|required|valid_email");
			$this->form_validation->set_rules("seller_address","Mailing address","trim|required");
			$this->form_validation->set_rules("seller_city","City / Town","trim|required");
			$this->form_validation->set_rules("seller_province","State / Province","trim|required");
			$this->form_validation->set_rules("seller_zip","Zip / Postal code","trim|required");
			
			if($this->form_validation->run()!=false)
			{
				$this->session->sess_destroy();
				//form validation true
				$seller_expire_date = $this->input->post("seller_expire_date");				
				$seller_payment_period = $this->input->post("seller_payment_period");
				if($seller_payment_period=="monthly"){$seller_expire_date =date('Y-m-d',mktime(0,0,0,date("m")+1,date("d"),date("Y")));}
				elseif($seller_payment_period=="yearly"){$seller_expire_date = date('Y-m-d',mktime(0,0,0,date("m")+12,date("d"),date("Y")));}
				elseif($seller_payment_period=="semi-yearly"){$seller_expire_date = date('Y-m-d',mktime(0,0,0,date("m")+6,date("d"),date("Y")));}
				
				$this->data = array(
				"seller_username"=>$this->input->post("seller_username"),
				"seller_password"=>$this->input->post("seller_password"),
				"seller_package"=>$this->input->post("seller_package"),
				"seller_payment_period"=>$this->input->post("seller_payment_period"),
				"seller_expire_date"=>$seller_expire_date,
				"seller_title"=>$this->input->post("seller_title"),
				"seller_firstname"=>$this->input->post("seller_firstname"),
				"seller_lastname"=>$this->input->post("seller_lastname"),
				"seller_phone"=>$this->input->post("seller_phone"),
				"seller_mobile"=>$this->input->post("seller_mobile"),
				"seller_fax"=>$this->input->post("seller_fax"),
				"seller_email"=>$this->input->post("seller_email"),
				"seller_website"=>$this->input->post("seller_website"),
				"seller_address"=>$this->input->post("seller_address"),
				"seller_address2"=>$this->input->post("seller_address2"),
				"seller_city"=>$this->input->post("seller_city"),
				"seller_province"=>$this->input->post("seller_province"),
				"seller_zip"=>$this->input->post("seller_zip"),
				"seller_country"=>$this->input->post("seller_country"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_company"=>$this->input->post("seller_company"),
				"seller_desc_1"=>$this->input->post("seller_desc_1"),
				"seller_language"=>$this->input->post("seller_language"),
				"seller_status"=>"pending",
				"seller_status_feature"=>"",
				"seller_status_email"=>"pending",
				"seller_status_approval"=>"off",
				"seller_lastupdate"=>date("Y-m-d H:i:s")				
				);
				
				$result = $this->Sellerdb->add_new_seller($this->data);			
				$this->data["success_msg"] = $result["msg"];
				$file_name = $result["id"].".jpg";				
				$alert = $this->do_upload($file_name);
				//send a mail			
				
				$mail_template = $this->Sellerdb->get_mail_template(3);
				if(is_object($mail_template))
				{
					$from_email = "info@trustedhomecontractors.com";
					$from_name = "Trusted Home Contractors";
					$to_mail = $this->input->post("seller_email");
					$seller_firstname = $this->input->post("seller_firstname");			
					$seller_lastname = $this->input->post("seller_lastname");					
					$seller_confirm = 'http://www.trustedhomecontractors.com/directory1/seller/seller_email_verification/'.$result["id"];
					
					$subject = str_replace("[seller_firstname]",$seller_firstname,$mail_template->email_subject_1);
					$subject = str_replace("[seller_lastname]",$seller_lastname,$subject);
				
					$content = str_replace("[seller_firstname]",$seller_firstname,$mail_template->email_content_1);
					$content = str_replace("[seller_lastname]",$seller_lastname,$content);
					$content = str_replace("[seller_confirm]",$seller_confirm,$content);					
				
					$this->send_mail($from_email,$from_name,$to_mail,$subject,$content);
				}
				//$this->data["success_msg"] .= "<br/>Verification mail has sent to your email address please check and verify it..";
				$product["name"] = $this->input->post("package_subscription_name_1");
				$product["price"] = $this->input->post("package_subscription_monthly");
				$product["quantity"] = 1;
				$product["discount"] = 10;
				if($product["price"]>=1)
				{
					$this->do_payment($product);
				}
				else
				{
					//$this->data["success_msg"] = "Verification mail has sent to your email address please check and verify it..";
					$this->data["seller_username"] = $this->input->post("seller_username");
					$this->data["seller_password"] = $this->input->post("seller_password");
					$this->load->view("seller_register",$this->data);
				}
				//setcookie("thc", $this->data["success_msg"], time() + (60), "http://www.trustedhomecontractors.com/seller-register/");
				//redirect("http://www.trustedhomecontractors.com/seller-login/");			
			}
			else
			{
				//form validation false
				$this->data["validation_errors"] = validation_errors();
				print_r($this->data["validation_errors"]);
				redirect("http://www.trustedhomecontractors.com/seller-register/");
			}
		}
		else
		{			
			redirect("http://www.trustedhomecontractors.com/seller-registered/");
		}				
	}
	public function seller_start()
	{
		if(!array_key_exists("slrd",$this->session->userdata())){redirect("seller_login");}
		
		$slrd = $this->session->userdata("slrd");
		if(isset($slrd["slrnm"]))
		{
			$result = $this->Sellerdb->select_seller(array("seller_username"=>$slrd["slrnm"]));
			
			foreach($result as $k=>$obj){$this->data["sellerObj"] = $obj;}
			$this->load->view("seller_start",$this->data);
		}
		else
		{
			redirect("/seller_dashboard/","refresh");
		}
		
	}
	//seller payment history
	public function payment_history($id=0,$currentPage=1,$limit=5)
	{
		if($id>0)
		{
			$data = array("payment_seller"=>$id,"currentPage"=>$currentPage,"limit"=>$limit);
			$this->data = $this->Sellerdb->payment_history($data);
			$this->load->view("seller_payment",$this->data);
		}
		else
		{
			$this->index();
		}
	}
	//seller transaction
	public function seller_transaction($currentPage=1,$limit=5)
	{
		//check weather user logged in or not
		if(!array_key_exists("slrd",$this->session->userdata())){redirect("seller_login");}
		$slrd = $this->session->userdata("slrd");
		
		if(isset($slrd["slrnm"]))
		{
			$seller_detail = $this->Sellerdb->select_seller(array("seller_username"=>$slrd["slrnm"]));			
			foreach($seller_detail as $k=>$obj){$this->data["sellerObj"] = $obj;}
			
			$data = array("payment_seller"=>$this->data["sellerObj"]->seller_id,"currentPage"=>$currentPage,"limit"=>$limit);
			$this->data = $this->Sellerdb->payment_history($data);
			$this->load->view("seller_transaction",$this->data);
		}
		else
		{
			$this->seller_own_listing();
		}
	}
	//seller or member search from
	public function seller_search()
	{
		$this->load->view("seller_search");
	}
	//get seller search result
	public function search_seller_result()
	{
		if(isset($_POST))
		{
			$data["seller_type"] = $this->input->post("search_type");
			$data["seller_username"] = $this->input->post("search_username");
			$data["seller_company"] = $this->input->post("search_company");
			$data["seller_firstname"] = $this->input->post("search_firstname");			
			$data["seller_lastname"] = $this->input->post("search_lastname");
			$data["order_by"] = $this->input->post("search_order");
			$this->session->set_userdata("search_seller_post",$data);
			$this->data = $this->Sellerdb->get_seller_search_resutl($data,1,5);
			
			$this->load->view("search_seller_result",$this->data);
		}
		else
		{
			$this->seller_search();
		}
	}
	// adding new payment
	public function seller_payment_subscription($id=0)
	{
		if($id>0)
		{
			$this->data["seller_detail"] = $this->Sellerdb->select_seller(array("seller_id"=>$id));
			$this->load->view("seller_payment_subscription",$this->data);
		}
		else
		{
			$this->index();
		}
	}
	public function seller_package_upgrade($seller_id=0,$package_subscription_id=0,$package_period="")
	{
		if($seller_id>0 && $package_subscription_id>0 && !empty($package_period))
		{
			$detail = $this->Sellerdb->select_seller(array("seller_id"=>$seller_id));
			foreach($detail as $obj){$sellerObj = $obj;}
			
			if($package_period=="3m")
			{
					$dateArray = explode("-",$sellerObj->seller_expire_date);
					$day = (int) $dateArray[2];
					$month = (int) $dateArray[1];
					$year = (int) $dateArray[0];
					$seller_expire_date = date('Y-m-d',mktime(0,0,0,$month+3,$day,$year));
					
					$payment_pack_days  = date("d",(strtotime($seller_expire_date - $sellerObj->seller_expire_date)));
					$data = array("seller_expire_date"=>$seller_expire_date,"seller_id"=>$seller_id,"seller_package"=>$sellerObj->seller_package,"seller_payment_period"=>"quarterly","package_subscription_id"=>$package_subscription_id,"payment_pack_days"=>90);
			}
			elseif($package_period=="6m")
			{
					$dateArray = explode("-",$sellerObj->seller_expire_date);
					$day = (int) $dateArray[2];
					$month = (int) $dateArray[1];
					$year = (int) $dateArray[0];
					$seller_expire_date = date('Y-m-d',mktime(0,0,0,$month+6,$day,$year));
					
					$payment_pack_days  = date("d",(strtotime($seller_expire_date - $sellerObj->seller_expire_date)));
					$data = array("seller_expire_date"=>$seller_expire_date,"seller_id"=>$seller_id,"seller_package"=>$sellerObj->seller_package,"seller_payment_period"=>"semiannually","package_subscription_id"=>$package_subscription_id,"payment_pack_days"=>180);
			}
			elseif($package_period=="12m")
			{
					$dateArray = explode("-",$sellerObj->seller_expire_date);
					$day = (int) $dateArray[2];
					$month = (int) $dateArray[1];
					$year = (int) $dateArray[0];
					$seller_expire_date = date('Y-m-d',mktime(0,0,0,$month+12,$day,$year));
					
					$payment_pack_days  = date("d",(strtotime($seller_expire_date - $sellerObj->seller_expire_date)));
					$data = array("seller_expire_date"=>$seller_expire_date,"seller_id"=>$seller_id,"seller_package"=>$sellerObj->seller_package,"seller_payment_period"=>"annually","package_subscription_id"=>$package_subscription_id,"payment_pack_days"=>365);
			}
			elseif($package_period=="1m")
			{	
					$dateArray = explode("-",$sellerObj->seller_expire_date);
					$day = (int) $dateArray[2];
					$month = (int) $dateArray[1];
					$year = (int) $dateArray[0];
					$seller_expire_date = date('Y-m-d',mktime(0,0,0,$month+1,$day,$year));
					
					$payment_pack_days  = date("d",(strtotime($seller_expire_date - $sellerObj->seller_expire_date)));
					
					$data = array("seller_expire_date"=>$seller_expire_date,"seller_id"=>$seller_id,"seller_package"=>1,"seller_payment_period"=>"monthly","package_subscription_id"=>$package_subscription_id,"payment_pack_days"=>30);
			}
			$this->data["success_msg"] = $this->Sellerdb->seller_package_upgrade($data);
			$this->payment_history($seller_id,1,5);			
		}
		else
		{
			$this->index();
		}
	}
	// adding feature list
	public function feature($status="off",$id=0,$page=0)
	{
		if($id>0)
		{
			if($status=="on"){$status="featured";}else{$status="";}
			$data = array("seller_status_feature"=>$status,"seller_id"=>$id);
			$this->data = $this->Sellerdb->feature($data);
			$this->data["page"] = $page;
			$ses = $this->session->userdata("search_seller_post");
			if(!empty($ses))
			{
				$data = $this->session->userdata("search_seller_post");
				$this->data = $this->Sellerdb->get_seller_search_resutl($data,1,5);			
				$this->load->view("search_seller_result",$this->data);
			}
			else
			{	
				$this->index();
			}
		}
		else
		{
			$this->index();
		}
	}
	// adding auto approve list
	public function auto_approve($status="off",$id=0,$page=0)
	{
		if($id>0)
		{
			$data = array("seller_status_approval"=>$status,"seller_id"=>$id);
			$this->data = $this->Sellerdb->auto_approve($data);
			$this->data["page"] = $page;
			$ses = $this->session->userdata("search_seller_post");
			if(!empty($ses))
			{
				$data = $this->session->userdata("search_seller_post");
				$this->data = $this->Sellerdb->get_seller_search_resutl($data,1,5);			
				$this->load->view("search_seller_result",$this->data);
			}
			else
			{	
				$this->index();
			}
		}
		else
		{
			$this->index();
		}
	}
	//delete seller payment history
	public function delete_payment_histroy($seller_id,$payment_id)
	{		
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$detail  = $this->Sellerdb->select_seller(array("seller_id"=>$seller_id));
		
		foreach($detail as $obj){$sellerObj = $obj;}
		$paymentObj = $this->Sellerdb->get_payment_detail($payment_id);
		
		$dateArray = explode("-",$sellerObj->seller_expire_date);
		
		$day = (int) $dateArray[2];
		$month = (int) $dateArray[1];
		$year = (int) $dateArray[0];
		
		$seller_expire_date = date("Y-m-d H:i:s",mktime(date("H"),date("i"),date("s"),$month,$day-$paymentObj->payment_pack_days,$year));
		
		$data = array("seller_expire_date"=>$seller_expire_date,"seller_id"=>$seller_id,"seller_package"=>$sellerObj->seller_package,"seller_payment_period"=>$sellerObj->seller_payment_period,"package_subscription_id");
		$this->Sellerdb->seller_package_degrade($data);
		$this->data["success_msg"] = $this->Sellerdb->delete_payment_histroy(array("payment_id"=>$payment_id));		
		$this->payment_history($seller_id,1,5);
	}
	//seller delete sec
	public function delete_seller($id=0,$page=0)
	{
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		$result = $this->Sellerdb->delete_seller(array("seller_id"=>$id));	
		$this->data["success_msg"] = $result;
		$this->page["page"] = $page;
		$ses = $this->session->userdata("search_seller_post");
		if(!empty($ses))
		{
			$data = $this->session->userdata("search_seller_post");
			$this->data = $this->Sellerdb->get_seller_search_resutl($data,1,5);			
			$this->load->view("search_seller_result",$this->data);
		}
		else
		{	
			$this->index();
		}
	}
	//image upload with creating thumb
	private function do_upload($file_name)
	{
		$config['upload_path'] = './logo_cache/';
		$config['allowed_types'] = 'jpg|jpeg';
		$config['max_size']	= '2000';
		$config['file_name'] = $file_name;
		
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload("seller_logo"))
		{
			return $this->data["error"] = $this->upload->display_errors();			
		}
		else
		{
			$image_data = $this->upload->data();
			$this->resize_image($image_data["full_path"],280,250);
		}		
	}
	// resize uploaded image
	private function resize_image($file_path, $width, $height)
	{
		$this->load->library('image_lib');	
		$img_cfg['image_library'] = 'gd2';
		$img_cfg['source_image'] = $file_path;
		$img_cfg['maintain_ratio'] = TRUE;
		$img_cfg['create_thumb'] = TRUE;
		$img_cfg['thumb_marker'] = "";
		$img_cfg['new_image'] = $file_path;
		$img_cfg['width'] = $width;
		$img_cfg['quality'] = 100;
		$img_cfg['height'] = $height;			
		$this->image_lib->initialize($img_cfg);
		$this->image_lib->resize();
	}
	//package listing section
	public function listing_package($data=array())
	{

		$this->data = $this->Sellerdb->select_listing_package();
		if(!empty($data)){$this->data["success_msg"]=$data["success_msg"];}
		$this->load->view("listing_package",$this->data);
	}
	public function listing_package_edit($package_listing_id=0)
	{
		if($package_listing_id>0)
		{
			$data=array("package_listing_id"=>$package_listing_id);
			$this->data = $this->Sellerdb->get_listing_package($data);
			$this->load->view("listing_package_edit",$this->data);
		}
		else
		{
			$this->listing_package();
		}
	}
	//Add new listing package
	public function add_listing_package()
	{
		$this->data["listingObj"] = (object) array(
			"package_listing_name_1"=>$this->input->post("package_listing_name_1"),
			"package_listing_price"=>$this->input->post("package_listing_price"),
			"package_listing_days"=>$this->input->post("package_listing_days"),
			"package_listing_pics"=>$this->input->post("package_listing_pics"),
			"package_listing_video"=>$this->input->post("package_listing_video"),
			"package_listing_doc"=>$this->input->post("package_listing_doc"),
			"package_listing_event"=>$this->input->post("package_listing_event"),
			"package_listing_news"=>$this->input->post("package_listing_news"),
			"package_listing_coupon"=>$this->input->post("package_listing_coupon"),
			"package_listing_product"=>$this->input->post("package_listing_product"),			
			"package_listing_category"=>$this->input->post("package_listing_category"),
			"package_listing_renew"=>"yes",
			"package_listing_featured"=>"no"
		);
		if($this->input->post("package_listing_name_1"))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules("package_listing_name_1","Package Name","trim|required");
			$this->form_validation->set_rules("package_listing_price","Price","trim|required");
			$this->form_validation->set_rules("package_listing_days","Days Before Expire","trim|required");
			$this->form_validation->set_rules("package_listing_pics","Max Pictures","trim|required");
			$this->form_validation->set_rules("package_listing_video","Max Video","trim|required");
			$this->form_validation->set_rules("package_listing_doc","Max Document","trim|required");
			$this->form_validation->set_rules("package_listing_event","Max Event","trim|required");
			$this->form_validation->set_rules("package_listing_news","Max News","trim|required");
			$this->form_validation->set_rules("package_listing_coupon","Max Coupon","trim|required");
			$this->form_validation->set_rules("package_listing_product","Max Product","trim|required");			
			$this->form_validation->set_rules("package_listing_category","Max Category","trim|required");
			$this->form_validation->set_rules("package_listing_renew","Show Renewable","trim|required");
			$this->form_validation->set_rules("package_listing_featured","Featured on Homepage","trim|required");
			if($this->form_validation->run()!=false)
			{
				$this->data = $this->Sellerdb->add_listing_package();
				$this->listing_package($this->data);
			}
			else
			{
				$this->data["validation_errors"] = validation_errors();
				$this->load->view("new_listing_package",$this->data);
			}			
		}
		else
		{
			$this->load->view("new_listing_package",$this->data);
		}
	}
	//listing package update
	public function listing_package_update()
	{
		if($this->input->post("package_listing_id"))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules("package_listing_name_1","Package Name","trim|required");
			$this->form_validation->set_rules("package_listing_price","Price","trim|required");
			$this->form_validation->set_rules("package_listing_days","Days Before Expire","trim|required");
			$this->form_validation->set_rules("package_listing_pics","Max Pictures","trim|required");
			$this->form_validation->set_rules("package_listing_video","Max Video","trim|required");
			$this->form_validation->set_rules("package_listing_doc","Max Document","trim|required");
			$this->form_validation->set_rules("package_listing_event","Max Event","trim|required");
			$this->form_validation->set_rules("package_listing_news","Max News","trim|required");
			$this->form_validation->set_rules("package_listing_coupon","Max Coupon","trim|required");
			$this->form_validation->set_rules("package_listing_product","Max Product","trim|required");			
			$this->form_validation->set_rules("package_listing_category","Max Category","trim|required");
			$this->form_validation->set_rules("package_listing_renew","Show Renewable","trim|required");
			$this->form_validation->set_rules("package_listing_featured","Featured on Homepage","trim|required");
			if($this->form_validation->run()!=false)
			{
				$this->data = $this->Sellerdb->listing_package_update();
				$this->listing_package($this->data);
			}
			else
			{
				$this->data["validation_errors"] = validation_errors();				
				$this->data["listingObj"] = (object) array(
					"package_listing_id"=>$this->input->post("package_listing_id"),
					"package_listing_name_1"=>$this->input->post("package_listing_name_1"),
					"package_listing_price"=>$this->input->post("package_listing_price"),
					"package_listing_days"=>$this->input->post("package_listing_days"),
					"package_listing_pics"=>$this->input->post("package_listing_pics"),
					"package_listing_video"=>$this->input->post("package_listing_video"),
					"package_listing_doc"=>$this->input->post("package_listing_doc"),
					"package_listing_event"=>$this->input->post("package_listing_event"),
					"package_listing_news"=>$this->input->post("package_listing_news"),
					"package_listing_coupon"=>$this->input->post("package_listing_coupon"),
					"package_listing_product"=>$this->input->post("package_listing_product"),			
					"package_listing_category"=>$this->input->post("package_listing_category"),
					"package_listing_renew"=>$this->input->post("package_listing_renew"),
					"package_listing_featured"=>$this->input->post("package_listing_featured")
				);
				$this->load->view("listing_package_edit",$this->data);
			}			
		}
		else
		{
			$this->listing_package();
		}
	}
	public function listing_package_delete($package_listing_id)
	{
		if($package_listing_id>0)
		{
			$this->data = $this->Sellerdb->listing_package_delete(array("package_listing_id"=>$package_listing_id));
			$this->listing_package($this->data);
		}
		else
		{
			$this->listing_package();
		}

	}
	//package subscription section
	public function subscription_package($data=array())
	{
		$this->data = $this->Sellerdb->select_subscription_package();
		if(!empty($data)){$this->data["success_msg"]=$data["success_msg"];}
		$this->load->view("subscription_package",$this->data);
	}
	public function subscription_package_edit($package_subscription_id=0)
	{
		if($package_subscription_id>0)
		{
			$data=array("package_subscription_id"=>$package_subscription_id);
			$this->data = $this->Sellerdb->get_subscription_package($data);
			$this->load->view("subscription_package_edit",$this->data);
		}
		else
		{
			$this->subscription_package();
		}
	}
	//Add new Subscription package
	public function add_subscription_package()
	{
		$this->data["subscriptionObj"] = (object) array(
					"package_subscription_name_1"=>"",
					"package_subscription_listings"=>"",
					"package_subscription_pics"=>"",
					"package_subscription_videos"=>"",
					"package_subscription_docs"=>"",
					"package_subscription_events"=>"",
					"package_subscription_news"=>"",
					"package_subscription_coupons"=>"",
					"package_subscription_products"=>"",
					"package_subscription_categories"=>"",			
					"package_subscription_featured"=>"no",
					"package_subscription_monthly"=>"",
					"package_subscription_quarterly"=>"",
					"package_subscription_semi_annually"=>"",
					"package_subscription_annually"=>""
				);
		if($this->input->post("package_listing_name_1"))
		{			
			$this->load->library('form_validation');
			$this->form_validation->set_rules("package_subscription_name_1","Package Name","trim|required");
			$this->form_validation->set_rules("package_subscription_listings","Listing","trim|required");
			$this->form_validation->set_rules("package_subscription_pics","Max Pictures","trim|required");
			$this->form_validation->set_rules("package_subscription_videos","Max Video","trim|required");
			$this->form_validation->set_rules("package_subscription_docs","Max Document","trim|required");
			$this->form_validation->set_rules("package_subscription_events","Max Event","trim|required");
			$this->form_validation->set_rules("package_subscription_news","Max News","trim|required");
			$this->form_validation->set_rules("package_subscription_coupons","Max Coupon","trim|required");
			$this->form_validation->set_rules("package_subscription_products","Max Product","trim|required");			
			$this->form_validation->set_rules("package_subscription_categories","Max Category","trim|required");
			$this->form_validation->set_rules("package_subscription_featured","Featured on Homepage","trim|required");
			$this->form_validation->set_rules("package_subscription_monthly","One Month Fee","trim|required");
			$this->form_validation->set_rules("package_subscription_quarterly","3 Months Fee","trim|required");
			$this->form_validation->set_rules("package_subscription_semi_annually","Semi Annual Fee on Homepage","trim|required");
			$this->form_validation->set_rules("package_subscription_annually","Annual Fee","trim|required");
			if($this->form_validation->run()!=false)
			{
				$this->data = $this->Sellerdb->add_subscription_package();
				$this->subscription_package($this->data);
			}
			else
			{
				$this->data["subscriptionObj"] = (object) array(
					"package_subscription_name_1"=>$this->input->post("package_subscription_name_1"),
					"package_subscription_listings"=>$this->input->post("package_subscription_listings"),
					"package_subscription_pics"=>$this->input->post("package_subscription_pics"),
					"package_subscription_videos"=>$this->input->post("package_subscription_videos"),
					"package_subscription_docs"=>$this->input->post("package_subscription_docs"),
					"package_subscription_events"=>$this->input->post("package_subscription_events"),
					"package_subscription_news"=>$this->input->post("package_subscription_news"),
					"package_subscription_coupons"=>$this->input->post("package_subscription_coupons"),
					"package_subscription_products"=>$this->input->post("package_subscription_products"),
					"package_subscription_categories"=>$this->input->post("package_subscription_categories"),			
					"package_subscription_featured"=>$this->input->post("package_subscription_featured"),
					"package_subscription_monthly"=>$this->input->post("package_subscription_monthly"),
					"package_subscription_quarterly"=>$this->input->post("package_subscription_quarterly"),
					"package_subscription_semi_annually"=>$this->input->post("package_subscription_semi_annually"),
					"package_subscription_annually"=>$this->input->post("package_subscription_annually")
				);
				$this->data["validation_errors"] = validation_errors();
				$this->load->view("new_subscription_package",$this->data);
			}			
		}
		else
		{
			$this->load->view("new_subscription_package",$this->data);
		}
	}
	//subscription package update
	public function subscription_package_update()
	{
		if($this->input->post("package_subscription_id"))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules("package_subscription_name_1","Package Name","trim|required");
			$this->form_validation->set_rules("package_subscription_listings","Listing","trim|required");
			$this->form_validation->set_rules("package_subscription_pics","Max Pictures","trim|required");
			$this->form_validation->set_rules("package_subscription_videos","Max Video","trim|required");
			$this->form_validation->set_rules("package_subscription_docs","Max Document","trim|required");
			$this->form_validation->set_rules("package_subscription_events","Max Event","trim|required");
			$this->form_validation->set_rules("package_subscription_news","Max News","trim|required");
			$this->form_validation->set_rules("package_subscription_coupons","Max Coupon","trim|required");
			$this->form_validation->set_rules("package_subscription_products","Max Product","trim|required");			
			$this->form_validation->set_rules("package_subscription_categories","Max Category","trim|required");
			$this->form_validation->set_rules("package_subscription_featured","Featured on Homepage","trim|required");
			$this->form_validation->set_rules("package_subscription_monthly","One Month Fee","trim|required");
			$this->form_validation->set_rules("package_subscription_quarterly","3 Months Fee","trim|required");
			$this->form_validation->set_rules("package_subscription_semi_annually","Semi Annual Fee on Homepage","trim|required");
			$this->form_validation->set_rules("package_subscription_annually","Annual Fee","trim|required");
			if($this->form_validation->run()!=false)
			{
				$this->data = $this->Sellerdb->subscription_package_update();
				$this->subscription_package($this->data);
			}
			else
			{
				$this->data["validation_errors"] = validation_errors();				
				$this->data["subscriptionObj"] = (object) array(
					"package_subscription_id"=>$this->input->post("package_subscription_id"),
					"package_subscription_name_1"=>$this->input->post("package_subscription_name_1"),
					"package_subscription_listings"=>$this->input->post("package_subscription_listings"),
					"package_subscription_pics"=>$this->input->post("package_subscription_pics"),
					"package_subscription_videos"=>$this->input->post("package_subscription_videos"),
					"package_subscription_docs"=>$this->input->post("package_subscription_docs"),
					"package_subscription_events"=>$this->input->post("package_subscription_events"),
					"package_subscription_news"=>$this->input->post("package_subscription_news"),
					"package_subscription_coupons"=>$this->input->post("package_subscription_coupons"),
					"package_subscription_products"=>$this->input->post("package_subscription_products"),
					"package_subscription_categories"=>$this->input->post("package_subscription_categories"),			
					"package_subscription_featured"=>$this->input->post("package_subscription_featured"),
					"package_subscription_monthly"=>$this->input->post("package_subscription_monthly"),
					"package_subscription_quarterly"=>$this->input->post("package_subscription_quarterly"),
					"package_subscription_semi_annually"=>$this->input->post("package_subscription_semi_annually"),
					"package_subscription_annually"=>$this->input->post("package_subscription_annually")
				);
				$this->load->view("subscription_package_edit",$this->data);
			}			
		}
		else
		{
			$this->subscription_package();
		}
	}
	public function subscription_package_delete($package_subscription_id)
	{
		if($package_subscription_id>0)
		{
			$this->data = $this->Sellerdb->subscription_package_delete(array("package_subscription_id"=>$package_subscription_id));
			$this->subscription_package($this->data);
		}
		else
		{
			$this->subscription_package();
		}
	}
	public function seller_profile_password()
	{
		if($this->input->post("seller_username"))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules("seller_username","User Name","trim|required");
			$this->form_validation->set_rules("seller_password_old","Old Password","trim|required");
			$this->form_validation->set_rules("seller_password_new","new Password","trim|required");
			$this->form_validation->set_rules("seller_password_new2","New password","trim|required");
			
			if($this->form_validation->run()!=false)
			{
				$seller_detail = $this->session->userdata("slrd");
				
				$newpass = $this->input->post("seller_password_new");
				$newpass2 = $this->input->post("seller_password_new2");
				$seller_username = $this->input->post("seller_username");
				$seller_pass_old = $this->input->post("seller_password_old");
				
				if($newpass==$newpass2)
				{
					if($slrd["slrnm"]==$seller_username && $slrd["seller_password"]==$seller_pass_old)
					{
						$result = $this->Sellerdb->change_seller_pass($status=true);
						$this->seller_own_listing();
					}
					else
					{
						$this->data["validation_errors"] = "Old password not matched...";
						$this->load->view("seller_profile_pass",$this->data);
					}
				}
				else
				{
					$this->data["validation_errors"] = "New pasword has not matched with confirmed password...";	
					$this->load->view("seller_profile_pass",$this->data);
				}
			}
			else
			{
				$this->data["validation_errors"] = validation_errors();	
				$this->load->view("seller_profile_pass",$this->data);
			}
		}
		else
		{
			$this->load->view("seller_profile_pass");
		}
	}
	public function seller_listing_setting()
	{
		$this->data["seller_listing_settingObj"] = $this->Sellerdb->get_seller_listing_setting();
		$this->load->view("seller_listing_setting",$this->data);
	}
	public function update_seller_listing_setting(){
			$id= $this->input->post('contractor_listing_setting_id');
			$data = (object) array(
			'feature_contractor_time_span' => $this->input->post('feature_contractor_time_span'),
			'new_contractor_time_span' => $this->input->post('new_contractor_time_span')
			);	
		$result = $this->Sellerdb->update_seller_listing_setting($id,$data);
		$this->data["success_msg"] = $result;		
		$this->seller_listing_setting();
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
	public function seller_email_verification($seller_id=0,$status="pedning",$page=0)
	{
		if($seller_id>0)
		{
			$this->Sellerdb->seller_email_verification($seller_id,$status);
			$this->data["page"] = $page;
			$this->index();
		}		
		//redirect("http://www.trustedhomecontractors.com/seller-login/");
	}
	private function do_payment($product)
	{
		$paypalObj = $this->Sellerdb->get_paypaldetail();
		$this->load->helper("string");
		$config['business'] 			= $paypalObj->payment_link;
		$config['cpp_header_image'] 	= ''; //Image header url [750 pixels wide by 90 pixels high]
		$config['return'] 				= base_url("seller/notify_payment/");
		//$config['cancel_return'] 		= base_url("payments/cancel_payment/");;
		//$config['notify_url'] 			= base_url("payments/do_payment/");; //IPN Post
		$config['production'] 			= FALSE; //Its false by default and will use sandbox
		//$config['discount_rate_cart'] 	= $product["discount"]; //This means 20% discount
		//$config["invoice"]				= '843843'; //The invoice id
		$config["invoice"]				= random_string("numeric",8);
		
		$this->load->library('Paypal',$config);
		
		#$this->paypal->add(<name>,<price>,<quantity>[Default 1],<code>[Optional]);
		
		$this->paypal->add($product["name"],$product["price"],$product["quantity"],$product["name"]); //First item function arguments like name , unit price , units, item number
		
		$this->paypal->pay();//Proccess the payment
	}
	public function notify_payment()
	{
		//$this->data = print_r($this->input->post(),true);
		$this->data["success_msg"] = "Verification mail has sent to your email address please check and verify it..";
		$this->load->view("seller_register",$this->data);
		//$this->load->view("paypal");
		//echo "<pre>".$received_data."</pre>";
	}
	public function cancel_payment()
	{
		$received_data = print_r($this->input->post(),true);
		//$this->load->view("paypal");
		echo "<pre>".$received_data."</pre>";
	}
}