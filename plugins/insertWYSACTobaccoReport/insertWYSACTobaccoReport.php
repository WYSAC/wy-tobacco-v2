<?php
/*
Plugin Name: WYSAC Tobacco Report Insert
Description: Adds administration functionality to insert Tobacco Reports. TMP folder in plugin folder must be writable.
Author: Eric Limegrover
Version: 0.1
*/

function wysac_author_sqlsrv_translate($author) {
    switch ($author) {
        // Case = WP author ID
        case 2: // Tiffany
            $sqlauthor = 21;
            break;
        case 3: // Laran
            $sqlauthor = 30;
            break;
        case 4: // Shinze
            $sqlauthor = 107;
            break;
        case 5: // Janelle
            $sqlauthor = 132;
            break;
        default: // Default to Tiffany if no match
            $sqlauthor = 0;
    }
    return $sqlauthor;
}

function getReport() {
    global $wpdb, $post_id; // wpdb activates the WPDB class, while $post_id is a global for post.php relating to the existing post ID
    // Get the report_id if exist
    $result = $wpdb->get_results( "SELECT report_id FROM wp_wysac_pdf_id WHERE post_id = ".$post_id, ARRAY_A );
	   
    $out = $result[0]['report_id'];
    if($out > 0) { // If its > 0, return the integer as the report_id
        return $out;
    } else {
        return false;
    }
}


function insertReportBoxUI( $post_type, $post ) {
    add_meta_box( // wordpress specific code to create the upload report box
        'my-meta-box', // classname
        __( 'Upload Report' ), // Title
        'renderInsertReport',
        'post',
        'normal',
        'high'
    );
}

function insertReportJS($hook) {
    // We only want this to load if we are on the post.php page
    if( $hook = 'post.php') { 
		// FYI :: Plugins_url will always reference the installed location for the plugin
        wp_enqueue_style( 'dropzone-css', plugins_url( '/insertWYSACTobaccoReport/dropzone/dropzone.css' ) );
        wp_enqueue_script( 'dropzone-js', plugins_url( '/insertWYSACTobaccoReport/dropzone/dropzone.js' ) );        
        wp_register_script( 'insertReport-js', plugins_url( '/insertWYSACTobaccoReport/insertReport.js' ) );
        wp_enqueue_script('insertReport-js');
    }
}

add_action('admin_enqueue_scripts', 'insertReportJS');

// Builds content in meta box
function renderInsertReport() { 
    $wysacSavedReportVisibleClass = '';
    $wysacDropzoneClass = '';
    
    $saved_report_id = getReport(); // Check if a report has already been uploaded. 
    
    if($saved_report_id) { // If report exist, make detail info visible, hide upload functionality
    	// make report information box visible
    	$wysacSavedReportVisibleClass = 'class="visible"'; 
    
    	// hide the upload report box. One PDf per post.
    	$wysacDropzoneClass='class="hideDropzone"';
    }

	// hidden unless report exists
	echo "<div id=\"wysacSavedReport\" $wysacSavedReportVisibleClass>\n".
    	 "<input type=\"hidden\" name=\"saved_report_id\" value=\"$saved_report_id\" id=saved_report_id=\"saved_report_id\" />".
    	 "<p>The saved report link for this post: <a href=\"http://wysac.uwyo.edu/wysac/ReportView.aspx?DocId=$saved_report_id&A=1\">Link</a></p>".
    	 "<p><a id=\"deleteReport\" rel=\"$saved_report_id\" id=\"reportLink\">Click here to delete this report.</a></p>".
    	 "</div>";
	// visible unless report exists
	echo "<div id=\"wysacDropzone\" $wysacDropzoneClass>";
    
    ?>

	<div id="uploadReportContainer">
        <div style="clear: both">
        	<p>After finalizing your report, upload a PDF of your report exported from Word. Upload your PDF file when you are ready to publish this post. If you are not ready to publish this post, skip this step for now.</p>
        	<p class="reportNotice" style="color: #900">This final should be the absolute, final version of your report.</p>
        		<label for="upload_report_publication_number">Publication Number</label><br>
        		<input type="text" name="upload_report_publication_number" id="upload_report_publication_number" value="">
        	</p>
        </div>

        <div style="clear: both; min-height: 100px">	
        	<p style="float: left; width: 200px;">
        		<label for="upload_report_document_category">Document Category</label><br>
        		<select name="report_type_id" id="report_type_id">
        			<option value="2">Fact Sheet</option>
        			<option value="3">Issue Brief</option>
        			<option value="4">Technical Report</option>
        			<option value="5">Other Resources</option>
        		</select>
        	</p>	
        	<p style="float: left; width: 100px;">
        		<label for="report_scope_id">Scope of Data</label><br>
        		<select name="report_scope_id" id="report_scope_id">
        			<option value="1">State</option>
        			<option value="2">Region</option>
        			<option value="3">County</option>
        		</select>
        	</p>
        	<p style="float: left; width: 200px;">
        		<label for="report_owner_author_id">Author(s)</label><br/>
        		<?php echo wysac_show_all_authors(); ?>
        </div>
        <div id="dropzoneContainer">
        	<div id="dropzone"></div>
        </div>
	</div>
</div>
<?php 

}

