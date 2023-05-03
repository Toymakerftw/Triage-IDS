function refreshInterface(interfaceName) {
	jQuery.ajax({
		url: 'refresh_interface.php',
		type: 'POST',
		data: {interface_name: interfaceName},
		success: function(response) {
			alert('Interface ' + interfaceName + ' has been refreshed.');
			location.reload();
		},
		error: function() {
			alert('An error occurred while refreshing the interface.');
		}
	});
}
