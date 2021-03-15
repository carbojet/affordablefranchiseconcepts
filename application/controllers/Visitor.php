<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Visitor extends CI_Controller {



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

	  $this->load->model("Visitordb");

	}
/*re-capthca function*/
	function validate_captcha() {
        $captcha = $this->input->post('g-recaptcha-response');
         $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LekPjEUAAAAAEjicqiB6K5e88jewAajIdnDrEKq &response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        if ($response . 'success' == false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
/*re-capthca function*/

	//default load seller page		

	public function index()

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		$this->visitor_list(0,5);

	}

	public function access()

	{

		if(!array_key_exists("vztrd",$this->session->userdata()))

		{

			$this->load->model("Logindb");			

			$this->load->library('form_validation');

			$this->form_validation->set_rules("visitor_username","User Name","trim|required");

			$this->form_validation->set_rules("visitor_password","Password","trim|required");

			/*$this->form_validation->set_rules("verification_code","Captcha","trim|callback_captcha_matches");*/		

			if($this->form_validation->run()!=false)
			{
				$this->data = array("table_name"=>"visitor","visitor_username"=>$this->input->post("visitor_username"),"visitor_password"=>$this->input->post("visitor_password"));
				$result = $this->Logindb->login($this->data);
				if(count($result)>0)
				{
					foreach($result as $obj){
					$this->session->set_userdata("vztrd",array("vztrstatus"=>"loggedin","vztrnm"=>$obj->visitor_username,"vztrfn"=>$obj->visitor_firstname,"vztrln"=>$obj->visitor_lastname));
					}
					$redirect_page = $this->input->post("redirect_page");
					if($redirect_page=="favorite")
					{
						$this->data["listing_id"] = $this->input->post("listing_id");
						$this->data["visitor_username"] = $this->input->post("visitor_username");
						$this->Visitordb->add_visitor_favourite($this->data);

						$this->visitor_favourite();
					}

					elseif($redirect_page=="comment")
					{

						$this->data["listing_id"] = $this->input->post("listing_id");

						$this->data["listing_title"] = $this->input->post("listing_title");

						$visitorObj = $this->Visitordb->get_visitor_edit($this->input->post("visitor_username"));
						
						$this->data["comment_visitor"] = $visitorObj->visitor_id;

						$this->load->view("new_visitor_review",$this->data);

					}

					else

					{

						$this->load->view("visitor_dashboard");

					}

				}

				else

				{

					$this->data["validation_errors"] = "Invalid User name & password...";

					$this->data["captcha"] = $this->random_code_gen();

					$this->session->set_flashdata("data",$this->data);

					redirect("http://www.affordablebusinessconcepts.com/directory/visitor/login/");

				}				

			}

			else

			{

				//form error validation msg

				$this->data["captcha"] = $this->random_code_gen();

				$this->data["validation_errors"] = validation_errors();

				redirect("http://www.affordablebusinessconcepts.com/directory/visitor/login/");

			}

		}

		elseif(array_key_exists("vztrd",$this->session->userdata()))

		{

			$redirect_page = $this->input->post("redirect_page");

			if($redirect_page=="favorite")

			{

				$this->data["listing_id"] = $this->input->post("listing_id");						

				$this->data["visitor_username"] = $this->input->post("visitor_username");

				

				$this->Visitordb->add_visitor_favourite($this->data);

				$this->visitor_favourite();

			}

			elseif($redirect_page=="comment")

			{

				$this->data["listing_id"] = $this->input->post("listing_id");

				$this->data["listing_title"] = $this->input->post("listing_title");

				$visitorObj = $this->Visitordb->get_visitor_edit($this->input->post("visitor_username"));
				$this->data["visitor_username"] = $this->input->post("visitor_username");
				$this->data["visitor_password"] = $this->input->post("visitor_password");
				$this->data["comment_visitor"] = $visitorObj->visitor_id;

				$this->load->view("new_visitor_registration",$this->data);

			}

			else

			{

				$this->load->view("visitor_dashboard");

			}

		}

		else

		{

			$this->data["captcha"] = $this->random_code_gen();

			$this->load->view('visitor_login',$this->data);

		}	

	}	

	public function logout()
	{
		$this->session->sess_destroy();
		$this->data["msg"] = "You have been logged out...";
		$this->data["captcha"] = $this->random_code_gen();
		$this->session->set_flashdata("data",$this->data);
		redirect("http://www.affordablebusinessconcepts.com/");
	}

	public function login()

	{

		if(!array_key_exists("vztrd",$this->session->userdata()))

		{

			$this->data["captcha"] = $this->random_code_gen();

			

			$this->load->view('visitor_login',$this->data);

		}

		else

		{

			

			$this->load->view("visitor_dashboard");

		}

	}

	public function visitor_dashboard()

	{

		if(!array_key_exists("vztrd",$this->session->userdata()))

		{

			$this->data["captcha"] = $this->random_code_gen();

			$this->load->view('visitor_login',$this->data);

		}

		else

		{

			$this->load->view("visitor_dashboard");

		}

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

	public function	visitor_list($currentPage=0,$limit=100)

	{	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if($currentPage==0){$currentPage = $this->input->post("navigation_page");}

		

		$page_click = $this->input->post("page_click");

		if($page_click=="next"){$currentPage +=1;}

		elseif($page_click=="prev"){$currentPage -=1;}

		

		$this->session->set_userdata("search_visitor_post",array());

		$this->data = $this->Visitordb->visitor_list($currentPage,$limit);

		$this->load->view("visitors",$this->data);

	}

	//visitor profile edit

	public function visitor_profile_edit()
	{		
		//check weather user logged in or not
		if(!array_key_exists("vztrd",$this->session->userdata())){$this->login();}
		$vztrd = $this->session->userdata("vztrd");

		if(isset($vztrd["vztrnm"]))

		{

			$this->data["visitorObj"] = $this->Visitordb->get_visitor_edit($vztrd["vztrnm"]);



			$this->data["countryObjArray"] = $this->Visitordb->get_country_list();

			$this->data["titleObjArray"] = $this->Visitordb->get_title_list();

			$this->load->view("visitor_profile_edit",$this->data);

		}		  

	}

	public function visitor_edit($visitor_id=0,$page=0)

	{

		if($visitor_id>0)

		{

			$this->data["visitorObj"] = $this->Visitordb->visitor_edit($visitor_id);

			$this->data["countryObjArray"] = $this->Visitordb->get_country_list();

			$this->data["titleObjArray"] = $this->Visitordb->get_title_list();
			
			$this->data["commentObjArray"] = $this->Visitordb->get_visitor_comment($visitor_id);

			$this->data["page"] = $page;

			$this->load->view("visitor_edit",$this->data);

		}

		else

		{

			$this->visitor_list();

		}

	}

	public function update_visitor()

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if($this->input->post("visitor_id"))

		{

			$this->load->library('form_validation');

			$this->form_validation->set_rules("visitor_password","Password","trim|required");

			$this->form_validation->set_rules("visitor_firstname","First Name","trim|required");

			$this->form_validation->set_rules("visitor_lastname","Last Name","trim|required");

			$this->form_validation->set_rules("visitor_email","Email","trim|required|valid_email");

			$this->form_validation->set_rules("visitor_address","Mailing address","trim|required");

			$this->form_validation->set_rules("visitor_city","City / Town","trim|required");

			$this->form_validation->set_rules("visitor_province","State / Province","trim|required");

			$this->form_validation->set_rules("visitor_zip","Zip / Postal code","trim|required");

			if($this->form_validation->run()!=false)

			{

				//validation sucess

				$result = $this->Visitordb->update_visitor();

				$this->data["success_msg"] = $result;

				@unlink("./visitor_cache/".$this->input->post("visitor_id").".jpg");

				$image_data = $this->do_upload($this->input->post("visitor_id"));

				$ses = $this->session->userdata("search_visitor_post");

				if(!empty($ses))

				{

					$data = $this->session->userdata("search_visitor_post");

					$this->data = $this->Visitordb->visitor_list(1,5,$data);

					$this->load->view("visitor_search_list",$this->data);

				}

				else

				{		

					$this->visitor_list($this->input->post("page"),5);

				}

			}

			else

			{	

				//validation error

				$this->data["validation_errors"] = validation_errors();

				$this->data["venderObj"] = (object) $_POST;

				

				$this->data["countryObjArray"] = $this->Visitordb->get_country_list();

				$this->data["titleObjArray"] = $this->Visitordb->get_title_list();

				$this->load->view("visitor_edit",$this->data);				

			}

		}

		else

		{

			$this->visitor_list();

		}

	}

	//self profile edit

	public function update_visitor_profile()

	{

		//check weather user logged in or not

		if(!array_key_exists("vztrd",$this->session->userdata())){$this->login();}

		if($this->input->post("visitor_id"))

		{

			$this->load->library('form_validation');

			$this->form_validation->set_rules("visitor_password","Password","trim|required");

			$this->form_validation->set_rules("visitor_firstname","First Name","trim|required");

			$this->form_validation->set_rules("visitor_lastname","Last Name","trim|required");

			$this->form_validation->set_rules("visitor_email","Email","trim|required|valid_email");

			$this->form_validation->set_rules("visitor_address","Mailing address","trim|required");

			$this->form_validation->set_rules("visitor_city","City / Town","trim|required");

			$this->form_validation->set_rules("visitor_province","State / Province","trim|required");

			$this->form_validation->set_rules("visitor_zip","Zip / Postal code","trim|required");

			if($this->form_validation->run()!=false)

			{

				//validation sucess

				$result = $this->Visitordb->update_visitor();

				$this->data["success_msg"] = $result;

				@unlink("./visitor_cache/".$this->input->post("visitor_id").".jpg");

				$image_data = $this->do_upload($this->input->post("visitor_id"));			

				$this->visitor_profile_edit();

			}

			else

			{	

				//validation error

				$this->data["validation_errors"] = validation_errors();

				$this->data["visitorObj"] = (object) $_POST;

				

				$this->data["countryObjArray"] = $this->Visitordb->get_country_list();

				$this->data["titleObjArray"] = $this->Visitordb->get_title_list();

				$this->load->view("visitor_profile_edit",$this->data);				

			}

		}

		else

		{

			$this->visitor_profile_edit();

		}

	}

	//add new visitor

	public function add_visitor()

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if($this->input->post("visitor_username"))

		{

			$this->load->library('form_validation');

			$this->form_validation->set_rules("visitor_username","Password","trim|required|is_unique[visitor.visitor_username]");

			$this->form_validation->set_rules("visitor_password","Password","trim|required");

			$this->form_validation->set_rules("visitor_firstname","First Name","trim|required");

			$this->form_validation->set_rules("visitor_lastname","Last Name","trim|required");

			$this->form_validation->set_rules("visitor_email","Email","trim|required|valid_email");

			$this->form_validation->set_rules("visitor_address","Mailing address","trim|required");

			$this->form_validation->set_rules("visitor_city","City / Town","trim|required");

			$this->form_validation->set_rules("visitor_province","State / Province","trim|required");

			$this->form_validation->set_rules("visitor_zip","Zip / Postal code","trim|required");

			if($this->form_validation->run()!=false)

			{

				//validation sucess

				$result = $this->Visitordb->add_visitor();

				$this->data["success_msg"] = $result;

				//$image_data = $this->do_upload($this->input->post("visitor_id"));			

				$this->visitor_list();

			}

			else

			{	

				//validation error

				$this->data["validation_errors"] = validation_errors();

				$this->data["visitorObj"] = (object) $_POST;

				

				$this->data["countryObjArray"] = $this->Visitordb->get_country_list();

				$this->data["titleObjArray"] = $this->Visitordb->get_title_list();

				$this->load->view("new_visitor",$this->data);				

			}

		}

		else

		{

			$this->data["visitorObj"] = (object) array(

			"visitor_username"=>"",

			"visitor_password"=>"",

			"visitor_title"=>"",

			"visitor_firstname"=>"",

			"visitor_lastname"=>"",

			"visitor_phone"=>"",

			"visitor_mobile"=>"",

			"visitor_fax"=>"",

			"visitor_email"=>"",

			"visitor_website"=>"",

			"visitor_address"=>"",

			"visitor_address2"=>"",

			"visitor_city"=>"",

			"visitor_province"=>"",

			"visitor_zip"=>"",

			"visitor_country"=>""			

			);

			

			$this->data["countryObjArray"] = $this->Visitordb->get_country_list();

			$this->data["titleObjArray"] = $this->Visitordb->get_title_list();

			$this->load->view("new_visitor",$this->data);

		}

	}

	//visitor registration

	public function visitor_registration()

	{

		if($this->input->post("visitor_username"))

		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules("visitor_username","Password","trim|required|is_unique[visitor.visitor_username]");

			$this->form_validation->set_rules("visitor_password","Password","trim|required");

			$this->form_validation->set_rules("visitor_firstname","First Name","trim|required");

			$this->form_validation->set_rules("visitor_lastname","Last Name","trim|required");

			$this->form_validation->set_rules("visitor_email","Email","trim|required|valid_email");

			$this->form_validation->set_rules("visitor_address","Mailing address","trim|required");

			$this->form_validation->set_rules("visitor_city","City / Town","trim|required");

			$this->form_validation->set_rules("visitor_province","State / Province","trim|required");

			$this->form_validation->set_rules("visitor_zip","Zip / Postal code","trim|required");

			if($this->form_validation->run()!=false)

			{

				//validation sucess

				$data = array(

			"visitor_username"=>$this->input->post("visitor_username"),

			"visitor_password"=>$this->input->post("visitor_password"),

			//"visitor_title"=>$this->input->post("visitor_title"),

			"visitor_firstname"=>$this->input->post("visitor_firstname"),

			"visitor_lastname"=>$this->input->post("visitor_lastname"),

			"visitor_phone"=>$this->input->post("visitor_phone"),

			"visitor_mobile"=>$this->input->post("visitor_mobile"),

			//"visitor_fax"=>$this->input->post("visitor_fax"),

			"visitor_email"=>$this->input->post("visitor_email"),

			//"visitor_website"=>$this->input->post("visitor_website"),

			"visitor_address"=>$this->input->post("visitor_address"),

			//"visitor_address2"=>$this->input->post("visitor_address2"),

			"visitor_city"=>$this->input->post("visitor_city"),








			"visitor_province"=>$this->input->post("visitor_province"),

			"visitor_zip"=>$this->input->post("visitor_zip"),

			"visitor_country"=>$this->input->post("visitor_country"),

			//"visitor_language"=>$this->input->post("visitor_language"),

			"visitor_status"=>"approved",

			"visitor_status_email"=>"approved",

			"visitor_status_approval"=>"on",

			"visitor_lastupdate"=>date("Y-m-d H:i:s")				

			);

				$result = $this->Visitordb->visitor_register($data);

				$this->data["success_msg"] = $result;

				$this->data["visitor_username"] = $this->input->post("visitor_username");

				$this->data["visitor_password"] = $this->input->post("visitor_password");

				$this->data["listing_id"] = $this->input->post("listing_id");

				$this->data["redirect_page"] = $this->input->post("redirect_page");

				$this->load->view("new_visitor_registration",$this->data);

			}

			else

			{	

				//validation error
				//$this->load->view("visitor_registration",$this->data);
				
				$this->data["listing_id"] = $this->input->post("listing_id");			
				redirect("http://www.affordablebusinessconcepts.com/login/?user-type=new&listing_id=".$this->data["listing_id"]);

			}

		}

		else

		{

			redirect("http://www.affordablebusinessconcepts.com/");

		}

	}

	//visitor search

	public function search_visitor()

	{

		if(isset($_POST["visitor_firstname"]))

		{	

			$visitor_lastname = $this->input->post("visitor_lastname");

			$visitor_firstname = $this->input->post("visitor_firstname");

			$visitor_email = $this->input->post("visitor_email");
			
			$visitor_phone = $this->input->post("visitor_phone");

			$data=array();

			if(!empty($visitor_lastname))

			{

				$data["visitor_lastname"] = $this->input->post("visitor_lastname");

			}

			if(!empty($visitor_firstname))

			{

				$data["visitor_firstname"] = $this->input->post("visitor_firstname");

			}

			if(!empty($visitor_email))

			{

				$data["visitor_email"] = $this->input->post("visitor_email");

			}
			
			if(!empty($visitor_phone))

			{

				$data["visitor_phone"] = $this->input->post("visitor_phone");

			}

			

			$currentPage=0;

			if($currentPage==0){$currentPage = $this->input->post("navigation_page");}

			

			$page_click = $this->input->post("page_click");

			

			if($page_click=="next"){$currentPage +=1;}

			elseif($page_click=="prev"){$currentPage -=1;}

			

			$this->data["post_data"] = $data;

			$this->session->set_userdata("search_visitor_post",$data);

			$this->data = $this->Visitordb->visitor_list($currentPage,100,$data);

			$this->load->view("visitor_search_list",$this->data);

		}

		else

		{

			$this->load->view("search_visitor");

		}

	}

	public function auto_approval($status="off",$visitor_id=0,$page=0)

	{

		$this->data["success_msg"] = $this->Visitordb->auto_approval($visitor_id,$status);

		$ses = $this->session->userdata("search_visitor_post");

		if(!empty($ses))

		{

			$data = $this->session->userdata("search_visitor_post");

			$this->data = $this->Visitordb->visitor_list(1,5,$data);

			$this->load->view("visitor_search_list",$this->data);

		}

		else

		{		

			$this->visitor_list($page,5);

		}

	}

	public function delete_visitor($visitor_id=0,$page=0)

	{

		$this->data["success_msg"] = $this->Visitordb->delete_visitor($visitor_id);

		$ses = $this->session->userdata("search_visitor_post");

		if(!empty($ses))

		{

			$data = $this->session->userdata("search_visitor_post");

			$this->data = $this->Visitordb->visitor_list(1,100,$data);

			$this->load->view("visitor_search_list",$this->data);

		}

		else

		{		

			$this->visitor_list($page,100);

		}

	}
	public function delete_selected_visitor()
	{	
		$visitor_list = $this->input->post("visitor_status_delete");
		if(count($visitor_list)>0)
		{
			foreach($visitor_list as $k=>$val)
			{
				$this->data["success_msg"] = $this->Visitordb->delete_visitor($val);
			}
		}
		$ses = $this->session->userdata("search_visitor_post");

		if(!empty($ses))
		{
			$data = $this->session->userdata("search_visitor_post");

			$this->data = $this->Visitordb->visitor_list(1,100,$data);

			$this->load->view("visitor_search_list",$this->data);

		}
		else
		{
			$page = $this->input->post("navigation_page");
			$this->visitor_list($page,100);

		}
	}

	public function visitor_reviews($visitor_id=0)

	{

		if($visitor_id>0)

		{

			$this->data["visitorObj"] = $this->Visitordb->visitor_edit($visitor_id);

			$this->data["visitor_review_list"] = $this->Visitordb->get_visitor_reviews($visitor_id);

			$this->load->view("visitor_reviews",$this->data);

		}

		else

		{

			$this->visitor_list();

		}

	}

	public function add_visitor_review()

	{

		$this->Visitordb->add_visitor_review();

		$this->visitor_review();

	}

	public function visitor_review()

	{

		$vztrd = $this->session->userdata("vztrd");

		$this->data["visitor_review_list"] = $this->Visitordb->get_visitor_reviews($vztrd["vztrnm"]);

		$this->load->view("visitor_review",$this->data);

	}

	public function visitor_review_edit($comment_id=0)

	{

		$this->data["reviewObj"] = $this->Visitordb->visitor_review_edit($comment_id);

		$this->load->view("visitor_review_edit",$this->data);

	}

	public function update_visitor_review()

	{

		if($this->input->post("comment_id"))

		{

			$this->load->library('form_validation');

			$this->form_validation->set_rules("comment_rating","comment rating","required");

			$this->form_validation->set_rules("comment_title","comment title","trim|required");

			$this->form_validation->set_rules("comment_description","comment description","trim|required");

			if($this->form_validation->run()!=false)

			{

				$this->Visitordb->update_visitor_review();

				$this->visitor_review();

			}

			else

			{

				$this->data["reviewObj"] = (object) $_POST;

				$this->load->view("visitor_review_edit",$this->data);

			}

		}

		else

		{

			$this->visitor_review();

		}

	}

	public function delete_visitor_review($id=0)

	{

		$this->Visitordb->delete_visitor_review($id);

		$this->visitor_review();		

	}

	private function add_visitor_favourite($listing_id=0)

	{

		$this->Visitordb->add_visitor_favourite();

	}

	public function visitor_favourite()

	{

		$vztrd = $this->session->userdata("vztrd");

		$this->data["visitor_favourite"] = $this->Visitordb->visitor_favourite($vztrd["vztrnm"]);

		$this->load->view("visitor_favourite",$this->data);

	}

	public function visitor_email_verification($visitor_id=0,$status="pedning",$page=0)

	{

		if($visitor_id>0)

		{

			$this->Visitordb->visitor_email_verification($seller_id,$status);

			$this->visitor_list($page,5);

		}		

		//redirect("http://www.trustedhomecontractors.com/seller-login/");

	}

	public function delete_visitor_favourite($id=0)

	{

		$this->Visitordb->delete_visitor_favourite($id);

		$this->visitor_favourite();

	}

	//image upload with creating thumb

	private function do_upload($file_name)

	{

		$config['upload_path'] = './visitor_cache/';

		$config['allowed_types'] = 'jpg|jpeg';

		$config['max_size']	= '2000';

		$config['file_name'] = $file_name;

		

		$this->load->library('upload', $config);



		if (!$this->upload->do_upload("visitor_logo"))

		{

			return $this->data["error"] = $this->upload->display_errors();			

		}

		else

		{

			$image_data = $this->upload->data();

			$this->resize_image($image_data["full_path"],180,180);

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

	public function random_code_gen($limit=5)

	{

		$rand ="";

		for($i=1;$i<=$limit;$i++)

		{

			$rand .=rand(0,9);

		}

		return $rand;		

	}

	public function ajax_log_status()
	{

		//$this->output->set_content_type('application/json');

		if(!array_key_exists("vztrd",$this->session->userdata()))

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
	public function multipl_ads_request()
	{				
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title','Title','trim|required');
			$this->form_validation->set_rules('visitor_first_name','First Name','trim|required|min_length[2]');
			$this->form_validation->set_rules('visitor_last_name','Last Name','trim|required|min_length[2]');
			//$this->form_validation->set_rules('visitor_email','Email','trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('visitor_email','Email','trim|required|valid_email');
			$this->form_validation->set_rules('visitor_tel','Contact Number','trim|required|regex_match[/^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/] ');
			$this->form_validation->set_rules('visitor_strt_add_one','Address-1','trim|required|min_length[2]');
			$this->form_validation->set_rules('visitor_strt_add_two','Address-2','trim');
			$this->form_validation->set_rules('visitor_city','City','trim|required|min_length[2]');
			$this->form_validation->set_rules('visitor_st_pro','State','trim|required|min_length[2]');
			$this->form_validation->set_rules('visitor_country','Country','trim|required|min_length[2]');
			$this->form_validation->set_rules('visitor_postal_code','Postal Code','trim|required');
			$this->form_validation->set_rules('visitor_capital_invest','Capital Available to Inest','trim|required');
			$this->form_validation->set_rules('visitor_est_nt_worth','estimated Net Worth','trim|required');
			$this->form_validation->set_rules('visitor_time_frame','Purchase Time Frame','trim|required');
			$this->form_validation->set_rules('visitor_eesired_location','Desired Location','trim|required|min_length[2]');
			$this->form_validation->set_rules('comments','trim');
			/*re-capthca*/
			$this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
			$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
			/*re-capthca*/
			if ($this->form_validation->run() != FALSE)
			{
	$content = "<table style='border-color:#666' cellpadding='10'>
	<tbody>";
				$listing_id_array = $this->input->post("selected_ad_id");
				$ad_title = $this->input->post("ad_title");
				foreach($ad_title as $k=>$val){
					$content .= "<tr>
						<td>Ad Title</td>
						<td><a href='http://www.affordablebusinessconcepts.com/product/?listing_id=".$listing_id_array[$k]."' target='_blank'>$val</a></td>
					  </tr>";
				}
				
				$title = $this->input->post("title");	
				$visitor_first_name = $this->input->post("visitor_first_name");	
				$visitor_last_name = $this->input->post("visitor_last_name");	
				$visitor_email = $this->input->post("visitor_email");	
				$visitor_tel = $this->input->post("visitor_tel");	
				$visitor_strt_add_one = $this->input->post("visitor_strt_add_one");	
				$visitor_strt_add_two = $this->input->post("visitor_strt_add_two");	
				$visitor_city = $this->input->post("visitor_city");	
				$visitor_st_pro = $this->input->post("visitor_st_pro");	
				$visitor_country = $this->input->post("visitor_country");	
				$visitor_zip = $this->input->post("visitor_postal_code");	
				$visitor_capital_invest = $this->input->post("visitor_capital_invest");	
				$visitor_est_nt_worth = $this->input->post("visitor_est_nt_worth");	
				$visitor_time_frame = $this->input->post("visitor_time_frame");	
				$visitor_eesired_location = $this->input->post("visitor_eesired_location");	
				$comments = $this->input->post("comments");	
				$chk1 = $this->input->post("chk1");
			
			
				
				
						
				//$from = "no-reply@affordablebusinessconcepts.com";
				//$to = array("info@affordablebusinessconcepts.com");
				$from = $visitor_email;
				$to = array("info@affordablebusinessconcepts.com");
				//$to = "pragyana.highermatrix@gmail.com";
				//$smtp_host = "www.some.com/pop3";
				//$smtp_user = "user_name";
				//$smpt_pass = "password";
				$content  .= "		
	<tr>
	<td><strong>Name:</strong></td>
	<td>$title $visitor_first_name $visitor_last_name</td>
	</tr>
	<tr>
	<td><strong>Email</strong></td>
	<td><a href='mailto:$visitor_email' target='_blank'>$visitor_email</a></td>
	</tr>
	<tr>
	<td><strong>Phone</strong></td>
	<td>$visitor_tel</td>
	</tr>
	<tr>
	<td><strong>Street Address Line One</strong></td>
	<td>$visitor_strt_add_one</td>
	</tr>
	<tr>
	<td><strong>Street Address Line Two</strong></td>
	<td>$visitor_strt_add_two</td>
	</tr>
	<tr>
	<td><strong>City</strong></td>
	<td>$visitor_city</td>
	</tr>
	<tr>
	<td><strong>State or Province</strong></td>
	<td>$visitor_st_pro</td>
	</tr>
	<tr>
	<td><strong>Country</strong></td>
	<td>$visitor_country</td>
	</tr>
	<tr>
	<td><strong>Zip or Postal Code</strong></td>
	<td>$visitor_zip</td>
	</tr>
	<tr>
	<td><strong>Capital Available to invest</strong></td>
	<td>$visitor_capital_invest</td>
	</tr>
	<tr>
	<td><strong>Estimated Net Worth</strong></td>
	<td>$visitor_est_nt_worth</td>
	</tr>
	<tr>
	<td><strong>Purchase Time Frame</strong></td>
	<td>$visitor_time_frame</td>
	</tr>
	<tr>
	<td><strong>Desired Location</strong></td>
	<td>$visitor_eesired_location</td>
	</tr>
	<tr>
	<td><strong>Additional Comments</strong></td>
	<td>$comments</td>
	</tr>
	</tbody></table>
	<p>&nbsp;$chk1<br></p>";
				//$config['protocol'] = 'smtp';
				//admin mail
				$this->load->library('email');	
				$config['mailtype'] = 'html';		
				//$this->email->set_newline("\r\n");
				$this->email->initialize($config);
				
				$this->email->from($from, $visitor_first_name);
				$this->email->to($to); 	
				$this->email->reply_to($visitor_email);	
				$this->email->subject('Multiple Ads request');
				$this->email->message($content);	
				
				$this->email->send();
				
				$mail_send_status = $this->email->send();
				if(!$mail_send_status)
				{
					//var_dump($this->email->print_debugger());
				}
				/*//commented line for testing
				$from = "info@affordablebusinessconcepts.com";
				//admin mail
				$this->load->library('email');	
				$config['mailtype'] = 'html';
				$config['newline']	= "\r\n";	
	
				$this->email->initialize($config);
				
				$this->email->from($from, $visitor_first_name);
				$this->email->to("info@affordablebusinessconcepts.com"); 	
				$this->email->reply_to($visitor_email);	
				$this->email->subject('Multiple Ads request');
				$this->email->message($content);			
				$this->email->send();*/
				
				//CLIENT MAIL
				$this->load->library('email');	
				$config['mailtype'] = 'html';		
				//$this->email->set_newline("\r\n");
				$this->email->initialize($config);
				
				$content = '<table style="width:100%;border:none;"><tr><td style="background-color:#c9a252;padding:70px 0 200px 0;"><table rules="all" align="center" cellpadding="10" style="width:80%;" cellspacing="0"><tr><td bgcolor="#333333" height="25"></td></tr><tr><td bgcolor="#ffffff">Hello <span style="text-transform:capitalize;">'.$visitor_first_name.'</span>,<p style="text-align:left;">Thank you for expressing interest in this excellent franchise opportunity featured at <a href="http://www.affordablebusinessconcepts.com/"> AffordableBusinessConcepts.com </a> . One of our consultants will be contacting you to share more insight into the advertisement you requested: </p>';
	
				foreach($ad_title as $k=>$val)
				{
					$content .='<a href="http://www.affordablebusinessconcepts.com/product/?listing_id='.$listing_id_array[$k].'" target="_blank">'.$val.'</a><br/>';
				}
	
	$content .='<p style="text-align:left;">If you are a business professional ready to build your own business, then franchising as you know is a wonderful way to go into business for yourself - without being by yourself. You don&#39;t have to be an expert at franchising or have industry experience. Because your growth affects the growth of the franchisor, you&#39;ll find a team of dedicated professionals willing and able to support you every step of the way.</p>
	
	<p style="text-align:left;">Affordable Business Concepts, LLC provides professional consulting and placement services for entrepreneurs without cost or obligation. We represent several hundred top ranked franchises in all industries, and have a very high success rate of matching qualified buyers to their ideal business. </p>
	
	<p style="text-align:left;">We respect buying a business is a major investment. In considering the purchase of a franchise, we recommend you participate in their educational process to become fully informed on the opportunity prior to making a decision. We also encourage you to visit our website where you will find information on how to investigate a franchise along with other tutorial documents, videos and resources. </p>
	
	<p style="text-align:left;">We look forward to assisting in your business exploration.</p>
	
	<p style="text-align:left;">Affordable Business Concepts, L.L.C.<br/>International Franchise Consultants<br/>Toll Free 1-866-388-3576<br/> Fax: (480) 320-4103</p>
	
	<p style="text-align:left;font-size:80%;">Affordable Business Concepts, LLC represents hundreds of top quality franchises opportunities in various industries. We are Certified Franchise Consultants with more than 20 years of experience Guiding Entrepreneurs to Golden Opportunities. Affordable Business Concepts, LLC respects the privacy of buyers and does not rent or sell any confidential information to any 
third party.</p>
	</td></tr></table></td></tr></table>';
				
				//$this->email->from("info@affordablebusinessconcepts.com","Affordable Business Concepts, LLC");
				$this->email->from("info@affordablebusinessconcepts.com","Affordable Business Concepts, LLC");
				$this->email->to($visitor_email); 		
				$this->email->subject('Your Business Inquiry Confirmation');
				$this->email->message($content);	
				
				$mail_send_status = $this->email->send();
				if(!$mail_send_status)
				{
					//var_dump($this->email->print_debugger());
				}
				$visitor_username = mt_rand(1000000000,9999999999);
				$visitor_password = mt_rand(1000000000,9999999999);
				$this->db->insert("visitor",array("visitor_username"=>$visitor_username,"visitor_password"=>$visitor_password,"visitor_title"=>$title,"visitor_firstname"=>$visitor_first_name,"visitor_lastname"=>$visitor_last_name,"visitor_email"=>$visitor_email,"visitor_phone"=>$visitor_tel,"visitor_address"=>$visitor_strt_add_one,"visitor_address2"=>$visitor_strt_add_two,"visitor_city"=>$visitor_city,"visitor_province"=>$visitor_st_pro,"visitor_zip"=>$visitor_zip,"visitor_country"=>$visitor_country,"visitor_company"=>$visitor_capital_invest,"visitor_mobile"=>$visitor_est_nt_worth,"visitor_fax"=>$visitor_time_frame,"visitor_website"=>$visitor_eesired_location,"visitor_logo"=>$comments,"visitor_lastupdate"=>date("Y-m-d H:i:s")));
			    $comment_visitor = $this->db->insert_id();
				//getting ip address
				if(!empty($_SERVER['HTTP_CLIENT_IP'])){$ip = $_SERVER['HTTP_CLIENT_IP'];}
				elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
				else{$ip = $_SERVER['REMOTE_ADDR'];}
				if(!empty($ad_title))
				{
					foreach($ad_title as $k=>$val)
					{
						$listing_id = $listing_id_array[$k];
						if($listing_id>0)
						{
							$this->db->insert("visitor_comment",array("comment_type"=>"listing","comment_linkid"=>$listing_id,"comment_visitor"=>$comment_visitor,"comment_rating"=>0,"comment_title"=>"Subscribe mail","comment_description"=>$comments,"comment_ipaddress"=>$ip,"comment_lastupdate"=>date("Y-m-d H:s:i"),"comment_status"=>"approved"));
							
							$listing_array = $this->db->get_where("listing",array("listing_id"=>$listing_id))->result();
							foreach($listing_array as $listing)
							{
								$visited = $listing->listing_visited+1;
								$this->db->where(array("listing_id"=>$listing_id))->update("listing",array("listing_visited"=>$visited));
							}
						}
					}
				}
				$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>0,"result"=>"MAIL SENT")));
							
			}
			else
			{
				//$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>1,"result"=>"Multiad request haveing some programming error")));
	    		$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>1,"result"=>validation_errors())));
			}
	}
	public function request_singalad()
	{
		$this->load->library('form_validation');
                $post = $this->input->post();
                unset($post["visitor_strt_add_two"]);    
                //code added by swati on 23/09/17
                unset($post["comments"]);    
                
		foreach($post as $k=>$value)
		{
			if(strpos("email",$k) !== false)
			{
				$this->form_validation->set_rules($k,"Email",'trim|required|valid_email');
			}
			elseif(strpos("tel",$k) !== false)
			{
				$this->form_validation->set_rules($k,"Phone",'trim|required|exact_length[12]');
			}
			else
			{
				$this->form_validation->set_rules($k,str_replace('_',' ',ucfirst($k)),'trim|required|min_length[2]');
			}
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>1,"result"=>validation_errors())));
		}
		else
		{
			$this->load->model("Listingdb");
			$listingData = $this->Listingdb->select_listing(array("listing_id"=>$this->input->post('listing_id')));
			$listingObj = $listingData[0];
			$listing_title = $listingObj->listing_title_1;
			
			$content ='<table style="border-color: #666;" cellpadding="10">
  <tr>
  <td colspan="2"><a href="'.$this->input->post('listing_ad_link').'">'.$listing_title.'</a></td>
  </tr>
  <tr>
    <td><strong>Name:</strong></td>
    <td>'.$this->input->post('title').' '.$this->input->post('visitor_first_name').' '.$this->input->post('visitor_last_name').'</td>
  </tr>
  <tr>
    <td><strong>Email</strong></td>
    <td>'.$this->input->post('visitor_email').'</td>
  </tr>
  <tr>
    <td><strong>Phone</strong></td>
    <td>'.$this->input->post('visitor_tel').'</td>
  </tr>
  <tr>
    <td><strong>Street Address Line One</strong></td>
    <td>'.$this->input->post('visitor_strt_add_one').'</td>
  </tr>
  <tr>
    <td><strong>Street Address Line Two</strong></td>
    <td>'.$this->input->post('visitor_strt_add_two').'</td>
  </tr>
  <tr>
	<td><strong>City</strong></td>
    <td>'.$this->input->post('visitor_city').'</td>
  </tr>
  <tr>
    <td><strong>State or Province</strong></td>
    <td>'.$this->input->post('visitor_st_pro').'</td>
  </tr>
  <tr>
    <td><strong>Country</strong></td>
    <td>'.$this->input->post('visitor_country').'</td>
  </tr>
  <tr>
    <td><strong>Zip or Postal Code</strong></td>
    <td>'.$this->input->post('visitor_postal_code').'</td>
  </tr>
  <tr>
    <td><strong>Capital Available to invest</strong></td>
    <td>'.$this->input->post('visitor_capital_invest').'</td>
  </tr>
  <tr>
    <td><strong>Estimated Net Worth</strong></td>
    <td>'.$this->input->post('visitor_est_nt_worth').'</td>
  </tr>
  <tr>
    <td><strong>Purchase Time Frame</strong></td>
    <td>'.$this->input->post('visitor_time_frame').'</td>
  </tr>
  <tr>
    <td><strong>Desired Location</strong></td>
    <td>'.$this->input->post('visitor_eesired_location').'</td>
  </tr>
  <tr>
    <td><strong>Additional Comments</strong></td>
    <td>'.$this->input->post('comments').'</td>
  </tr>
  </table>
&nbsp;'.$this->input->post('chk1');
			$from = "info@affordablebusinessconcepts.com";
			$to = array("info@affordablebusinessconcepts.com");
			//$to = "pragyana.highermatrix@gmail.com";
			//admin mail
			$this->load->library('email');	
			$config['mailtype'] = 'html';		
			$this->email->initialize($config);
			
			$this->email->from($from, $this->input->post('visitor_first_name'));
			$this->email->to($to); 	
			$this->email->reply_to($this->input->post('visitor_email'));	
			$this->email->subject($this->input->post('title').' '.$this->input->post('visitor_first_name').' '.$this->input->post('visitor_last_name').' Interested in '.$listing_title);
			$this->email->message($content);	
			
			$this->email->send();
			$mail_send_status = $this->email->send();
			
			$content = '<table style="width:100%;border:none;"><tr><td style="background-color:#c9a252;padding:70px 0 200px 0;"><table rules="all" align="center" cellpadding="10" style="width:80%;" cellspacing="0"><tr><td bgcolor="#333333" height="25"></td></tr><tr><td bgcolor="#ffffff">Hello <span style="text-transform:capitalize;">'.$this->input->post("visitor_first_name").';</span>

<p style="text-align:left;">Thank you for expressing interest in this excellent franchise opportunity featured at <a href="http://www.affordablebusinessconcepts.com">AffordableBusinessConcepts.com</a>. One of our consultants will be contacting you to share more insight into the advertisement you requested: <a href="'.$this->input->post("listing_ad_link").'">'.$listing_title.'</a></p><p style="text-align:left;">If you are a business professional ready to build your own business, then franchising as you know is a wonderful way to go into business for yourself - without being by yourself. You don&#39;t have to be an expert at franchising or have industry experience. Because your growth affects the growth of the franchisor, you&#39;ll find a team of dedicated professionals willing and able 
to support you every step of the way.</p><p style="text-align:left;">Affordable Business Concepts, LLC provides professional consulting and placement services for entrepreneurs without cost or obligation. We represent several hundred top ranked franchises in all industries, and have a very high success rate of matching qualified buyers to their ideal business </p><p style="text-align:left;">We respect buying a business is a major investment. In considering the purchase of a franchise, we recommend you participate in their educational process to become fully informed on the opportunity prior to making a decision. We also encourage you to visit our website where you will find information on how to investigate a franchise along with other tutorial documents, videos and resources. </p><p style="text-align:left;">We look forward to assisting in your business exploration. </p>
<p><table><tr><td>Affordable Business Concepts, L.L.C.</td></tr><tr><td>International Franchise Consultants</td></tr><tr><td>Toll Free 1-866-388-3576 Fax: (480) 320-4103</td></tr></table></p><p style="text-align:left;font-size:80%;padding-left:3px;">Affordable Business Concepts, LLC represents hundreds of top quality franchises opportunities in various industries. We are Certified Franchise Consultants with more than 20 years of experience Guiding Entrepreneurs to Golden Opportunities. Affordable Business Concepts, LLC respects the privacy of buyers and does not rent or sell any confidential information to any third party.</p></td></tr></table></td></tr></table>';
			
			$to = $this->input->post('visitor_email');
			$from = "info@affordablebusinessconcepts.com";
			//admin mail
			$this->load->library('email');	
			$config['mailtype'] = 'html';		
			//$this->email->set_newline("\r\n");
			$this->email->initialize($config);
			
			$this->email->from($from, 'Affordable Business Concepts,LLC');
			$this->email->to($to); 	
			$this->email->reply_to('info@affordablebusinessconcepts.com');	
			$this->email->subject('Your Business Inquiry Confirmation for '.$listing_title);
			$this->email->message($content);	
			
			$this->email->send();
			$mail_send_status = $this->email->send();
			$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>0,"result"=>"MAIL SENT")));
		}
	}
	public function request_information()
	{
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('g-recaptcha-responsee', 'recaptcha validation', 'required|callback_validate_captchaa');
		//$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
		$post = $this->input->post();
		//unset($post["visitor_strt_add_one"]);
		unset($post["visitor_strt_add_two"]);
		//unset($post["visitor_country"]);
		unset($post["visitor_capital_invest"]);
		unset($post["visitor_est_nt_worth"]);
		unset($post["visitor_time_frame"]);
		unset($post["visitor_eesired_location"]);
		//codeadded by swati on 22/09/17 
		unset($post["comments"]);
		
		foreach($post as $k=>$v)
		{
		    //print_r($k); exit;
			if(strpos("email",$k) !== false)
			{
				$this->form_validation->set_rules($k,"Email",'trim|required|valid_email');
			}
			elseif(strpos("tel",$k) !== false)
			{
				$this->form_validation->set_rules($k,"Phone",'trim|required|exact_length[12]');
			}
			else
			{
				$this->form_validation->set_rules($k,str_replace('_',' ',ucfirst($k)),'trim|required|min_length[2]');
			} 
		}
	/*	$this->form_validation->set_rules('g-recaptcha-responsee', 'recaptcha validation', 'required|callback_validate_captchaa');
		$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
		function validate_captchaa() {
        $captcha = $this->input->post('g-recaptcha-responsee');
         $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfNQDEUAAAAADXjdszwZuGd0jfoJ5fY8TX0AgEn &response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        if ($response . 'success' == false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }*/
		if ($this->form_validation->run() == FALSE)
		{
			//$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>1,"result"=>"VALIDATION ERROR")));
			$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>1,"result"=>validation_errors())));
		}
		else
		{		
				$content = '<table style="border-color: #666;" cellpadding="10">
  <tr>
    <td><strong>Name:</strong></td>
    <td>'.$this->input->post('title').' '.$this->input->post('visitor_first_name').' '.$this->input->post('visitor_last_name').'</td>
  </tr>
  <tr>
    <td><strong>Email</strong></td>
    <td>'.$this->input->post('visitor_email').'</td>
  </tr>
  <tr>
    <td><strong>Phone</strong></td>
    <td>'.$this->input->post('visitor_tel').'</td>
  </tr>
  <tr>
    <td><strong>Street Address Line One</strong></td>
    <td>'.$this->input->post('visitor_strt_add_one').'</td>
  </tr>
  <tr>
    <td><strong>Street Address Line Two</strong></td>
    <td>'.$this->input->post('visitor_strt_add_two').'</td>
  </tr>
  <tr>
    <td><strong>City</strong></td>
    <td>'.$this->input->post('visitor_city').'</td>
  </tr>
  <tr>
    <td><strong>State or Province</strong></td>
    <td>'.$this->input->post('visitor_st_pro').'</td>
  </tr>
  <tr>
    <td><strong>Country</strong></td>
    <td>'.$this->input->post('visitor_country').'</td>
  </tr>
  <tr>
    <td><strong>Zip or Postal Code</strong></td>
    <td>'.$this->input->post('visitor_postal_code').'</td>
  </tr>

  <tr>
    <td><strong>Capital Available to invest</strong></td>
    <td>'.$this->input->post('visitor_capital_invest').'</td>
  </tr>
  <tr>
    <td><strong>Estimated Net Worth</strong></td>
    <td>'.$this->input->post('visitor_est_nt_worth').'</td>
  </tr>
  <tr>
    <td><strong>Purchase Time Frame</strong></td>
    <td>'.$this->input->post('visitor_time_frame').'</td>
  </tr>
  <tr>
    <td><strong>Desired Location</strong></td>
    <td>'.$this->input->post('visitor_eesired_location').'</td>
  </tr>
  <tr>
    <td><strong>Additional Comments</strong></td>
    <td>'.$this->input->post('comments').'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>'.$this->input->post('chk1').'</td>
  </tr>
</table>';			
			$to = "info@affordablebusinessconcepts.com";
			//$to = "swatimishra.highermatrix@gmail.com";
			//$to = "pragyana.highermatrix@gmail.com";
			$from = $this->input->post('visitor_email');
			//admin mail
			$this->load->library('email');	
			$config['mailtype'] = 'html';		
			//$this->email->set_newline("\r\n");
			$this->email->initialize($config);
			
			$this->email->from($from, $this->input->post("visitor_first_name"));
			$this->email->to($to); 	
			$this->email->reply_to($this->input->post('visitor_email'));	
			$this->email->subject('Contact form Request Information');
			$this->email->message($content);	
			
			$this->email->send();
			$mail_send_status = $this->email->send();		

			$content = '<table style="width:100%;border:none;"><tr><td style="background-color:#c9a252;padding:70px 0 350px 0;"><table rules="all" align="center" cellpadding="10" style="width:80%;" cellspacing="0"><tr><td bgcolor="#333333" height="25"></td></tr><tr><td bgcolor="#ffffff">
			Hello <span style="text-transform:capitalize;">'.$this->input->post('visitor_first_name').',</span><p>Thank you for contacting us. One of our consultants will be calling you to answer your questions and to discuss franchise opportunities in your area featured at <a href="http://www.affordablebusinessconcepts.com">Affordable Business Concepts, LLC</a>. Using our service saves you significant time, and does not cost or obligate you in any way.</p><p>We look forward to assisting in your business exploration.</p><p><table><tr><td>Affordable Business Concepts, L.L.C.</td></tr><tr><td>International Franchise Consultants</td></tr><tr><td>Toll Free 1-866-388-3576 Fax: (480) 320-4103</td></tr></table></p><p style="font-size:80%;padding-left:3px;">Affordable Business Concepts, LLC represents hundreds of top quality franchises opportunities in various industries. We are Certified Franchise Consultants with more than 20 years of experience Guiding Entrepreneurs to Golden Opportunities. Affordable Business Concepts, LLC respects the privacy of buyers and does not rent or sell any confidential information to any third party.</p></td></tr></table></div>';
			
			$to = $this->input->post('visitor_email');
			$from = "info@affordablebusinessconcepts.com";
			//admin mail
			$this->load->library('email');	
			$config['mailtype'] = 'html';		
			//$this->email->set_newline("\r\n");
			$this->email->initialize($config);
			
			$this->email->from($from, 'Affordable Business Concepts,LLC');
			$this->email->to($to); 	
			$this->email->reply_to('info@affordablebusinessconcepts.com');	
			$this->email->subject('Contact Confirmation from ABC');
			$this->email->message($content);	
			
			$this->email->send();
			$mail_send_status = $this->email->send();

			$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>0,"result"=>"MAIL SENT")));
		}
	}
	public function request_pre_qual_form()
	{
		$this->load->library('form_validation');
        $this->load->helper('security');
		$post = $this->input->post();
		unset($post["pre_businessphone"]);
		unset($post["pre_qual_fax"]);
		unset($post["pre_qual_retirement_fund"]);
		unset($post["pre_qual_invest_amt"]);
		unset($post["pre_qual_nt_worth"]);
		
		
		unset($post["cash_in_bank23"]);
		unset($post["cash_in_bank2"]);
		unset($post["cash_in_bank3"]);
		unset($post["cash_in_bank4"]);
		unset($post["cash_in_bank5"]);
		unset($post["cash_in_bank6"]);
		unset($post["cash_in_bank7"]);
		unset($post["cash_in_bank8"]);
		unset($post["cash_in_bank9"]);
		unset($post["cash_in_bank10"]);
		unset($post["cash_in_bank11"]);
		unset($post["cash_in_bank12"]);
		unset($post["cash_in_bank13"]);
		unset($post["cash_in_bank14"]);
		unset($post["cash_in_bank15"]);
		unset($post["cash_in_bank16"]);
		unset($post["cash_in_bank17"]);
		unset($post["cash_in_bank18"]);
		unset($post["cash_in_bank19"]);
		unset($post["cash_in_bank20"]);
		unset($post["cash_in_bank21"]);
		unset($post["cash_in_bank22"]);
        
		$this->form_validation->set_rules('pre_qual_email',"Email",'trim|required|valid_email');
        $this->form_validation->set_rules('pre_qual_cellphone',"Cell Phone",'trim|required|exact_length[12]');
        $this->form_validation->set_rules('pre_qual_homephone',"Home Phone",'trim|required|exact_length[12]');
        $this->form_validation->set_rules('pre_qual_frst_name','First name','trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('pre_qual_last_name','Last name','trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('pre_qual_street','Street','trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('pre_qual_city','City','trim|required|min_length[2]|xss_clean');        
        $this->form_validation->set_rules('pre_qual_addr','State','trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('pre_qual_zip','Zip code','trim|required|min_length[2]|max_length[7]|xss_clean');
        $this->form_validation->set_rules('pre_businessphone','Business Phone','trim|exact_length[12]|xss_clean');
        $this->form_validation->set_rules('pre_qual_fax','Fax','trim|exact_length[12]|xss_clean');      
		$this->form_validation->set_rules('pre_qual_spouse_name','Spouse’s Name','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('pre_qual_partner_name','Business Partner(s) Name(s)','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('pre_qual_name','Highest Education (level)','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('pre_qual_edu_major','Education Major','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('pre_qual_cr_score','Credit Score','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('pre_qual_desc_posistion','Describe Position Held','trim|required|min_length[2]|xss_clean');
        
        
        
		/*foreach($post as $k=>$value)
		{
			if(strpos("email",$k) !== false)
			{
				$this->form_validation->set_rules($k,"Email",'trim|required|valid_email');
			}
			elseif(strpos("cellphone",$k) !== false)
			{
				$this->form_validation->set_rules($k,"Cell Phone",'trim|required|exact_length[12]');
			}
			elseif(strpos("homephone",$k) !== false)
			{
				$this->form_validation->set_rules($k,"Home Phone",'trim|required|exact_length[12]');
			}
			else
			{
				$this->form_validation->set_rules($k,$k,'trim|required|min_length[2]');
			}
		}*/
        
		if ($this->form_validation->run() == FALSE)
		{
			$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>1,"result"=>validation_errors())));
		}
		else
		{			
			$content ='<table width="80%">
  <tr>
  	<td>
    	<h2 style="text-align:center;color:#500050;font-size:16pt;">AFFORDABLE BUSINESS CONCEPTS, LLC</h2>
        <h2 style="text-align:center;color:#500050;font-size:16pt;">CONFIDENTIAL FRANCHISE PRE-QUALIFICATION QUESTIONNAIRE</h2>
    </td>	
  </tr>
</table>
<table width="80%" cellpadding="10" border="1" cellspacing="0" bgcolor="#666666">
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">First Name:</td>
    <td width="35%">'.$this->input->post('pre_qual_frst_name').'</td>
    <td bgcolor="#eeece1">Today&#39;s Date:</td>
    <td width="30%">'.$this->input->post('pre_qual_today_dt').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Last Name:</td>
    <td>'.$this->input->post('pre_qual_last_name').'</td>
    <td bgcolor="#eeece1">Spouse&#39;s Name:</td>
    <td>'.$this->input->post('pre_qual_spouse_name').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Street:</td>
    <td>'.$this->input->post('pre_qual_street').'</td>
    <td bgcolor="#eeece1">Is Spouse Employed?</td>
    <td>'.$this->input->post('pre_qual_is_sp_emp').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">City:</td>
    <td>'.$this->input->post('pre_qual_city').' </td>
    <td bgcolor="#eeece1">Business Partner Name(s):</td>
    <td>'.$this->input->post('pre_qual_partner_name').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">State or Province,Country:</td>
    <td>'.$this->input->post('pre_qual_addr').'</td>
    <td bgcolor="#eeece1">Rent or Own a home</td>
    <td>'.$this->input->post('pre_qual_home').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Zip or Postal Code:</td>
    <td>'.$this->input->post('pre_qual_zip').'</td>
    <td bgcolor="#eeece1">Highest Education</td>
    <td>'.$this->input->post('pre_qual_name').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Email:</td>
    <td>'.$this->input->post('pre_qual_email').'</td>
    <td bgcolor="#eeece1">Education Major:</td>
    <td>'.$this->input->post('pre_qual_edu_major').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Cell Phone:</td>
    <td>'.$this->input->post('pre_qual_cellphone').'</td>
    <td bgcolor="#eeece1">Credit Score:</td>
    <td>'.$this->input->post('pre_qual_cr_score').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Home Phone:</td>
    <td>'.$this->input->post('pre_qual_homephone').'</td>
    <td bgcolor="#eeece1">Are you Currently Employed?</td>
    <td>'.$this->input->post('pre_qual_employed').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Business Phone:</td>
    <td>'.$this->input->post('pre_businessphone').'</td>
    <td bgcolor="#eeece1">Describe Position Held:</td>
    <td>'.$this->input->post('pre_qual_desc_posistion').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Fax:</td>
    <td>'.$this->input->post('pre_qual_fax').'</td>
    <td bgcolor="#eeece1">Full Time or Passive :</td>
    <td>'.$this->input->post('pre_qual_fl_prt_time').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Country of Citizenship:</td>
    <td>'.$this->input->post('pre_qual_country_citizen').'</td>
    <td bgcolor="#eeece1">Amount in Retirement Funds:</td>
    <td>$ '.$this->input->post('pre_qual_retirement_fund').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Desired Location of New Business:</td>
    <td>'.$this->input->post('pre_qual_de_loc').'</td>
    <td bgcolor="#eeece1">Amount to Invest:</td>
    <td>$ '.$this->input->post('pre_qual_invest_amt').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Purchase Time Frame:</td>
    <td>'.$this->input->post('pre_qual_time_frame').'</td>
    <td bgcolor="#eeece1">Net Worth:</td>
    <td>$ '.$this->input->post('pre_qual_nt_worth').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Franchises or Industries of interest?</td>
    <td>'.$this->input->post('pre_qual_explore').'</td>
    <td bgcolor="#eeece1">Select Franchised Model: Home, Mobile, Office or Retail:</td>
    <td>'.$this->input->post('pre_qual_homebase_busi').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Franchises already considered:</td>
    <td>'.$this->input->post('pre_qual_act_franchise').'</td>
    <td bgcolor="#eeece1">Interested in Multiple Units:</td>
    <td>'.$this->input->post('pre_qual_multplu_units').'</td>
  </tr>
</table>
<!--Newend-->
<table>
<tr>
<td height="50">     
</td>    
</tr>
</table>
<table bgcolor="#666666" width="80%" cellpadding="10" border="1" cellspacing="0">
  <tr bgcolor="#ffffff">
    <th colspan="4" style="color:#500050;"><strong>Net Worth Calculator (Estimate to nearest dollar)</strong>
  </td>  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Assets</td>
    <td>$</td>
    <td bgcolor="#eeece1">Liabilities</td>
    <td>$</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Cash in Bank</td>
    <td>$'.$this->input->post('cash_in_bank23').'</td>
    <td bgcolor="#eeece1">Total Credit Cards Debt</td>
    <td>$'.$this->input->post('cash_in_bank13').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Cash In Savings</td>
    <td>$'.$this->input->post('cash_in_bank2').'</td>
    <td bgcolor="#eeece1">Total Auto Loans Debt</td>
    <td>$'.$this->input->post('cash_in_bank14').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Stocks, Bonds, Mutual Funds</td>
    <td>$'.$this->input->post('cash_in_bank3').'</td>
    <td bgcolor="#eeece1">Total Student Loans Debt</td>
    <td>$'.$this->input->post('cash_in_bank15').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Total Retirement (IRA+ 401K)</td>
    <td>$'.$this->input->post('cash_in_bank4').'</td>
    <td bgcolor="#eeece1">Home Equity Line of Credit</td>
    <td>$'.$this->input->post('cash_in_bank19').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Primary Home Market Value</td>
    <td>$'.$this->input->post('cash_in_bank5').'</td>
    <td bgcolor="#eeece1">Primary Mortgage Debt</td>
    <td>$'.$this->input->post('cash_in_bank16').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Other Real Estate Market Value</td>
    <td>$'.$this->input->post('cash_in_bank6').'</td>
    <td bgcolor="#eeece1">Second Mortgage Debt</td>
    <td>$'.$this->input->post('cash_in_bank17').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Business Value</td>
    <td>$'.$this->input->post('cash_in_bank8').'</td>
    <td bgcolor="#eeece1">Other Real Estate Debt</td>
    <td>$'.$this->input->post('cash_in_bank18').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Money Due You</td>
    <td>$'.$this->input->post('cash_in_bank9').'</td>
    <td bgcolor="#eeece1">Total Account Charge Debt</td>
    <td>$'.$this->input->post('cash_in_bank21').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Other Assets</td>
    <td>$'.$this->input->post('cash_in_bank10').'</td>
    <td bgcolor="#eeece1">Other Debts</td>
    <td>$'.$this->input->post('cash_in_bank20').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td bgcolor="#eeece1">Total Assets</td>
    <td>$'.$this->input->post('cash_in_bank11').'</td>
    <td bgcolor="#eeece1">Total Liabilities</td>
    <td>$'.$this->input->post('cash_in_bank22').'</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td colspan="2" bgcolor="#eeece1">TOTAL NET WORTH = Assets – Liabilities: $</td>
    <td colspan="2">$'.$this->input->post('cash_in_bank12').'</td>
  </tr>
</table>

<table width="80%" align="left">
	<tr bgcolor="#ffffff">
    	<td>
        <p style="text-align:justify;">By clicking the submit button you certify that all of the information stated herein is a true and correct representation of your personal and financial condition. It is understood that the purpose of this questionnaire is to compile general information so we may help you and that is in no way binding upon either party.</p>
        </td>
    </tr>
</table>';
			$from = "info@affordablebusinessconcepts.com";
			$to = array("info@affordablebusinessconcepts.com");
			//$to = "pragyana.highermatrix@gmail.com";
			//admin mail
			$this->load->library('email');	
			$config['mailtype'] = 'html';		
			$this->email->initialize($config);
			
			$this->email->from($from, $this->input->post('pre-qual-frst-last-name'));
			$this->email->to($to); 	
			$this->email->reply_to($this->input->post('pre-qual-email'));	
			$this->email->subject('CONFIDENTIAL FRANCHISE PRE-QUALIFICATION QUESTIONNAIRE');
			$this->email->message($content);	
			
			$this->email->send();
			$mail_send_status = $this->email->send();
			
			//commented login for testing//
			/*$from = "info@affordablebusinessconcepts.com";$to = array("info@affordablebusinessconcepts.com");
			$this->load->library('email');	
			$config['mailtype'] = 'html';		
			$this->email->initialize($config);			
			$this->email->from($from, $this->input->post('pre-qual-frst-last-name'));
			$this->email->to($to); 	
			$this->email->reply_to($this->input->post('pre-qual-email'));	
			$this->email->subject('CONFIDENTIAL FRANCHISE PRE-QUALIFICATION QUESTIONNAIRE');
			$this->email->message($content);			
			$this->email->send();	*/		
			
			$content = '<table style="width:100%;border:none;"><tr><td style="background-color:#c9a252;padding:70px 0 200px 0;"><table rules="all" align="center" cellpadding="10" style="width:80%;" cellspacing="0"><tr><td bgcolor="#333333" height="25"></td></tr><tr><td bgcolor="#ffffff">Hello <span style="text-transform:capitalize;">'.$this->input->post('pre_qual_frst_name').',</span>

<p>Thank you for submitting your confidential franchise pre-qualification questionnaire. One of our consultants will be contacting you to share more information about requested franchise opportunities with the top brands featured at <a href="http://www.affordablebusinessconcepts.com">Affordable Business Concepts, LLC</a>. Using our service saves you significant time, and does not cost or obligate you in any way.</p><p>We look forward to assisting in your business exploration.</p><p><table><tr><td>Affordable Business Concepts, L.L.C.</td></tr><tr><td>International Franchise Consultants</td></tr><tr><td>Toll Free 1-866-388-3576 Fax: (480) 320-4103</td></tr></table></p>
<p style="font-size:80%;padding-left:3px;">Affordable Business Concepts, LLC represents hundreds of top quality franchises opportunities in various industries. We are Certified Franchise Consultants with more than 20 years of experience Guiding Entrepreneurs to Golden Opportunities. Affordable Business Concepts, LLC respects the privacy of buyers and does not rent or sell any confidential information to any third party.<p></td></tr></table></td></tr></table>';
			
			$to = $this->input->post('pre_qual_email');
			$from = "info@affordablebusinessconcepts.com";
			//admin mail
			$this->load->library('email');	
			$config['mailtype'] = 'html';		
			//$this->email->set_newline("\r\n");
			$this->email->initialize($config);
			
			$this->email->from($from, 'Affordable Business Concepts,LLC');
			$this->email->to($to); 	
			$this->email->reply_to('info@affordablebusinessconcepts.com');	
			$this->email->subject('Confirmation of ABC Franchise Pre-Qualification Questionnaire');
			$this->email->message($content);	
			
			$this->email->send();
			$mail_send_status = $this->email->send();
			$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>0,"result"=>"MAIL SENT")));
		}
	}
	public function request_free_phone_consult()
	{
		$this->load->library('form_validation');
		
		$post = $this->input->post();
		//unset($post["visitor_strt_add_one"]);
		unset($post["visitor_strt_add_two"]);
		//unset($post["visitor_country"]);
		unset($post["visitor_capital_invest"]);
		unset($post["visitor_est_nt_worth"]);
		unset($post["visitor_time_frame"]);
		unset($post["visitor_eesired_location"]);
		//code added by swati on 22/09/17 
		unset($post["comments"]);
		foreach($post as $k=>$v)
		{
			if(strpos("email",$k) !== false)
			{
				$this->form_validation->set_rules($k,"Email",'trim|required|valid_email');
			}
			elseif(strpos("tel",$k) !== false)
			{
				$this->form_validation->set_rules($k,"Phone",'trim|required|exact_length[12]');
			}
			else
			{
				$this->form_validation->set_rules($k,str_replace('_',' ',ucfirst($k)),'trim|required|min_length[2]');
			}
		}
		if ($this->form_validation->run() == FALSE)
		{
			//$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>1,"result"=>"VALIDATION ERROR")));
			$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>1,"result"=>validation_errors())));
		}
		else
		{		
				$content = '<h2 style="text-align:center;">Request Free Phone Consultation</h2><table style="border-color: #666;" cellpadding="10"><tr><td><strong>Name:</strong></td><td>'.$this->input->post('title').' '.$this->input->post('visitor_first_name').' '.$this->input->post('visitor_last_name').'</td></tr><tr><td><strong>Email</strong></td>    <td>'.$this->input->post('visitor_email').'</td></tr><tr><td><strong>Phone</strong></td><td>'.$this->input->post('visitor_tel').'</td></tr><tr><td><strong>Street Address Line One</strong></td><td>'.$this->input->post('visitor_strt_add_one').'</td></tr><tr><td><strong>Street Address Line Two</strong></td><td>'.$this->input->post('visitor_strt_add_two').'</td></tr><tr><td><strong>City</strong></td><td>'.$this->input->post('visitor_city').'</td></tr><tr><td><strong>State or Province</strong></td><td>'.$this->input->post('visitor_st_pro').'</td></tr><tr><td><strong>Country</strong></td><td>'.$this->input->post('visitor_country').'</td></tr>
  <tr>
    <td><strong>Zip or Postal Code</strong></td>
    <td>'.$this->input->post('visitor_postal_code').'</td>
  </tr>
  <tr>
    <td><strong>Capital Available to invest</strong></td>
    <td>'.$this->input->post('visitor_capital_invest').'</td>
  </tr>
  <tr>
    <td><strong>Estimated Net Worth</strong></td>
    <td>'.$this->input->post('visitor_est_nt_worth').'</td>
  </tr>
  <tr>
    <td><strong>Purchase Time Frame</strong></td>
    <td>'.$this->input->post('visitor_time_frame').'</td>
  </tr>
  <tr>
    <td><strong>Desired Location</strong></td>
    <td>'.$this->input->post('visitor_eesired_location').'</td>
  </tr>
  <tr>
    <td><strong>Additional Comments</strong></td>
    <td>'.$this->input->post('comments').'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>'.$this->input->post('chk1').'</td>
  </tr>
  </table>';			
						
			$from = "info@affordablebusinessconcepts.com";
			$to = array("info@affordablebusinessconcepts.com");
			//$to="pragyana.highermatrix@gmail.com";
			//admin mail
			$this->load->library('email');	
			$config['mailtype'] = 'html';
			$config['newline']	= "\r\n";	

			$this->email->initialize($config);
			
			$this->email->from($from, $this->input->post("visitor_first_name"));
			$this->email->to($to); 	
			$this->email->reply_to($this->input->post('visitor_email'));	
			$this->email->subject('Request Free Phone Consultation');
			$this->email->message($content);	
			
			$this->email->send();
			$mail_send_status = $this->email->send();
			
			
			//commented line for testing
			/*$from = "info@affordablebusinessconcepts.com";
			$to = array($this->input->post('visitor_email'));
			//admin mail
			$this->load->library('email');	
			$config['mailtype'] = 'html';
			$config['newline']	= "\r\n";	

			$this->email->initialize($config);
			
			$this->email->from($from, $this->input->post("visitor_first_name"));
			$this->email->to($to); 	
			$this->email->reply_to($this->input->post('visitor_email'));	
			$this->email->subject('Request Free Phone Consultation');
			$this->email->message($content);			
			$this->email->send();*/
			
			$content = '<table style="width:100%;border:none;"><tr><td style="background-color:#c9a252;padding:70px 0 200px 0;"><table rules="all" align="center" cellpadding="10" style="width:80%;" cellspacing="0"><tr><td bgcolor="#333333" height="25"></td></tr><tr><td bgcolor="#ffffff">Hello <span style="text-transform:capitalize;">'.$this->input->post('visitor_first_name').',</span><p>Thank you for requesting a phone consultation. One of our consultants will be calling you to answer your questions and to discuss franchise opportunities in your area featured at <a href="http://www.affordablebusinessconcepts.com">Affordable Business Concepts LLC</a>. Using our service saves you significant time, and does not cost or obligate you in any way.</p><p>We look forward to assisting in your business exploration.</p><p>Best Regards,</p><p><table><tr><td>Affordable Business Concepts, L.L.C.</td></tr><tr><td>International Franchise Consultants</td></tr><tr><td>Toll Free 1-866-388-3576 Fax: (480) 320-4103</td></tr></table></p><p style="font-size:80%;padding-left:3px;">Affordable Business Concepts, LLC represents hundreds of top quality franchises opportunities in various industries. We are Certified Franchise Consultants with more than 20 years of experience Guiding Entrepreneurs to Golden Opportunities. Affordable Business Concepts, LLC respects the privacy of buyers and does not rent or sell any confidential information to any third party.</p>
</td></tr></table></td></tr></table>';
			$to = $this->input->post('visitor_email');
			$from = "info@affordablebusinessconcepts.com";
			//admin mail
			$this->load->library('email');	
			$config['mailtype'] = 'html';		
			$this->email->initialize($config);
			
			$this->email->from($from, 'Affordable Business Concepts,LLC');
			$this->email->to($to); 	
			$this->email->reply_to('info@affordablebusinessconcepts.com');
			$this->email->subject('Confirmation of Phone Consultation with ABC');
			$this->email->message($content);	
			
			$this->email->send();
			$mail_send_status = $this->email->send();

			$this->output->set_content_type('application/json')->set_output(json_encode(array("error"=>0,"result"=>"MAIL SENT")));
		}
	}
}