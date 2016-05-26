<?php
class Contact_m extends CI_Model
{
	public function __construct(){ }
	
	function search($search_url="", $data=array())
	{
		if(isset($data) && is_array($data) && sizeof($data) > 0)
		{
			$this->phpsession->save("search_url", $search_url);
			$this->phpsession->save("search_data", $data);
			redirect($this->uri->uri_string());
		}
		
		if(!isset($data) || !is_array($data) || sizeof($data) == 0)
		{
			if($this->phpsession->get("search_url") == $search_url)
			{
				$data = $this->phpsession->get("search_data");
			}
			else if($this->phpsession->get("search_url") !== false)
			{
				$this->phpsession->clear("search_url");
				$this->phpsession->clear("search_data");
				$data = array();
			}
		} 
		
		$this->phpsession->save("search_url", $search_url);
		$this->phpsession->save("search_data", $data);
		$where = "";
		
		if($data !== false && is_array($data)) {
			
			if(isset($data["search_contact"]))
			{
				$where .= ($where == "" ? " WHERE " : " AND ") . " (`name` LIKE " . $this->db->escape("%" . $data["search_contact"] . "%") . " OR `tel_no` LIKE " . $this->db->escape("%" . $data["search_contact"] . "%") . " ) ";
			}
		}
		
		return $where;
	}
	
	public function get_contact()
	{
		$sql = "SELECT * FROM `phone_contact` ";
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function contact_listing($pag = array(), $where="")
	{
		$per_page = $pag["per_page"];
		$cur_page_segment = $pag["uri_segment"];
		
		$start_form  = $this->uri->segment($cur_page_segment);
		$limit = " LIMIT " . $per_page;
		
		if(is_numeric($start_form) && $start_form > 1)
		{
			$limit = " LIMIT " . $start_form . ", " . $per_page;
		}
		
		$sql = "SELECT COUNT(`id`) AS total FROM `phone_contact` " . $where;
		$pag["total_rows"] = $this->db->query($sql)->row()->total;
		$this->pagination->initialize($pag);
		
		$query = $this->db->query("SELECT * FROM `phone_contact` " . $where . " ORDER BY `id` DESC " . $limit);

		return $query;
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