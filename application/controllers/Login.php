<?php
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_m');
		$this->load->model('user_model');
	}
	
	public function index()
	{
	    redirect('login/login_form');
	}
	
	public function login_form()
	{
		$data['title'] = "Login Page";
		if(isset($this->session->userdata['logged_in']))
		{
			redirect('home/index');
		}
		else
		{
			$this->load->view('login/login_form', $data);
		}
	}
	
	public function verify()
	{
		if($this->input->post('username') != '' || $this->input->post('password') != '')
		{
			$rs = $this->login_m->verify_login();
			
			if($rs === TRUE)
			{
				redirect('home/index');
			}
			else
			{
			    $data['error'] = "Login Failed";
				$this->load->view('login/error', $data);
			}
	    }
	    else
	    {
		    $data['error'] = "Please fill the blank field";
		    $this->load->view('login/error', $data);
	    }
	}
	
	public function register()
	{
		if($_POST)
		{
			$rs = $this->user_model->register_user();
			
			if($rs === false)
			{
				redirect('login');
			}
			else
			{
				set_msg("Registration success", "alert-success");
				redirect('login');
			}
		}
		else
		{
			set_msg('Invalid request. Please try again later');
			redirect('login');
		}
	}
	
	public function logout()
	{
		$this->session->unset_userdata(array('username', 'id', 'name', 'logged_in'));
		redirect('login/login_form');
	}
}
?>