<?php
class User_Model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_user($username = FALSE)
	{
		if($username === FALSE)
		{
			$sql = "SELECT * FROM `phone_user`";
			$query = $this->db->query($sql);
			
			return $query;
		}
		
		$sql = "SELECT * FROM `phone_user` WHERE `username` = ".$this->db->escape($username);
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	public function get_paging_user($start_from = FALSE, $limit_per_page = FALSE)
	{
		$limit = $limit_per_page;
		if(is_numeric($start_from))
		{
			$limit = $start_from . ", " . $limit_per_page;
		}
		
		if($start_from === NULL)
		{
			$start_from = "0";
		}
		$sql = "SELECT * FROM `phone_user` LIMIT ".$limit;
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	public function validate_password($id = FALSE, $curr_password = FALSE)
	{
		$sql = "SELECT * FROM `phone_user` WHERE `id` = ".$this->db->escape($id);
		$query = $this->db->query($sql);
		$row = $query->row();
		
		if($row->password === md5($curr_password))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function validate_availability($username = FALSE, $name = FALSE, $id = FALSE)
	{
		if($username !== FALSE && $name === FALSE && $id === FALSE)
		{
			$user_query = $this->get_user($username);
			
			if($user_query->num_rows() > 0)
			{
				return FALSE;
			}
			
			return TRUE;
		}
		else if($username !== FALSE && $name !== FALSE && $id !== FALSE)
		{
			$user_query = $this->get_user($username);
			
			if($user_query->num_rows() > 0)
			{
 				$row = $user_query->row();
				if($row->id === $id)
				{
					return TRUE;
				}
				
				return FALSE;
			}
			
			return TRUE;
		}
		
	}
	
	public function create_user()
	{
		$datestring = '%Y-%m-%d %H:%i:%s';
		$time = time();
		
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$name = $this->input->post('name');
		$create_date = mdate($datestring, $time);
		$update_date = $create_date;
		
		$sql = "INSERT INTO `phone_user`( `username`, `password`, `name`, `create_date`, `update_date` )"
			."VALUES( ".$this->db->escape($username).", ".$this->db->escape($password).", ".$this->db->escape($name).", ".$this->db->escape($create_date).", ".$this->db->escape($update_date)."  )";
		
	    return $this->db->query($sql);
	}
	
	public function register_user()
	{
		$db_user = array(
			'username' => trim($this->input->post('username')),
			'password' => trim($this->input->post('password')),
			'name' => trim($this->input->post('name')),
			'create_date' => date("Y-m-d H:i:s"),
			'update_date' => date("Y-m-d H:i:s")
		);
		
		if($db_user['name'] == "")
		{
			set_msg("Fullname cannot be empty");
			return false;
		}
		if($db_user['username'] == "")
		{
			set_msg("Username cannot be empty");
			return false;
		}
		if($db_user['password'] == "")
		{
			set_msg("Password cannot be empty");
			return false;
		}
		if(strlen($db_user['password']) < 3)
		{
			set_msg("Minimum length for password is 4 characters");
			return false;
		}
		
		$db_user['password'] = md5($db_user['password']);
		$rs = $this->db->insert('phone_user', $db_user);
		
		return $rs;
	}
	
	public function update_user()
	{
		$datestring = '%Y-%m-%d %H:%i:%s';
		$time = time();
		
		$id = $this->input->post('id');
		$username = $this->input->post('username');
		$name = $this->input->post('name');
		$update_date = mdate($datestring, $time);
		
		if($this->input->post("change") !== NULL)
		{
			$password = md5($this->input->post('new_password'));
			
			$sql = "UPDATE `phone_user` "
				."SET `username` = ".$this->db->escape($username).", "
				."`password` = ".$this->db->escape($password).", "
				."`name` = ".$this->db->escape($name).", "
				."`update_date` = ".$this->db->escape($update_date)." "
				."WHERE `id` = ".$this->db->escape($id);
		}
		else
		{
			$sql = "UPDATE `phone_user` "
				."SET `username` = ".$this->db->escape($username).", "
				."`name` = ".$this->db->escape($name).", "
				."`update_date` = ".$this->db->escape($update_date)." "
				."WHERE `id` = ".$this->db->escape($id);
		}
		
	    return $this->db->query($sql);
	}
	
	public function remove_user()
	{
		$id = $this->input->post('id');
		$sql = "DELETE FROM `phone_user` WHERE `id` = ".$this->db->escape($id);
		
	    return $this->db->query($sql);
	}
}