<?php
class Login_m extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function verify_login()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		
		$sql = "SELECT * FROM `phone_user` WHERE username = ".$this->db->escape($username)." AND password = ".$this->db->escape($password);
		$query = $this->db->query($sql);
		$row = $query->row();
		if($query->num_rows() == 1)
		{
			$this->session->set_userdata(array('username' => $row->username, 'id' => $row->id, 'name' => $row->name, 'logged_in' => TRUE));
			return TRUE;
		}
		else
		{
			$this->session->unset_userdata(array('username' => '', 'id' => '', 'name' => '', 'logged_in' => ''));
			return FALSE;
		}
	}
}