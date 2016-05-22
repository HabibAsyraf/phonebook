<?php
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		
		if(!isset($this->session->userdata['logged_in']))
		{
			redirect(base_url());
		}
	}
	
	public function index()
	{
		redirect('home/homepage');
	}
	
	public function homepage()
	{
		$data['title'] = "Homepage";
		
		$this->load->view('templates/header', $data);
		$this->load->view('home/homepage_v', $data);
		$this->load->view('templates/footer');
	}
}
?>