<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PhpSession {

	var $CI;
	var $tableId;
	var $get = array();
    // constructor
    function PhpSession() {
        // Set the super object to a local variable for use throughout the class
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->CI->load->database('default', true);
		if($this->CI->session->userdata('phpsession_table')) {
			$this->tableId = $this->CI->session->userdata('phpsession_table');
		}
		
		$this->ini_var();
    }
    
    function ini_var() {
	    $this->CI->load->database('default', true);
		if(isset($this->tableId) && !empty($this->tableId)) {
			$this->CI->db->query("DELETE FROM `phpsession_table` WHERE `update_time` > (`update_time`+7200)");
			$query = $this->CI->db->query("SELECT * FROM `phpsession_table` WHERE `id` = " . $this->CI->db->escape($this->tableId)/* . " AND `ip_address` = " . $this->CI->db->escape($_SERVER['REMOTE_ADDR'])*/);
			if($query->num_rows() > 0) {
				$row = $query->row();
				$this->get = unserialize(base64_decode($row->content));
			} else 
				$this->insertTableId();
		} else 
			$this->insertTableId();
    }
    
    function get($item) {
		return ( ! isset($this->get[$item])) ? FALSE : $this->get[$item];
    }
    
	function save($var, $val) {
		$this->get[$var] = $val;
		$this->updateTableId();
	}
	
	function clear($var = null) {
		$this->CI->load->database('default', true);
		if(isset($var)) {
			unset($this->get[$var]);
			$this->updateTableId();
		}
		else {
			$this->get = array();
			$this->CI->db->query("DELETE FROM `phpsession_table` WHERE `id` = " . $this->CI->db->escape($this->tableId)/* . " AND `ip_address` = " . $this->CI->db->escape($_SERVER['REMOTE_ADDR'])*/);
			$this->CI->db->query("DELETE FROM `phpsession_table` WHERE `update_time` <= " . $this->CI->db->escape(mktime(0,0,0,date("m")-1,date("d"),date("Y"))));
		}
	}
	
	function insertTableId() {
		$this->CI->load->database('default', true);
		$this->tableId = uniqid();
		$this->CI->db->query("INSERT INTO `phpsession_table` (`id`, `ip_address`, `content`, `update_time`) VALUES (" . $this->CI->db->escape($this->tableId) . ", " . $this->CI->db->escape($_SERVER['REMOTE_ADDR']) . ", " . $this->CI->db->escape(base64_encode(serialize($this->get))) . ", " . $this->CI->db->escape(time()) . ")");
		$this->CI->session->set_userdata(array('phpsession_table' => $this->tableId));
		
    }
    
    function updateTableId() {
	    $this->CI->load->database('default', true);
		$query = $this->CI->db->query("SELECT * FROM `phpsession_table` WHERE `id` = " . $this->CI->db->escape($this->tableId)/* . " AND `ip_address` = " . $this->CI->db->escape($_SERVER['REMOTE_ADDR'])*/);
		if($query->num_rows() > 0)
			$this->CI->db->query("UPDATE `phpsession_table` SET `content` = " . $this->CI->db->escape(base64_encode(serialize($this->get))) . ", `update_time` = " . $this->CI->db->escape(time()) . " WHERE `id` = " . $this->CI->db->escape($this->tableId)/* . " AND `ip_address` = " . $this->CI->db->escape($_SERVER['REMOTE_ADDR'])*/);
		else
			$this->insertTableId();
    }
    
}
?>