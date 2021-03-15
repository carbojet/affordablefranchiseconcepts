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
        $this->load->view('pages',$this->data);
	}
}
