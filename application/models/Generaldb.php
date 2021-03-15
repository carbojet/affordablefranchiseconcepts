<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Generaldb extends CI_Model {



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

	 * map to /index.php/welcome/delete_all_category<method_name>

	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct()
     {
	          parent::__construct();

     }

	

	//********************************* SETUP DISCOUNT SECTION *****************************************************//

	public function setup_discount()

	{	

		try

		{	

			return $this->db->get("setup_discount")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}	

	public function select_setup_discount($data){

		return $this->db->get_where("setup_discount",$data)->result();

	}

	public function update_setup_discount($id,$data){

		try{

			$this->db->where('discount_id', $id);

			$this->db->update('setup_discount', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function add_setup_discount($data){

		try{

			$this->db->insert('setup_discount', $data);			

			throw new Exception("New Discount Code has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function delete_setup_discount($data)

	{

		try

		{

			if($this->db->get_where("setup_discount",$data)->num_rows()>0)

			{

				$this->db->delete("setup_discount",$data);				

				throw new Exception("One Discount Code has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP LOCATION SECTION *****************************************************//

	public function setup_location($location_parent=0,$startpage=0,$limit=5){

		try

		{	

				$rec = ceil($this->db->get_where('setup_location', array('location_parent' => $location_parent))->num_rows()/$limit);

				

				$lTo = $limit;

				

				if($startpage<1){$startpage=1;}

				if($startpage>$rec){$startpage = $rec;}

				if($startpage>1){$lFrom = ($startpage-1)*$limit;}

				else{$lFrom = 0;} 				



				$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);

				$data["location_list"] = $this->db->order_by("location_name","asc")->limit($lTo,$lFrom)->get_where('setup_location', array('location_parent' => $location_parent))->result();

				return $data;

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	public function setup_listings_count($location_parent=0){

		try

		{	

			return $this->db->select("*")->from('listing')->where("listing_location_path like ","-".$location_parent."-%")->get()->num_rows();

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	public function select_setup_location($data){

		return $this->db->get_where("setup_location",$data)->result();

	}

	public function delete_all_location()
	{
		$this->db->truncate('setup_location');
	}
	
	public function setup_location_reset()
	{
		$this->db->truncate('setup_location');
		$result = $this->db->get("default_setup_location")->result();
		foreach($result as $obj)
		{
			$this->db->insert("setup_location",array("location_id"=>$obj->location_id,"location_parent"=>$obj->location_parent,"location_path"=>$obj->location_path,"location_name"=>$obj->location_name,"location_zipcode"=>$obj->location_zipcode,"location_lastupdate"=>date("Y-m-d H:i:s")));
		}				
	}
	
	public function delete_all_category()
	{
		$this->db->truncate('setup_category_listing');
	}
	
	public function setup_category_reset()
	{
		$this->db->truncate('setup_category_listing');
		$result = $this->db->get("default_setup_category_listing")->result();
		foreach($result as $obj)
		{
			$this->db->insert("setup_category_listing",array("category_id"=>$obj->category_id,"category_parent"=>$obj->category_parent,"category_path"=>$obj->category_path,"category_path"=>$obj->category_path,"category_name_1"=>$obj->category_name_1,"category_desc_1"=>$obj->category_desc_1,"category_url_1"=>$obj->category_url_1,"category_stat_listing"=>$obj->category_stat_listing,"category_image"=>$obj->category_image,"category_lastupdate"=>date("Y-m-d H:i:s")));
		}				
	}
	
	public function add_setup_location(){

		try{

			$parent_location = $this->input->post("location_parent");

			for($i=1;$i<=10;$i++){

				$val = $this->input->post("location_name".$i);

				if(!empty($val)){	
					$result = $this->db->select_max('location_id')->get('setup_location')->result();
					var_dump($result);
					
					$data = array('location_name' => $val,'location_parent' => $parent_location);
					$this->db->insert('setup_location',$data);
					$insert_id = $this->db->insert_id();				

					$detail = $this->db->get_where('setup_location',array('location_id'=>$parent_location))->result();

					foreach($detail as $k=>$obj){echo $current_location_path = $obj->location_path;}

					$location_path = $current_location_path.$insert_id."-";

										

					$this->db->where('location_id', $insert_id );

					$this->db->update('setup_location',array("location_path"=>$location_path));				

					

				}

			}			

			throw new Exception("New Location has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	public function update_setup_location($id,$data){

		try{

			$this->db->where('location_id', $id);

			$this->db->update('setup_location', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	public function delete_setup_location($data)

	{



		try

		{	

			if($this->db->get_where("setup_location",$data)->num_rows()>0)

			{				

				$this->db->delete("setup_location",$data);				

				throw new Exception("One Location has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP COUNTRY SECTION *****************************************************//

	public function setup_country()

	{	

		try

		{	

			return $this->db->order_by("country_order","asc")->get("setup_country")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function select_setup_country($data){

		return $this->db->get_where("setup_country",$data)->result();

	}

	public function add_setup_country(){

		try{

			

			for($i=1;$i<=10;$i++){

				$val = $this->input->post("country_name".$i);

				$country_order = 1000;

				if(!empty($val)){	

					$data = array(

						'country_name' => $val,

						'country_order' => $country_order					

					);			

					$this->db->insert('setup_country',$data);

				}

			}			

			throw new Exception("New Country has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}	

	public function update_setup_country($id,$data){

		try{

			$this->db->where('country_id', $id);

			$this->db->update('setup_country', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}	

	public function delete_setup_country($data)

	{



		try

		{	

			if($this->db->get_where("setup_country",$data)->num_rows()>0)

			{				

				$this->db->delete("setup_country",$data);				

				throw new Exception("One Country has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP CURRENCY SECTION *****************************************************//

	public function setup_currency()

	{	

		try

		{	

			return $this->db->order_by("currency_name","asc")->get("setup_currency")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function select_setup_currency($data){

		return $this->db->get_where("setup_currency",$data)->result();

	}

	public function add_setup_currency($data){

		try{

		

				$this->db->insert('setup_currency',$data);				

				throw new Exception("New Currency has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}	

	public function update_setup_currency($id,$data){

		try{

			$this->db->where('currency_id', $id);

			$this->db->update('setup_currency', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}	

	public function delete_setup_currency($data)

	{



		try

		{	

			if($this->db->get_where("setup_currency",$data)->num_rows()>0)

			{				

				$this->db->delete("setup_currency",$data);				

				throw new Exception("One Currency has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP DAY NAME SECTION *****************************************************//

	public function setup_dayname()

	{	

		try

		{	

			return $this->db->order_by("day_order","asc")->get("setup_dayname")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function select_setup_dayname($data){

		return $this->db->get_where("setup_dayname",$data)->result();

	}

	public function update_setup_dayname($id,$data){

		try{

			$this->db->where('day_id', $id);

			$this->db->update('setup_dayname', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP MONTH NAME SECTION *****************************************************//

	public function setup_monthname()

	{	

		try

		{	

			return $this->db->order_by("month_order","asc")->get("setup_monthname")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function select_setup_monthname($data){

		return $this->db->get_where("setup_monthname",$data)->result();

	}	

	public function update_setup_monthname($id,$data){

		try{

			$this->db->where('month_id', $id);

			$this->db->update('setup_monthname', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP TITLE SECTION *****************************************************//

	public function setup_title()

	{	

		try

		{	

			return $this->db->get("setup_title")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function add_setup_title(){

		try{

			

			for($i=1;$i<=10;$i++){

				$val = $this->input->post("title_name_".$i."_1");

				if(!empty($val)){	

					$data = array(

					'title_name_1' => $val

					);		

					$this->db->insert('setup_title',$data);

				}

			}			

			throw new Exception("New Personal Title has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}	

	public function select_setup_title($data){

		return $this->db->get_where("setup_title",$data)->result();

	}

	public function update_setup_title($id,$data){

		try{

			$this->db->where('title_id', $id);

			$this->db->update('setup_title', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function delete_setup_title($data)

	{



		try

		{	

			if($this->db->get_where("setup_title",$data)->num_rows()>0)

			{				

				$this->db->delete("setup_title",$data);				

				throw new Exception("One Title has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP RANGE YEAR SECTION *****************************************************//

	public function setup_rangeyear()

	{	

		try

		{	

			return $this->db->order_by("rangeyear_value","desc")->get("setup_rangeyear")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function add_setup_rangeyear($data){

		try{

				$this->db->insert('setup_rangeyear',$data);

				throw new Exception("New Year Range has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}	

	public function select_setup_rangeyear($data){

		return $this->db->get_where("setup_rangeyear",$data)->result();

	}

	public function update_setup_rangeyear($id,$data){

		try{

			$this->db->where('rangeyear_id', $id);

			$this->db->update('setup_rangeyear', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function delete_setup_rangeyear($data)

	{



		try

		{	

			if($this->db->get_where("setup_rangeyear",$data)->num_rows()>0)

			{				

				$this->db->delete("setup_rangeyear",$data);				

				throw new Exception("One Year Range has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP RADIUS SECTION *****************************************************//

	public function setup_radius()

	{	

		try

		{	

			return $this->db->order_by("radius_value","asc")->get("setup_radius")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function add_setup_radius($data){

		try{

				$this->db->insert('setup_radius',$data);

				throw new Exception("New Distance Radius has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}	

	public function select_setup_radius($data){

		return $this->db->get_where("setup_radius",$data)->result();

	}

	public function update_setup_radius($id,$data){

		try{

			$this->db->where('radius_id', $id);

			$this->db->update('setup_radius', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function delete_setup_radius($data)

	{



		try

		{	

			if($this->db->get_where("setup_radius",$data)->num_rows()>0)

			{				

				$this->db->delete("setup_radius",$data);				

				throw new Exception("One Distance Radius has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP OPEN STATUS SECTION *****************************************************//

	public function setup_openstatus()

	{	

		try

		{	

			return $this->db->get("setup_openstatus")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function select_setup_openstatus($data){

		return $this->db->get_where("setup_openstatus",$data)->result();

	}

	

	

	//********************************* SETUP OPEN HOUR SECTION *****************************************************//

	public function setup_openhour()

	{	

		try

		{	

			return $this->db->get("setup_openhour")->result();				

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function add_setup_openhour(){

		try{

			

			for($i=1;$i<=10;$i++){

				$val = $this->input->post("openhour_name_".$i."_1");

				

				if(!empty($val)){	

					$data = array(

						'openhour_name_1' => $val								

					);			

					$this->db->insert('setup_openhour',$data);					

					$insert_id = $this->db->insert_id();

					

					$this->db->where('openhour_id', $insert_id );

					$this->db->update('setup_openhour',array("openhour_order"=>$insert_id));				

					

				}

			}			

			throw new Exception("New Open Hour has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function select_setup_openhour($data){

		return $this->db->get_where("setup_openhour",$data)->result();

	}

	public function update_setup_openhour($id,$data){

		try{

			$this->db->where('openhour_id', $id);

			$this->db->update('setup_openhour', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function delete_setup_openhour($data)

	{



		try

		{	

			if($this->db->get_where("setup_openhour",$data)->num_rows()>0)

			{				

				$this->db->delete("setup_openhour",$data);				

				throw new Exception("One Open Hour has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	

	//********************************* SETUP SECTOR LISTING SECTION *****************************************************//

	public function setup_sector_listing($sector_parent=0,$startpage=0,$limit=10)

	{	

		try

		{	

			$rec = ceil($this->db->get_where('setup_category_listing', array('category_parent'=>0))->num_rows()/$limit);

			$lTo = $limit;			

			

			if($startpage<1){$startpage=1;}

			if($startpage>$rec){$startpage = $rec;}

			if($startpage>1){$lFrom = ($startpage-1)*$limit;}

			else{$lFrom = 0;} 
			

			$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);

			$data["sector_listing_list"] = $this->db->order_by("category_name_1")->limit($lTo,$lFrom)->get_where('setup_category_listing', array('category_parent' => 0))->result();

		}
		catch(Exception $e)
		{
			$data["error"] =  $e->getMessage();
		}
		return $data;

	}

	public function select_setup_sector_listing($data){

		return $this->db->get_where("setup_category_listing",$data)->result();

	}



	

	public function setup_listings_sector_count($parent_category=0){

		try

		{	

			return $this->db->select("*")->from('listing_category')->where("category_value",$parent_category)->get()->num_rows();

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

		

	public function add_setup_sector_listing($data){

		try{
			
			$result = $this->db->select_max('category_id')->get('setup_category_listing')->result();
			if(count($result > 0)){
			
			foreach($result as $obj){
				$insert_id = $obj->category_id + 1;
			}
			}else{
				$insert_id = 1;
			}
			
			$data['category_id'] = $insert_id;
			
			$img_name = str_replace(" ","-",$data['category_name_1']);
			
			$data['category_image'] = $img_name.".jpg";
			
			$this->db->insert('setup_category_listing',$data);
			
			
			
			//$this->new_sector_listing_photo_upload($insert_id);	
			
			//$photo_data = array("photo_listing"=>$data["id"],"photo_caption_1"=>$this->input->post("photo_caption_1"),"photo_status"=>"approved","photo_status_main"=>"main","photo_lastupdate"=>date("Y-m-d H:i:s"));

			//$this->db->insert("listing_photo",$photo_data);
			$this->new_sector_photo_upload($img_name,"photo_file_1");				

			throw new Exception("New Sector Listing has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}
	
	//UPLOADING IMAGES FOR SECTORS
	private function new_sector_photo_upload($file_name,$tag_name)

	{
		
		$this->load->library('image_lib');

		$config['upload_path'] = "./sector_photo/";

		$config['allowed_types'] = 'jpg|jpeg';

		$config['max_size']	= '12400'; //in km = 10mb

		$config['file_name'] = $file_name;

		

		$this->load->library('upload', $config);



		if (!$this->upload->do_upload($tag_name))

		{

			return $data["error"] = $this->upload->display_errors();		

		}

		else

		{
			$image_data = $this->upload->data();

			//for big

			//$new_image_path = explode("photo_big/",$image_data["file_path"])[0]."photo_medium/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $image_data["full_path"];

			$img_cfg['maintain_ratio'] = FALSE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $image_data["full_path"];

			$img_cfg['width'] = 600;			

			$img_cfg['height'] = 500;

			$img_cfg['quality'] = "100%";

			$img_cfg['x_axis'] = '0';

			$img_cfg['y_axis'] = '0';			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();		

		}		

	}

	public function update_setup_sector_listing($id,$data){

		try{	
			$img_name = str_replace(" ","-",$data['category_name_1']);		
			//$id = $this->input->post('sector_id');
			if(!empty($_FILES["photo_file_1"]["name"])){
					@unlink("./sector_photo/".$img_name.".jpg");
			}

			$this->db->where('category_id', $id);

			$this->db->update('setup_category_listing', $data);	
			
			if(!empty($_FILES["photo_file_1"]["name"])){
				$this->new_sector_photo_upload($img_name,"photo_file_1");
			}

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function delete_setup_sector_listing($data)

	{



		try

		{	

			if($this->db->get_where("setup_category_listing",$data)->num_rows()>0)

			{	

				//@unlink("./sector_listing_cache/".$data["sector_id"].".jpg");
//
//				@unlink("./sector_listing_cache_small/".$data["sector_id"].".jpg");					

				$this->db->delete("setup_category_listing",$data);			

				throw new Exception("One Sector Listing has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function setup_sector_listing_delete_icon($id){

		try{			

				//@unlink("./sector_listing_cache/".$id.".jpg");
//
//				@unlink("./sector_listing_cache_small/".$id.".jpg");				

				return $this->db->get_where("setup_category_listing",$id)->result();

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	//image upload with creating thumb

 	private function new_sector_listing_photo_upload($file_name)

	 {

	  $this->load->library('image_lib');

	  $config['upload_path'] = "./sector_listing_cache/";

	  $config['allowed_types'] = 'jpg|jpeg';

	  $config['max_size'] = '1000';

	  $config['file_name'] = $file_name;

	  

	  $this->load->library('upload', $config);

	

	  if (!$this->upload->do_upload("sector_icon"))

	  {

//	   return $this->data["error"] = $this->upload->display_errors();  

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

	   $img_cfg['width'] = 280;

	   //$img_cfg['quality'] = 100;

	   $img_cfg['height'] = 250;   

	   $this->image_lib->initialize($img_cfg);

	   $this->image_lib->resize();

	   //for medium

	   $temp_var =  explode("sector_listing_cache/",$image_data["file_path"]);

	   $new_image_path = $temp_var[0]."sector_listing_cache_small/".$file_name.".jpg";

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
	
	// Select Sector
	public function	sector_list()
	{
		return $this->db->order_by('category_name_1','ASC')->get_where('setup_category_listing', array('category_parent' => 0))->result();		
	}

	//********************************* SETUP CATEGORY LISTING SECTION *****************************************************//

	public function setup_category_listing($category_parent=0,$startpage=0,$limit=10)

	{	

		try

		{	
			$rec = ceil($this->db->where('category_parent >',0)->get('setup_category_listing')->num_rows()/$limit);

			$lTo = $limit;			

			

			if($startpage<1){$startpage=1;}

			if($startpage>$rec){$startpage = $rec;}

			if($startpage>1){$lFrom = ($startpage-1)*$limit;}

			else{$lFrom = 0;} 

			

			$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);

				$data["category_listing_list"] = $this->db->where('category_parent >',0)->order_by("category_name_1")->limit($lTo,$lFrom)->get('setup_category_listing')->result();

			return $data;				


		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function select_setup_category_listing($data){

		return $this->db->get_where("setup_category_listing",$data)->result();

	}



	

	public function setup_listings_category_count($parent_category=0){

		try

		{	

			return $this->db->select("*")->from('listing_category')->where("category_value",$parent_category)->get()->num_rows();

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}	

	public function add_setup_category_listing($data){

		try{

			$this->db->insert('setup_category_listing',$data);

			//$insert_id = $this->db->insert_id();				

			//$this->new_category_listing_photo_upload($insert_id);			

			throw new Exception("New Category Listing has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	//Listing Sector Active and Deactive
	 
	public function ajaxCategory_stat($val,$category_id){
		try
		{

			$this->db->where('category_id', $category_id);

			$this->db->update('setup_category_listing',array("category_stat_listing"=>$val));	

			throw new Exception("Status Changed!");	

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}	 	
	}
	
	//Setup Location Active and Deactive
	 
	public function ajaxLocation_stat($val,$location_id){
		try
		{

			$this->db->where('location_id', $location_id);

			$this->db->update('setup_location',array("location_stat"=>$val));	

			throw new Exception("Status Changed!");	

		}	

		catch(Exception $e)

		{

			return $e->getMessage();

		}	 	
	}

	public function update_setup_category_listing($id,$data){

		try{			

			//if(!empty($_FILES["category_icon"]["name"])){			
//
//				@unlink("./category_listing_cache/".$id.".jpg");
//
//				@unlink("./category_listing_cache_small/".$id.".jpg");
//
//				$this->new_category_listing_photo_upload($id);	
//
//			}

			$this->db->where('category_id', $id);

			$this->db->update('setup_category_listing', $data);	

			throw new Exception("One record has been Updated...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function delete_setup_category_listing($data)

	{



		try

		{	

			if($this->db->get_where("setup_category_listing",$data)->num_rows()>0)

			{	

				@unlink("./category_listing_cache/".$data["category_id"].".jpg");

				@unlink("./category_listing_cache_small/".$data["category_id"].".jpg");					

				$this->db->delete("setup_category_listing",$data);				

				throw new Exception("One Category Listing has been Deleted sucessfully...");

			}

			else

			{

				throw new Exception("Record not found to delete...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function setup_category_listing_delete_icon($id){

		try{			

				@unlink("./category_listing_cache/".$id.".jpg");

				@unlink("./category_listing_cache_small/".$id.".jpg");				

				return $this->db->get_where("setup_category_listing",$id)->result();

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}
	
    
	//image upload with creating thumb

 	private function new_category_listing_photo_upload($file_name)

	 {

	  $this->load->library('image_lib');

	  $config['upload_path'] = "./category_listing_cache/";

	  $config['allowed_types'] = 'jpg|jpeg';

	  $config['max_size'] = '1000';

	  $config['file_name'] = $file_name;

	  

	  $this->load->library('upload', $config);

	

	  if (!$this->upload->do_upload("category_icon"))

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

	   $img_cfg['width'] = 280;

	   //$img_cfg['quality'] = 100;

	   $img_cfg['height'] = 250;   

	   $this->image_lib->initialize($img_cfg);

	   $this->image_lib->resize();

	   //for medium

	   $temp_var =  explode("category_listing_cache/",$image_data["file_path"]);

	   $new_image_path = $temp_var[0]."category_listing_cache_small/".$file_name.".jpg";

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



}

