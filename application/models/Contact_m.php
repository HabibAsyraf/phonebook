<?php
class Contact_m extends CI_Model
{
	public function __construct()
	{
		
	}
	
	public function get_contact()
	{
		$sql = "SELECT * FROM `phone_contact` ";
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function contact_listing()
	{
		$query = $this->db->query("SELECT COUNT(id) AS total FROM `phone_contact`")->row();
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
	
	public function create_contact($data = array())
	{
		$db_contact = array(
			"name" => trim(isset($data['name']) ? $data['name'] : ""),
			"tel_no" => trim(isset($data['tel_no']) ? $data['tel_no'] : ""),
			"update_date" => trim(date("Y-m-d H:i:s"))
		);
		
		$update = false;
		$msg = "";
		
		if(isset($data['id']) && trim($data['id']) != "")
		{
			$update = true;
		}
		
		if(isset($db_contact['name']) && trim($db_contact['name']) == "")
		{
			$msg = "Contact name cannot be empty";
		}
		else if(isset($db_contact['tel_no']) && trim($db_contact['tel_no']) == "")
		{
			$msg = "Telephone number cannot be empty";
		}
		
		
		if($update === false)
		{
			$db_contact['create_date'] = $db_contact['update_date'];
		}
		
		if($msg == "")
		{
			if($update === true)
			{
				$update_contact = array();
				foreach($db_contact as $k => $v)
				{
					$update_contact[] = "`" . $k . "` = " . $this->db->escape($v);
				}
				
				$sql =   "UPDATE `phone_contact` SET " . implode(", ", $update_contact) . " "
						."WHERE `id` = " . $this->db->escape(trim($data['id']));
				
				$this->db->query($sql);
				if($this->db->affected_rows() > 0)
				{
					set_msg("Contact succesfully updated.", "alert-success");
					return true;
				}
			}
			else
			{
				$insert_contact = array();
				foreach($db_contact as $k => $v)
				{
					$insert_contact["`" . $k . "`"] = $this->db->escape($v);
				}
				
				$sql =   "INSERT INTO `phone_contact`( " . implode(", ", array_keys($insert_contact)) . " ) "
						."VALUES( " . implode(", ", array_values($insert_contact)) . " )";
				
				$this->db->query($sql);
				if($this->db->affected_rows() > 0)
				{
					set_msg("New contact succesfully inserted.", "alert-success");
					return true;
				}
			}
		}
		
		set_msg($msg);
	    return false;
	}
	
	public function remove_contact($id)
	{
		$sql = "DELETE FROM `phone_contact` "
			."WHERE `id` = ".$this->db->escape($id);
		
	    return $this->db->query($sql);
	}
}