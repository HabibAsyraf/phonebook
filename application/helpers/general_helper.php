<?php
// array debug
if(!function_exists("array_debug")) {
	function array_debug($data, $var_dump=false) {
		echo '<pre>';
		if($var_dump === false) {
			print_r($data);
		} else {
			var_dump($data);
		}
		echo '</pre>';
	}
}

// Message setting
if(!function_exists("set_msg")) {
	function set_msg($msg, $type="alert-danger") {
		$CI =& get_instance();
		$CI->phpsession->save("sys_msg", $msg);
		$CI->phpsession->save("sys_msg_type", $type);
	}
}

if(!function_exists("get_msg")) {
	function get_msg($dismissable=false) {
		$CI =& get_instance();
		$show = "";
		if($CI->phpsession->get("sys_msg")) {
			$show = '
				<div class="alert ' . ($dismissable === true ? 'alert-dismissable' : '') . ' ' . $CI->phpsession->get("sys_msg_type") . '">' . $CI->phpsession->get("sys_msg") . ($dismissable === true ? '<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>' : '') . '</div>
			';
			$CI->phpsession->clear("sys_msg");
			$CI->phpsession->clear("sys_msg_type");
		}
		echo $show;
	}
}
?>