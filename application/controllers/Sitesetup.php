<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Sitesetup extends CI_Controller {



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
	  $this->load->model("Sitesetupdb");
	}	
	//default load seller page		

	public function index()
	{
		$this->load->view("dashboard");	
	}
	public function mail_templates()
	{
		$this->data["mail_template_list"] = $this->Sitesetupdb->mail_templates();
		$this->load->view("email_template",$this->data);
	}
	public function update_all_mail_templates()
	{
		if($this->input->post("email_id"))
		{
			$this->data["success_msg"] = $this->Sitesetupdb->update_all_mail_templates();
		}
		$this->mail_templates();
	}
	public function email_template_edit($email_id=0)
	{
		if($email_id>0)
		{
			$this->data["mail_templateObj"] = $this->Sitesetupdb->email_template_edit($email_id);
			$this->load->view("mail_template_edit",$this->data);

		}

		else

		{

			$this->mail_templates();

		}		

	}

	public function update_email_template()

	{

		if($this->input->post("email_id"))

		{

			$this->data["success_msg"] = $this->Sitesetupdb->update_email_template();

		}

		$this->mail_templates();

	}	

	public function payment_preferences()

	{

		$this->data["payment_preference_list"] = $this->Sitesetupdb->payment_preferences();

		$this->load->view("payment_preference",$this->data);

	}

	public function update_all_payment_preference()

	{

		if($this->input->post("payment_id"))

		{

			$this->data["success_msg"] = $this->Sitesetupdb->update_all_payment_preference();

		}

		$this->payment_preferences();

	}

	public function payment_2co_edit($payment_id=0)

	{

		if($payment_id>0)

		{

			$this->data["paymnet_preferenceObj"] = $this->Sitesetupdb->payment_preference_edit($payment_id);

			$this->load->view("payment_2co_edit",$this->data);

		}

		else

		{

			$this->payment_preferences();

		}		

	}

	public function payment_paypal_edit($payment_id=0)

	{

		if($payment_id>0)

		{

			$this->data["paymnet_preferenceObj"] = $this->Sitesetupdb->payment_preference_edit($payment_id);

			$this->load->view("payment_paypal_edit",$this->data);

		}

		else

		{

			$this->payment_preferences();

		}		

	}

	public function update_payment_preference()

	{

		if($this->input->post("payment_id"))

		{

			$data = array(

				"payment_link"=>$this->input->post("payment_link"),

				"payment_mode"=>$this->input->post("payment_mode")

			);

			$this->data["success_msg"] = $this->Sitesetupdb->update_payment_preference($data);

		}

		$this->payment_preferences();

	}
	
	// ################################################# IMPORT / EXPORT ##################################################
	
	private function upload_csvfile($file_name,$tag_name)
	{
		
		$this->load->library('image_lib');

		$config['upload_path'] = "./import_export/";

		$config['allowed_types'] = '*';

		$config['max_size']	= '100000'; //in kb (100mb)

		$config['file_name'] = $file_name;
		
		$this->load->library('upload', $config);

		
		if (!$this->upload->do_upload($tag_name))
		{
			$this->data["upload_error"] = $this->upload->display_errors();
			return false;
		}
		else
		{
			$this->data["upload_image_data"] = $this->upload->data();
			
			if($this->data["upload_image_data"]["file_ext"]==".csv")
			{return true;}else{return false;}				
		}
	}
	public function import_export()
	{
		//read csv file
		//load the csv library
		//$upload_type = $this->input->post("upload_type");
		
		$import_section = $this->input->post("import_section");
		if($this->input->post("import"))
		{			
			if($import_section=="listing"){$file_name = "listing";}
			if($import_section=="sectors"){$file_name = "sectors";}
			if($import_section=="location"){$file_name = "locations";}
			@unlink('./import_export/'.$file_name.'.csv');
			
			//ini_set('memory_limit', '128M');
			
			if(!empty($_FILES["photo_file_1"]["name"]))
			{
				$upload_result = $this->upload_csvfile($file_name,"photo_file_1");
				
				
				if($upload_result)
				{
				$file = './import_export/'.$file_name.'.csv';  
				$this->load->library('getcsv');
				$result = $this->getcsv->parse_file($file);
				//$this->load->library('parsecsv');
//				$this->parsecsv->encoding('UTF-16', 'UTF-8');
//				$this->parsecsv->delimiter = "\t";
//				$this->parsecsv->auto($file);
//				$result = $this->parsecsv->data;
				//print_r($result);
//				exit;
				
				$result = $this->Sitesetupdb->import_export($result,"import",$import_section);
				
				$this->data["success"] = "Import completed...";
				$this->data["result"] = $result;
				$this->load->view("import_export",$this->data);	
				}
				else
				{
					$this->load->view("import_export",$this->data);
				}			
			}
			else
			{
				//form validation false				
				$this->data["validation_errors"] = "No File found to upload...";
				$this->load->view("import_export");
			}
		}
		elseif($this->input->post("export"))
		{	
			@unlink('./import_export/listing.csv');
			@unlink('./import_export/sectors.csv');
			@unlink('./import_export/locations.csv');
			@unlink('./import_export/visitors.csv');
			//ini_set('memory_limit', '500M');
			ini_set('memory_limit', '1024M');
			$result = $this->Sitesetupdb->import_export(array(),"export",$import_section);
		
			$this->load->library('parsecsv');
			if($import_section=="listing"){$file_name = "listing.csv";}
			if($import_section=="sectors"){$file_name = "sectors.csv";}
			if($import_section=="location"){$file_name = "locations.csv";}
			if($import_section=="visitors"){$file_name = "visitors.csv";}			
			touch('./import_export/'.$file_name);
			
			foreach($result as $rows)
			{
				set_time_limit(0);				
				$this->parsecsv->save('./import_export/'.$file_name,array($rows),true);
			}
			$this->load->view("import_export",array("export"=>true,"file_name"=>$file_name));
		}
		else
		{	 		
			$this->load->view("import_export");	  
		}
	}
}