<?php
class Contact extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('contact_m');
		//$this->load->library('html2pdf/html2pdf');
		
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
	
	public function pdf_listing()
	{
		$data['query'] = $this->contact_m->contact_print();
		$data['title'] = "Contact List";
		
		$content = $this->load->view('contact/contact_listing_p', $data, true);
		
	    $html2pdf = new HTML2PDF('P','A4','fr');
	    $html2pdf->WriteHTML($content);
	    $html2pdf->Output('Contact.pdf');
	}
	
	public function excel_listing()
	{
		$data['query'] = $this->contact_m->contact_print();
// 		$data['content']
		$data['title'] = "Contact List";
		
		$content = $this->load->view('contact/contact_listing_p', $data, true);
		
	    $html2pdf = new HTML2PDF('P','A4','fr');
	    $html2pdf->WriteHTML($content);
	    $html2pdf->Output('Contact.pdf');
	}
	
	public function create()
	{
		$data = $this->input->post();
		
		$result = $this->contact_m->create_contact($data);
		redirect('contact/listing');
	}
	
	public function remove($info="")
	{
		if($info != "")
		{
			//$decrypted_info = array();
			$decrypted_info = explode("###", base64_decode(urldecode($info)));
			
			$this->contact_m->remove_contact($decrypted_info[0]);
			
			if(sizeof($decrypted_info) > 1)
			{
				redirect($decrypted_info[1]);
			}
		}
		redirect('contact/listing');
	}
}
?>