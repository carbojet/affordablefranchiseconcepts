<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Listing extends CI_Controller {



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

	 * map to /index.php/welcome/
* @see http://codeigniter.com/user_guide/general/urls.html

	 */
	 
	public function __construct()

	{

	  parent::__construct();

	  $this->load->model("Listingdb");

	}

	public function temp_fun()

	{

		//$this->Listingdb->temp_fun();

	}	

	//default load seller page		

	public function index()

	{
		$this->load->model('Generaldb');
		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if(isset($this->data["page"])){$page = $this->data["page"];}
		else{$page=1;}
		

		$data = $this->Listingdb->listing_list($page,100);

		$this->data["listing_list"]= $data["listing_list"];

                if(isset($page)){$data["pagination"]["currentpage"]=$page;}
		else{$data["pagination"]["currentpage"]=1;}

		$this->data["pagination"] = $data["pagination"];

		$this->pages = $this->data["pagination"]["pages"];

		$this->session->set_userdata("search_listing_post",array());

		$this->load->view("listing",$this->data);

	}

	//seller pagenitation

	public function	listing_nxt_page($currentPage)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		//$currentPage++;

		$data = $this->Listingdb->listing_list($currentPage,100);

		$this->data["listing_list"]= $data["listing_list"];

		

		if($data["pagination"]['startpage']>=$data["pagination"]['pages']){
			
			$temp_array = $data["pagination"];
			$temp_array['currentpage'] = $data["pagination"]['pages'];
			$data["pagination"] = $temp_array;
			
			$data["pagination"]['startpage'] = $data["pagination"]['pages'];
		}
		else{
		
			$temp_array = $data["pagination"];
			$temp_array['currentpage'] = $data["pagination"]['startpage'];
			$data["pagination"] = $temp_array;
			
			$data["pagination"]['currentpage'] = $data["pagination"]['startpage'];
			$data["pagination"]['startpage'] +=1;			
		}
                $this->data["pagination"] = $data["pagination"];

		$this->data["side_menu"] = array("4"=>"active","sub"=>"active");

		$this->load->view("listing",$this->data);

	}

	public function	listing_pre_page($currentPage)

	{	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		//$currentPage--;

		$data = $this->Listingdb->listing_list($currentPage,100);

		

		$this->data["listing_list"]= $data["listing_list"];
                if($data["pagination"]['startpage']>0){
			$temp_array = $data["pagination"];
			$temp_array['currentpage'] = $data["pagination"]['startpage'];
			$data["pagination"]=$temp_array;
			
			$data["pagination"]['startpage'] -=1;			
		}
		else
		{
			$temp_array = $data["pagination"];
			$temp_array['currentpage'] = 1;
			$data["pagination"]=$temp_array;
		}

		$this->data["pagination"] = $data["pagination"];

		

		//$this->data["side_menu"] = array("4"=>"active","sub"=>"active");

		$this->load->view("listing",$this->data);

	}

	//seller listing pagination 

	public function	seller_own_listing()

	{

		if(!array_key_exists("slrd",$this->session->userdata())){redirect("seller_login");}

		$slrd = $this->session->userdata("slrd");

		if(isset($slrd["slrnm"]))

		{

			$this->load->model("Sellerdb");

			$result = $this->Sellerdb->select_seller(array("seller_username"=>$slrd["slrnm"]));			

			//var_dump($result);

			

			foreach($result as $k=>$obj){$this->data["sellerObj"] = $obj;}

			$currentPage = $this->input->post("startpage");				

			$currentPage++;

			$data = array(

				"listing_seller"=>$this->data["sellerObj"]->seller_id,

			);

		$data = $this->Listingdb->listing_management($data,$currentPage,5);

		

		$this->data["listing_list"]= $data["listing_list"];

		$this->data["pagination"] = $data["pagination"];		

		$this->load->view("seller_own_listing",$this->data);

		}

		else

		{

			$this->load->view("seller_login");

		}

	}

	//seller pagination after search

	public function	listing_management($listing_seller=0)

	{

		if($listing_seller>0)

		{

		$currentPage = $this->input->post("startpage");

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$currentPage++;

			$data = array(

				"listing_seller"=>$listing_seller,

			);

		$data = $this->Listingdb->listing_management($data,$currentPage,5);

		

		$this->data["listing_list"]= $data["listing_list"];

		$this->data["pagination"] = $data["pagination"];

		

		$this->load->view("listing",$this->data);

		}

		else

		{

			$this->index();

		}

	}

	//listing search form

	public function listing_search()
	{	
		if($this->input->post("visit_status"))
		{
			$currentPage = $this->input->post("navigation_page");
			$clk = $this->input->post("page_click");
			if($clk=="next"){$currentPage +=1;}
			if($clk=="prev"){$currentPage -=1;}	

			$data["listing_id"] = $this->input->post("listing_id");
			$data["listing_seller_id"] = $this->input->post("listing_seller_id");			
			$data["listing_status_keywords"] = $this->input->post("listing_status_keywords");
			$data["listing_sector"] = $this->input->post("listing_sector");
			$data["listing_category"] = $this->input->post("listing_category");	
			$data["listing_location_path"]="";		
			$listing_location_path = array();
			$listing_location_country = $this->input->post("listing_location_country");
			$listing_location_state = $this->input->post("listing_location_state");
			$listing_location_city = $this->input->post("listing_location_city");
			
			
			if(is_array($listing_location_city)){
			foreach($listing_location_city as $val){				
				if($val !=""){
				 	$listing_location_path[] = "-".$listing_location_country."-".$listing_location_state."-".$val."-";
				}
			}}
			
			if(empty($listing_location_path))
			{
				
				$listing_location_country = $this->input->post("listing_location_country");
				
				if(!empty($listing_location_country)){				
					$location_path = "-".$this->input->post("listing_location_country")."-";
					if($listing_location_state!=0)
					{
						$location_path .=$this->input->post("listing_location_state")."-";
					}
					$listing_location_path[] = $location_path;
				}
			}			
						
						
			//$data["listing_location_path"] = $listing_location_path;
			//var_dump($listing_location_path);exit;
			$data["listing_location_path"] = $listing_location_path;
			$data["listing_zip"] = $this->input->post("listing_zip");
			$data["s_status"] = $this->input->post("s_status");
			$data["visit_status"] = $this->input->post("visit_status");
			$data["s_featured"] = $this->input->post("s_featured");
			$data["listing_status_new"] = $this->input->post("listing_status_new");
			$data["s_order"] = $this->input->post("s_order");
			//var_dump($data);
			
			
			
			$data = $this->Listingdb->get_listing_search_result($data,$currentPage,100);
			
			$this->session->set_userdata("search_listing_post",$data["post_data"]);
			
			$this->data["listing_list"] = $data["listing_list"];

			$this->data["pagination"] = $data["pagination"];

			$this->data["post_data"] = $data["post_data"];
			$this->data["visit_status"] = $this->input->post("visit_status");
			$this->load->view("listing_search_result",$this->data);

		}

		else

		{		

			$this->index();

		}

	}

	//listing statics

	public function listing_statistics($listing_id=0,$page=0)
	{
		if($listing_id>0)
		{
			$this->data =array("stat_listing"=>$listing_id);
			$detail = $this->Listingdb->listing_statistics($this->data);
			$days_array = array();
			$fromdate = date("Y-m-d",strtotime("-26 day"));
			$todate = date("Y-m-d");
			while($fromdate<=$todate)
			{
				$days_array[$fromdate]= 0;
				$fromdate = date("Y-m-d",strtotime($fromdate.' +1 day'));
			}
			$months_array = array();
			$fromdate = date("Y-m",strtotime("-11 month"));
			while($fromdate<=$todate)
			{
				$months_array[$fromdate]= 0;
				$fromdate = date("Y-m",strtotime($fromdate.' +1 month'));
			}

			foreach($detail as $k=>$obj)
			{
				//$days_array[$obj->stat_date] = $obj->stat_total;
				//if(array_key_exists($obj->stat_date,$days_array))

				if(isset( $days_array[$obj->stat_date] ) )
				{
					$days_array[$obj->stat_date] += $obj->stat_total;
				}
				if(isset( $months_array[date("Y-m",strtotime($obj->stat_date))] ) )
				{
					$months_array[date("Y-m",strtotime($obj->stat_date))] += $obj->stat_total;
				}
			}
			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));
			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}			
			$this->data["page"] = $page;
			$this->data["daily"] = $days_array;
			$this->data["monthly"] = $months_array;
			$this->load->view("listing_statistics",$this->data);
		}
		else
		{
			$this->index();
		}
	}

	//seller listing statics

	public function seller_listing_statistics($listing_id=0)

	{

		if($listing_id>0)

		{

			$this->data =array("stat_listing"=>$listing_id);

			$detail = $this->Listingdb->listing_statistics($this->data);

			

			

			$days_array = array();

			//$fromdate = date("Y-m-d",strtotime("-26 day"));			

			$fromdate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")));

			

			$todate = date("Y-m-d");

			

			while($fromdate<=$todate)

			{

				$days_array[$fromdate]= 0;

				$fromdate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));

			}

			

			$months_array = array();

			$fromdate = date("Y-m",mktime(0,0,0,date("m")-11,date("d"),date("Y")));

			

			while($fromdate<=$todate)

			{

				$months_array[$fromdate]= 0;

				$fromdate = date("Y-m",mktime(0,0,0,date("m")+1,date("d"),date("Y")));

			}

			foreach($detail as $k=>$obj)

			{

				//$days_array[$obj->stat_date] = $obj->stat_total;

				//if(array_key_exists($obj->stat_date,$days_array))

				if(isset( $days_array[$obj->stat_date] ) )

				{

					$days_array[$obj->stat_date] += $obj->stat_total;

				}

				

				if(isset( $months_array[date("Y-m",strtotime($obj->stat_date))] ) )

				{

					$months_array[date("Y-m",strtotime($obj->stat_date))] += $obj->stat_total;

				}

			}

			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));

			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["daily"] = $days_array;

			$this->data["monthly"] = $months_array;

			$this->load->view("seller_listing_statistics",$this->data);

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	//seller listing review fun

	public function seller_listing_reviews($listing_id=0)

	{

		$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

		foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

		$this->data["listing_review_list"] = $this->Listingdb->get_review_list(false,$listing_id);

		$this->load->view("seller_listing_reviews",$this->data);

	}

	//listing review fun

	public function listing_reviews($listing_id=0)

	{

		$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

		foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

		$this->data["listing_review_list"] = $this->Listingdb->get_review_list(false,$listing_id);

		$this->load->view("listing_reviews",$this->data);

	}

	//edit review fun

	public function edit_review($comment_id=0)

	{		

		$this->data["reviewObj"] = $this->Listingdb->get_review_detail($comment_id);

		

		$result = $this->Listingdb->select_listing(array("listing_id"=>$this->data["reviewObj"]->comment_linkid));			

		foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

		$this->load->view("review_edit",$this->data);

	}

	//edit review fun

	public function update_review()

	{		

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if($this->input->post("comment_id"))

		{	

			$this->load->library('form_validation');

			$this->form_validation->set_rules("comment_rating","Please select rating","trim|required");

			$this->form_validation->set_rules("comment_title","Enter Title","trim|required");

			$this->form_validation->set_rules("comment_description","Enter Comments","trim|required");

			$this->form_validation->set_rules("comment_ipaddress","Ip address","trim|required");

			if($this->form_validation->run()!=false)

			{

				$result = $this->Listingdb->update_review();

				$this->data["success_msg"] = $result;

				$this->listing_reviews($this->input->post("comment_linkid"));

			}

			else

			{

				//validation error

				$this->data["validation_errors"] = validation_errors();

								 

				$reviewObj = (object) $_POST;		

				$result = $this->Listingdb->select_listing(array("listing_id"=>$reviewObj->comment_linkid));			

				foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}	

						

				$this->data["reviewObj"] = $reviewObj;

				$this->load->view("review_edit",$this->data);

			}

		}

		else

		{

			$this->index();

		}

	}

	//add listing step one

	public function new_review_step_1($comment_linkid=0)

	{

		$data["reviewObj"] = (object) array("comment_linkid"=>$comment_linkid);

		$this->load->view("new_review_step_1",$data);

	}

	//get seller search result

	public function new_review_step_2()

	{

		if(isset($_POST))

		{

			$currentPage = $this->input->post("startpage");

			if($currentPage<0){$currentPage++;}



			$data = array(

				"visitor_username"=>$this->input->post("search_username"),

				"visitor_firstname"=>$this->input->post("search_firstname"),

				"visitor_lastname"=>$this->input->post("search_lastname")

			);			

			$this->data = $this->Listingdb->search_visitors($data,$currentPage,5);

			$this->data["comment_linkid"] = $this->input->post("comment_linkid");			

			$this->load->view("new_review_step_2",$this->data);

		}

		else

		{

			$this->index();

		}

	}

	public function new_review_final_step($comment_linkid=0,$comment_visitor=0)

	{

		$this->new_review(array("comment_linkid"=>$comment_linkid,"comment_visitor"=>$comment_visitor));

	}

	

	//add new review

	public function new_review($data=array())

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if($this->input->post("comment_visitor"))

		{	

			$this->load->library('form_validation');

			$this->form_validation->set_rules("comment_rating","Please select rating","trim|required");

			$this->form_validation->set_rules("comment_title","Enter Title","trim|required");

			$this->form_validation->set_rules("comment_description","Enter Comments","trim|required");

			$this->form_validation->set_rules("comment_ipaddress","Ip address","trim|required");

					

			if($this->form_validation->run()!=false)

			{

				//form validation true

				$this->data = $this->Listingdb->nadd_new_review();

				$this->listing_reviews($this->input->post("comment_linkid"));		

			}

			else

			{

				//form validation false

				$this->data["validation_errors"] = validation_errors();

				$this->data["reviewObj"] = (object) array(

				"comment_visitor"=>$this->input->post("comment_visitor"),

				"comment_rating"=>$this->input->post("comment_rating"),

				"comment_rating"=>$this->input->post("comment_rating"),

				"comment_title"=>$this->input->post("comment_title"),

				"comment_description"=>$this->input->post("comment_description")

				);

				$result = $this->Listingdb->select_listing($this->input->post("comment_linkid"));			

				foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

				$this->data["visitorObj"] = $this->Listingdb->get_visitor($this->input->post("comment_visitor"));

				$this->load->view("new_review",$this->data);

			}

		}

		else

		{

			$this->data["reviewObj"] = (object) array(

			"comment_visitor"=>$data["comment_visitor"],

			"comment_linkid"=>$data["comment_linkid"],

			"comment_rating"=>"",

			"comment_title"=>"",

			"comment_description"=>""

			);

			$result = $this->Listingdb->select_listing(array("listing_id"=>$data["comment_linkid"]));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			$this->data["visitorObj"] = $this->Listingdb->get_visitor($data["comment_visitor"]);

			$this->load->view("new_review",$this->data);

		}				

	}

	//delete review

	public function delete_review($comment_id=0,$comment_linkid=0)

	{

		if($comment_id>0)

		{

			$data =array("comment_id"=>$comment_id);

			$this->data["success_msg"] = $this->Listingdb->delete_review($data);

			$this->listing_reviews($comment_linkid);

		}

		else

		{

			$this->index();

		}

	}		

	//listing edit sec

	public function seller_listing_edit($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("slrd",$this->session->userdata())){redirect("seller_login");}

		

		if($id>0)

		{

			$result = $this->Listingdb->select_listing(array("listing_id"=>$id));

			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			$this->load->model("Sellerdb");

			$this->data["countryObjArray"] = $this->Sellerdb->get_country_list();

			//$this->data["titleObjArray"] = $this->Sellerdb->get_title_list();

			$this->load->view("seller_listing_edit",$this->data);

		}

		else

		{

			redirect("/listing/","refresh");

		}

	}

	//listing edit sec

	public function edit($id=0,$page=0)
	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if($id>0)

		{

			$result = $this->Listingdb->select_listing(array("listing_id"=>$id));			
			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			//$this->data["countryObjArray"] = $this->Sellerdb->get_country_list();

			//$this->data["titleObjArray"] = $this->Sellerdb->get_title_list();

			$this->data["page"] = $page;
			$category_lists = $this->Listingdb->get_listing_category(array("category_listing"=>$id)); 
			$this->data["category_lists"] = $category_lists;
			$this->load->view("listing_edit",$this->data);

		}

		else

		{

			redirect("/listing/","refresh");

		}

	}

	//seller listing update sec	

	public function update_seller_listing()

	{	

		//check weather user logged in or not

		if(!array_key_exists("slrd",$this->session->userdata())){redirect("seller_login");}

		if($this->input->post("listing_id"))

		{	

			$this->load->library('form_validation');

			$this->form_validation->set_rules("listing_title_1","Enter Your Business Name","trim|required");

			$this->form_validation->set_rules("listing_location_1","Location","trim|required");			

			$this->form_validation->set_rules("listing_address","Address","trim|required");

			$this->form_validation->set_rules("listing_zip","Zip Code","trim|required");

			$this->form_validation->set_rules("listing_phone","Phone No","trim|required");

			$this->form_validation->set_rules("listing_email","Email","trim|required|valid_email");						

			$this->form_validation->set_rules("listing_textbox1_1","Trade License Locale","trim|required");

			$this->form_validation->set_rules("listing_textbox2_1","Trade License Authority","trim|required");

			$this->form_validation->set_rules("listing_textbox4_1","Trade License Expiration","trim|required");

			$this->form_validation->set_rules("listing_textbox5_1","Trade License Description","trim|required");

			$this->form_validation->set_rules("listing_descbrief_1","Description","trim|required");

			$this->form_validation->set_rules("listing_descfull_1","Description","trim");			

			

			if($this->form_validation->run()!=false)

			{

				//validation sucess				

				$listing_location_path = "-";

				for($i=1;$i<=3;$i++)

				{

					$listing_location_id = $this->input->post("listing_location_$i");

					if(!empty($listing_location_id)){$listing_location_path .= $listing_location_id."-";}

				}

				$listing_feature="-";

				for($i=1;$i<=24;$i++)

				{

					$temp = $this->input->post("listing_feature_$i");

					if(!empty($temp)){$listing_feature .= $i."-";}

				}

				//getting category initation

				$listing_category = $this->input->post("listing_category");

				if(!empty($listing_category))

				{

					$prime_categoryObj = $this->Listingdb->get_prime_category(array("category_id"=>$this->input->post("listing_category")));

					$category_name_1 =$prime_categoryObj->category_name_1;

				}else{$category_name_1="";}

								

				$replace_listing_title = str_replace(" ","-",$this->input->post("listing_title_1"));

				

				//getting lng lat from address

				$listing_posted_latitude = $this->input->post("listing_posted_latitude");

				$listing_posted_longitude = $this->input->post("listing_posted_longitude");

				if(empty($listing_posted_latitude) || empty($listing_posted_longitude))

				{

					$address = $this->input->post("listing_address")." ".$this->input->post("listing_address2");

					$lng_lat = $this->get_lng_lat($address);

					

					$listing_posted_latitude = $lng_lat["latitude"];

					$listing_posted_longitude = $lng_lat["longitude"];

				}

				

				$listing_status_keywords = $this->input->post("listing_title_1")." + ".$replace_listing_title." + ".$this->input->post("listing_descbrief_1")." + ".$this->input->post("listing_descfull_1")." + ".$this->input->post("listing_textbox1_1")." + ".$this->input->post("listing_textbox2_1")." + ".$this->input->post("listing_textbox3_1")." + ".$this->input->post("listing_textbox4_1")." + ".$this->input->post("listing_textbox5_1")." + ".$category_name_1." + ".$this->input->post("listing_address")." + ".$this->input->post("listing_address2")." + ".$this->input->post("listing_phone")." + ".$this->input->post("listing_email")." + ".$this->input->post("listing_website");	

								

				$this->data = array("listing_seller"=>$this->input->post("listing_seller"),"listing_package"=>$this->input->post("listing_package"),"listing_expire"=>date("Y-m-d H:i:s",strtotime($this->input->post("listing_expire"))),"listing_title_1"=>$this->input->post("listing_title_1"),"listing_location_path"=>$listing_location_path,"listing_location"=>$listing_location_id,"listing_address"=>$this->input->post("listing_address"),"listing_address2"=>$this->input->post("listing_address2"),"listing_zip"=>$this->input->post("listing_zip"),"listing_posted_latitude"=>$listing_posted_latitude,"listing_posted_longitude"=>$listing_posted_longitude,"listing_phone"=>$this->input->post("listing_phone"),"listing_fax"=>$this->input->post("listing_fax"),"listing_email"=>$this->input->post("listing_email"),"listing_website"=>$this->input->post("listing_website"),"listing_facebook"=>$this->input->post("listing_facebook"),"listing_twitter"=>$this->input->post("listing_twitter"),"listing_aim"=>$this->input->post("listing_aim"),"listing_yahoo"=>$this->input->post("listing_yahoo"),"listing_msn"=>$this->input->post("listing_msn"),"listing_skype"=>$this->input->post("listing_skype"),"listing_open_1_status"=>$this->input->post("listing_open_status_1"),"listing_open_1_start"=>$this->input->post("listing_open_hourfrom_1"),"listing_open_1_end"=>$this->input->post("listing_open_hourto_1"),"listing_open_2_status"=>$this->input->post("listing_open_status_2"),"listing_open_2_start"=>$this->input->post("listing_open_hourfrom_2"),"listing_open_2_end"=>$this->input->post("listing_open_hourto_2"),"listing_open_3_status"=>$this->input->post("listing_open_status_3"),"listing_open_3_start"=>$this->input->post("listing_open_hourfrom_3"),"listing_open_3_end"=>$this->input->post("listing_open_hourto_3"),"listing_open_4_status"=>$this->input->post("listing_open_status_4"),"listing_open_4_start"=>$this->input->post("listing_open_hourfrom_4"),"listing_open_4_end"=>$this->input->post("listing_open_hourto_4"),"listing_open_5_status"=>$this->input->post("listing_open_status_5"),"listing_open_5_start"=>$this->input->post("listing_open_hourfrom_5"),"listing_open_5_end"=>$this->input->post("listing_open_hourto_5"),"listing_open_6_status"=>$this->input->post("listing_open_status_6"),"listing_open_6_start"=>$this->input->post("listing_open_hourfrom_6"),"listing_open_6_end"=>$this->input->post("listing_open_hourto_6"),"listing_open_7_status"=>$this->input->post("listing_open_status_7"),"listing_open_7_start"=>$this->input->post("listing_open_hourfrom_7"),"listing_open_7_end"=>$this->input->post("listing_open_hourto_7"),"listing_dropdown1"=>$this->input->post("listing_dropdown1"),"listing_dropdown2"=>$this->input->post("listing_dropdown2"),"listing_textbox1_1"=>$this->input->post("listing_textbox1_1"),"listing_textbox2_1"=>$this->input->post("listing_textbox2_1"),"listing_textbox3_1"=>$this->input->post("listing_textbox3_1"),"listing_textbox4_1"=>$this->input->post("listing_textbox4_1"),"listing_textbox5_1"=>$this->input->post("listing_textbox5_1"),"listing_feature"=>$listing_feature,"listing_descbrief_1"=>$this->input->post("listing_descbrief_1"),"listing_descfull_1"=>$this->input->post("listing_descfull_1"),"listing_status_feature"=>"featured","listing_status_claimed"=>"claimed","listing_status_keywords"=>$listing_status_keywords,"listing_status"=>"approved","listing_lastupdate"=>date("Y-m-d H:i:s"));

				

				

				$result = $this->Listingdb->update_listing($this->data);

				$this->data["success_msg"] = $result;

				$this->seller_own_listing();

			}

			else

			{	

				//validation error

				$this->data["validation_errors"] = validation_errors();

								 			

				$this->data["listingObj"] = (object) $_POST;	

				$this->load->view("seller_listing_edit",$this->data);				

			}

		}

		else

		{

			$this->seller_own_listing();

		}		

	}

	//seller update sec	

	public function update()
	{
		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if($this->input->post("listing_id"))

		{   
			$this->load->library('form_validation');

			$this->form_validation->set_rules("listing_seller","Please select Seller","trim|required");

			$this->form_validation->set_rules("listing_title_1","Enter Your Business Name","trim|required");

			$this->form_validation->set_rules("listing_price","Enter listing Pricing","trim|required");

			$this->form_validation->set_rules("listing_location_1","Country","trim|required");	
			$this->form_validation->set_rules("listing_location_2","State","trim|required");	
			$this->form_validation->set_rules("listing_location_3","City","trim|required");			

			//$this->form_validation->set_rules("listing_address","Address","trim|required");

			

			$this->form_validation->set_rules("listing_facilities","Facilities","trim|required");

			$this->form_validation->set_rules("listing_competition","Competition","trim|required");

			$this->form_validation->set_rules("listing_growth","Growth","trim|required");

			$this->form_validation->set_rules("listing_financing","Financing","trim|required");

			$this->form_validation->set_rules("listing_training","Training","trim|required");
			
			$this->form_validation->set_rules("listing_sell_reason","Sell Reason","trim|required");

			

			//$this->form_validation->set_rules("listing_descbrief_1","Description","trim|required");

			$this->form_validation->set_rules("listing_descfull_1","Description","trim");

			if($this->form_validation->run()!=false)
			{				
				//validation sucess				

				$listing_location_path = "-";

				for($i=1;$i<=3;$i++)

				{

					$listing_location_id = $this->input->post("listing_location_".$i);

					if(!empty($listing_location_id)){$listing_location_path .= $listing_location_id."-";}

				}

				//$listing_feature="-";
//
//				for($i=1;$i<=24;$i++)
//
//				{
//
//					$temp = $this->input->post("listing_feature_$i");
//
//					if(!empty($temp)){$listing_feature .= $i."-";}
//
//				}

				//getting lng lat from address

				$listing_posted_latitude = $this->input->post("listing_posted_latitude");

				$listing_posted_longitude = $this->input->post("listing_posted_longitude");

				if(empty($listing_posted_latitude) || empty($listing_posted_longitude))

				{

					$address = $this->input->post("listing_address")." ".$this->input->post("listing_address2");

					$lng_lat = $this->get_lng_lat($address);

					

					$listing_posted_latitude = $lng_lat["latitude"];

					$listing_posted_longitude = $lng_lat["longitude"];

				}

				

				$listing_category_path="-";		
				
				
				$listing_sector_array = $this->input->post("listing_sector");
				$listing_category_array = $this->input->post("listing_category");
				$temp_array = $listing_category_array;
				foreach($listing_category_array as $k=>$val){
					$listing_sector = 	$listing_sector_array[$k];
					$listing_category_id = $val;
					if(!empty($listing_category_id)){$listing_category_path .= $listing_sector."-".$listing_category_id."-";}
				}		
				$listing_category_path="-".$listing_sector_array[0]."-".$listing_category_array[0]."-".$listing_sector_array[1]."-".$listing_category_array[1]."-".$listing_sector_array[2]."-".$listing_category_array[2];	
				
				
				//getting category initation	
				$listing_category_array = $this->input->post("listing_category");
				$category_name_list = "";
				$temp_array = $listing_category_array;
				foreach($listing_category_array as $k=>$val){
					$prime_categoryObj = $this->Listingdb->get_prime_category(array("category_id"=>$val));
					$category_name_list .= $prime_categoryObj->category_name_1." + ";
				}			

								

				$replace_listing_title = str_replace(" ","-",$this->input->post("listing_title_1"));

				

				

				$listing_status_keywords = $this->input->post("listing_title_1")." + ".$replace_listing_title." + ".$this->input->post("listing_descfull_1")." + ".$category_name_list." + ".$this->input->post("listing_address")." + ".$this->input->post("listing_address2")." + ".$this->input->post("listing_phone")." + ".$this->input->post("listing_email")." + ".$this->input->post("listing_website");

					

				$listing_expire = date("Y-m-d",strtotime($this->input->post("listing_expire")));				

				$this->data = array("listing_title_1"=>$this->input->post("listing_title_1"),"listing_location_path"=>$listing_location_path,"listing_location"=>$listing_location_id,"listing_category"=>$listing_category_id,"listing_category_path"=>$listing_category_path,"listing_address"=>$this->input->post("listing_address"),"listing_address2"=>$this->input->post("listing_address2"),"listing_zip"=>$this->input->post("listing_zip"),"listing_posted_latitude"=>$listing_posted_latitude,"listing_posted_longitude"=>$listing_posted_longitude,"listing_descfull_1"=>$this->input->post("listing_descfull_1"),"listing_facilities"=>$this->input->post("listing_facilities"),"listing_competition"=>$this->input->post("listing_competition"),"listing_growth"=>$this->input->post("listing_growth"),"listing_financing"=>$this->input->post("listing_financing"),"listing_price"=>$this->input->post("listing_price"),"listing_training"=>$this->input->post("listing_training"),"listing_image"=>$this->input->post("photo_caption_1"),"listing_sell_reason"=>$this->input->post("listing_sell_reason"),"listing_status_keywords"=>$listing_status_keywords,"listing_status"=>"approved","listing_lastupdate"=>date("Y-m-d H:i:s"));				

					

				$result = $this->Listingdb->update_listing($this->data);
				$this->data["success_msg"] = $result;

				$this->data["page"] = $this->input->post("page");
				
				$ses = $this->session->userdata("search_listing_post");
				
				if(!empty($ses))

				{

					$data = $this->session->userdata("search_listing_post");

					$data = $this->Listingdb->get_listing_search_result($data,$this->input->post("page"),100);

					$this->data["listing_list"] = $data["listing_list"];

					$this->data["pagination"] = $data["pagination"];

					$this->data["post_data"] = $data["post_data"];

					$this->load->view("listing_search_result",$this->data);

				}

				else

				{

					$this->index();

				}

			}

			else

			{	
				//validation error

				echo $this->data["validation_errors"] = validation_errors();							 

				//$userObj = (object) $_POST;			
				
				//$this->data["listingObj"] = $userObj;

				//$this->load->view("listing_edit",$this->data);				

			}

		}

		else

		{

			$this->index();

		}		

	}

	//add listing step one

	public function new_listing_step_1()

	{

		$this->load->view("new_listing_step_1");

	}

	

	//get seller search result

	public function new_listing_step_2()

	{

		//var_dump($_POST);

		if(isset($_POST))

		{

			$data["seller_type"] = $this->input->post("search_type");

			$data["seller_username"] = $this->input->post("search_username");



			$data["seller_company"] = $this->input->post("search_company");



			$data["seller_firstname"] = $this->input->post("search_firstname");



			$data["seller_lastname"] = $this->input->post("search_lastname");

			$data["order_by"] = $this->input->post("search_order");

			$this->load->model("Sellerdb");

			$this->data = $this->Sellerdb->get_seller_search_resutl($data,1,5);

			$this->load->view("new_listing_step_2",$this->data);

		}

		else

		{

			//$this->new_listing_step_1();

		}

	}

	//get new listing by seller

	public function new_own_listing($id=0)

	{

		if(!array_key_exists("slrd",$this->session->userdata())){header("www.trustedhomecontractors.com/seller-login/");}

		

		if($this->input->post("listing_seller"))

		{

			$this->load->library('form_validation');

			$this->form_validation->set_rules("listing_seller","Please select Seller","trim|required");

			$this->form_validation->set_rules("listing_expire","Please select Seller","trim|required");

			$this->form_validation->set_rules("listing_category_1","Please select Category","trim|required");

			$this->form_validation->set_rules("listing_title_1","Enter Your Business Name","trim|required");

			$this->form_validation->set_rules("listing_price","Enter Your Listing Price","trim|required");

			$this->form_validation->set_rules("listing_location_1","Location","trim|required");			

			$this->form_validation->set_rules("listing_address","Address","trim|required");

			$this->form_validation->set_rules("listing_zip","Zip Code","trim|required");

			$this->form_validation->set_rules("listing_phone","Phone No","trim|required");

			$this->form_validation->set_rules("listing_email","Email","trim|required|valid_email");						

			$this->form_validation->set_rules("listing_textbox1_1","Trade License Locale","trim|required");

			$this->form_validation->set_rules("listing_textbox2_1","Trade License Authority","trim|required");

			$this->form_validation->set_rules("listing_textbox4_1","Trade License Expiration","trim|required");

			$this->form_validation->set_rules("listing_textbox5_1","Trade License Description","trim|required");

			$this->form_validation->set_rules("listing_descbrief_1","Description","trim|required");

			$this->form_validation->set_rules("listing_descfull_1","Description","trim");

			

			if($this->form_validation->run()!=false)

			{

				//form validation true

				$listing_location_path = "-";

				for($i=1;$i<=3;$i++)

				{

					$listing_location_id = $this->input->post("listing_location_$i");

					if(!empty($listing_location_id)){$listing_location_path .= $listing_location_id."-";}

				}

				$listing_feature="-";

				for($i=1;$i<=24;$i++)

				{

					$temp = $this->input->post("listing_feature_$i");

					if(!empty($temp)){$listing_feature .= $i."-";}

				}

				$listing_category_path="-";				

				for($i=1;$i<=10;$i++)

				{

					if($i==1){$listing_category_id = $this->input->post("listing_feature_$i");}

					$listing_category_id = $this->input->post("listing_category_$i");

					if(!empty($listing_category_id)){$listing_category_path .= $listing_category_id."-";}

				}

				

				//getting lng lat from address

				$listing_posted_latitude = $this->input->post("listing_posted_latitude");

				$listing_posted_longitude = $this->input->post("listing_posted_longitude");

				if(empty($listing_posted_latitude) || empty($listing_posted_longitude))

				{

					$address = $this->input->post("listing_address")." ".$this->input->post("listing_address2");

					$lng_lat = $this->get_lng_lat($address);

					

					$listing_posted_latitude = $lng_lat["latitude"];

					$listing_posted_longitude = $lng_lat["longitude"];

				}

				

				//getting category initation

				$prime_categoryObj = $this->Listingdb->get_prime_category(array("category_id"=>$this->input->post("listing_category_1")));

				

				$listing_status_keywords = $this->input->post("listing_title_1")." + ".str_replace(" ","-",$this->input->post("listing_title_1"))." + ".$this->input->post("listing_descbrief_1")." + ".$this->input->post("listing_descfull_1").$prime_categoryObj->category_name_1." + ".$this->input->post("listing_address")." + ".$this->input->post("listing_address2")."+".$this->input->post("listing_facilities")."+".$this->input->post("listing_competition")."+".$this->input->post("listing_growth")."+".$this->input->post("listing_financing")."+".$this->input->post("listing_training");

				

				$listing_url_1 = str_replace(" ","-",$this->input->post("listing_title_1"));				

				

				$this->data = array("listing_seller"=>$this->input->post("listing_seller"),"listing_package"=>$this->input->post("listing_package"),"listing_expire"=>date("Y-m-d H:i:s",strtotime($this->input->post("listing_expire"))),"listing_category"=>$this->input->post("listing_category_1"),"listing_category_path"=>$listing_category_path,"listing_url_1"=>$listing_url_1,"listing_title_1"=>$this->input->post("listing_title_1"),"listing_price"=>$this->input->post("listing_price"),"listing_location_path"=>$listing_location_path,"listing_location"=>$listing_location_id,"listing_address"=>$this->input->post("listing_address"),"listing_address2"=>$this->input->post("listing_address2"),"listing_facilities"=>"","listing_competition"=>"","listing_growth"=>"","listing_financing"=>"","listing_training"=>"","listing_feature"=>$listing_feature,"listing_descbrief_1"=>$this->input->post("listing_descbrief_1"),"listing_descfull_1"=>$this->input->post("listing_descfull_1"),"listing_status_feature"=>"featured","listing_status_claimed"=>"claimed","listing_status_keywords"=>$listing_status_keywords,"listing_status"=>"approved","listing_lastupdate"=>date("Y-m-d H:i:s"));

				$catg = 0;

				$result = $this->Listingdb->add_new_listing($this->data,$catg);			

				$this->data["success_msg"] = $result["msg"];

				$this->seller_own_listing();

			}

			else

			{

				//form validation false

				$this->data["validation_errors"] = validation_errors();

								 

				$this->data["listingObj"] = (object) array("listing_seller"=>"","listing_package"=>"","listing_expire"=>"","listing_title_1"=>"","listing_price"=>"0.00","listing_location_path"=>"","listing_location"=>"","listing_address"=>"","listing_address2"=>"","listing_zip"=>"","listing_posted_latitude"=>"","listing_posted_longitude"=>"","listing_facilities"=>"","listing_competition"=>"","listing_growth"=>"","listing_financing"=>"","listing_training"=>"","listing_feature"=>"","listing_descbrief_1"=>"","listing_descfull_1"=>"");

				$this->load->view("new_own_listing",$this->data);

			}

		}

		else

		{

			$this->load->model("Sellerdb");

			$result = $this->Sellerdb->select_seller(array("seller_id"=>$id));

			

			foreach($result as $k=>$obj){$sellerObj = $obj;}

			

			$this->data["listingObj"] = (object) array("listing_seller"=>$sellerObj->seller_id,"seller_package"=>$sellerObj->seller_package,"seller_expire_date"=>$sellerObj->seller_expire_date,"seller_firstname"=>$sellerObj->seller_firstname,"seller_lastname"=>$sellerObj->seller_lastname,"listing_category"=>"","listing_title_1"=>"","listing_price"=>"0.00","listing_location_path"=>"","listing_location"=>"","listing_address"=>"","listing_address2"=>"","listing_zip"=>"","listing_posted_latitude"=>"","listing_posted_longitude"=>"","listing_feature"=>"","listing_facilities"=>"","listing_competition"=>"","listing_growth"=>"","listing_financing"=>"","listing_training"=>"","listing_descbrief_1"=>"","listing_descfull_1"=>"");						

			$this->load->view("new_own_listing",$this->data);

		}

	}

	public function new_listing_final_step($id=0)

	{

		$this->new_listing($id);

	}

	//add new listing

	public function new_listing($id=0)
	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		$listing_seller = $this->input->post("listing_seller");
		if(!empty($listing_seller))
		{			
		
			$this->load->library('form_validation');

			$this->form_validation->set_rules("listing_seller","Please select Seller","trim|required");

			//$this->form_validation->set_rules("listing_sector","Please select Sector","trim|required");

			//$this->form_validation->set_rules("listing_category","Please select Category","trim|required");

			$this->form_validation->set_rules("listing_title_1","Enter Your Business Name","trim|required");

			$this->form_validation->set_rules("listing_price","Enter listing Pricing","trim|required");

			$this->form_validation->set_rules("listing_location_1","Country","trim|required");			
			$this->form_validation->set_rules("listing_location_2","State","trim|required");
			$this->form_validation->set_rules("listing_location_3","City","trim|required");

			

			$this->form_validation->set_rules("listing_facilities","Facilities","trim|required");

			$this->form_validation->set_rules("listing_competition","Competition","trim|required");

			$this->form_validation->set_rules("listing_growth","Growth","trim|required");

			$this->form_validation->set_rules("listing_financing","Financing","trim|required");

			$this->form_validation->set_rules("listing_training","Training","trim|required");
			
			$this->form_validation->set_rules("listing_sell_reason","Sell Reason","trim|required");

			

			//$this->form_validation->set_rules("listing_descbrief_1","Description","trim|required");

			$this->form_validation->set_rules("listing_descfull_1","Description","trim");

			

			if($this->form_validation->run()!=false)
			{
				
				//form validation true

				$listing_location_path = "-";

				for($i=1;$i<=3;$i++)

				{

					$listing_location_id = $this->input->post("listing_location_$i");

					if(!empty($listing_location_id)){$listing_location_path .= $listing_location_id."-";}

				}

				$listing_category_path="-";		
						
				$listing_sector_array = $this->input->post("listing_sector");
				$listing_category_array = $this->input->post("listing_category");
				$temp_array = $listing_category_array;
				foreach($listing_category_array as $k=>$val){
					$listing_sector = 	$listing_sector_array[$k];
					$listing_category_id = $val;
					if(!empty($listing_category_id)){$listing_category_path .= $listing_sector."-".$listing_category_id."-";}
				}
				
				
				$listing_category_path="-".$listing_sector_array[0]."-".$listing_category_array[0]."-".$listing_sector_array[1]."-".$listing_category_array[1]."-".$listing_sector_array[2]."-".$listing_category_array[2];
				

				//getting lng lat from address

				$listing_posted_latitude = $this->input->post("listing_posted_latitude");

				$listing_posted_longitude = $this->input->post("listing_posted_longitude");

				if(empty($listing_posted_latitude) || empty($listing_posted_longitude))

				{

					$address = $this->input->post("listing_address")." ".$this->input->post("listing_address2");

					$lng_lat = $this->get_lng_lat($address);

					

					$listing_posted_latitude = $lng_lat["latitude"];

					$listing_posted_longitude = $lng_lat["longitude"];

				}

				//getting category initation
				$listing_category_array = $this->input->post("listing_category");
				$category_name_list = "";
				$temp_array = $listing_category_array;
				foreach($listing_category_array as $k=>$val){
					$prime_categoryObj = $this->Listingdb->get_prime_category(array("category_id"=>$val));
					$category_name_list .= $prime_categoryObj->category_name_1." + ";
				}
				$listing_status_keywords = $this->input->post("listing_title_1")." + ".str_replace(" ","-",$this->input->post("listing_title_1"))." + ".$this->input->post("listing_descfull_1")." + ".$category_name_list." + ".$this->input->post("listing_address")." + ".$this->input->post("listing_address2")."+".$this->input->post("listing_facilities")."+".$this->input->post("listing_competition")."+".$this->input->post("listing_growth")."+".$this->input->post("listing_financing")."+".$this->input->post("listing_training")."+".$this->input->post("listing_address2");			

				$listing_url_1 = str_replace(" ","-",$this->input->post("listing_title_1"));

				$listing_seller = $this->input->post("listing_seller");

				$this->data = array("listing_seller"=>$listing_seller,"listing_category"=>$listing_category_array[0],"listing_category_path"=>$listing_category_path,"listing_url_1"=>$listing_url_1,"listing_title_1"=>$this->input->post("listing_title_1"),"listing_price"=>$this->input->post("listing_price"),"listing_location_path"=>$listing_location_path,"listing_location"=>$listing_location_id,"listing_address"=>$this->input->post("listing_address"),"listing_address2"=>$this->input->post("listing_address2"),"listing_zip"=>$this->input->post("listing_zip"),"listing_posted_latitude"=>$listing_posted_latitude,"listing_posted_longitude"=>$listing_posted_longitude,"listing_descfull_1"=>$this->input->post("listing_descfull_1"),"listing_facilities"=>$this->input->post("listing_facilities"),"listing_competition"=>$this->input->post("listing_competition"),"listing_growth"=>$this->input->post("listing_growth"),"listing_financing"=>$this->input->post("listing_financing"),"listing_training"=>$this->input->post("listing_training"),"listing_sell_reason"=>$this->input->post("listing_sell_reason"),"listing_status_feature"=>"unfeatured","listing_image"=>$this->input->post("photo_caption_1"),"listing_status_claimed"=>"claimed","listing_status_keywords"=>$listing_status_keywords,"listing_status"=>"pending","listing_lastupdate"=>date("Y-m-d H:i:s"));
				//var_dump($this->data);exit;
				$catg = 0;

				$result = $this->Listingdb->add_new_listing($this->data,$catg);		

				$this->data["success_msg"] = $result["msg"];

				

				//send a mail			

				//listing approved

				$listing_number = $result["id"];

				$listing_name = $this->input->post("listing_title_1");

				$this->load->model("Sellerdb");

				

				$result = $this->Sellerdb->select_seller(array("seller_id"=>$result["listing_seller"]));		

				foreach($result as $k=>$obj){$sellerObj = $obj;}				

				$this->index();
			}
			else
			{

				//form validation false

				$this->data["validation_errors"] = validation_errors();

								 

				$this->data["listingObj"] = (object) array("listing_seller"=>"","listing_package"=>"","listing_expire"=>"","listing_title_1"=>"","listing_price"=>"0.00","listing_location_path"=>"","listing_location"=>"","listing_address"=>"","listing_address2"=>"","listing_zip"=>"","listing_posted_latitude"=>"","listing_posted_longitude"=>"","listing_price"=>"0.00","listing_descbrief_1"=>"","listing_descfull_1"=>"","listing_facilities"=>"","listing_competition"=>"","listing_growth"=>"","listing_financing"=>"","listing_training"=>"");

				$this->load->view("new_listing",$this->data);

			}

		}
		else
		{		

			$this->data["listingObj"] = (object) array("listing_category"=>"","listing_price"=>"0.00","listing_title_1"=>"","listing_location_path"=>"","listing_location"=>"","listing_address"=>"","listing_address2"=>"","listing_zip"=>"","listing_posted_latitude"=>"","listing_posted_longitude"=>"","listing_facilities"=>"","listing_competition"=>"","listing_growth"=>"","listing_financing"=>"","listing_training"=>"","listing_descbrief_1"=>"","listing_descfull_1"=>"");						
			
			$this->load->view("new_listing",$this->data);

		}				

	}
	
	//Delete All Listing
	public function delete_all_listing(){		
		
		$result = $this->Listingdb->delete_all_listing();
				
		$this->data["success_msg"] = $result;	
		$this->index();
	}

	//delete selected listing
	public function delete_selected_listing()

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}		
		

		$listing_status_delete = $this->input->post("listing_status_delete");
		
		foreach($listing_status_delete as $val){
			set_time_limit(0);
			$result = $this->Listingdb->delete_listing(array("listing_id"=>$val));	
		}		

		$this->data["success_msg"] = $result;

		$ses = $this->session->userdata("search_listing_post");

		
		
		if(!empty($ses))

		{

			$data = $this->session->userdata("search_listing_post");
			$page = $data["startpage"];
			$data = $this->Listingdb->get_listing_search_result($data,$page,100);

			$this->data["listing_list"] = $data["listing_list"];

			$this->data["pagination"] = $data["pagination"];

			$this->data["post_data"] = $data["post_data"];

			$this->data["page"] = $page;

			$this->load->view("listing_search_result",$this->data);

		}

		else

		{

			$this->index();

		}

	}

	//delete listing

	public function delete_listing($id=0,$page=1)
	{
		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		if($id<=0){
			$id = $this->input->post("delete_id");
			
		}
		
		$result = $this->Listingdb->delete_listing(array("listing_id"=>$id));	

		$this->data["success_msg"] = $result;

		$ses = $this->session->userdata("search_listing_post");
		
		
		if(!empty($ses))

		{

			$data = $this->session->userdata("search_listing_post");

			$data = $this->Listingdb->get_listing_search_result($data,$page,100);

			$this->data["listing_list"] = $data["listing_list"];

			$this->data["pagination"] = $data["pagination"];

			$this->data["post_data"] = $data["post_data"];

			$this->data["page"] = $page;

			$this->load->view("listing_search_result",$this->data);

		}

		else

		{

			$this->index();

		}

	}

	//delete seller own listing

	public function delete_own_listing($id)

	{

		//check weather user logged in or not

		if(!array_key_exists("slrd",$this->session->userdata())){redirect("seller_login");}

		

		$result = $this->Listingdb->delete_listing(array("listing_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->seller_own_listing();

	}

	//delete seller listing

	public function delete_seller_listing($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("slrd",$this->session->userdata())){redirect("seller_login");}

		

		$result = $this->Listingdb->delete_listing(array("listing_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->seller_own_listing();

	}

	//get listing category

	public function listing_category($listing_id=0)

	{

		if($listing_id>0)

		{

			$data =array("category_listing"=>$listing_id);

			$this->data["listing_category_list"] = $this->Listingdb->get_listing_category($data);

			

			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			

			$this->load->view("listing_category",$this->data);			

		}

		else

		{

			$this->index();

		}

	}
	
	

	//get seller listing category

	public function seller_listing_category($listing_id=0)

	{

		if($listing_id>0)

		{

			$data =array("category_listing"=>$listing_id);

			$this->data["listing_category_list"] = $this->Listingdb->get_listing_category($data);

			

			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			

			$this->load->view("seller_listing_category",$this->data);			

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	//add seller listing category

	public function add_seller_listing_category($listing_id=0)

	{

		if($this->input->post("category_listing"))

		{				

			$this->data["success_msg"] = $this->Listingdb->add_listing_category();			

			$data =array("category_listing"=>$this->input->post("category_listing"));

			$this->data["listing_category_list"] = $this->Listingdb->get_listing_category($data);
			

			$result = $this->Listingdb->select_listing(array("listing_id"=>$this->input->post("category_listing")));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			$this->load->view("seller_listing_category",$this->data);				

		}

		elseif($listing_id>0)

		{

			$data =array("category_listing"=>$listing_id);

			$this->data["listing_category_list"] = $this->Listingdb->get_listing_category($data);

			

			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			$this->load->view("new_seller_listing_category",$this->data);

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	//add listing category

	public function add_listing_category($listing_id=0)

	{

		if($this->input->post("category_listing"))

		{				

			$this->data["success_msg"] = $this->Listingdb->add_listing_category();

			

			$data =array("category_listing"=>$this->input->post("category_listing"));

			$this->data["listing_category_list"] = $this->Listingdb->get_listing_category($data);

			

			$result = $this->Listingdb->select_listing(array("listing_id"=>$this->input->post("category_listing")));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			$this->load->view("listing_category",$this->data);				

		}

		elseif($listing_id>0)

		{

			$data =array("category_listing"=>$listing_id);

			$this->data["listing_category_list"] = $this->Listingdb->get_listing_category($data);

			

			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			

			$this->load->view("new_listing_category",$this->data);

		}

		else

		{

			$this->index();

		}

	}

	//delete seller listing category

	public function delete_seller_listing_category($category_id=0,$listing_id=0)

	{

		$this->data["success_msg"] = $this->Listingdb->delete_listing_category($category_id,$listing_id);

		$this->seller_listing_category($listing_id);

	}

	//delete listing category

	public function delete_listing_category($category_id=0,$listing_id=0)

	{

		$this->data["success_msg"] = $this->Listingdb->delete_listing_category($category_id,$listing_id);

		$this->listing_category($listing_id);

	}

	public function package_limit($listing_package=0)

	{

		return $this->Listingdb->get_package_detail($listing_package);

	}

	// listing photo

	public function listing_photos($listing_id=0)

	{

		if($listing_id>0)

		{

		$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

		foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

		

		$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

		$this->data["listing_photo"] = $this->Listingdb->listing_photos(array("photo_listing"=>$listing_id));

		

		$this->load->view("listing_photos",$this->data);

		}

		else

		{

			$this->index();

		}

	}

	

	// listing photo

	public function own_listing_photos($listing_id=0)

	{

		if($listing_id>0)

		{

		$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

		foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

		

		$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

		echo $listing_id;

		$this->data["listing_photo"] = $this->Listingdb->listing_photos(array("photo_listing"=>$listing_id));

		

		$this->load->view("own_listing_photos",$this->data);

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	//set photo as main listing photo

	public function set_listing_main_photo($photo_id=0,$listing_id=0)

	{

		$this->data["success_msg"] = $this->Listingdb->set_listing_main_photo($photo_id,$listing_id);

		

		$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

		foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

		

		$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

		$this->data["listing_photo"] = $this->Listingdb->listing_photos(array("photo_listing"=>$listing_id));

		

		$this->load->view("listing_photos",$this->data);

	}

	//set seller photo as main listing photo

	public function set_own_listing_main_photo($photo_id=0,$listing_id=0)

	{

		$this->data["success_msg"] = $this->Listingdb->set_listing_main_photo($photo_id,$listing_id);

		

		$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

		foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

		

		$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

		$this->data["listing_photo"] = $this->Listingdb->listing_photos(array("photo_listing"=>$listing_id));

		

		$this->load->view("own_listing_photos",$this->data);

	}

	//get listing photo detail for edit

	public function edit_listing_photo($photo_id=0,$listing_id=0)

	{

		$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

		foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

		

		$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

		$this->data["listing_photoObj"] = $this->Listingdb->edit_listing_photo($photo_id);

		$this->load->view("listing_photo_edit",$this->data);

	}

	//get own listing photo detail for edit

	public function edit_own_listing_photo($photo_id=0,$listing_id=0)

	{

		$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

		foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

		

		$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

		$this->data["listing_photoObj"] = $this->Listingdb->edit_listing_photo($photo_id);

		$this->load->view("own_listing_photo_edit",$this->data);

	}

	// update listing photo

	public function update_listing_photo()

	{

		if($this->input->post("photo_caption_1"))

		{

			$this->data["success_msg"] = $this->Listingdb->update_listing_photo();

			

			@unlink("./photo_big/".$this->input->post("photo_id").".jpg");

			@unlink("./photo_medium/".$this->input->post("photo_id").".jpg");

			@unlink("./photo_small/".$this->input->post("photo_id").".jpg");

						

			$this->new_listing_photo_upload($this->input->post("photo_id"));

			

			$this->listing_photos($this->input->post("photo_listing"));			

		}

		else

		{

			$this->index();

		}

	}

	// update seller own listing photo

	public function update_own_listing_photo()

	{

		if($this->input->post("photo_caption_1"))

		{

			$this->data["success_msg"] = $this->Listingdb->update_listing_photo();

			

			@unlink("./photo_big/".$this->input->post("photo_id").".jpg");

			@unlink("./photo_medium/".$this->input->post("photo_id").".jpg");

			@unlink("./photo_small/".$this->input->post("photo_id").".jpg");

						

			$this->new_listing_photo_upload($this->input->post("photo_id"));

			

			$this->own_listing_photos($this->input->post("photo_listing"));			

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	public function add_listing_photo($listing_id=0)

	{

		if($this->input->post("photo_listing"))

		{

			$this->data["success_msg"] = $this->Listingdb->add_listing_photo();

			

			$this->listing_photos($this->input->post("photo_listing"));			

		}

		elseif($listing_id>0)

		{

			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			

			$this->data["listing_photoObj"] = (object) array("photo_listing"=>$listing_id);

			$this->load->view("new_listing_photo",$this->data);

		}

		else

		{

			$this->index();

		}

	}

	//add own listing photo

	public function add_own_listing_photo($listing_id=0)

	{

		if($this->input->post("photo_listing"))

		{

			$this->data["success_msg"] = $this->Listingdb->add_listing_photo();

			

			$this->own_listing_photos($this->input->post("photo_listing"));			

		}

		elseif($listing_id>0)

		{

			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			

			$this->data["listing_photoObj"] = (object) array("photo_listing"=>$listing_id);

			$this->load->view("new_own_listing_photo",$this->data);

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	//delete phosts from listing

	public function delete_listing_photo($photo_id=0,$listing_id=0)

	{

		if($photo_id>0)

		{

			$this->data["success_msg"] = $this->Listingdb->delete_listing_photo($photo_id);

			$this->listing_photos($listing_id);

		}

		else

		{

			$this->index();

		}

	}

	//delete photos from seller own listing

	public function delete_own_listing_photo($photo_id=0,$listing_id=0)

	{

		if($photo_id>0)

		{

			$this->data["success_msg"] = $this->Listingdb->delete_listing_photo($photo_id);

			$this->own_listing_photos($listing_id);

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	//get listing videos

	public function listing_videos($listing_id=0)

	{

		if($listing_id>0)

		{

			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			$this->data["listing_video"] = $this->Listingdb->get_listing_video(array("video_listing"=>$listing_id));

			$this->load->view("listing_video",$this->data);

		}

		else

		{

			$this->index();

		}

	}

	//get seller listing videos

	public function own_listing_videos($listing_id=0)

	{

		if($listing_id>0)

		{

			$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			$this->data["listing_video"] = $this->Listingdb->get_listing_video(array("video_listing"=>$listing_id));

			$this->load->view("own_listing_video",$this->data);

		}

		else

		{

			$this->index();

		}

	}	

	//edit video into listing

	public function edit_listing_video($video_id=0,$video_type="upload")

	{

		if($video_id>0)

		{

			$this->data["listing_videoObj"] = $this->Listingdb->edit_listing_videos(array("video_id"=>$video_id));

			

			$result = $this->Listingdb->select_listing(array("listing_id"=>$this->data["listing_videoObj"]->video_listing));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			if($video_type=="upload")

			{				

				$this->load->view("listing_video_upload_edit",$this->data);

			}

			elseif($video_type=="external")

			{

				$this->load->view("listing_video_external_edit",$this->data);

			}

			elseif($video_type=="youtube")

			{

				$this->load->view("listing_video_youtube_edit",$this->data);

			}

		}

		else

		{

			$this->index();

		}

	}

	//edit video into listing

	public function edit_own_listing_video($video_id=0,$video_type="upload")

	{

		if($video_id>0)

		{

			$this->data["listing_videoObj"] = $this->Listingdb->edit_listing_videos(array("video_id"=>$video_id));

			

			$result = $this->Listingdb->select_listing(array("listing_id"=>$this->data["listing_videoObj"]->video_listing));			

			foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

			$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

			if($video_type=="upload")

			{				

				$this->load->view("own_listing_video_upload_edit",$this->data);

			}

			elseif($video_type=="external")

			{

				$this->load->view("own_listing_video_external_edit",$this->data);

			}

			elseif($video_type=="youtube")

			{

				$this->load->view("own_listing_video_youtube_edit",$this->data);

			}

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	//add video into listing

	public function add_listing_video($listing_id=0,$type="upload")

	{

		if($listing_id>0)

		{

			if($this->input->post("video_listing"))

			{	

				$type = $this->input->post("video_type");

				if($type=="upload")

				{	

					$this->data = $this->Listingdb->add_listing_video_upload();

				}

				elseif($type=="external")

				{

					$this->data = $this->Listingdb->add_listing_video_external();

				}

				elseif($type=="youtube")

				{

					$this->data = $this->Listingdb->add_listing_video_youtube();

				}

				//print_r($this->data);

				if($this->data["status"])

				{

					$this->listing_videos($listing_id);

				}

				else

				{

					

					$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

					foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

								

					$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

					if($type=="upload")

					{

						$this->load->view("new_listing_video_upload",$this->data);

					}

					elseif($type=="external")

					{

						$this->load->view("new_listing_video_external",$this->data);

					}

					elseif($type=="youtube")

					{

						$this->load->view("new_listing_video_youtube",$this->data);

					}

				}

			}

			else

			{

				$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

				foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

							

				$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

				if($type=="upload")

				{

					$this->load->view("new_listing_video_upload",$this->data);

				}

				elseif($type=="external")

				{

					$this->load->view("new_listing_video_external",$this->data);

				}

				elseif($type=="youtube")

				{

					$this->load->view("new_listing_video_youtube",$this->data);



				}

			}

		}

		else

		{

			$this->index();

		}

	}

	public function update_listing_video($listing_id=0,$type="upload")

	{

		if($listing_id>0)

		{

			if($this->input->post("video_listing"))

			{	

				$type = $this->input->post("video_type");

				if($type=="upload")

				{	

					$this->data = $this->Listingdb->update_listing_video_upload();

				}

				elseif($type=="external")

				{

					$this->data = $this->Listingdb->update_listing_video_external();

				}

				elseif($type=="youtube")

				{

					$this->data = $this->Listingdb->update_listing_video_youtube();

				}

				if($this->data["status"])

				{

					$this->listing_videos($listing_id);

				}

				else

				{

					

					$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

					foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

								

					$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

					if($type=="upload")

					{

						$this->load->view("listing_video_upload_edit",$this->data);

					}

					elseif($type=="external")

					{

						$this->load->view("listing_video_external_edit",$this->data);

					}

					elseif($type=="youtube")

					{

						$this->load->view("listing_video_youtube_edit",$this->data);

					}

				}

			}

			else

			{

				$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

				foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

							

				$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

				if($type=="upload")

				{

					$this->load->view("listing_video_upload_edit",$this->data);

				}

				elseif($type=="external")

				{

					$this->load->view("listing_video_external_edit",$this->data);

				}

				elseif($type=="youtube")

				{

					$this->load->view("listing_video_youtube_edit",$this->data);

				}

			}

		}

		else

		{

			$this->index();

		}

	}

	//add seller own video into listing

	public function add_own_listing_video($listing_id=0,$type="upload")

	{

		if($listing_id>0)

		{

			if($this->input->post("video_listing"))

			{	

				$type = $this->input->post("video_type");

				if($type=="upload")

				{	

					$this->data = $this->Listingdb->add_listing_video_upload();

				}

				elseif($type=="external")

				{

					$this->data = $this->Listingdb->add_listing_video_external();

				}

				elseif($type=="youtube")

				{

					$this->data = $this->Listingdb->add_listing_video_youtube();

				}

				if($this->data["status"])

				{

					$this->own_listing_videos($listing_id);

				}

				else

				{

					

					$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

					foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

								

					$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

					if($type=="upload")

					{

						$this->load->view("new_own_listing_video_upload",$this->data);

					}

					elseif($type=="external")

					{

						$this->load->view("new_own_listing_video_external",$this->data);

					}

					elseif($type=="youtube")

					{

						$this->load->view("new_own_listing_video_youtube",$this->data);

					}

				}

			}

			else

			{

				$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));			

				foreach($result as $k=>$obj){$this->data["listingObj"] = $obj;}

							

				$this->data["packageObj"] = $this->package_limit($this->data["listingObj"]->listing_package);

				if($type=="upload")

				{

					$this->load->view("new_own_listing_video_upload",$this->data);

				}

				elseif($type=="external")

				{

					$this->load->view("new_own_listing_video_external",$this->data);

				}

				elseif($type=="youtube")

				{

					$this->load->view("new_own_listing_video_youtube",$this->data);

				}

			}

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	

	//delete listing videos

	public function delete_listing_video($video_id,$listing_id)

	{

		$this->data["success_msg"] = $this->Listingdb->delete_listing_video(array("video_id"=>$video_id,"listing_id"=>$listing_id));

		$this->listing_videos($listing_id);

	}

	//remove video file

	public function remove_listing_video($video_id)

	{

		if($video_id>0)

		{

			$this->data["listing_videoObj"] = $this->Listingdb->edit_listing_videos(array("video_id"=>$video_id));			

			@unlink("./video/".$this->data["listing_videoObj"]->video_file);

			$this->edit_listing_video($video_id);

		}

		else

		{

			$this->index();

		}

	}

	//remove video file

	public function remove_own_listing_video($video_id)

	{

		if($video_id>0)

		{

			$this->data["listing_videoObj"] = $this->Listingdb->edit_listing_videos(array("video_id"=>$video_id));			

			@unlink("./video/".$this->data["listing_videoObj"]->video_file);

			$this->edit_listing_video($video_id);

		}

		else

		{

			$this->seller_own_listing();

		}

	}

	//image upload with creating thumb

	private function new_listing_photo_upload($file_name)

	{

		$this->load->library('image_lib');

		$config['upload_path'] = "./photo_big/";

		$config['allowed_types'] = 'jpg|jpeg';

		$config['max_size']	= '12400';//in kb = 10mb

		$config['file_name'] = $file_name;

		

		$this->load->library('upload', $config);



		if (!$this->upload->do_upload("photo_file"))

		{

			return $this->data["error"] = $this->upload->display_errors();		

		}

		else

		{

			$image_data = $this->upload->data();

			//for big

			//$new_image_path = explode("photo_big/",$image_data["file_path"])[0]."photo_medium/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $image_data["full_path"];

			$img_cfg['maintain_ratio'] = TRUE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $image_data["full_path"];

			$img_cfg['width'] = 600;

			//$img_cfg['quality'] = 100;

			$img_cfg['height'] = 500;			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

			//for medium

			$temp_var =  explode("photo_big/",$image_data["file_path"]);

			$new_image_path = $temp_var[0]."photo_medium/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $image_data["full_path"];

			$img_cfg['maintain_ratio'] = TRUE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $new_image_path;

			$img_cfg['width'] = 280;

			//$img_cfg['quality'] = 100;

			$img_cfg['height'] = 250;			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

			//for small

			$temp_var = explode("photo_big/",$image_data["file_path"]);

			$new_image_path = $temp_var[0]."photo_small/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $image_data["full_path"];

			$img_cfg['maintain_ratio'] = TRUE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $new_image_path;

			$img_cfg['width'] = 80;

			//$img_cfg['quality'] = 100;

			$img_cfg['height'] = 80;			



			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

		}		

	}

	// adding feature list

	public function feature($status="off",$id=0,$page=0)
	{
		if($id>0)
		{

			if($status=="on"){$status="featured";}else{$status="";}

			$data = array("listing_status_feature"=>$status,"listing_id"=>$id);

			$this->data["success_msg"] = $this->Listingdb->feature($data);

			$this->data["page"] = $page;

			$ses = $this->session->userdata("search_listing_post");

			if(!empty($ses))

			{

				$data = $this->session->userdata("search_listing_post");

				$data = $this->Listingdb->get_listing_search_result($data,$page,100);

				$this->data["listing_list"] = $data["listing_list"];

				$this->data["pagination"] = $data["pagination"];

				$this->data["post_data"] = $data["post_data"];

				$this->load->view("listing_search_result",$this->data);

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
	
	// adding new listing
	public function status_new($status="off",$id=0,$page=0)
	{
		if($id>0)
		{

			if($status=="on"){$status="renew";}else{$status="new";}
			$visit_status = "";
			$data = array("listing_status_new"=>$status,"listing_id"=>$id);

			$this->data["success_msg"] = $this->Listingdb->status_new($data);

			$this->data["page"] = $page;

			$ses = $this->session->userdata("search_listing_post");

			if(!empty($ses))

			{

				$data = $this->session->userdata("search_listing_post");

				$data = $this->Listingdb->get_listing_search_result($data,$page,100);

				$this->data["listing_list"] = $data["listing_list"];

				$this->data["pagination"] = $data["pagination"];

				$this->data["post_data"] = $data["post_data"];

				$this->load->view("listing_search_result",$this->data);

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

	//get setup filed list

	public function setup_field_listing()

	{

		$this->data["field_listing"] = $this->Listingdb->get_setup_filed_listing();

		$this->load->view("setup_field_listing",$this->data);

	}

	public function update_all_setup_field_listing()

	{

		$this->data["success_msg"] = $this->Listingdb->update_all_setup_field_listing();

		$this->setup_field_listing();

	}

	public function setup_field_listing_edit($field_listing_id=0)

	{

		if($this->input->post("field_listing_name_1"))

		{

			$this->data["success_msg"] = $this->Listingdb->update_setup_field_listing();

			$this->setup_field_listing();



		}

		elseif($field_listing_id>0)

		{

			$this->data["field_listingObj"] = $this->Listingdb->setup_field_listing_edit($field_listing_id);

			$this->load->view("setup_field_listing_edit",$this->data);

		}

		else

		{

			$this->setup_field_listing();

		}

	}

	// adding auto approve list

	public function auto_approve($status="off",$id=0)

	{

		if($id>0)

		{

			$data = array("seller_status_approval"=>$status,"listing_id"=>$id);

			$this->data = $this->Sellerdb->auto_approve($data);

			$this->index();

		}

		else

		{

			$this->index();

		}

	}

        //share listing to a friend

	public function share_a_listing()

	{

		$listing_id = $this->input->post("listing_id");

		$listing_title = $this->input->post("listing_title");

		$listing_url = "http://www.trustedhomecontractors.com/share-".$listing_id."-".$this->input->post("listing_url");

		

		$sender_name = $this->input->post("required_sender_name");

		$sender_email = $this->input->post("required_sender_email");

		$friend_name = $this->input->post("required_friend_name");

		$friend_email = $this->input->post("required_friend_email");

		

		$mail_template = $this->Listingdb->get_mail_template(31);

		if(!empty($listing_id))

		{

			if(is_object($mail_template))

			{

				$from_email = "info@trustedhomecontractors.com";

				$from_name = "M Pinkston Trusted Home Contractors";

				$to_mail = $this->input->post("required_friend_email");				

				

				$subject = str_replace("[friend_name]",$friend_name,$mail_template->email_subject_1);

			

				$content = str_replace("[friend_name]",$friend_name,$mail_template->email_content_1);

				$content = str_replace("[listing_number]",$listing_id,$content);

				$content = str_replace("[listing_name]",$listing_title,$content);

				$content = str_replace("[sender_name]",$sender_name,$content);

				$content = str_replace("[sender_email]",$sender_email,$content);

				$content = str_replace("[listing_url]",$listing_url,$content);

				

				$this->send_mail($from_email,$from_name,$to_mail,$subject,$content);

				header("Location:$listing_url");						

			}

		}

	}

        //listing contact form

	public function listing_contact()

	{

		$listing_id = $this->input->post("listing_number");

		$result = $this->Listingdb->select_listing(array("listing_id"=>$listing_id));

		foreach($result as $k=>$obj){$listingObj = $obj;}

		

		$seller_firstname = $listingObj->seller_firstname;

		$seller_lastname = $listingObj->seller_lastname;

		$listing_name = $listingObj->listing_title_1;

		$contact_name = $this->input->post("contact_name");

		$contact_email = $this->input->post("contact_email");

		$contact_subject = $this->input->post("contact_subject");

		$contact_message = $this->input->post("contact_message");

		$mail_template = $this->Listingdb->get_mail_template(30);

		if(is_object($mail_template))

		{

			$from_email = "info@trustedhomecontractors.com";

			$from_name = "Trusted Home Contractors";

			$to_mail = $this->input->post("seller_email");

			$seller_firstname = $this->input->post("seller_firstname");			

			$seller_lastname = $this->input->post("seller_lastname");					

			

			$subject = str_replace("[seller_firstname]",$seller_firstname,$mail_template->email_subject_1);

			$subject = str_replace("[seller_lastname]",$seller_lastname,$subject);

		

			$content = str_replace("[listing_number]",$listing_id,$mail_template->email_content_1);

			$content = str_replace("[listing_name]",$listing_name,$content);

			$content = str_replace("[contact_name]",$contact_name,$content);

			$content = str_replace("[contact_email]",$contact_email,$content);

			$content = str_replace("[contact_subject]",$contact_subject,$content);

			$content = str_replace("[contact_message]",$contact_message,$content);

			

			$this->send_mail($from_email,$from_name,$to_mail,$subject,$content);

			

			$this->data["listingObj"] = $listingObj;

			$this->data["success_msg"] = "mail sent...";

						

		}

		else

		{

			$this->data["success_msg"] = "something went wrong...";

		}

		$this->load->view("listing_contact",$this->data);				

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

	//ajax location listing

	public function ajax_location_list($id=0)

	{

		//$this->output->set_content_type('application/json');

                //$this->output->set_header('Content-Type: application/json; charset=utf-8');

		if($id>0){
		$detail = $this->Listingdb->get_location_list(array("location_parent"=>$id));

		if(!empty($detail)){

		foreach($detail as $k=>$locationObj)

		{

			//$this->data[$locationObj->location_id] = $locationObj->location_name;
			$this->data[] = array("id"=>$locationObj->location_id,"location_name"=>$locationObj->location_name);
		}}else{
			$this->data = array('0'=>'No City');
		}}else{
			$this->data = array('0'=>'No City');
		}	

        $this->output->set_content_type('application/json')->set_output(json_encode($this->data));

	}

	//Ajax Category listing

	public function ajax_category_list($id=0)

	{
		if($id>0){

		$detail = $this->Listingdb->get_category_list($id);		
		if(!empty($detail)){
		foreach($detail as $k=>$categoryObj)
		{

				$this->data[$categoryObj->category_id] = $categoryObj->category_name_1;

		}}else{
			$this->data = array('0'=>'No Category');
		}}else{
			$this->data = array('0'=>'No Category');
		}		
        $this->output->set_content_type('application/json')->set_output(json_encode($this->data));

	}
	
	//Ajax SELECT CITY

	public function ajax_select_city($id=0)

	{	
		
		if($id>0){

		$detail = $this->Listingdb->get_select_city($id);		
		if(!empty($detail)){
		foreach($detail as $k=>$cityObj)
		{

				$this->data[] = array("id"=>$cityObj->location_id,"location_name"=>$cityObj->location_name);

		}}else{
			$this->data = array('0'=>'No City');
		}}else{
			$this->data = array('0'=>'No City');
		}		
        $this->output->set_content_type('application/json')->set_output(json_encode($this->data));

	}


	

	private function get_lng_lat($address="")

	{

        $prepAddr = str_replace(' ','+',$address);

        $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');

        $output = json_decode($geocode);

		

		if(!empty($output->results[0]))

		{

        	$data["latitude"] = $output->results[0]->geometry->location->lat;

        	$data["longitude"] = $output->results[0]->geometry->location->lng;

		}else{$data = array("latitude"=>"","longitude"=>"");}

		return $data;

	}

}