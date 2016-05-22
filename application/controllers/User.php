<?php
class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->load->library('pagination');
		
		if(!isset($this->session->userdata['logged_in']))
		{
			redirect(base_url());
		}
	}
	
	public function index()
	{
	    redirect('user/listing');
	}
	
	public function listing($start_from = NULL)
	{
		$this->load->helper('form');
	    $this->load->library('form_validation');
	    
		$data['title'] = "User";
		$data['datestring'] = '%d-%F-%Y %g:%i:%a';
		$data['user_row'] = $this->user_model->get_user();
    	$data['rows_number'] = $start_from+1;
    	
    	$config['base_url'] = site_url("user/listing");
		$config['total_rows'] = $data['user_row']->num_rows();
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 1;
		$config['use_page_numbers'] = FALSE;
		$config['full_tag_open'] = '<h4 style="color: red">';
		$config['full_tag_close'] = '</h4>';
		$config['cur_tag_open'] = '<b style="font-size: x-large">';
		$config['cur_tag_close'] = '</b>';
		
		$this->pagination->initialize($config);
		
		$data['user'] = $this->user_model->get_paging_user($start_from, $config['per_page'])->result();
		
        $this->load->view('templates/header', $data);
		$this->load->view('user/listing', $data);
	    $this->load->view('templates/footer');
	}
	
	public function print_listing()
	{
		$data['query'] = $this->contact_m->contact_print();
		$data['title'] = "Contact List";
		
		$content = $this->load->view('contact/contact_listing_p', $data, true);
		
	    $html2pdf = new HTML2PDF('P','A4','fr');
	    $html2pdf->WriteHTML($content);
	    $html2pdf->Output('Contact.pdf');
	}
	
	public function create()
	{
		$this->load->helper('form');
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('username', 'Username', 'required');
	    $this->form_validation->set_rules('password', 'Password', 'required');
	    $this->form_validation->set_rules('name', 'Name', 'required');
		
		//$data['datestring'] = '%d-%F-%Y %g:%i:%a';
		
	    if ($this->form_validation->run() === FALSE)
	    {
		    $data['error'] = "Please fill blank field";
			$this->load->view('user/error', $data);
	    }
	    else
	    {
		    if($this->user_model->validate_availability($this->input->post('username')) === TRUE)
		    {
		        $this->user_model->create_user();
		        redirect('user/listing');
	        }
	        else
	        {
		        $data['error'] = "Error: Username ".$this->input->post('username')." already exist!";
		        $this->load->view('user/error', $data);
	        }
	    }
	}
	
	public function update()
	{
		$this->load->helper('form');
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('id', 'ID', 'required');
	    $this->form_validation->set_rules('username', 'Username', 'required');
	    $this->form_validation->set_rules('name', 'Name', 'required');
		
		if($this->input->post("change") !== NULL)
		{
			$this->form_validation->set_rules('current_password', 'Current_Password', 'required');
			$this->form_validation->set_rules('new_password', 'New_Password', 'required');
			$this->form_validation->set_rules('retype_password', 'Retype_Password', 'required');
		}
		
		$data['datestring'] = '%d-%F-%Y %g:%i:%a';
		
	    if ($this->form_validation->run() === FALSE)
	    {
			$data['error'] = "Please Fill The Blank Field";
			$this->load->view('user/error', $data);
	    }
	    else
	    {
		    if($this->user_model->validate_availability($this->input->post('username'), $this->input->post('name'), $this->input->post('id')) === TRUE)
		    {
				if($this->input->post("change") !== NULL)
				{
					if($this->user_model->validate_password($this->input->post('id'), $this->input->post('current_password')) === TRUE)
					{
						if($this->input->post("new_password") !== $this->input->post("retype_password"))
						{
							$data['error'] = "Please make sure retype the correct new password";
							$this->load->view('user/error', $data);
						}
						else
						{
							$this->user_model->update_user();
							redirect('user/listing');
						}
					}
					else
					{
						$data['error'] = "Wrong password!";
						$this->load->view('user/error', $data);
					}
				}
				else
				{
					$this->user_model->update_user();
					redirect('user/listing');
				}
	        }
	        else
	        {
		        $data['error'] = "Error: Username ".$this->input->post('username')." already exist!";
		        $this->load->view('user/error', $data);
	        }
	    }
	}
	
	public function remove()
	{
		$this->load->helper('form');
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('id', 'ID', 'required');
	    
	    if ($this->form_validation->run() === FALSE)
	    {
			$this->load->view('user/error', $data);
	    }
	    else
	    {
	        $this->user_model->remove_user();
	        redirect('user/listing');
	    }
	}
}
?>