<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
	  	parent::__construct();
		$this->load->model('Generaldb');
		$this->load->model('Pagesdb');
		$this->load->model('Shortcodes');
		$this->Chome = & get_instance();
	}		
	public function index($slug='home'){
		$this->data['slug']=$slug;
		$menu = array();
		$result = $this->Pagesdb->get_menus(3);
		foreach($result as $row){
			$this->data['menu'] = $row;
		}
		
		
		/** */

		if($slug){
			$reslut = $this->Pagesdb->select_page(array('post_name'=>$slug));
			$this->data["pageObj"] = $reslut;
			//var_dump($reslut);
			$this->load->view('frontend/home',$this->data);
		}else{			
        	$this->load->view('frontend/home',$this->data);
		}
	}
	public function directory($slug){
		echo $slug;		
	}
	public function getStringBetween($str){
		$content = $str;
		if(preg_match_all("/\[.*?\]/i",$str,$shortcodes)){
			if(count($shortcodes[0])>0){
				foreach($shortcodes[0] as $shortcode){
					$params = array();
					$shortcodewithparam = str_replace("]","",str_replace("[","",str_replace("-","_",$shortcode)));
					$shortcodewithparam = explode(" ",$shortcodewithparam);
					if(is_array($shortcodewithparam)){
						$function_name = $shortcodewithparam[0];
						unset($shortcodewithparam[0]);
						if(count($shortcodewithparam)>0){
							foreach($shortcodewithparam as $param){
								if($param[0]!=''){
									$param = explode("=",$param);
									if(is_array($param)){$params[$param[0]] = $param[1];}
								}								 
							}
						}												
					}else{
						$function_name = $shortcodewithparam;
					}
					if(method_exists($this->Shortcodes,$function_name)){
						$result = $this->Shortcodes->$function_name($params);						
						$content = str_replace($shortcode,$result,$str);
					}
				}
			}
		}
		return $content;					
	}
	public function do_shortcode($str){
		$sub = substr($str, strpos($str,"[")+strlen("["),strlen($str));
		
		$shortcode = substr($sub,0,strpos($sub,"]"));
		$function_name = str_replace("-","_",$shortcode);
		if(method_exists($this->Shortcodes,$function_name)){
			return $this->Shortcodes->$function_name();
		}else{
			return false;
		}
	}
	
}

