function save_pdf_id(report_name, post_id, report_id) {
	//console.log('report_name:'+report_name+' post_ID:'+post_id + 'report_id:' + report_id);
    jQuery.ajax({
      method: "POST", // better than GET
      url: ajaxurl,// wp specific variable
      data: { 'action': 'wysac_save_pdf_id', 'post_id': post_id, 'report_name': report_name, 'report_id': report_id }
    })
    .done(function( data ) {
    	// Success
    	jQuery('#wysacDropzone').hide();
    	jQuery('#wysacSavedReport').addClass('visible');
    	jQuery('#successfulUpload').remove(); // in rare cases of upload/delete/upload-again duplicates
    	
    	jQuery('#saved_report_id').val(report_id);
    	jQuery('#reportLink').prop('href', 'http://wysac.uwyo.edu/wysac/ReportView.aspx?DocId='+report_id+'&A=1' );
    	jQuery('#deleteReport').attr('rel', report_id);
    	
    	// Show Success Message
    	filename = jQuery('.dz-filename').text();
    	filesize = jQuery('.dz-size').text();
    	jQuery('#wysacSavedReport').prepend('<div id="successfulUpload"><p>Report Uploaded</p><p>Filename: <b>'+filename+'</b><br/>Filesize: <b>'+filesize+'</b></div>');
    	jQuery('#dropzone').removeClass('dz-started').empty();
    })
    .fail(function( data ) {
    	// Fail
    	alert("epic fail"+data);
    });
}

function delete_pdf_id(post_id, report_author_id, report_id) {
	//console.log('report_name:'+report_name+' post_ID:'+post_id + 'report_id:' + report_id);
	    jQuery.ajax({
	      method: "POST",
	      url: ajaxurl,// wp specific variable
	      data: { 'action': 'wysac_delete_saved_report', 
	    	  	  'post_id': post_id,
	    	  	  'report_id' : report_id,
	    	  	  'report_author_id': report_author_id }
	    })
	    .done(function( data ) {
	    	// Success
	    	//echo "<div id=\"wysacSavedReport\" $wysacSavedReportVisibleClass>\n".
	    	 //"<input type=\"hidden\" name=\"saved_report_id\" value=\"$saved_report_id\" />".
	    	 //"<p>There is a saved report for this post <a id="reportLink" href=\"http://wysac.uwyo.edu/wysac/ReportView.aspx?DocId=$saved_report_id&A=1\">Link</a></p>".
	    	 //"<p><a id=\"deleteReport\" rel=\"$saved_report_id\">Click here to delete this report.</a></p>".
	    	 //"</div>";
	    	jQuery('#wysacSavedReport').removeClass('visible');
	    	jQuery('#saved_report_id').val(''); // null out fields
	    	jQuery('#reportLink').attr('href', '');
	    	jQuery('#deleteReport').attr('rel','');
	    	// make dropzone area visible again
	    	jQuery('#wysacDropzone').show();
	    })
	    .fail(function( data ) {
	    	// Fail
	    	alert("epic fail"+data);
	    });
	}

jQuery(function ($) {
	// on user click, run the delete function
	$('#deleteReport').click(function() {
		// submit values for delete function
		post_id			 = $('#post_ID').val();
		report_id		 = $(this).attr('rel');
		report_author_id = $('#post_author').val();
		// submit function
		result = delete_pdf_id(post_id, report_author_id, report_id);
	});


	if($('#post-status-display').text().indexOf("Published") >= 0) { // If post-status is published, then build & enable upload
		//// Build Get Variables to pass to PDF insert
			// Author ID
			var report_author_id	= $('#report_owner_author_id').val();
			// Document Category
			var report_type_id		= $('#report_type_id').val();
			// Scope of Data
			var report_scope_id 	= $('#report_scope_id').val();
			// Publication Number
			var report_number		= $('#upload_report_publication_number').val();
			// Post_ID to associate with Wordpress
			var post_ID 			= $('#post_ID').val();
			// report_name
			var report_name 		= $('#title').val();
			// Short Description :: Use a regex to get the first 20 words of the post
			var short_description   = $('textarea#content').val().replace(/(([^\s]+\s\s*){20})(.*)/,"$1…");

		//// Build Dropzone area
		var myDropzone = new Dropzone("div#dropzone", {
			url: "http://dalton.uwyo.edu/wytobacco/wp-content/plugins/insertWYSACTobaccoReport/processReportUpload.php?id=upload",
			// Send POST form variables. Cleaner and better than GETs
			init: function() { // sends POST data to processReportUpload.php
				  this.on("sending", function(file, xhr, formData) {
				    formData.append("report_author_id", report_author_id);
				    formData.append("report_type_id", report_type_id);
				    formData.append("report_scope_id", report_scope_id);
				    formData.append("report_number", report_number);
				    formData.append("post_ID", post_ID);
				    formData.append("report_name", report_name);
				    formData.append("short_description", short_description);
				  });
			},
			// Success is triggered only if 1. File uploaded, and; 2. File imported
			success: function(file, response) {
					// Check if response has SUCCESS string which is passed form PHP. Process errors are handled here.
					var obj = jQuery.parseJSON(response);
					//{"result":"success","post_ID":"174","description":"","category":"","scope":"County","publication_number":"sdgdfgdfgd"}
					//console.log("1:" + obj.report_name + " 2:"+ post_ID + " 3:" + obj.report_id);
					if(obj.result == 'success') { // It saved a new PDF
						console.log(obj);
						save_pdf_id(obj.report_name, post_ID, obj.report_id);
					} else if(obj.result == 'duplicate') { // Duplicate title found
						save_pdf_id(obj.report_name, post_ID, obj.report_id);
						console.log(obj);
					} else { // Error
						alert("There has been an error:"+response);
					}
				},
			// This will be an HTTP error not triggered by a response to the PHP query. If there is anything other than a 
			// 200 response back, this will trigger
			error: function(file, response) { 
		        if($.type(response) === "string")
		            var message = response; //dropzone sends it's own error messages in string
		        else
		            var message = response.message;
		        file.previewElement.classList.add("dz-error");
		        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
		        _results = [];
		        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
		            node = _ref[_i];
		            _results.push(node.textContent = message);
		        }
			}
		});
	} else { // disable functionality if status != Published
		$('#wysacDropzone').css({opacity:0.25, cursor: 'not-allowed'});
		$('#wysacDropzone').parent().prev()
			.append('<span style="color: #966; padding-left: 10px;margin-left: 10px; border-left: 1px solid #999;">Publish post to add report')
			.parent().addClass('closed');
	}
	
});