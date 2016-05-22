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
?>