// Trigger main content body for upload mechanism UI
add_action( 'add_meta_boxes', 'insertReportBoxUI', 10, 2 );

function wysac_show_all_authors() { // Function called in renderInsertReport() to build author(s) dropdown :: Multiselect functionality handled by Jquery plugin
    global $wpdb;
    
    // Query WP User Table
    $result = $wpdb->get_results( "SELECT * FROM wp_users");
    
    $select = '';
    if($result) {
        foreach($result as $row) {
            $select .= '<option value="'.wysac_author_sqlsrv_translate($row->ID).'">'.ucfirst($row->user_nicename).'</option>';
        }
        return '<select id="report_owner_author_id" name="report_owner_author_id">'.$select.'</select>';
    }
}

// Ajax Delete Report Function
function wysac_delete_saved_report() {
    global $wpdb;
    include("processReportUpload.php");

    $conn = sqlsrvConnect();
    
    // Used only with MYSQL
    $post_id          = $_POST['post_id'];
    // Use donly with SQLSRV
    $report_author_id = $_POST['report_author_id'];
    $report_id        = $_POST['report_id'];

    /** Begin SQL Srv SP Call **/
    $spParams = array(
        array(NULL,1), // recordset.
        array(NULL,1), // sql
        array($report_id,1), // report_id
        array($report_author_id,1) // report_user_id :: Not used, but for logging
    );
   
    $sp = "{ call dbo.ReportDelete_SP(?,?,?,?) }";
    
    $result = sqlsrv_query($conn, $sp, $spParams);
    /** End SQL Srv SP Call **/
    
    if($result) { // if SQLSRV return TRUE
        if($wpdb->delete('wp_wysac_pdf_id', array( 'post_id' => $post_id ), $where_format = null )) { // if WPDB return TRUE
			return json_encode(array ('deleted' => 'true', 'post_id' => $report_id));
		} else { 
			return json_encode(array('deleted' => 'false', 'db' => 'mysql'));
		}
    } else {
			return json_encode(array('deleted' => 'false', 'db' => 'sqlsrv'));        
    }
}

// WP Ajax trigger for the delete function
add_action( 'wp_ajax_wysac_delete_saved_report', 'wysac_delete_saved_report' );

// Function called via AJAX to save pdf_id to post_id
function wysac_save_pdf_id() {
    // globalized wpdb class
    global $wpdb;

    // sent via AJAX Post on success insert into sqlsrv
    $post_id       = $_POST['post_id']; // wordpress post ID
    $report_name   = $_POST['report_name']; // report_name
    $report_id     = $_POST['report_id'];
     
    // Wordpress database function
    $wpdb->insert(
        'wp_wysac_pdf_id',
        array(
            'post_id'       => $post_id,
            'report_name'   => $report_name,
            'report_id'     => $report_id
        )
    );

    // kill_further wp processing
    wp_die();
}
// WP Ajax trigger for the save report_id to MYSQL DB.
add_action( 'wp_ajax_wysac_save_pdf_id', 'wysac_save_pdf_id' );

add_action( 'admin_menu', 'wysac_uploaded_reports' );

function wysac_uploaded_reports() {
	add_menu_page( 'Uploaded Tobacco Reports', 'PDF Reports', 'manage_options', 'myplugin/myplugin-admin-page.php', 'wysac_display_reports', 'dashicons-tickets', 6  );
}

// Function to display table view of inserted reports
function wysac_display_reports() {
	global $wpdb;
	
	echo "<h1>Uploaded PDF Reports</h1>";
	// initia DB query to get stored results
	$result = $wpdb->get_results( "SELECT * FROM wp_wysac_pdf_id ");

	//post_id report_name report_id
	$table_header = '<tr><th>Post ID</th><th>Report Name</th><th>Report ID</th></tr>';
	$out = '';
	if($result) {
		foreach($result as $row) {
			$out .= '<tr>';
			$out .= '<td>'.$row->post_id.'</td>';
			$out .= '<td>'.$row->report_name.'</td>';
			$out .= '<td>'.$row->report_id.'</td>';
			$out .= '</tr>';
		}
	} else {
	       $out .= '<thead><tr><td colspan="3">No Uploaded Reports</td></tr></thead>';
	}

 	$table = '<table class="widefat">'.$table_header.$out.'</table>';
	echo $table;
} 


?>