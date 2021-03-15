<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class General extends CI_Controller {



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

	 * map to /index.php/welcome/sss<method_name>

	 * @see http://codeigniter.com/user_guide/general/urls.html

	 */

	public function __construct()

	{

	  parent::__construct();

	  $this->load->model('Generaldb');

	  $this->load->library('form_validation');

	}

			

	public function index()

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		$this->data['discount_list'] = $this->Generaldb->setup_discount();

		$this->load->view('setup_discount',$this->data);	

	}

	//****************************************** SETUP DISCOUNT SECTION *****************************************************//

	public function setup_discount(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if($this->session->flashdata("validation_errors")){$this->session->keep_flashdata("validation_errors"); }

		if($this->session->flashdata("sec")){$this->session->keep_flashdata("sec"); }

  		if($this->session->flashdata("setup_discount")){$this->session->keep_flashdata("setup_discount");}

			

			$this->data['discount_list'] = $this->Generaldb->setup_discount();

			$this->load->view('setup_discount',$this->data);

	}

	

	public function new_setup_discount()

	{	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		if($this->input->post("discount_code"))

		{

			$this->form_validation->set_rules('discount_code', 'Discount Code', 'trim|required');

			$this->form_validation->set_rules('discount_percentage', 'Percentage', 'trim|required');

			$this->form_validation->set_rules('discount_expire', 'Expire Date', 'trim|required');

			

			if ($this->form_validation->run() == FALSE)

			{

				$this->session->set_flashdata("validation_errors",validation_errors());

				$this->session->set_flashdata("sec","setup_discount_add");

				$setup_discount = (object) array(				

				'discount_code' => $this->input->post('discount_code'),

				'discount_percentage' => $this->input->post('discount_percentage'),

				'discount_expire' => $this->input->post('discount_expire')

				);

				$this->data["success_msg"] = $result;

				redirect('general/setup_discount');

			}

			else

			{	

				$data = array(

				'discount_code' => $this->input->post('discount_code'),

				'discount_percentage' => $this->input->post('discount_percentage'),

				'discount_expire' => $this->input->post('discount_expire')

				);

				$res = $this->Generaldb->add_setup_discount($data);				

				$this->data["success_msg"] = $res;	

				$this->setup_discount();

			}

			

		}

		else

		{	

			$this->load->view('new_setup_discount');

		}

	}

	

	public function setup_discount_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_discount');

		}else {

		$result = $this->Generaldb->select_setup_discount(array("discount_id"=>$id));

		foreach($result as $k=>$discountObj){		

			$this->data["discountObj"] = $discountObj;

		}$this->load->view('setup_discount_edit',$this->data);	

		}

	}	

	

	public function setup_discount_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->form_validation->set_rules('discount_code', 'Discount Code', 'trim|required');

		$this->form_validation->set_rules('discount_percentage', 'Percentage', 'trim|required');

		$this->form_validation->set_rules('discount_expire', 'Expire Date', 'trim|required');				

		

		if ($this->form_validation->run() == FALSE)

		{

			$this->session->set_flashdata("validation_errors",validation_errors());

			$this->session->set_flashdata("sec","setup_discount_edit");

			$setup_discount = (object) array(

			'discount_id' => $this->input->post('discount_id'),

			'discount_code' => $this->input->post('discount_code'),

			'discount_percentage' => $this->input->post('discount_percentage'),

			'discount_expire' => $this->input->post('discount_expire')

			);			

			redirect('general/setup_discount');

		}else{

			$id= $this->input->post('discount_id');

			$data = array(

			'discount_code' => $this->input->post('discount_code'),

			'discount_percentage' => $this->input->post('discount_percentage'),

			'discount_expire' => $this->input->post('discount_expire')

			);

			$result = $this->Generaldb->update_setup_discount($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_discount();

		}

	}

	

	//Setup Discount delete sec

	public function delete_setup_discount($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_discount(array("discount_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_discount();

	}

	

	//****************************************** SETUP LOCATION SECTION *****************************************************//

	public function setup_location($parent_location=0){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if(isset($this->data["success_msg"])){

		$msg = $this->data["success_msg"];

		}

		

		$this->data = $this->Generaldb->setup_location($parent_location);

		if(!empty($msg)){

		$this->data["success_msg"] = $msg;

		}

		$this->data["parent_location"] = $parent_location;

		$this->load->view('setup_location',$this->data);

	}

	public function delete_all_location()
	{
		$this->Generaldb->delete_all_location();
		$this->setup_location();
	}
	
	public function setup_location_reset()
	{
		$this->Generaldb->setup_location_reset();
		$this->setup_location();
		$this->data["success_msg"] = "Location reset successfully executed...";
	}
	
	public function delete_all_category()
	{
		$this->Generaldb->delete_all_category();
		$this->setup_sector_listing();
	}
	
	public function setup_category_reset()
	{
		$this->Generaldb->setup_category_reset();
		$this->setup_sector_listing();
		$this->data["success_msg"] = "Sector and Category reset successfully executed...";
	}
	
	//Listing Sector Active and Deactive
	 
	public function ajaxCategory_stat($val,$category_id){
	 	$this->Generaldb->ajaxCategory_stat($val,$category_id);
	}
	
	//Setup Location Active and Deactive
	 
	public function ajaxLocation_stat($val,$location_id){
	 	$this->Generaldb->ajaxLocation_stat($val,$location_id);
	}
	
	public function setup_location_add($parent_location=0)
	{
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		if($this->input->post("location_name1"))
		{	
			$res = $this->Generaldb->add_setup_location();
			if(empty($parent_location)){	
				$this->data['parent_location'] = "";
			}else{		
			$this->data['parent_location'] = $parent_location;
			}
			$this->data["success_msg"] = $res;	
			$this->setup_location();			
		}
		else
		{
			$this->data['parent_location'] = $parent_location;
			$this->load->view('setup_location_add',$this->data);
		}
	}
	public function setup_location_edit($id=null){
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		if ($id == null) {
			$this->load->view('setup_location');
		}else {
			$result = $this->Generaldb->select_setup_location(array("location_id"=>$id));
			foreach($result as $k=>$locationObj){		
				$this->data["locationObj"] = $locationObj;
			}
			$this->load->view('setup_location_edit',$this->data);	
		}
	}
	public function setup_location_update(){	
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required');
		$this->form_validation->set_rules('location_url', 'SEO Friendly Name', 'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata("validation_errors",validation_errors());
			$this->session->set_flashdata("sec","setup_discount_edit");
			$setup_discount = (object) array(
			'location_id' => $this->input->post('location_id'),
			'location_name' => $this->input->post('location_name'),
			'location_url' => $this->input->post('location_url')
			);			
			redirect('general/setup_location');
		}else{
			$id= $this->input->post('location_id');
			$data = (object) array(
			'location_id' => $this->input->post('location_id'),
			'location_name' => $this->input->post('location_name'),
			'location_url' => $this->input->post('location_url')
			);			
			$result = $this->Generaldb->update_setup_location($id,$data);
			$this->data["success_msg"] = $result;
			$this->setup_location();
		}
	}
	//Setup Location delete sec
	public function delete_setup_location($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_location(array("location_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_location();

	}

	

	//General paginatation

	public function	location_nxt_page($parent_location=0,$currentPage=0)

	{

		

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$currentPage++;



		$data = $this->Generaldb->setup_location($parent_location,$currentPage,5);

		$this->data["location_list"]= $data["location_list"];

		if(empty($data["pagination"])){

			$this->data["pagination"] = array("startpage"=>0,"pages"=>0);			

		}else{

		$this->data["pagination"] = $data["pagination"];

		}

		$this->data["side_menu"] = array("4"=>"active","sub"=>"active");

		$this->data["parent_location"] = $parent_location;		

		$this->load->view("setup_location",$this->data);

	}

	public function	location_pre_page($parent_location=0,$currentPage=0)

	{	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$currentPage--;

		$data = $this->Generaldb->setup_location($parent_location,$currentPage,5);

		

		$this->data["location_list"]= $data["location_list"];

		if(empty($data["pagination"])){

			$this->data["pagination"] = array("startpage"=>0,"pages"=>0);

		}else{

		$this->data["pagination"] = $data["pagination"];

		}

		

		//$this->data["side_menu"] = array("4"=>"active","sub"=>"active");

		$this->data["parent_location"] = $parent_location;

		$this->load->view("setup_location",$this->data);

	}

	

	//****************************************** SETUP COUNTRY SECTION *****************************************************//

	public function setup_country(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->data['country_list'] = $this->Generaldb->setup_country();

		$this->load->view('setup_country',$this->data);

	}

	public function setup_country_add()

	{	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		if($this->input->post("country_name1"))

		{	

		

			$res = $this->Generaldb->add_setup_country();	

			

			$this->data["success_msg"] = $res;	

			$this->setup_country();			

		}

		else

		{			

			$this->load->view('setup_country_add');

		}

	}

	public function setup_country_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_country');

		}else {

		$result = $this->Generaldb->select_setup_country(array("country_id"=>$id));

		foreach($result as $k=>$countryObj){		

			$this->data["countryObj"] = $countryObj;

		}$this->load->view('setup_country_edit',$this->data);	

		}

	}	

	public function setup_country_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}			



			$id= $this->input->post('country_id');

			$data = array(

			'country_id' => $this->input->post('country_id'),

			'country_name' => $this->input->post('country_name')			

			);

			$result = $this->Generaldb->update_setup_country($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_country();		

	}

	//Setup COuntry delete sec

	public function delete_setup_country($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_country(array("country_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_country();

	}

	

	//****************************************** SETUP CURRENCY SECTION *****************************************************//

	public function setup_currency(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->data['currency_list'] = $this->Generaldb->setup_currency();

		$this->load->view('setup_currency',$this->data);

	}

	public function setup_currency_add()

	{	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		if($this->input->post("currency_name"))

		{	

			$data = array(

				'currency_name' => $this->input->post('currency_name'),

				'currency_code' => $this->input->post('currency_code'),

				'currency_symbol' => $this->input->post('currency_symbol')

				);

			$res = $this->Generaldb->add_setup_currency($data);	

			

			$this->data["success_msg"] = $res;	

			$this->setup_currency();			

		}

		else

		{			

			$this->load->view('setup_currency_add');

		}

	}

	public function setup_currency_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_currency');

		}else {

		$result = $this->Generaldb->select_setup_currency(array("currency_id"=>$id));

		foreach($result as $k=>$currencyObj){		

			$this->data["currencyObj"] = $currencyObj;

		}$this->load->view('setup_currency_edit',$this->data);	

		}

	}	

	public function setup_currency_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}			



			$id= $this->input->post('currency_id');

			$data = array(

			'currency_id' => $this->input->post('currency_id'),

			'currency_name' => $this->input->post('currency_name'),

			'currency_code' => $this->input->post('currency_code'),

			'currency_symbol' => $this->input->post('currency_symbol')			

			);

			$result = $this->Generaldb->update_setup_currency($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_currency();		

	}

	//Setup COuntry delete sec

	public function delete_setup_currency($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_currency(array("currency_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_currency();

	}

	

	//****************************************** SETUP DAY NAME SECTION *****************************************************//

	public function setup_dayname(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->data['dayname_list'] = $this->Generaldb->setup_dayname();

		$this->load->view('setup_dayname',$this->data);

	}

	public function setup_dayname_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_dayname');

		}else {

		$result = $this->Generaldb->select_setup_dayname(array("day_id"=>$id));

		foreach($result as $k=>$daynameObj){		

			$this->data["daynameObj"] = $daynameObj;

		}$this->load->view('setup_dayname_edit',$this->data);	

		}

	}	

	public function setup_dayname_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}			



			$id= $this->input->post('day_id');

			$data = array(

			'day_name_1' => $this->input->post('day_name_1'),

			'day_short_1' => $this->input->post('day_short_1')			

			);

			$result = $this->Generaldb->update_setup_dayname($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_dayname();		

	}

	

	//****************************************** SETUP MONTH NAME SECTION *****************************************************//

	public function setup_monthname(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->data['monthname_list'] = $this->Generaldb->setup_monthname();

		$this->load->view('setup_monthname',$this->data);

	}

	public function setup_monthname_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_monthname');

		}else {

		$result = $this->Generaldb->select_setup_monthname(array("month_id"=>$id));

		foreach($result as $k=>$monthnameObj){		

			$this->data["monthnameObj"] = $monthnameObj;

		}$this->load->view('setup_monthname_edit',$this->data);	

		}

	}	

	public function setup_monthname_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}			



			$id= $this->input->post('month_id');

			$data = array(

			'month_name_1' => $this->input->post('month_name_1'),

			'month_short_1' => $this->input->post('month_short_1')			

			);

			$result = $this->Generaldb->update_setup_monthname($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_monthname();		

	}

	

	//****************************************** SETUP TITLE SECTION *****************************************************//

	public function setup_title(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->data['title_list'] = $this->Generaldb->setup_title();

		$this->load->view('setup_title',$this->data);

	}

	public function setup_title_add(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		if($this->input->post("title_name_1_1"))

		{

			$res = $this->Generaldb->add_setup_title();	

			

			$this->data["success_msg"] = $res;	

			$this->setup_title();			

		}

		else

		{			

			$this->load->view('setup_title_add');

		}



	}

	public function setup_title_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_title');

		}else {

		$result = $this->Generaldb->select_setup_title(array("title_id"=>$id));

		foreach($result as $k=>$titleObj){		

			$this->data["titleObj"] = $titleObj;

		}$this->load->view('setup_title_edit',$this->data);	

		}

	}	

	public function setup_title_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}			

			$id= $this->input->post('title_id');

			$data = array(

			'title_name_1' => $this->input->post('title_name_1'),

			);

			$result = $this->Generaldb->update_setup_title($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_title();		

	}

	//Setup COuntry delete sec

	public function delete_setup_title($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_title(array("title_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_title();

	}

	

	//****************************************** SETUP RANGE YEAR SECTION *****************************************************//

	public function setup_rangeyear(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->data['rangeyear_list'] = $this->Generaldb->setup_rangeyear();

		$this->load->view('setup_rangeyear',$this->data);

	}

	public function setup_rangeyear_add(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		if($this->input->post("rangeyear_value"))

		{

			$data = array(

				'rangeyear_name_1'=>$this->input->post("rangeyear_value"),

				'rangeyear_name_2'=>$this->input->post("rangeyear_value"),

				'rangeyear_name_3'=>$this->input->post("rangeyear_value"),

				'rangeyear_name_4'=>$this->input->post("rangeyear_value"),

				'rangeyear_name_5'=>$this->input->post("rangeyear_value"),

				'rangeyear_name_6'=>$this->input->post("rangeyear_value"),

				'rangeyear_name_7'=>$this->input->post("rangeyear_value"),

				'rangeyear_name_8'=>$this->input->post("rangeyear_value"),

				'rangeyear_name_9'=>$this->input->post("rangeyear_value"),

				'rangeyear_name_10'=>$this->input->post("rangeyear_value"),

				'rangeyear_value'=>$this->input->post("rangeyear_value")

			);

			$res = $this->Generaldb->add_setup_rangeyear($data);	

			

			$this->data["success_msg"] = $res;	

			$this->setup_rangeyear();			

		}

		else

		{			

			$this->load->view('setup_rangeyear_add');

		}



	}

	public function setup_rangeyear_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_rangeyear');

		}else {

		$result = $this->Generaldb->select_setup_rangeyear(array("rangeyear_id"=>$id));

		foreach($result as $k=>$rangeyearObj){		

			$this->data["rangeyearObj"] = $rangeyearObj;

		}$this->load->view('setup_rangeyear_edit',$this->data);	

		}

	}	

	public function setup_rangeyear_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}			

			$id= $this->input->post('rangeyear_id');

			$data = array(

			'rangeyear_value' => $this->input->post('rangeyear_value')

			);

			$result = $this->Generaldb->update_setup_rangeyear($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_rangeyear();		

	}

	//Setup COuntry delete sec

	public function delete_setup_rangeyear($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_rangeyear(array("rangeyear_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_rangeyear();

	}

	

	//****************************************** SETUP RADIUS SECTION *****************************************************//

	public function setup_radius(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->data['radius_list'] = $this->Generaldb->setup_radius();

		$this->load->view('setup_radius',$this->data);

	}

	public function setup_radius_add(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		if($this->input->post("radius_value"))

		{

			$data = array(

				'radius_name_1'=>$this->input->post("radius_name_1"),

				'radius_value'=>$this->input->post("radius_value")

			);

			$res = $this->Generaldb->add_setup_radius($data);	

			

			$this->data["success_msg"] = $res;	

			$this->setup_radius();			

		}

		else

		{			

			$this->load->view('setup_radius_add');

		}



	}

	public function setup_radius_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_radius');

		}else {

		$result = $this->Generaldb->select_setup_radius(array("radius_id"=>$id));

		foreach($result as $k=>$radiusObj){		

			$this->data["radiusObj"] = $radiusObj;

		}$this->load->view('setup_radius_edit',$this->data);	

		}

	}	

	public function setup_radius_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}			

			$id= $this->input->post('radius_id');

			$data = array(

			'radius_name_1' => $this->input->post('radius_name_1'),

			'radius_value' => $this->input->post('radius_value')

			);

			$result = $this->Generaldb->update_setup_radius($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_radius();		

	}

	//Setup COuntry delete sec

	public function delete_setup_radius($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_radius(array("radius_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_radius();

	}

	

	//****************************************** SETUP OPEN STATUS SECTION *****************************************************//

	public function setup_openstatus(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->data['openstatus_list'] = $this->Generaldb->setup_openstatus();

		$this->load->view('setup_openstatus',$this->data);

	}

	public function setup_openstatus_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_openstatus');

		}else {

		$result = $this->Generaldb->select_setup_openstatus(array("openstatus_id"=>$id));

		foreach($result as $k=>$openstatusObj){		

			$this->data["openstatusObj"] = $openstatusObj;

		}$this->load->view('setup_openstatus_edit',$this->data);	

		}

	}	

	public function setup_openstatus_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}	

				

			$id= $this->input->post('openstatus_id');

			$data = array(

			'openstatus_name_1' => $this->input->post('openstatus_name_1')

			);

			$result = $this->Generaldb->update_setup_openstatus($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_openstatus();		

	}

	

	//****************************************** SETUP OPEN HOUR SECTION *****************************************************//

	public function setup_openhour(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->data['openhour_list'] = $this->Generaldb->setup_openhour();

		$this->load->view('setup_openhour',$this->data);

	}

	public function setup_openhour_add(){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		if($this->input->post("openhour_name_1_1"))

		{

			

			$res = $this->Generaldb->add_setup_openhour();	

			

			$this->data["success_msg"] = $res;	

			$this->setup_openhour();			

		}

		else

		{			

			$this->load->view('setup_openhour_add');

		}



	}

	public function setup_openhour_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_openhour');

		}else {

		$result = $this->Generaldb->select_setup_openhour(array("openhour_id"=>$id));

		foreach($result as $k=>$openhourObj){		

			$this->data["openhourObj"] = $openhourObj;

		}$this->load->view('setup_openhour_edit',$this->data);	

		}

	}

	public function setup_openhour_update(){	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}	

				

			$id= $this->input->post('openhour_id');

			$data = array(

			'openhour_name_1' => $this->input->post('openhour_name_1')

			);

			$result = $this->Generaldb->update_setup_openhour($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_openhour();		

	}



	public function delete_setup_openhour($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_openhour(array("openhour_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_openhour();

	}

	//****************************************** SETUP CATEGORY LISTING SECTION *****************************************************//

	public function setup_category_listing($category_parent=0){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		$this->data = $this->Generaldb->setup_category_listing($category_parent);

		if(!empty($msg)){

		$this->data["success_msg"] = $msg;

		}

		$this->data["category_parent"] = $category_parent;

		$this->load->view('setup_category_listing',$this->data);

	}

	public function setup_category_listing_add(){
		
		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}			

		if($this->input->post("category_name_1"))
		{ 

			$data = array(

				'category_name_1' => $this->input->post("category_name_1"),
				
				'category_parent' => $this->input->post("sector_name"),

				'category_url_1' => $this->input->post("category_url_1"),

				'category_desc_1' => $this->input->post("category_desc_1")

			);		

			$res = $this->Generaldb->add_setup_category_listing($data);			

			$this->data["success_msg"] = $res;	

			$this->setup_category_listing();			

		}

		else
		{			
			
			$this->load->view('setup_category_listing_add');

		}
	}	

	

	public function setup_category_listing_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}		

		if ($id == null) {

		  $this->load->view('setup_category_listing');

		}else {

		$result = $this->Generaldb->select_setup_category_listing(array("category_id"=>$id));

		foreach($result as $k=>$category_listingObj){		

			$this->data["category_listingObj"] = $category_listingObj;

		}$this->load->view('setup_category_listing_edit',$this->data);	

		}

	}

	

	public function setup_category_listing_update(){

				//check weather user logged in or not

			if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}	

				

			$id= $this->input->post('category_id');

			$data = array(

			'category_name_1' => $this->input->post('category_name_1'),
			
			'category_parent' => $this->input->post("sector_name"),

			'category_url_1' => $this->input->post('category_url_1'),

			'category_desc_1' => $this->input->post('category_desc_1')			

			);

			$result = $this->Generaldb->update_setup_category_listing($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_category_listing();	

	}

	

	public function delete_setup_category_listing($id=0){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_category_listing(array("category_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_category_listing();

	}

	public function setup_category_listing_delete_icon($id=0){		

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$this->Generaldb->setup_category_listing_delete_icon($id);

		$result = $this->Generaldb->select_setup_category_listing(array("category_id"=>$id));

		foreach($result as $k=>$category_listingObj){		

			$this->data["category_listingObj"] = $category_listingObj;

		}$this->load->view('setup_category_listing_edit',$this->data);					

	}

	

	

	//General paginatation

	public function	category_listing_nxt_page($category_parent=0,$currentPage=0)
	{
		

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$currentPage++;



		$data = $this->Generaldb->setup_category_listing($category_parent,$currentPage,10);

		$this->data["category_listing_list"]= $data["category_listing_list"];

		if(empty($data["pagination"])){

			$this->data["pagination"] = array("startpage"=>0,"pages"=>0);			

		}else{

		$this->data["pagination"] = $data["pagination"];

		}

		$this->data["side_menu"] = array("4"=>"active","sub"=>"active");

		$this->data["category_parent"] = $category_parent;		

		$this->load->view("setup_category_listing",$this->data);

	}

	public function	category_listing_pre_page($category_parent=0,$currentPage=0)

	{	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$currentPage--;

		$data = $this->Generaldb->setup_category_listing($category_parent,$currentPage,10);

		

		$this->data["category_listing_list"]= $data["category_listing_list"];

		if(empty($data["pagination"])){

			$this->data["pagination"] = array("startpage"=>0,"pages"=>0);

		}else{

		$this->data["pagination"] = $data["pagination"];

		}

		

		//$this->data["side_menu"] = array("4"=>"active","sub"=>"active");

		$this->data["category_parent"] = $category_parent;

		$this->load->view("setup_category_listing",$this->data);

	}

	//****************************************** SETUP SECTOR LISTING SECTION *****************************************************//

	public function setup_sector_listing($sector_parent=0){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

			

		$this->data = $this->Generaldb->setup_sector_listing($sector_parent);

		if(!empty($msg)){

		$this->data["success_msg"] = $msg;

		}

		$this->data["sector_parent"] = $sector_parent;

		$this->load->view('setup_sector_listing',$this->data);

	}

	public function setup_sector_listing_add($sector_parent=""){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		if($this->input->post("sector_name_1"))

		{	

			$data = array(

				'category_name_1' => $this->input->post("sector_name_1"),

				'category_parent' => 0,

				'category_url_1' => $this->input->post("sector_url_1"),

				'category_desc_1' => $this->input->post("sector_desc_1")

			);		

			$res = $this->Generaldb->add_setup_sector_listing($data);			

			$this->data["success_msg"] = $res;

			$this->setup_sector_listing(0,$sector_parent);			

		}

		else

		{

			$this->data["category_parent"] = $sector_parent;			

			$this->load->view('setup_sector_listing_add',$this->data);

		}

	}	

	

	public function setup_sector_listing_edit($id=null){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if ($id == null) {

		  $this->load->view('setup_sector_listing');

		}else {

		$result = $this->Generaldb->select_setup_sector_listing(array("category_id"=>$id));

		foreach($result as $k=>$sector_listingObj){		

			$this->data["category_listingObj"] = $sector_listingObj;

		}$this->load->view('setup_sector_listing_edit',$this->data);	

		}

	}	

	public function setup_sector_listing_update(){

				//check weather user logged in or not

			if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}	

				

			$id= $this->input->post('sector_id');

			$data = array(

			'category_name_1' => $this->input->post('sector_name_1'),

			'category_url_1' => $this->input->post('sector_url_1'),

			'category_desc_1' => $this->input->post('sector_desc_1')			

			);

			$result = $this->Generaldb->update_setup_sector_listing($id,$data);

			$this->data["success_msg"] = $result;

			$this->setup_sector_listing();	

	}

	public function delete_setup_sector_listing($id=0){

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$result = $this->Generaldb->delete_setup_sector_listing(array("sector_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->setup_sector_listing();

	}

	public function setup_sector_listing_delete_icon($id=0){

			

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

				

		$this->Generaldb->setup_sector_listing_delete_icon($id);

		$result = $this->Generaldb->select_setup_sector_listing(array("sector_id"=>$id));

		foreach($result as $k=>$sector_listingObj){		

			$this->data["sector_listingObj"] = $sector_listingObj;

		}$this->load->view('setup_sector_listing_edit',$this->data);					

	}	

	//General paginatation

	public function	sector_listing_nxt_page($sector_parent=0,$currentPage=0)
	{		
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$currentPage++;
		$data = $this->Generaldb->setup_sector_listing($sector_parent,$currentPage,10);
		$this->data["sector_listing_list"]= $data["sector_listing_list"];

		if(empty($data["pagination"])){

			$this->data["pagination"] = array("startpage"=>0,"pages"=>0);			

		}else{

		$this->data["pagination"] = $data["pagination"];

		}

		$this->data["side_menu"] = array("4"=>"active","sub"=>"active");

		$this->data["sector_parent"] = $sector_parent;		

		$this->load->view("setup_sector_listing",$this->data);

	}

	public function	sector_listing_pre_page($sector_parent=0,$currentPage=0)

	{	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$currentPage--;

		$data = $this->Generaldb->setup_sector_listing($sector_parent,$currentPage,10);

		

		$this->data["sector_listing_list"]= $data["sector_listing_list"];

		if(empty($data["pagination"])){

			$this->data["pagination"] = array("startpage"=>0,"pages"=>0);

		}else{

		$this->data["pagination"] = $data["pagination"];

		}

		

		//$this->data["side_menu"] = array("4"=>"active","sub"=>"active");

		$this->data["sector_parent"] = $sector_parent;

		$this->load->view("setup_sector_listing",$this->data);

	}
	
}

