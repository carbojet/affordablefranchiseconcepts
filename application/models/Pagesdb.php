
<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Pagesdb extends CI_Model {



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

	public function temp_fun()
	{}	

public function listing_location_path($path){

$path = explode("-",$path);
$result1 = $this->db->get_where("setup_location",array("location_parent"=>0,"location_id"=>$path[1]))->result();
foreach($result1 as $obj){ $country = $obj->location_name;}

$result2 = $this->db->get_where("setup_location",array("location_id"=>$path[2]))->result();
foreach($result2 as $obj){ $state = $obj->location_name;}

$result3 = $this->db->get_where("setup_location",array("location_id"=>$path[3]))->result();
foreach($result3 as $obj){ $city = $obj->location_name;}

return "$city, $state, $country";


}


	public function listing_list($startpage,$limit)
	{
		try
		{
			if($this->db->get("listing")->num_rows()>0)
			{
				$rec = ceil($this->db->get("listing")->num_rows()/$limit);				

				$lTo = $limit;				

				//if($startpage<1){$startpage=1;}

				if($startpage>$rec){$startpage = $rec;}

				if($startpage>1){$lFrom = ($startpage-1)*$limit;}

				else{$lFrom = 0;}				

				$query = $this->db->select("*")->from("listing")->join('seller', 'seller.seller_id = listing.listing_seller')->join("setup_location","setup_location.location_id = seller.seller_country")->order_by('listing_id', 'desc')->limit($lTo,$lFrom);				
				
				$data["listing_list"] = $this->db->get()->result();
				
				

				$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);

				

			}

			else

			{
				$data["listing_list"] = array();
				$data["pagination"] = array("startpage"=>0,"pages"=>0);
				throw new Exception("No record found...");

			}

		}

		catch(Exception $e)

		{

			$data['msg']= $e->getMessage();

		}		return $data;

	}

	public function listing_management($data,$startpage,$limit)

	{

		try

		{			

			$query = $this->db->select("*")->from("listing")->where("listing_seller",$data["listing_seller"]);			

			$rec = ceil($this->db->get()->num_rows()/$limit);

			//re using query for fetching records

			$query = $this->db->select("*")->from("listing")->where("listing_seller",$data["listing_seller"]);			

			$query = $query->join('seller', 'listing.listing_seller = seller.seller_id')->join('setup_country', 'seller.seller_country = setup_country.country_id');			

			$query = $query->order_by("listing_id",'desc');			

			$lTo = $limit;			

			if($startpage<1){$startpage=1;}

			if($startpage>$rec){$startpage = $rec;}

			if($startpage>1){$lFrom = ($startpage-1)*$limit;}

			else{$lFrom = 0;} 			

			$query->limit($lTo,$lFrom);	

			$data["listing_list"] = $this->db->get()->result();		

			

			$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);

			return $data;

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}		

	}

	public function get_listing_search_result($data,$startpage=0,$limit=100)
	{
		try
		{		
			//$this->db->select('*');
//			$this->db->from('listing');
//			$this->db->join("seller","listing.listing_seller=seller.seller_id");
			
			$where ="";
			if(!empty($data["listing_id"]))
			{
				if(!empty($where)){$where .=' and ';}
				$where .= "listing.listing_id='".$data["listing_id"]."'";
				
				//$this->db->where("listing.listing_id",$data["listing_id"]);
			}
			
			if(!empty($data["listing_status_keywords"]))
			{
				if(!empty($where)){$where .=' and ';}
				$where .= "listing.listing_status_keywords like '%".$data["listing_status_keywords"]." %'";
				
				//$this->db->like("listing.listing_status_keywords",$data["listing_id"],'both');
			}

			if(!empty($data["listing_sector"])){
				//$listing_sector = "-".$data["listing_sector"]."-";
				if(!empty($where)){$where .=' and ';}
				$where .= "listing.listing_category_path like '%-".$data["listing_sector"]."-%'";
				
				//$this->db->like("listing.listing_category_path",$data["listing_sector"],'both');			
				if(!empty($data["listing_category"])){
					
					if(!empty($where)){$where .=' and ';}
					$where .= "listing.listing_category_path like '%-".$data["listing_category"]."-%'";
					
					//$this->db->like("listing.listing_category_path",$data["listing_category_1"],'both');				
					
				}
			}
			
			
			
			if(!empty($data["listing_location_path"])){if(!empty($where)){$where .=' and ';}
			
				foreach($data["listing_location_path"] as $k=>$listing_location_path){
				
					if($k>0){$where .=' or ';}					
					$where .= "listing.listing_location_path like '".$listing_location_path."%'";
					
					//$this->db->or_like("listing.listing_location_path",$listing_location_path,'right');
				}
			
			}
			
			if(!empty($data["listing_zip"]))
			{
				if(!empty($where)){$where .=' and ';}
				$where .= "listing.listing_zip='".$data["listing_zip"]."'";
				//$this->db->where("listing.listing_zip",$data["listing_zip"]);
			}
			
			if(!empty($data["s_status"]))
			{
				if(!empty($where)){$where .=' and ';}
				$where .= "listing.listing_status='".$data["s_status"]."'";
				//$this->db->where("listing.listing_status",$data["s_status"]);
			}
			
			if(!empty($data["s_featured"]))
			{
				if(!empty($where)){$where .=' and ';}
				$where .= "listing.listing_status_feature='".$data["s_featured"]."'";
				//$this->db->where("listing.listing_status_feature",$data["s_featured"]);
			}
			
			if(!empty($data["listing_status_new"]))
			{
				if(!empty($where)){$where .=' and ';}
				$where .= "listing.listing_status_new='".$data["listing_status_new"]."'";
				//$this->db->where("listing.listing_status_new",$data["listing_status_new"]);
			}
			
			if(!empty($data["listing_seller_id"]))
			{
			
				if(!empty($where)){$where .=' and ';}
				$where .= "seller.seller_username like '".$data["listing_seller_id"]."%'";
				//$this->db->like("seller.seller_username",$data["listing_status_new"],'right');
			}
			
			if(!empty($data["visit_status"])){
				if($data["visit_status"]=="any")
				{
					if(!empty($where)){$where .=' and ';}
					$where .= "listing.listing_visited >='0'";
				}
				if($data["visit_status"]=="visited")
				{
					if(!empty($where)){$where .=' and ';}
					$where .= "listing.listing_visited >'0'";
				}
				if($data["visit_status"]=="not_visited")
				{
					if(!empty($where)){$where .=' and ';}
					$where .= "listing.listing_visited <='0'";
				}
			}
			if(!empty($where)){$where .=' and ';}
			$where .= "seller.seller_id=listing.listing_seller";	
			
			
			$order_by ="";
			switch($data["s_order"])
			{				
				case "listing_id asc":
					$order_by = " order by listing.listing_id asc";
					
				break;
				case "listing_visited asc":
					$order_by = " order by listing.listing_visited asc";
					
				break;
				case "listing_visited desc":
					$order_by = " order by listing.listing_visited desc";
					
				break;
				default:
					$order_by = " order by listing.listing_id desc";
					
				break;
			}
			
			
			//,(select count(*) from visitor_comment where visitor_comment.comment_linkid=listing.listing_id) as 'visitor_status'
			
			$rec = ceil($this->db->query("select * from listing,seller where ".$where.$order_by)->num_rows()/$limit);			
			
			//$rec = ceil($this->db->get()->num_rows()/$limit);
			
			$lTo = $limit;

			if($startpage<1){$startpage=1;}

			if($startpage>$rec){$startpage = $rec;}

			if($startpage>1){$lFrom = ($startpage-1)*$limit;}

			else{$lFrom = 0;} 				
				
			$data["startpage"] = $startpage;
			$data["post_data"] = $data;
			
			//echo "select * from listing,seller where ".$where.$order_by." limit $lFrom,$lTo";

			$data["listing_list"] = $this->db->query("select * from listing,seller where ".$where.$order_by." limit $lFrom,$lTo")->result();
			
			//$this->db->select('*');
//			$this->db->from('listing');
//			$this->db->join("seller","listing.listing_seller=seller.seller_id");
//			if(!empty($data["listing_id"]))
//			{				
//				$this->db->where("listing.listing_id",$data["listing_id"]);
//			}
//			
//			if(!empty($data["listing_status_keywords"]))
//			{				
//				$this->db->like("listing.listing_status_keywords",$data["listing_id"],'both');
//			}
//
//			if(!empty($data["listing_sector"])){				
//				$this->db->like("listing.listing_category_path",$data["listing_sector"],'both');			
//				if(!empty($data["listing_category_1"])){					
//					$this->db->like("listing.listing_category_path",$data["listing_category_1"],'both');					
//				}
//			}
//			
//			
//			
//			if(!empty($data["listing_location_path"])){		
//				foreach($data["listing_location_path"] as $k=>$listing_location_path){					
//					$this->db->or_like("listing.listing_location_path",$listing_location_path,'right');
//				}
//			}
//			
//			if(!empty($data["listing_zip"]))
//			{
//				$this->db->where("listing.listing_zip",$data["listing_zip"]);
//			}
//			
//			if(!empty($data["s_status"]))
//			{
//				$this->db->where("listing.listing_status",$data["s_status"]);
//			}
//			
//			if(!empty($data["s_featured"]))
//			{
//				$this->db->where("listing.listing_status_feature",$data["s_featured"]);
//			}
//			
//			if(!empty($data["listing_status_new"]))
//			{
//				$this->db->where("listing.listing_status_new",$data["listing_status_new"]);
//			}
//			
//			if(!empty($data["listing_seller_id"]))
//			{
//				$this->db->like("seller.seller_username",$data["listing_status_new"],'right');
//			}
//
//			switch($data["s_order"])
//			{				
//				case "expire":
//					$this->db->order_by('listing.listing_expire',"desc");
//				break;
//				case "status":
//					$this->db->order_by('listing.listing_status',"asc");
//				break;
//				case "seller":
//					$this->db->order_by('listing.seller_firstname',"asc");
//				break;
//				default:
//					$this->db->order_by('listing.listing_id',"desc");
//				break;
//			}
//						
//			//$this->db->limit($lFrom,$lTo);
//			$data["listing_list"] = $this->db->limit($lTo,$lFrom)->get()->result();
//			echo $this->db->last_query();

			$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);

			return $data;
		}

		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}

	//get review of listing

	public function get_review_list($count=false,$listing_id=0)

	{

		if($count)

		{

			return $this->db->get_where("visitor_comment",array("comment_type"=>"listing","comment_linkid"=>$listing_id))->num_rows();

		}

		else

		{

			return $this->db->select("*")->from("visitor_comment")->where(array("comment_type"=>"listing","comment_linkid"=>$listing_id))->join('visitor', 'visitor_comment.comment_visitor = visitor.visitor_id')->get()->result();

			//return $this->db->join('visitor', 'visitor_comment.comment_visitor = visitor.visitor_id')->get_where("visitor_comment",)->result();

		}

	}

	//get review of listing

	public function get_review_detail($comment_id=0)

	{

		$detail =  $this->db->select("*")->from("visitor_comment")->where(array("comment_id"=>$comment_id))->join('visitor', 'visitor_comment.comment_visitor = visitor.visitor_id')->get()->result();

		foreach($detail as $k=>$obj){return $obj;}

	}
	
	public function get_comment_list($listing_id)
	{
		return $this->db->get_where("visitor_comment",array("comment_linkid"=>$listing_id))->result();
	}
	public function update_review()

	{

		try

		{

			$data =array(

				"comment_rating"=>$this->input->post("comment_rating"),

				"comment_ipaddress"=>$this->input->post("comment_ipaddress"),

				"comment_title"=>$this->input->post("comment_title"),

				"comment_description"=>$this->input->post("comment_description")

			);

			$this->db->where("comment_id",$this->input->post("comment_id"));

			$this->db->update("visitor_comment",$data);

			throw new Exception("One record has Updated...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	//get visitor 

	public function get_visitor($visitor_id=0)

	{

		$detail = $this->db->get_where("visitor",array("visitor_id"=>$visitor_id))->result();

		foreach($detail as $k=>$obj){return $obj;}

	}

	//delete review

	public function delete_review($data)

	{

		try

		{

			if($this->db->get_where("visitor_comment",$data)->num_rows()>0)

			{

				$this->db->delete("visitor_comment",$data);

				throw new Exception("One record has Deleted...");

			}

			else

			{

				throw new Exception("Record Not Found...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function search_visitors($data,$startpage,$limit)

	{

		try

		{

			$query = $this->db->select("*")->from("visitor");			

			if(!empty($data["visitor_username"])){$query = $query->like("visitor_username",$data["visitor_username"]);}	

			if(!empty($data["visitor_firstname"])){$query = $query->like("visitor_firstname",$data["visitor_firstname"]);}			

			if(!empty($data["visitor_lastname"])){$query = $query->like("visitor_lastname",$data["visitor_lastname"]);}

			

			$rec = ceil($this->db->get()->num_rows()/$limit);

			//re using query for fetching records

			$query = $this->db->select("*")->from("visitor");			

			if(!empty($data["visitor_username"])){$query = $query->like("visitor_username",$data["visitor_username"]);}	

			if(!empty($data["visitor_firstname"])){$query = $query->like("visitor_firstname",$data["visitor_firstname"]);}			

			if(!empty($data["visitor_lastname"])){$query = $query->like("visitor_lastname",$data["visitor_lastname"]);}

			

			$query = $query->order_by("visitor_id",'desc');

			

			$lTo = $limit;

			

			if($startpage<1){$startpage=1;}

			if($startpage>$rec){$startpage = $rec;}

			if($startpage>1){$lFrom = ($startpage-1)*$limit;}

			else{$lFrom = 0;} 				

			

			$query->limit($lTo,$lFrom);				



			$data["visitor_list"] = $this->db->get()->result();

			$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);

			

			throw new Exception("Records Found...");

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;		

	}

	public function nadd_new_review()

	{

		try

		{

			$data = array(

				"comment_linkid"=>$this->input->post("comment_linkid"),

				"comment_visitor"=>$this->input->post("comment_visitor"),

				"comment_rating"=>$this->input->post("comment_rating"),

				"comment_ipaddress"=>$this->input->post("comment_ipaddress"),

				"comment_title"=>$this->input->post("comment_title"),

				"comment_description"=>$this->input->post("comment_description"),

				"comment_type"=>"listing",

				"comment_language"=>$this->input->post("comment_language"),

				"comment_lastupdate"=>date("Y-m-d H:i:s"),

				"comment_status"=>"approved"

			);

			$this->db->insert("visitor_comment",$data);

			throw new Exception("One Review Added...");

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

	}

	//get active country list

	public function get_active_country()

	{

		return $this->db->get_where("setup_location",array("location_parent"=>0))->result();

	}

	//get location list

	public function get_location_list($data)

	{
		return $this->db->where($data)->order_by("location_name","ASC")->get("setup_location")->result();		
		//return $this->db->get_where("setup_location",$data)->order_by("location_name","ASC")->result();

	}
	
	

	public function get_openstatus()

	{

		return $this->db->get("setup_openstatus")->result();

	}

	//get open status list

	public function get_openhour()

	{

		return $this->db->get("setup_openhour")->result();

	}

	//get Insured list

	public function get_insured_list()

	{

		return $this->db->get("setup_dropdown1")->result();

	}

	//get Prime category

	public function get_prime_category($data)

	{

		$detail = $this->db->get_where("setup_category_listing",$data)->result();

		foreach($detail as $k=>$obj){return $obj;}

	}

	//get Bonded list

	public function get_bonded_list()

	{

		return $this->db->get("setup_dropdown2")->result();

	}

	//get related listing comment rating

	public function get_listing_rating($data)

	{

		$detail = $this->db->select("*")->select_max('comment_rating')->where("comment_linkid",$data["listing_id"])->limit(0,1)->get("visitor_comment")->result();

		foreach($detail as $k=>$obj){ return $obj;}

	}

	//get related listing single main photo by default view

	public function get_listing_main_photo($data)

	{		

		$detail = $this->db->select("*")->where(array("photo_listing"=>$data["listing_id"],"photo_status_main"=>$data["photo_status_main"]))->get("listing_photo")->result();

		foreach($detail as $k=>$obj){ return $obj;}

	}

	public function get_listing_package($data)

	{

		$detail = $this->db->select("*")->where(array("package_listing_id"=>$data["listing_package"]))->get("setup_package_listing")->result();

		foreach($detail as $k=>$obj){ return $obj;}

	}

	public function get_seller_package($data)

	{

		$detail = $this->db->select("*")->where(array("package_subscription_id"=>$data["seller_package"]))->get("setup_package_subscription")->result();

		foreach($detail as $k=>$obj){ return $obj;}

	}

	//get related listing visited status

	public function get_listing_visited($data)

	{

		$counter=0;

		$detail = $this->db->get_where("listing_stat",$data)->result();

		foreach($detail as $k=>$obj){$counter += $obj->stat_total;}

		return $counter;

	}
	public function get_listing_mailed($data)
	{
		return $this->db->get_where("visitor_comment",$data)->result();
	}

	//listing statistics

	public function listing_statistics($data)
	{
		return $this->db->get_where("listing_stat",$data)->result();				
	}

	//get related listing Favourited status

	public function get_listing_favourited($data)

	{

		return $this->db->get_where("visitor_favourite",$data)->result();

	}

	public function select_listing($data)

	{

		try

		{

			if($this->db->get_where("listing",$data)->num_rows()>0)

			{

				$this->db->select("*")->from("listing")->where($data)->join('seller', 'listing.listing_seller = seller.seller_id');

				return $this->db->get()->result();

			}

			else

			{

				throw new Exception("No record found...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}	

	}

	public function update_listing($data)
	{
		try
		{	
			if($this->db->get_where("listing",array("listing_id"=>$this->input->post("listing_id")))->num_rows()>0)
			{
				$this->db->where('photo_listing', $this->input->post("listing_id"));
				$res = $this->db->get("listing_photo")->result();
				
				foreach($res as $obj){
					$photoobj = $obj;				
				}
				
				if(!empty($_FILES["photo_file_1"]["name"])){
					@unlink("./photo_big/".$this->input->post("listing_image"));
					@unlink("./photo_medium/".$this->input->post("listing_image"));
					@unlink("./photo_small/".$this->input->post("listing_image"));
				}
				$this->db->where('listing_id', $this->input->post("listing_id"));
				
				$this->db->update('listing', $data);
				
				//$this->db->where('category_listing',$this->input->post("listing_id"))->delete("listing_category");
//				$category_list_array = $this->input->post("listing_category");
//				foreach($category_list_array as $category_id){
//				
//					$this->db->insert("listing_category",array("category_listing"=>$this->input->post("listing_id"),"category_value"=>$category_id,"category_path"=>"-$category_id-","category_status"=>"approved"));
//				}				
			
			if(!empty($_FILES["photo_file_1"]["name"])){
				$photo_name = explode(".",$this->input->post("listing_image"));
				$this->new_listing_photo_upload($photo_name[0],"photo_file_1");
			}
				throw new Exception("One record has Updated...");

			}

			else

			{

				throw new Exception("No record found to Update...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}
	public function add_new_listing($data,$catg)
	{
		try

		{
			
			$this->db->insert("seller",array("seller_username"=>$this->input->post("listing_seller"),"seller_country"=>$this->input->post("listing_location_1"),"seller_status"=>"approved","seller_status_feature"=>"featured","seller_status_email"=>"approved","seller_status_approval"=>"on"));
			$data['listing_seller'] =  $this->db->insert_id();
			$this->db->insert("listing",$data);
			$data["id"] = $this->db->insert_id();
				$listing_category_array = $this->input->post("listing_category");
				$temp_array = $listing_category_array;
				foreach($listing_category_array as $k=>$val){
					$this->db->insert("listing_category",array("category_listing"=>$data["id"],"category_value"=>$val,"category_path"=>"-".$val."-","category_status"=>"approved"));
				}
			

			
			//$photo_data = array("photo_listing"=>$data["id"],"photo_caption_1"=>$this->input->post("photo_caption_1"),"photo_status"=>"approved","photo_status_main"=>"main","photo_lastupdate"=>date("Y-m-d H:i:s"));

			//$this->db->insert("listing_photo",$photo_data);
			//$this->new_listing_photo_upload($this->db->insert_id(),"photo_file_1");
			//for($i=1;$i<=$catg;$i++)
//
//			{
//
//				$this->db->insert("listing_categort",$catg);
//
//			}



			throw new Exception("New user has been added sucessfully...");		

		}

		catch(Exception $e)

		{

			$data["msg"] = $e->getMessage();

		}

		return $data;		

	}
	public function add_listing_wp($title)
	{
		$slogan = str_replace(" ","-",$title);
		$this->db->insert("wp_posts",array("post_author"=>1,"post_data"=>date("Y-m-d H:s:i"),"post_content"=>"[]"));
	}
	public function feature($data)

	{

		try

		{

			if($this->db->get_where("listing",array("listing_id"=>$data["listing_id"]))->num_rows()>0)

			{

				$this->db->where('listing_id', $data["listing_id"]);		

				$this->db->update('listing', array("listing_status_feature"=>$data["listing_status_feature"],"listing_lastupdate"=>date("Y-m-d H:i:s")));

				throw new Exception("Listing feature list updated...");

			}

			else

			{

				throw new Exception("Listing feature record not found...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}
	
	
	public function status_new($data)

	{

		try

		{

			if($this->db->get_where("listing",array("listing_id"=>$data["listing_id"]))->num_rows()>0)

			{

				$this->db->where('listing_id', $data["listing_id"]);		

				$this->db->update('listing', array("listing_status_new"=>$data["listing_status_new"],"listing_lastupdate"=>date("Y-m-d H:i:s")));

				throw new Exception("Listing new list updated...");

			}

			else

			{

				throw new Exception("Listing new record not found...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function auto_approve($data)

	{

		try

		{

			if($this->db->get_where("listing",array("_id"=>$data["listing_id"]))->num_rows()>0)

			{

				$this->db->where('listing_id', $data["listing_id"]);		

				$this->db->update('listing', array("listing_status_approval"=>$data["listing_status_approval"]));

				throw new Exception("Listing Approve list updated...");

			}

			else

			{

				throw new Exception("Seller Approve record not found...");

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}
	
	public function delete_all_listing(){		

		try

		{
			$this->db->truncate('seller');
			$this->db->truncate('listing_category');
			$this->db->truncate('listing');
			throw new Exception("Successfully Deleted!");
		}

		catch(Exception $e)
		{

			return $e->getMessage();

		}
	
	}

	public function delete_listing($data)

	{

		try

		{

			if($this->db->get_where("listing",$data)->num_rows()>0)

			{

				$this->db->delete("listing",$data);

				//@unlink("./logo_cache/".$data["seller_id"].".jpg");

				$this->db->delete("listing_category",array("category_listing"=>$data["listing_id"]));				
							
				$this->db->delete("seller",array("seller_id"=>$data["listing_id"]));	
				
				throw new Exception("One Listing has been Deleted sucessfully...");

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

	//add category into listing

	public function add_listing_category()

	{

		try

		{
			$data = array("category_listing"=>$this->input->post("category_listing"),"category_value"=>$this->input->post("listing_category_1"),"category_path"=>"-".$this->input->post("listing_category_1")."-","category_status"=>"approved");			
				
			
			$this->db->insert("listing_category",$data);

			$detail = $this->db->get_where("listing_category",array("category_listing"=>$this->input->post("category_listing")))->result();

			$listing_category_path = "-";

			foreach($detail as $k=>$obj)

			{

				$listing_category_path .= $obj->category_value."-, ";

			}

			$this->db->where("listing_id",$this->input->post("category_listing"))->update("listing",array("listing_category_path"=>$listing_category_path));

			throw new Exception("New category added into listing # ".$this->input->post("category_listing"));

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}	

	}
	
	// Select Sector
	public function	sector_list()
	{
		return $this->db->order_by('category_name_1','ASC')->get_where('setup_category_listing', array('category_parent' => 0))->result();		
	}
	
	//Select Sector through Category Id
	public function category_sector($data){
		return $this->db->get_where('setup_category_listing',array('category_id' => $data))->result();
	}
	

	//delete gategory from listing

	public function delete_listing_category($category_id=0,$listing_id=0)

	{

		try

		{

			$detail = $this->db->select("setup_category_listing.category_id")->from("listing_category")->where(array("listing_category.category_id"=>$category_id))->join("setup_category_listing","listing_category.category_value=setup_category_listing.category_id")->get()->result();

			if(count($detail)>0)

			{

				foreach($detail as $k=>$obj){$setup_category_id=$obj->category_id;}

				$listing_detail = $this->db->get_where("listing",array("listing_id"=>$listing_id))->result();

				foreach($listing_detail as $k=>$obj)

				{

					$listing_category_path = str_replace("-".$setup_category_id."-, "," ",$obj->listing_category_path);

					$this->db->where("listing_id",$listing_id);

					$this->db->update("listing",array("listing_category_path"=>$listing_category_path));

				}

				$this->db->delete("listing_category",array("category_id"=>$category_id));	

				throw new Exception("One Category has been removed from selected listing sucessfully...");			

			}

			else

			{

				throw new Exception("No record found...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	//get category listing

	public function get_category_list($id,$level=0)

	{		
		return $this->db->get_where("setup_category_listing",array("category_parent"=>$id))->result();

	}
	
	//get SELECT CITY

	public function get_select_city($id)

	{	
		//return $this->db->where(array("location_parent"=>$id))->order_by("location_name","desc")->get("setup_location")->result();
		return $this->db->query("SELECT * FROM setup_location WHERE location_parent = '$id' ORDER BY location_name ASC")->result();
	}

	//get listing category

	public function get_listing_category($data)
	{

		return $this->db->select("listing_category.category_id,listing_category.category_value,setup_category_listing.category_name_1")->from("listing_category")->where($data)->join("setup_category_listing","listing_category.category_value=setup_category_listing.category_id")->get()->result();
	}
	
	
	// GET SECTOR BASED ON CATEGORY
	public function get_sector_detail($data){
		$result =  $this->db->get_where("setup_category_listing",$data)->result();
		foreach($result as $obj){
			return $obj;
		}
	}

	

	//get listing photo list

	public function listing_photos($data)

	{

		return $this->db->get_where("listing_photo",$data)->result();

	}

	//set photo as main in listing

	public function set_listing_main_photo($photo_id=0,$listing_id=0)

	{

		try

		{

			$this->db->where("photo_listing",$listing_id)->update("listing_photo",array("photo_status_main"=>""));

			$this->db->where("photo_id",$photo_id)->update("listing_photo",array("photo_status_main"=>"main"));

			

			throw new Exception("Photo # ".$photo_id." been set as main photo...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}		

	}

	

	// get listing photo detail to edit

	public function edit_listing_photo($photo_id=0)

	{

		$detail = $this->db->get_where("listing_photo",array("photo_id"=>$photo_id))->result();

		foreach($detail as $obj){return $obj;}

	}

	public function update_listing_photo()

	{

		try

		{

			$this->db->where("photo_id",$this->input->post("photo_id"))->update("listing_photo",array("photo_caption_1"=>$this->input->post("photo_caption_1")));

			throw new Exception("Photo # ".$this->input->post("photo_id")." been updated...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function add_listing_photo()

	{

		try

		{

			$loop = $this->input->post("upload_loop");

			$photo_listing = $this->input->post("photo_listing");

			$temparray = array();

			for($i=$loop;$i<=$this->input->post("upload_limit");$i++)

			{

				if(!empty($_FILES['photo_file_1']["name"]))

				{

					$data = array("photo_listing"=>$photo_listing,"photo_caption_1"=>$this->input->post("photo_caption_1"),"photo_status"=>"approved","photo_lastupdate"=>date("Y-m-d H:i:s"));

					$this->db->insert("listing_photo",$data);

					$temparray[] = $this->db->insert_id();

					$this->new_listing_photo_upload($this->db->insert_id(),"photo_file_1");

				}

			}

			$content="";

			foreach($temparray as $k=>$id){

				$content .=" # $id ";

			}			

			throw new Exception("Photo $content been updated...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function delete_listing_photo($photo_id=0)

	{

		try

		{

			if($this->db->get_where("listing_photo",array("photo_id"=>$photo_id))->num_rows()>0)

			{

				$this->db->delete("listing_photo",array("photo_id"=>$photo_id));

				

				@unlink("./photo_big/".$photo_id.".jpg");

				@unlink("./photo_medium/".$photo_id.".jpg");

				@unlink("./photo_small/".$photo_id.".jpg");

				

				throw new Exception("Photo # ".$photo_id." been deleted...");

				

			}

			else

			{

				throw new Exception("No record found...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	//uploading videos

	private function listing_video_upload($file_name,$tag_name)

	{

		$this->load->library('image_lib');

		$config['upload_path'] = "./video/";

		$config['allowed_types'] = 'mov|swf|wmv';

		$config['max_size']	= '512000';

		$config['file_name'] = $file_name;

		

		$this->load->library('upload', $config);



		if (!$this->upload->do_upload($tag_name))

		{

			$data["error"] = $this->upload->display_errors();			

		}

		else

		{

			$data["image_data"] = $this->upload->data();

		}

		return $data;		

	}

	//uploading video cover photo

	private function listing_video_photo_upload($file_name,$tag_name)

	{

		$this->load->library('image_lib');

		$config['upload_path'] = "./video_big/";

		$config['allowed_types'] = 'jpg|jpeg';

		$config['max_size']	= '5120';

		$config['file_name'] = $file_name;

		

		$this->load->library('upload', $config);



		if (!$this->upload->do_upload($tag_name))

		{

			$data["error"] = $this->upload->display_errors();		

		}

		else

		{

			$data["image_data"] = $this->upload->data();

			//for big

			@unlink("./video_big/".$data["video_id"].".jpg");

			@unlink("./video_small/".$data["video_id"].".jpg");

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $data["image_data"]["full_path"];

			$img_cfg['maintain_ratio'] = TRUE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $data["image_data"]["full_path"];

			$img_cfg['width'] = 480;

			$img_cfg['height'] = 315;			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

			

			//for small

			$temp_var = explode("video_big/",$data["image_data"]["file_path"]);

			$new_image_path = $temp_var[0]."video_small/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $data["image_data"]["full_path"];

			$img_cfg['maintain_ratio'] = TRUE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $new_image_path;

			$img_cfg['width'] = 80;

			$img_cfg['height'] = 80;			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

		}

		return $data;		

	}

	//uploading images for listing

	private function new_listing_photo_upload($file_name,$tag_name)

	{
		
		$this->load->library('image_lib');

		$config['upload_path'] = "./photo_big/";

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

			//for medium

			$temp_var = explode("photo_big/",$image_data["file_path"]);

			$new_image_path = $temp_var[0]."photo_medium/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $image_data["full_path"];

			$img_cfg['maintain_ratio'] = FALSE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $new_image_path;

			$img_cfg['width'] = 280;

			$img_cfg['height'] = 250;

			$img_cfg['quality'] = "100%";

			$img_cfg['x_axis'] = '0';

			$img_cfg['y_axis'] = '0';			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

			//for small

			$temp_var = explode("photo_big/",$image_data["file_path"]);

			$new_image_path = $temp_var[0]."photo_small/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $image_data["full_path"];

			$img_cfg['maintain_ratio'] = FALSE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $new_image_path;

			$img_cfg['width'] = 80;

			$img_cfg['height'] = 80;

			$img_cfg['quality'] = "100%";

			$img_cfg['x_axis'] = '0';

			$img_cfg['y_axis'] = '0';			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

		}		

	}

	//get listing video list

	public function get_listing_video($data)

	{

		return $this->db->select("*")->from("listing_video")->where($data)->get()->result();

	}

	//get listing video list

	public function edit_listing_videos($data)

	{

		$detail = $this->db->select("*")->from("listing_video")->where($data)->get()->result();

		foreach($detail as $k=>$obj)

		{

			return $obj;

		}

	}

	//add listing video from external

	public function add_listing_video_youtube()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;

			if(!empty($_FILES["video_photo"]["name"]))

			{

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				if(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_youtube"=>$this->input->post("video_youtube"),

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				

				$this->db->insert("listing_video",$data_array);

				

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->db->insert_id(),"video_photo");

				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	//add listing video from external

	public function add_listing_video_external()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;

			if(!empty($_FILES["video_photo"]["name"]))

			{

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				if(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_url"=>$this->input->post("video_url"),

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);				

				$this->db->insert("listing_video",$data_array);				

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->db->insert_id(),"video_photo");				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	//add listing video upload

	public function add_listing_video_upload()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;		

			if(!empty($_FILES["video_file"]["name"]) &&!empty($_FILES["video_photo"]["name"]))

			{				

				$allowed_v_types = array('mov','swf','wmv');

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				$xv = explode('.', $_FILES["video_file"]["name"]);

				$xv = $xv[1];

				if(!in_array($xv, $allowed_v_types))

				{

					throw new Exception("Upload Video File (.MOV, .SWF or .WMV files)...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

				elseif($_FILES["video_file"]["size"]>(512000*1024*1024))

				{

					throw new Exception("Upload Video File Size must not exceed 100MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

				elseif(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}				

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video and cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_file"=>$_FILES["video_file"]["name"],

					"video_ext"=>$xv,

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				$this->db->insert("listing_video",$data_array);

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->db->insert_id(),"video_photo");

				$data["upload_video_data"] = $this->listing_video_upload($this->db->insert_id(),"video_file");

				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	

	//add listing video from external

	public function update_listing_video_youtube()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;

			if(!empty($_FILES["video_photo"]["name"]))

			{

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				if(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_youtube"=>$this->input->post("video_youtube"),

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				$this->db->where("video_id",$this->input->post("video_id"));

				$this->db->update("listing_video",$data_array);

				

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->input->post("video_id"),"video_photo");

				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	//add listing video from external

	public function update_listing_video_external()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;

			if(!empty($_FILES["video_photo"]["name"]))

			{

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				if(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_url"=>$this->input->post("video_url"),

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				$this->db->where("video_id",$this->input->post("video_id"));				

				$this->db->update("listing_video",$data_array);				

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->input->post("video_id"),"video_photo");				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	//add listing video upload

	public function update_listing_video_upload()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;		

			if(!empty($_FILES["video_file"]["name"]) &&!empty($_FILES["video_photo"]["name"]))

			{				

				$allowed_v_types = array('mov','swf','wmv');

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				$xv = explode('.', $_FILES["video_file"]["name"]);

				$xv = $xv[1];

				if(!in_array($xv, $allowed_v_types))

				{

					throw new Exception("Upload Video File (.MOV, .SWF or .WMV files)...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

				elseif($_FILES["video_file"]["size"]>(512000*1024*1024))

				{

					throw new Exception("Upload Video File Size must not exceed 100MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

				elseif(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}				

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video and cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_file"=>$_FILES["video_file"]["name"],

					"video_ext"=>$xv,

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				$this->db->insert("listing_video",$data_array);

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->db->insert_id(),"video_photo");

				$data["upload_video_data"] = $this->listing_video_upload($this->db->insert_id(),"video_file");

				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	

	

	//delete listnig videos

	public function delete_listing_video($data)

	{

		try

		{

			if($this->db->get_where("listing_video",array("video_id"=>$data["video_id"]))->num_rows()>0)

			{

				$this->db->delete("listing_video",array("video_id"=>$data["video_id"]));

				@unlink("./video_big/".$data["video_id"].".jpg");

				@unlink("./video_small/".$data["video_id"].".jpg");

				@unlink("./video/".$data["video_id"].".wmv");

				

				throw new Exception("Listing Video #".$data["video_id"]." Been Deleted successfully...");

			}

			else

			{

				throw new Exception("Record Not Found...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	} 

	// get default country listing

	public function get_country_list()

	{

		$this->db->select("*")->from("default_setup_country")->where(array("country_status"=>1))->order_by('country_order', 'asc');

		return $this->db->get()->result();

	}

	//get package detail

	public function get_package_detail($listing_package=0)

	{

		$detail = $this->db->get_where("setup_package_listing",array("package_listing_id"=>$listing_package))->result();

		foreach($detail as $k=>$obj){return $obj;}

	}

	//listing package section

	public function select_listing_package()

	{

		try

		{

			$data["listing_package_result"] = $this->db->get("setup_package_listing")->result();

			return $data;

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	//subscription package section

	public function select_subscription_package()

	{

		try

		{

			$data["subscription_package_result"] = $this->db->get("setup_package_subscription")->result();

			return $data;

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function get_subscription_package($data)

	{

		try

		{

			$subscription_detail = $this->db->get_where("setup_package_subscription",$data)->result();

			foreach($subscription_detail as $k=>$obj){$data["subscriptionObj"] = $obj;}

			return $data;

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function get_opendays()

	{

		return $this->db->select("day_id,day_name_1")->from("setup_dayname")->get()->result();

	}

	public function get_setup_filed_listing()

	{

		return $this->db->get("setup_field_listing")->result();

	}

	public function update_all_setup_field_listing()

	{

		$field_listing_id_list = $this->input->post("field_listing_id");

		$status_list = $this->input->post("field_listing_val");

		foreach($field_listing_id_list as $k=>$field_listing_id)

		{						

			$field_listing_enable = $status_list[$k];

			$this->db->where("field_listing_id",$field_listing_id);

			$this->db->update("setup_field_listing",array("field_listing_enable"=>$field_listing_enable));			

		}

		return "All Field Listing Been Updated...";

	}

	public function update_setup_field_listing()

	{					

		$this->db->where("field_listing_id",$this->input->post("field_listing_id"));

		$this->db->update("setup_field_listing",array("field_listing_name_1"=>$this->input->post("field_listing_name_1")));			

		return "One record Been Updated...";

	}

	public function setup_field_listing_edit($field_listing_id)

	{

		$result = $this->db->get_where("setup_field_listing",array("field_listing_id"=>$field_listing_id))->result();		

		foreach($result as $obj){return $obj;}

	}

        public function get_mail_template($email_id=0)

	{

		if($email_id>0)

		{

			$detail = $this->db->get_where("setup_email",array("email_id"=>$email_id,"email_status"=>"yes"))->result();

			foreach($detail as $obj){return $obj;}

		}

	}

}