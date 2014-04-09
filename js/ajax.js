jQuery(document).ready(function($){ 
	jQuery('#balance_report').hide();
	jQuery('#ss_le_lookup').click(function(){
		var data = {
			action: 'ss_le_balance',
			security: wp_ajax.ajaxnonce,
			username: jQuery('#ss_le_username').val(),
			password: jQuery('#ss_le_password').val()
		};
		jQuery('#balance_report').show();
		var image = '<img src="'+wp_ajax.pluginimg+'" id="ss_le_loader" alt="Loading..." width="32" height="32" />';
		jQuery('#balance_results').html(image);
		jQuery.post(
			wp_ajax.ajaxurl, 
			data,                   
			function(response){
				jQuery('#balance_results').html(response);
			}
		); 
	});
	jQuery('#ss_le_close').click(function(){
		jQuery('#balance_report').hide('slow');
	});
});
