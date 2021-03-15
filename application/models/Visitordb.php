<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Visitordb extends CI_Model {



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

	public function visitor_list($startpage,$limit,$data=array())
	{
		try
		{
			if(!empty($data))
			{
				$this->db->where($data);
			}
			$rows = $this->db->get("visitor")->num_rows();
			if($rows>0)
			{
				$rec = ceil($rows/$limit);
				$lTo = $limit;
				if($startpage<1){$startpage=1;}
				if($startpage>$rec){$startpage = $rec;}
				if($startpage>1){$lFrom = ($startpage-1)*$limit;}
				else{$lFrom = 0;}
				
				
				if(!empty($data))
				{
					$this->db->where($data);
				}
				
				$data["visitor_list"] = $this->db->order_by('visitor_id', 'desc')->limit($lTo,$lFrom)->get("visitor")->result();
				
				$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);
				return $data;
			}
			else
			{
				throw new Exception("No record found...");
			}
		}
		catch(Exception $e)
		{
			$data["error"] = $e->getMessage();
			$data["visitor_list"] = array();
			$data["pagination"] = array("startpage"=>1,"pages"=>0);
		}
		return $data;		
	}
	public function get_visitor_reviews($visitor_id=0)
	{
		$result = $this->db->join("listing","visitor_comment.comment_linkid=listing.listing_id")->get_where("visitor_comment",array("comment_visitor"=>$visitor_id))->result();

		if(count($result)<=0){
			$result = $this->db->join("visitor_comment","visitor_comment.comment_visitor=visitor.visitor_id")->join("listing","listing.listing_id=visitor_comment.comment_linkid")->get_where("visitor",array("visitor_username"=>$visitor_id))->result();
		}
		return $result;
	}
	public function visitor_review_edit($comment_id=0)

	{

		$result = $this->db->join("listing","visitor_comment.comment_linkid=listing.listing_id")->get_where("visitor_comment",array("comment_id"=>$comment_id))->result();

		foreach($result as $obj){return $obj;}

	}

	public function add_visitor_review()

	{

		$ip= $this->input->ip_address();

		$this->db->insert("visitor_comment",array("comment_rating"=>$this->input->post("comment_rating"),"comment_title"=>$this->input->post("comment_title"),"comment_description"=>$this->input->post("comment_description"),"comment_linkid"=>$this->input->post("comment_linkid"),"comment_type"=>"listing","comment_visitor"=>$this->input->post("comment_visitor"),"comment_language"=>"1","comment_ipaddress"=>$ip,"comment_lastupdate"=>date("Y-m-d H:i:s"),"comment_status"=>"approve"));

		

		//send a mail			

		//review approved			

		$comment_number = $this->db->insert_id();

		$mail_template = $this->get_mail_template(54);

		$visitorObj = $this->visitor_edit($this->input->post("comment_visitor"));

		

		if(is_object($mail_template))

		{

			$from_email = "info@trustedhomecontractors.com";

			$from_name = "Trusted Home Contractors";

			$to_mail = $visitorObj->visitor_email;

			$visitor_firstname = $visitorObj->visitor_firstname;			

			$visitor_lastname = $visitorObj->visitor_lastname;				

								

			$subject = str_replace("[visitor_firstname]",$visitor_firstname,$mail_template->email_subject_1);

			$subject = str_replace("[visitor_lastname]",$visitor_lastname,$subject);

			$subject = str_replace("[comment_number]",$comment_number,$subject);

		

			$content = str_replace("[visitor_firstname]",$visitor_firstname,$mail_template->email_content_1);

			$content = str_replace("[visitor_lastname]",$visitor_lastname,$content);

			$content = str_replace("[comment_number]",$comment_number,$content);

			$content = str_replace("[comment_title]",$this->input->post("comment_title"),$content);										

			$this->send_mail($from_email,$from_name,$to_mail,$subject,$content);

		}

		

	}

	private function get_mail_template($email_id=0)

	{

		if($email_id>0)

		{

			$detail = $this->db->get_where("setup_email",array("email_id"=>$email_id,"email_status"=>"yes"))->result();

			foreach($detail as $obj){return $obj;}

		}

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

	public function update_visitor_review()

	{

		$this->db->where("comment_id",$this->input->post("comment_id"));

		$this->db->update("visitor_comment",array("comment_rating"=>$this->input->post("comment_rating"),"comment_title"=>$this->input->post("comment_title"),"comment_description"=>$this->input->post("comment_description")));

	}

	public function delete_visitor_review($comment_id=0)

	{

		$this->db->delete("visitor_comment",array("comment_id"=>$comment_id));

	}

	public function get_country_list($country_id=1)

	{

		$this->db->select("*")->from("setup_country")->where(array("country_status"=>$country_id))->order_by('country_order', 'asc');

		return $this->db->get()->result();

	}

	public function get_title_list()

	{

		$this->db->select("*")->from("setup_title");

		return $this->db->get()->result();

	}
	
	public function get_visitor_comment($visitor_id=0)
	{
		return $this->db->join("listing","listing.listing_id=visitor_comment.comment_linkid")->get_where("visitor_comment",array("comment_visitor"=>$visitor_id))->result();
	}
	
	public function visitor_edit($visitor_id=0)

	{

		$result = $this->db->get_where("visitor",array("visitor_id"=>$visitor_id))->result();

		foreach($result as $obj){return $obj;}

	}

	public function update_visitor()

	{

		try

		{

			if($this->db->get_where("visitor",array("visitor_id"=>$this->input->post("visitor_id")))->num_rows()>0)

			{

				$data = array(

				"visitor_password"=>$this->input->post("visitor_password"),

				"visitor_title"=>$this->input->post("visitor_title"),

				"visitor_firstname"=>$this->input->post("visitor_firstname"),

				"visitor_lastname"=>$this->input->post("visitor_lastname"),

				"visitor_phone"=>$this->input->post("visitor_phone"),

				"visitor_mobile"=>$this->input->post("visitor_mobile"),

				"visitor_fax"=>$this->input->post("visitor_fax"),

				"visitor_email"=>$this->input->post("visitor_email"),

				"visitor_website"=>$this->input->post("visitor_website"),

				"visitor_address"=>$this->input->post("visitor_address"),

				"visitor_address2"=>$this->input->post("visitor_address2"),

				"visitor_city"=>$this->input->post("visitor_city"),

				"visitor_province"=>$this->input->post("visitor_province"),

				"visitor_zip"=>$this->input->post("visitor_zip"),

				"visitor_country"=>$this->input->post("visitor_country"),

				"visitor_language"=>$this->input->post("visitor_language"),

				"visitor_status"=>"approved",

				"visitor_status_email"=>"approved",

				"visitor_status_approval"=>"on",

				"visitor_lastupdate"=>date("Y-m-d H:i:s")				

				);

				

				$this->db->where('visitor_id', $this->input->post("visitor_id"));		

				$this->db->update('visitor', $data);

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

	public function add_visitor()

	{

		try

		{

			$data = array(

			"visitor_username"=>$this->input->post("visitor_username"),

			"visitor_password"=>$this->input->post("visitor_password"),

			"visitor_title"=>$this->input->post("visitor_title"),

			"visitor_firstname"=>$this->input->post("visitor_firstname"),

			"visitor_lastname"=>$this->input->post("visitor_lastname"),

			"visitor_phone"=>$this->input->post("visitor_phone"),

			"visitor_mobile"=>$this->input->post("visitor_mobile"),

			"visitor_fax"=>$this->input->post("visitor_fax"),

			"visitor_email"=>$this->input->post("visitor_email"),

			"visitor_website"=>$this->input->post("visitor_website"),

			"visitor_address"=>$this->input->post("visitor_address"),

			"visitor_address2"=>$this->input->post("visitor_address2"),

			"visitor_city"=>$this->input->post("visitor_city"),

			"visitor_province"=>$this->input->post("visitor_province"),

			"visitor_zip"=>$this->input->post("visitor_zip"),

			"visitor_country"=>$this->input->post("visitor_country"),

			"visitor_language"=>$this->input->post("visitor_language"),

			"visitor_status"=>"approved",

			"visitor_status_email"=>"approved",

			"visitor_status_approval"=>"on",

			"visitor_lastupdate"=>date("Y-m-d H:i:s")				

			);

			$this->db->insert('visitor', $data);

			$image_data = $this->do_upload($this->db->insert_id());

				

			throw new Exception("New visitor added...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function visitor_register($data)

	{

		try

		{

			$this->db->insert('visitor', $data);

			//$image_data = $this->do_upload($this->db->insert_id());

				

			throw new Exception("New visitor added...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	//delete visitor

	public function delete_visitor($visitor_id)

	{

		try

		{

			$this->db->delete("visitor",array("visitor_id"=>$visitor_id));

			$this->db->delete("visitor_comment",array("comment_visitor"=>$visitor_id));

			@unlink("./visitor_cache/".$visitor_id.".jpg");

			throw new Exception("One visitor detail deleted...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	//auto approval change

	public function auto_approval($visitor_id=0,$status="off")

	{

		try

		{

			$this->db->where("visitor_id",$visitor_id);

			$this->db->update("visitor",array("visitor_status_approval"=>$status));

			throw new Exception("Visitor # $visitor_id auto approval status changed...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

    public function visitor_favourite($visitor_username)

	{

		return $this->db->join("visitor_favourite","visitor_favourite.favourite_visitor=visitor.visitor_id")->join("listing","listing.listing_id=visitor_favourite.favourite_listing")->get_where("visitor",array("visitor_username"=>$visitor_username))->result();

	}

	public function add_visitor_favourite($data)

	{

		$detail = $this->db->get_where("visitor",array("visitor_username"=>$data["visitor_username"]))->result();

		foreach($detail as $obj)

		{

			$counter = $this->db->get_where("visitor_favourite",array("favourite_visitor"=>$obj->visitor_id,"favourite_listing"=>$data["listing_id"]))->num_rows();

			if($counter<=0)

			{

				$this->db->insert("visitor_favourite",array("favourite_visitor"=>$obj->visitor_id,"favourite_listing"=>$data["listing_id"],"favourite_date"=>date("Y-m-d H:i:s")));

			}

		}

	}

	//get related listing comment rating

	public function get_listing_rating($data)

	{

		$detail = $this->db->select("*")->select_max('comment_rating')->where("comment_linkid",$data["listing_id"])->limit(0,1)->get("visitor_comment")->result();

		foreach($detail as $k=>$obj){ return $obj;}

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

    public function get_visitor_edit($visitor_username=0)

	{

		$result = $this->db->get_where("visitor",array("visitor_username"=>$visitor_username))->result();

		foreach($result as $obj){return $obj;}

	}

	public function visitor_email_verification($visitor_id,$status)

	{

		if($visitor_id>0)

		{

			$this->db->where("visitor_id",$visitor_id);

			$this->db->update("visitor",array("visitor_status_email"=>$status));

		}

	}

	//get related listing single main photo by default view

	public function get_listing_main_photo($data)

	{

		$detail = $this->db->select("*")->where(array("photo_listing"=>$data["listing_id"],"photo_status_main"=>$data["photo_status_main"]))->get("listing_photo")->result();

		foreach($detail as $k=>$obj){ return $obj;}

	}

	public function delete_visitor_favourite($id=0)

	{		

		$this->db->delete("visitor_favourite",array("favourite_id"=>$id));

	}

}