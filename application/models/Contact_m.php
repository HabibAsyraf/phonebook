<?php
class Contact_m extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_contact()
	{
		$sql = "SELECT * FROM `phone_contact` ";
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function contact_listing()
	{
		$query = $this->db->query("SELECT COUNT(id) AS total FROM `phone_contact")->row();
		$data['total_rows'] = $query->total;

		$config['base_url'] = site_url().'/contact/listing/';
		$config['uri_segment'] = 3;
		$config['total_rows'] = $data['total_rows'];
		$config['per_page'] = PAGING_DEFAULT_LIMIT;
		
		$data['rows_number'] = $this->uri->segment($config['uri_segment']) + 1;
		
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		$sql = '';
		if($data['total_rows'] > 0)
		{
			if($this->uri->segment($config['uri_segment']) && is_numeric($this->uri->segment($config['uri_segment'])))
			{
				$sql = ' LIMIT ' . $this->uri->segment($config['uri_segment']) . ', ' . $config['per_page'];
			}
			else
			{
				$sql = ' LIMIT 0, ' . $config['per_page'];
			}
		}
		
		$data['query'] = $this->db->query("SELECT * FROM `phone_contact` ORDER BY `id` DESC $sql");

		return $data;
	}
	
	public function contact_print()
	{
		
		$query = $this->db->query("SELECT * FROM `phone_contact` ORDER BY `name` ");
		return $query;
	}
	
	public function create_contact()
	{
		$datestring = '%Y-%m-%d %H:%i:%s';
		$time = time();
		
		$name = $this->input->post('name');
		$tel_no = $this->input->post('tel_no'); 
		$create_date = mdate($datestring, $time);
		$update_date = $create_date;
		
		$sql = "INSERT INTO `phone_contact`( `name`, `tel_no`, `create_date`, `update_date` )"
			."VALUES( ".$this->db->escape($name).",  ".$this->db->escape($tel_no).",  ".$this->db->escape($create_date).",  ".$this->db->escape($update_date)."  )";
		
	    return $this->db->query($sql);
	}
	
	public function update_contact()
	{
		$datestring = '%Y-%m-%d %H:%i:%s';
		$time = time();
		
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$tel_no = $this->input->post('tel_no'); 
		$update_date = mdate($datestring, $time);
		
		$sql = "UPDATE `phone_contact` "
			."SET `name` = ".$this->db->escape($name).", "
			."`tel_no` = ".$this->db->escape($tel_no).", "
			."`update_date` = ".$this->db->escape($update_date)." "
			."WHERE `id` = ".$this->db->escape($id);
		
	    return $this->db->query($sql);
	}
	
	public function remove_contact()
	{
		$id = $this->input->post('id');
		
		$sql = "DELETE FROM `phone_contact` "
			."WHERE `id` = ".$this->db->escape($id);
		
	    return $this->db->query($sql);
	}
}