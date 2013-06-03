jQuery(document).ready(function($) {
 	var custom_uploader;

 	$("#upload_image_button").click(function(e){
 		e.preventDefault();
		console.log(typeof(custom_uploader));
 		if(custom_uploader){
 			console.log("its true");
 			custom_uploader.open();
 			return;
 		} else {
 			console.log("its false");
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
 
}); //end of doc ready