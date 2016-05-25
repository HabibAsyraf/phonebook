<?php
class Contact extends CI_Controller
{
	public $data;
	public $where;
	public $pag_config;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('contact_m');
		
		if(!isset($this->session->userdata['logged_in']))
		{
			redirect(base_url());
		}
		
		// handle the pagination setup
		if(in_array(strtolower($this->uri->segment(2)), array("listing", "search"))) {
			$this->pag_config["uri_segment"] = 4;
			$per_page = $this->uri->segment($this->pag_config["uri_segment"] - 1);
			$this->pag_config["per_page"] = (is_numeric($per_page) && $per_page > 1 ? $per_page : PAGING_DEFAULT_LIMIT);
			$this->pag_config["base_url"] = site_url() . "/" . $this->uri->segment(1) . "/" . $this->uri->segment(2) . "/" . $this->pag_config["per_page"] . "/";
			$this->pagination->initialize($this->pag_config); 
		}
		
		// handle the listing search function
		if(!in_array(strtolower($this->uri->segment(2)), array("pdf_listing", "excel_listing", "create", "remove")))
		{
			$search_url = $this->uri->segment(1) . "/" . $this->uri->segment(2);
			$this->where = $this->contact_m->search($search_url, $this->input->post());
		}
	}
	
	public function index()
	{
	    redirect('contact/listing');
	}
	
	public function listing()
	{
		$this->data["query"] = $this->contact_m->contact_listing($this->pag_config);
		$this->data["pagination"] = $this->pagination->create_links();
		
    	$this->data['title'] = "Contact";
		
        $this->load->view('templates/header', $this->data);
		$this->load->view('contact/contact_listing_v', $this->data);
	    $this->load->view('templates/footer');
	}
	
	public function search()
	{
		$this->data['query'] = $this->contact_m->contact_listing($this->pag_config, $this->where);
    	$this->data["pagination"] = $this->pagination->create_links();
		
    	$this->data['title'] = "Contact";
		
        $this->load->view('templates/header', $this->data);
		$this->load->view('contact/contact_listing_v', $this->data);
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