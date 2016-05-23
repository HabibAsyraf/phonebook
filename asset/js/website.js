function delete_confirmation(msg) {
	if(typeof(msg) == 'undefined' || msg == '') {
		msg = 'Are you confirm want to delete this records?';
	}
	return confirm(msg);
}