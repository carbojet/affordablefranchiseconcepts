<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

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
      $this->load->model("Pagesdb");
	}		
	public function index(){

        if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if(isset($this->data["page"])){$page = $this->data["page"];}
		else{$page=1;}
		$data = $this->Pagesdb->pages($page,20);
		$this->data["pages"]= $data["pages"];

		if(isset($page)){$data["pagination"]["currentpage"]=$page;}
		else{$data["pagination"]["currentpage"]=1;}

		$this->data["pagination"] = $data["pagination"];
		$this->pages = $this->data["pagination"]["pages"];

        $this->load->view('pages',$this->data);
	}
	public function new_page($id=0)
	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		
		$post_title = $this->input->post("post_title");
		if(!empty($post_title))
		{			
		
			$this->load->library('form_validation');
			$this->form_validation->set_rules("post_title","Enter Your Business Name","trim|required");
			$this->form_validation->set_rules("post_content","Description","trim");
			if($this->form_validation->run()!=false){
				//form validation true
				//$this->create_page();
			}
			else{
				//form validation false
				$this->data["validation_errors"] = validation_errors();
				$this->load->view("new_page",$this->data);
			}
		}
		else{
			$this->data['page'] = (object) array('post_title'=>'',"post_content"=>'');
			$this->load->view("new_page",$this->data);
		}				
	}
}
