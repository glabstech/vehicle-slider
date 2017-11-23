jQuery(document).ready(function($) {
	
	$(document).ready(function() {
		
		var mediaUploader;
		var color_url;
		var color_image;

		$(document).on('click', '#gltv_image_upload', function(e) {
			e.preventDefault();
			
			color_url = $(this).parent().parent().find('.color-url').find('.alignright').find('input').attr('id');
			color_image = $(this).parent().parent().find('.color-image').find('.alignright').find('img').attr('id');
			
// 			color_image = $(this).closest('div').parent().find('.color-image').find('img').attr('id');
			console.log(color_url);
			console.log(color_image);
			// If the uploader object has already been created, reopen the dialog
			if (mediaUploader) {
				mediaUploader.open();
				return;
			}
			// Extend the wp.media object
			mediaUploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				multiple: false
			});
			// When a file is selected, grab the URL and set it as the text field's value
			mediaUploader.on('select', function() {
				var attachment = mediaUploader.state().get('selection').first().toJSON();
				
				$('#' + color_url).val(attachment.url);
				$('#' + color_image).attr('src',attachment.url);
			});
			// Open the uploader dialog
			mediaUploader.open();
		});
		
  	});
	
	
	$(document).ready(function() {
		
		// Adds New Variation
		$('#add_variation').click(function() {
			var row = $('.empty-row.screen-reader-text').clone(true);
			row.removeClass('empty-row screen-reader-text');
			row.insertBefore('#repeatable-fieldset-one #tbody>.holder:last');
			var jsclr = jscolor.installByClassName("jscolor");
			row.addClass(jsclr);
			
			function randomString(length, chars) {
				var result = '';
				for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
				return result;
			}
			
			row.find('#color_url').each(function() {
				$(this).attr('id', 'color_url_' + randomString(3, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'));
			});
			
			row.find('#color_image').each(function() {
				$(this).attr('id', 'color_image_' + randomString(3, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'));
			});
			
			return false;
		});

		// Removes Variation
		$(document).on('click', '#remove', function() {
			$(this).parents('.holder').remove();
		});
			
		// Drags Variation
		$('#repeatable-fieldset-one #tbody').sortable({
			opacity: 0.6,
			revert: true,
			cursor: 'move',
			handle: '#sort'
		});
		
	});
	
	$(document).on('click', '#cc_txtfld', function(event) {
		$(this).select();
		document.execCommand("copy");
		alert('Shortcode Copied');
	});



	var popup = $("#carousel_type").attr('value');
	if ( popup == 'Pop-up') {
		$(".carousel-options").show();
	}

	$('#carousel_type').change(function(){
		if ( this.value == 'Pop-up') {
			$(".carousel-options").show();
		} else {
			$(".carousel-options").hide();
		}
	});
	
	
});