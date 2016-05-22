<?php
class Contact extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('contact_m');
		$this->load->library('html2pdf/html2pdf');
		
		if(!isset($this->session->userdata['logged_in']))
		{
			redirect(base_url());
		}
	}
	
	public function index()
	{
	    redirect('contact/listing');
	}
	
	public function listing()
	{
		$data = $this->contact_m->contact_listing();
    	$data['title'] = "Contact";
		$data['datestring'] = '%d-%F-%Y %g:%i:%a';
		
        $this->load->view('templates/header', $data);
		$this->load->view('contact/contact_listing_v', $data);
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
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('name', 'Name', 'required');
	    $this->form_validation->set_rules('tel_no', 'Tel_No', 'required');
		
		$data['title'] = "Contact";
		$data['datestring'] = '%d-%F-%Y %g:%i:%a';
		
	    if ($this->form_validation->run() === FALSE)
	    {
			$this->load->view('contact/error', $data);
	    }
	    else
	    {
	        $this->contact_model->create_contact();
	        redirect('contact/listing');
	    }
	}
	
	public function update()
	{
		$this->load->helper('form');
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('id', 'ID', 'required');
	    $this->form_validation->set_rules('name', 'Name', 'required');
	    $this->form_validation->set_rules('tel_no', 'Tel_No', 'required');
		
		$data['title'] = "Contact";
		$data['datestring'] = '%d-%F-%Y %g:%i:%a';
		
	    if ($this->form_validation->run() === FALSE)
	    {
			$this->load->view('contact/error', $data);
	    }
	    else
	    {
	        $this->contact_model->update_contact();
	        redirect('contact/listing');
	    }
	}
	
	public function remove()
	{
		$this->load->helper('form');
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('id', 'ID', 'required');
	    
	    if ($this->form_validation->run() === FALSE)
	    {
			$this->load->view('contact/error', $data);
	    }
	    else
	    {
	        $this->contact_model->remove_contact();
	        redirect('contact/listing');
	    }
	}
}
?>