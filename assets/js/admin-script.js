jQuery(document).ready(function($) {
 	var custom_uploader;

 	$("#upload_image_button").click(function(e){
 		e.preventDefault();
		console.log(typeof(custom_uploader));
 		if(custom_uploader){
 			custom_uploader.open();
 			return;
 		}
 		custom_uploader = wp.media.frames.file_frame = wp.media({
 			title: 'Choose PDF',
 			button: {
 				text: 'Choose PDF'
 			},
 			multiple: false
 			//library: { type: 'pdf'}
 		}); // end of custom uploader script

 		custom_uploader.on('select', function(){
 			attachment = custom_uploader.state().get('selection').first().toJSON();
 			$('#upload_pdf').val(attachment.url);
 		});

 		custom_uploader.open();
 	});
 	$("#upload_image_button_tax").click(function(e){
 		e.preventDefault();
		//console.log(typeof(custom_uploader));
 		if(custom_uploader){
 			custom_uploader.open();
 			return;
 		}
 		custom_uploader = wp.media.frames.file_frame = wp.media({
 			title: 'Choose Category Image',
 			button: {
 				text: 'Choose Image'
 			},
 			multiple: false
 			//library: { type: 'pdf'}
 		}); // end of custom uploader script

 		custom_uploader.on('select', function(){
 			attachment = custom_uploader.state().get('selection').first().toJSON();
 			console.log($('#term_meta[term_meta]'));
 			$('.term_tax_input').val(attachment.url);
 		});

 		custom_uploader.open();
 	});
 	
}); //end of doc ready