jQuery(document).ready(function($) {
	$(document).on('click', '.js-menu-item-upload', function(e) {
		e.preventDefault();
		var $button        = $(this);
		var $inputField    = $button.siblings('.edit-menu-item-image');
		var customUploader = wp.media({
			title: 'Select Image',
			library: {type: 'image'},
			button: {text: 'Select'},
			multiple: false
		});
		customUploader.on('select', function() {
			var attachment = customUploader.state().get('selection').first().toJSON();
			$inputField.val(attachment.url);
		});
		customUploader.open();
	});
});
